<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Colocation;
use App\Models\Category;
use App\Models\User;
use App\Models\Settlement;
class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'colocation_id',
        'category_id',
        'payer_id',
        'title',
        'amount',
        'expense_date',
    ];

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_id');
    }

    public function settlements()
    {
        return $this->hasMany(Settlement::class);
    }
}
