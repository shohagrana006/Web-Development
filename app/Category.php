<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = ['category_name', 'category_description', 'category_photo'];

    function relationProductTable(){
      return $this->hasMany('App\Product', 'category_id', 'id')->withTrashed();
    }
}
