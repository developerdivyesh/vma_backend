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
        'qr_code_path',
        'native_place',
        'custom_field_1',
        'custom_field_2',
        'custom_field_3',
        'custom_field_4',
        'custom_field_5',
    ];

    public function attendances() {
        return $this->hasMany(Attendance::class);
    }
}
