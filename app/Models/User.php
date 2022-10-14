<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use RalphJSmit\Filament\Notifications\Concerns\FilamentNotifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, FilamentNotifiable;

    public function canAccessFilament(): bool
    {
        return true;
    }

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function initials()
    {
        $ret = '';
        foreach (explode(' ', $this->name) as $word) {
            $ret .= strtoupper($word[0]);
        }

        return $ret;
    }
}
