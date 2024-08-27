<?php

namespace App\Listeners;

use App\Models\ReferralEarning;
use Illuminate\Support\Facades\DB;
use App\Events\SubscriptionPayment;
use App\Notifications\ReferralComission;

class ProcessReferralComission {
    /**
     * Create the event listener.
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SubscriptionPayment $event): void {
        if (get_option('affiliate_status', 0) == 0) {
            return;
        }

        $refferedUser        = $event->user;
        $subscriptionPayment = $event->subscriptionPayment;

        if($refferedUser->referral_status != 0){
            return;
        }

        DB::beginTransaction();

        $referralEarning                          = new ReferralEarning();
        $referralEarning->user_id                 = $refferedUser->referrer_id;
        $referralEarning->subscription_payment_id = $subscriptionPayment->id;
        $referralEarning->reffered_user_id        = $refferedUser->id;
        $referralEarning->amount                  = $subscriptionPayment->amount;
        $referralEarning->commission_percentage   = get_option('affiliate_commission', 1);
        $referralEarning->commission_amount       = ($referralEarning->commission_percentage / 100) * $referralEarning->amount;
        $referralEarning->save();

        $refferedUser->referral_status = 1;
        $refferedUser->save();

        DB::commit();

        // Send Notification to User about Referral Payment
        try {
            $refferedUser->referrer->notify(new ReferralComission($refferedUser, $referralEarning));
        } catch (\Exception $e) {}
    }
}
