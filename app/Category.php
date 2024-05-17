<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
      'name',
      'slug',
      'position',
      'sts'
    ];

    
    public function categories()
    {
      return $this->hasMany(Category::class, 'mctg');
    }
}
