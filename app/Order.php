<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    protected $fillable = ['payment_status'];
    use SoftDeletes;
    function relationOrderDetail()
    {
        return $this->hasMany('App\Order_detail');
    }
    function userrelation()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
