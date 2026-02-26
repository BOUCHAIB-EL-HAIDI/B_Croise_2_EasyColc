<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
Use App\Models\User;
use App\Models\Expense;
use App\Models\Payment;
class Settlement extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_id',
        'debtor_id',
        'creditor_id',
        'amount',
    ];

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function debtor()
    {
        return $this->belongsTo(User::class, 'debtor_id');
    }

    public function creditor()
    {
        return $this->belongsTo(User::class, 'creditor_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
