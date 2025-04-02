<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $table = 'otps'; // Table name

    protected $fillable = [
        'mobile',
        'otp',
        'expires_at',
    ];

    public $timestamps = true; // Enable created_at and updated_at
}