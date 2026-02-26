<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Membership;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Settlement;
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'reputation',
        'isGlobalAdmin',
        'isBanned',
    ];

    protected $hidden = [
        'password',
    ];


    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }


    public function activeMembership()
    {
        return $this->hasOne(Membership::class)
                    ->where('is_active', true);
    }




    public function expenses()
    {
        return $this->hasMany(Expense::class, 'payer_id');
    }




    public function payments()
    {
        return $this->hasMany(Payment::class, 'paid_by_id');
    }




    public function settlementsAsDebtor()
    {
        return $this->hasMany(Settlement::class, 'debtor_id');
    }


    public function settlementsAsCreditor()
    {
        return $this->hasMany(Settlement::class, 'creditor_id');
    }



}
