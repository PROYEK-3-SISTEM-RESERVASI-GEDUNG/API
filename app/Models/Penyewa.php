<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens; 

class Penyewa extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'penyewa';
    protected $guarded =[''];

    public $timestamps = false;
}
