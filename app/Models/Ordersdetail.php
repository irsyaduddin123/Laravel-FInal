<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordersdetail extends Model
{
    use HasFactory;
    protected $table = 'ordersdetails';
    protected $guarded = ['id'];

    protected $with = ['order', 'product'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
