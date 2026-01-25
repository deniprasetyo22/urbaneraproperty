<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // OPSI 1: Izinkan semua user yang punya email tertentu (Paling Aman)
        // return $this->email === 'admin@urbanera.id' || $this->email === 'deniprasetyo2210@gmail.com';

        // OPSI 2: Izinkan semua user yang sudah login (Hati-hati, semua user terdaftar bisa masuk admin)
        // return true;

        // OPSI 3: Cek apakah emailnya berakhiran @urbanera.id
        // return str_ends_with($this->email, '@urbanera.id');

        // REKOMENDASI SAYA (Sementara): Izinkan semua user agar Anda bisa login dulu
        return true;
    }
}