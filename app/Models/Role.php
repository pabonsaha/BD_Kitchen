<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;


    const SUPER_ADMIN = 1;
    const ADMIN = 2;
    const DESIGNER = 3;
    const CUSTOMER = 4;
    const MANUFACTURER = 5;

    protected $casts = [
        'permissions' => 'array',
    ];



    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
