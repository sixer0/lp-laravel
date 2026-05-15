<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'company',
        'name',
        'phone',
        'email',
        'message',
        'ip',
        'user_agent',
        'user_agent_short',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope: active status
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'new');
    }
}
