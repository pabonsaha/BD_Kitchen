<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeBoard extends Model
{
    use HasFactory;
    protected $fillable =[
        'title',
        'type_id',
        'published_at',
        'receivers',
        'description',
        'attachments',
        'active_status'
    ];
    public function noticeType()
    {
        return $this->belongsTo(NoticeType::class, 'type_id');
    }


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


}
