<?php

namespace App\Models;

use App\Models\Business;
use App\Models\Package;
use App\Utilities\Overrider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail {
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'password', 'user_type', 'status', 'package_id', 'profile_picture', 'referrer_id', 'referral_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['referral_link'];

    public function scopeActive($query) {
        return $query->where('status', 1);
    }

    public function scopeStaff($query) {
        return $query->whereHas('business', function (Builder $query) {
            $query->where('owner_id', auth()->id())
                ->where('role_id', '!=', null);
        });
    }

    public function package() {
        return $this->belongsTo(Package::class, 'package_id')->withDefault();
    }

    public function subscriptionPayments() {
        return $this->hasMany(SubscriptionPayment::class, 'user_id');
    }

    public function business() {
        return $this->belongsToMany(Business::class, 'business_users')->withPivot('owner_id', 'is_active', 'role_id');
    }

    public function roles(): BelongsToMany {
        return $this->belongsToMany(Role::class, 'business_users', 'user_id', 'role_id')->using(BusinessUser::class);
    }

        /**
     * A user has a referrer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referrer() {
        return $this->belongsTo(User::class, 'referrer_id', 'id');
    }

    public function referrals() {
        return $this->hasMany(User::class, 'referrer_id', 'id');
    }

    public function referral_earnings() {
        return $this->hasMany(ReferralEarning::class, 'user_id', 'id');
    }

    public function referral_payment() {
        return $this->hasOne(ReferralEarning::class, 'reffered_user_id', 'id');
    }

    public function referral_payouts() {
        return $this->hasMany(ReferralPayout::class, 'user_id', 'id');
    }

    protected function createdAt(): Attribute {
        $date_format = get_date_format();
        $time_format = get_time_format();

        return Attribute::make(
            get: fn($value) => \Carbon\Carbon::parse($value)->format("$date_format $time_format"),
        );
    }

    protected function subscriptionDate(): Attribute {
        $date_format = get_date_format();

        return Attribute::make(
            get: fn($value) => $value != null?\Carbon\Carbon::parse($value)->format("$date_format") : null,
        );
    }

    protected function validTo(): Attribute {
        $date_format = get_date_format();

        return Attribute::make(
            get: fn($value) => $value != null?\Carbon\Carbon::parse($value)->format("$date_format") : null,
        );
    }

    /**
     * Get the user's referral link.
     *
     * @return string
     */
    public function getReferralLinkAttribute()
    {
        return $this->referral_link = route('register', ['ref' => $this->referral_token]);
    }

    public function sendEmailVerificationNotification() {
        if (get_option('email_verification') == 0) {
            return;
        }
        Overrider::load("Settings");
        $this->notify(new VerifyEmail);
    }

}
