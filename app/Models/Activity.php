<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;

class Activity extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'description',
        'icon',
        'color',
        'metadata',
        'read_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'read_at' => 'datetime',
    ];

    /**
     * Get the user that owns the activity.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include recent activities.
     */
    public function scopeRecent($query, $limit = 10)
    {
        return $query->latest()->limit($limit);
    }

    /**
     * Mark the activity as read.
     */
    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            $this->update(['read_at' => now()]);
        }
    }

    /**
     * Create a new activity.
     */
    public static function createActivity($userId, $type, $title, $description = null, $icon = 'bell', $color = 'text-gray-500', $metadata = [])
    {
        return self::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'description' => $description,
            'icon' => $icon,
            'color' => $color,
            'metadata' => $metadata,
        ]);
    }
}
