<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'depot_id', 'spbu_id', 'photo',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function depot()
    {
        return $this->belongsTo(Depot::class);
    }

    public function spbu()
    {
        return $this->belongsTo(Spbu::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPimpinan(): bool
    {
        return $this->role === 'pimpinan';
    }

    public function isOperatorDepot(): bool
    {
        return $this->role === 'operator_depot';
    }

    public function isOperatorSpbu(): bool
    {
        return $this->role === 'operator_spbu';
    }

    public function roleLabel(): string
    {
        return match ($this->role) {
            'admin' => 'Administrator',
            'operator_depot' => 'Operator Terminal BBM',
            'operator_spbu' => 'Operator SPBU',
            'pimpinan' => 'Pimpinan',
            default => $this->role,
        };
    }
}
