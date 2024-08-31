<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    public function currency()
    {
        return $this->hasOne(Currencies::class,'id','currency_id');
    }

    public function timezone()
    {
        return $this->hasOne(TimeZone::class,'id','time_zone_id');
    }

    public function DateFormat()
    {
        return $this->hasOne(DateFormat::class,'id','date_format_id');
    }
}
