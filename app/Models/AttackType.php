<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttackType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'effective_against',
        'weak_against',
        'damage'
    ];

    public function powers(): HasMany
    {
        return $this->hasMany(Power::class);
    }
}
