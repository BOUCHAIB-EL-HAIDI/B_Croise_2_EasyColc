<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Settlement;
use App\Models\User;
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'settlement_id',
        'paid_by_id',
        'amount',
        'status',
        'payment_date',
        'confirmed_at',
    ];

    public function settlement()
    {
        return $this->belongsTo(Settlement::class);
    }

    public function paidBy()
    {
        return $this->belongsTo(User::class, 'paid_by_id');
    }
}
