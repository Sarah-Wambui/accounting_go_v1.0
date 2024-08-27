<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayoutMethod extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'affiliate_payout_methods';

    public function getParametersAttribute($value) {
		return json_decode($value);
	}

}