<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products_categories extends Model
{
    protected $fillable = [
      'product_id',
      'category_id'
    ];

    
    public function category()
    {
      return $this->belongsTo(Category::class, 'category_id');
    }
}
