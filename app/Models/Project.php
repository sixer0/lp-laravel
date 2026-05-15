<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'image_alt',
        'hours_tag',
        'price_tag',
        'project_url',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Boot method - auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->name);
            }
            if (!isset($project->order)) {
                $project->order = static::max('order') + 1;
            }
        });
    }

    /**
     * Scope: Active projects
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order', 'asc');
    }

    /**
     * Get full image URL
     */
    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return asset('/images/default-project.jpg');
        }
        return $this->image;
    }

    /**
     * Get display hours tag
     */
    public function getHoursTagAttribute($value)
    {
        return $value ?: '';
    }

    /**
     * Get display price tag
     */
    public function getPriceTagAttribute($value)
    {
        return $value ?: '';
    }
}
