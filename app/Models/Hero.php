<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $legal_name
 * @property string $hero_alias
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property Carbon $date_of_birth
 * @property string $backstory
 * @property Carbon $email_verified_at
 * @property string $remember_token
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Collection|Power[] $powers
 * @property Statistic $statistic
 */
class Hero extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'legal_name',
        'hero_alias',
        'email',
        'phone',
        'password',
        'date_of_birth',
        'backstory',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function powers(): HasMany
    {
        return $this->hasMany(Power::class);
    }

    public function statistic(): HasOne
    {
        return $this->hasOne(Statistic::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
