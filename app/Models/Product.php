<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use Sluggable;

    protected $table = 'products';
    protected $fillable = [
        'id',
        'name',
        'deskripsi',
        'stok',
        'price',
        'min_stok',
        'image',
        'category_id',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function order_detail()
    {
        return $this->hasMany(Ordersdetail::class);
    }
}
