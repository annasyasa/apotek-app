<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;
    //ditambahkan jika nama migration dan mmodel tdk sesuai
    //public $table
    protected $fillable = [
        'type', 'name', 'price', 'stock'
    ];
}
