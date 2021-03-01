<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order_detail extends Model
{
    protected $fillable = ['stars', 'review'];
    use SoftDeletes;
    function OrderdetailToProduct()
    {
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }
}
