<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];


    public function funRunRegistrations(): HasMany
{
    return $this->hasMany(
        FunRunRegistration::class,
        'user_id'
    );
}

public function verifiedFunRunPayments(): HasMany
{
    return $this->hasMany(
        FunRunPayment::class,
        'verified_by'
    );
}

/**
 * Super Admin -> akses penuh, termasuk kelola akun admin lain.
 * Admin biasa -> akses panel admin standar (default kalau kolom
 * role kosong/belum diisi, supaya akun lama yang belum sempat
 * di-migrasi datanya tetap bisa masuk seperti biasa).
 */
public function isSuperAdmin(): bool
{
    return $this->role === 'super_admin';
}

public function isAdminRole(): bool
{
    return in_array($this->role, ['admin', 'super_admin']);
}

/**
 * Cek apakah user ini boleh buka menu tertentu.
 *
 * - Super Admin selalu true buat SEMUA menu (hardcode, bukan
 *   data), biar nggak pernah kekunci dari menunya sendiri.
 * - Role lain (admin/user) dicek ke tabel role_menu_permissions.
 *   Kalau belum pernah diatur sama sekali (baris kosong), DEFAULT-nya
 *   ditolak (aman by default) -- Super Admin wajib nyalain manual
 *   lewat halaman "Atur Akses Menu".
 */
public function canAccessMenu(string $menuKey): bool
{
    if ($this->isSuperAdmin()) {
        return true;
    }

    return \App\Models\RoleMenuPermission::where('role', $this->role)
        ->where('menu_key', $menuKey)
        ->exists();
}
}