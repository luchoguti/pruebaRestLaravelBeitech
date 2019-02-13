<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    public $table = "order_detail";
    protected $primaryKey = 'order_detail_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_detail_id','order_id', 'product_description', 'price','quantity','product_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
    /**
     * A OrderDetails belongs to a order
     *
     * @return Illuminate\Database\Eloquent\Relations\Relation
     */
    public function Products(){
        return $this->belongsTo('App\Products','product_id');
    }
    public $timestamps = false;
}
