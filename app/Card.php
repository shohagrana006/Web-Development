<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use SoftDeletes;
    protected $fillable = ['product_quantity'];
    function relationProductName(){
      return $this->belongsTo('App\Product', 'product_id', 'id');
    }
}
