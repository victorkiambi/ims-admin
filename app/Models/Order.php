<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

//    protected $fillable = [
//        'customer_id',
//        'status',
//        'total',
//        'payment_method',
//        'payment_status',
//        'shipping_method',
//        'shipping_status',
//        'shipping_address',
//        'shipping_city',
//    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function products()
    {
        return $this->hasManyThrough(Product::class, OrderItem::class, 'order_id', 'id', 'id', 'product_id');
    }
}
