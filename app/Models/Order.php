<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['customer_id',
                            'store_id',
                            'status',
                            'driver_id',
                            'assigned_at',
                            'delivered_at'];      
}
