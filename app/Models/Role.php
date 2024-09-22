<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;


    const USER =1;
    const ADMIN = 2;
    const KITCHEN = 3;

    protected $casts = [
        'permissions' => 'array',
    ];



    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
