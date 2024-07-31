<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reedem extends Model
{
    use HasFactory;
    protected $table = 'reedemcodes';
    protected $fillable = [
        'code',
        'discount_percentage'
    ];
}
