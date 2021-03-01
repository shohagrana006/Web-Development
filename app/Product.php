<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    function relationCategoryTable(){
      return $this->hasOne('App\Category', 'id', 'category_id')->withTrashed();
    }
    function relationProduct_imageTable(){
      return $this->hasMany('App\Product_image', 'product_id', 'id')->withTrashed();
    }
}
