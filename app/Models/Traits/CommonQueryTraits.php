<?php

namespace App\Models\Traits;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;

trait CommonQueryTraits
{

    public function scopeIsClient($query, $columnName = 'kitchen_id')
    {
        if (Auth::user()->role_id == Role::KITCHEN) {
            $query = $query->where($columnName, Auth::user()->id);
        }
        return $query;
    }
}
