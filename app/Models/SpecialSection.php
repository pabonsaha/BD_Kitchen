<?php

namespace App\Models;

use App\Models\Traits\CommonQueryTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialSection extends Model
{
    use CommonQueryTraits;
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(SpecialSectionCategory::class, 'special_section_category_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(SpecialSectionDetail::class);
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
