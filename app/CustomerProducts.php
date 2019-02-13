<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerProducts extends Model
{
    public $table = "customer_product";    
    protected $primaryKey = 'product_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id','product_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
}
