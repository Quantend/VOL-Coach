<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Panel; // Zorg ervoor dat je de Panel class importeert

class User extends Authenticatable implements FilamentUser  
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',  
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessFilament(): bool
    {
        return $this->is_admin;  
    }

    // Pas de canAccessPanel methode aan om de Panel parameter te accepteren
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin; // Hier kun je de logica voor toegang aanpassen
    }
}