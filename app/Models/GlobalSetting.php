<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'options',
        'type',
        'description',
        'active_status',
        'created_by',
        'updated_by',
    ];
}
