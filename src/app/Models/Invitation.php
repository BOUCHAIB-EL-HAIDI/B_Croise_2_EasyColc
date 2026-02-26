<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Colocation;
class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'colocation_id',
        'token',
        'email',
        'status',
    ];

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }
}
