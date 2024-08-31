<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignerContact extends Model
{
    use HasFactory;
    protected $fillable=[
        'designer_id',
        'name',
        'email',
        'phone',
        'message',
        'status',
    ];


    public function designer()
    {
        return $this->belongsTo(User::class, 'designer_id');
    }


}
