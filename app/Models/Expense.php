<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'type_id',
        'expense_date',
        'amount',
        'voucher',
        'details',
        'active_status',
    ];

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class, 'type_id');
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
