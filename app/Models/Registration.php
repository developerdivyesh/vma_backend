<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attendance;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'salutation',
        'name',
        'first_name',
        'last_name',
        'mobile',
        'source',
        'age', 
        'qr_code_path'
    ];

    public function attendances() {
        return $this->hasMany(Attendance::class);
    }
}
