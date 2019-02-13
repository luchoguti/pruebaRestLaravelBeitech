<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    public $table = "order";

    protected $primaryKey = 'order_id';
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'order_id','customer_id', 'creation_date', 'total','delivery_address'
    ];

    /**
        * The attributes that should be hidden for arrays.
        *
        * @var array
        */
    protected $hidden = [
    ];
    /**
     * A order a can have many OrderDetails
     *
     * @return Illuminate\Database\Eloquent\Relations\Relation
     */
    public function OrderDetail(){
        return $this->hasMany('App\OrderDetails','order_id','order_id');
    }
    public $timestamps = false;
}
