<?php

namespace App;

use App\Models\ProductImg;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function products_categories()
    {
      return $this->hasMany(Products_categories::class, 'product_id');
    }

    public function product_variations()
    {
      return $this->hasMany(ProductVariation::class, 'product_id');
    }

    public function order_details()
    {
      return $this->hasMany(OrderDetail::class, 'product_id');
    }

    public function multiple_images()
    {
      return $this->hasMany(ProductImg::class, 'product_id');
    }

}
