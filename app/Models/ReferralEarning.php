<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ReferralEarning extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'referral_earnings';

    public function user(){
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function reffered_user(){
        return $this->belongsTo(User::class, 'reffered_user_id')->withDefault();
    }

    public function subscription_payment(){
        return $this->belongsTo(SubscriptionPayment::class, 'subscription_payment_id')->withDefault();
    }

    protected function amount(): Attribute {
        $decimal_place = get_option('decimal_places', 2);

        return Attribute::make(
            get: fn(string $value) => number_format($value, $decimal_place, '.', ''),
        );
    }

    protected function 	commissionAmount(): Attribute {
        $decimal_place = get_option('decimal_places', 2);

        return Attribute::make(
            get: fn(string $value) => number_format($value, $decimal_place, '.', ''),
        );
    }

    protected function createdAt(): Attribute {
        $date_format = get_date_format();
        $time_format = get_time_format();

        return Attribute::make(
            get:fn($value) => \Carbon\Carbon::parse($value)->format("$date_format $time_format"),
        );
    }

}