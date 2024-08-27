<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ReferralPayout extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'referral_payouts';

    public function user(){
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function affiliate_payout_method(){
        return $this->belongsTo(PayoutMethod::class, 'affiliate_payout_method_id')->withDefault();
    }

    public function getRequirementsAttribute($value) {
        return json_decode($value);
    }

    protected function amount(): Attribute {
        $decimal_place = get_option('decimal_places', 2);

        return Attribute::make(
            get: fn(string $value) => number_format($value, $decimal_place, '.', ''),
        );
    }

    protected function 	charge(): Attribute {
        $decimal_place = get_option('decimal_places', 2);

        return Attribute::make(
            get: fn(string $value) => number_format($value, $decimal_place, '.', ''),
        );
    }

    protected function finalAmount(): Attribute {
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