<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $guarded = ['id'];

    public function order_detail()
    {
        return $this->hasMany(Ordersdetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
