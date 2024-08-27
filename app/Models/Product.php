<?php

namespace App\Models;

use App\Models\ProductUnit;
use App\Traits\MultiTenant;
use Attribute;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use MultiTenant;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';


    public function scopeActive($query) {
        return $query->where('status', 1);
    }

    public function product_unit() {
        return $this->belongsTo(ProductUnit::class)->withDefault();
    }

    public function income_category() {
        return $this->belongsTo(TransactionCategory::class, 'income_category_id')->withDefault();
    }

    public function expense_category() {
        return $this->belongsTo(TransactionCategory::class, 'expense_category_id')->withDefault();
    }

}