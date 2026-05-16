<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'username', 'password_hash', 'display_name', 'email', 'role', 'is_active',
    ];

    protected $hidden = ['password_hash'];

    protected $casts = [
        'is_active' => 'boolean',
        'role'      => 'string',
    ];

    protected $table = 'users';

    /**
     * Verify a plain-text password against stored hash.
     */
    public function verifyPassword(string $plain): bool
    {
        return password_verify($plain, $this->password_hash);
    }

    /**
     * Generate a Bcrypt hash: encoding cost 12.
     */
    public static function makeHash(string $plain): string
    {
        return password_hash($plain, PASSWORD_DEFAULT);
    }

    /**
     * Check if user has admin privileges.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
