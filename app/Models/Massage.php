<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Massage extends Model
{
    use HasFactory;
    protected $table = 'massage';
    protected $fillable = [
        'id',
        'nama',
        'email',
        'pesan',
        
    ];
}
