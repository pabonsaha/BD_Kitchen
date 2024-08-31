<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeType extends Model
{
    use HasFactory;

    public function notices(){
        return $this->hasMany(NoticeBoard::class, 'type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
