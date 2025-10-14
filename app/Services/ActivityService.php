<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\User;

class ActivityService
{
    /**
     * Log a new activity for a user.
     *
     * @param User $user
     * @param string $type
     * @param string $title
     * @param string|null $description
     * @param string $icon
     * @param string $color
     * @param array $metadata
     * @return Activity
     */
    public static function log(
        User $user,
        string $type,
        string $title,
        ?string $description = null,
        string $icon = 'bell',
        string $color = 'text-gray-500',
        array $metadata = []
    ): ?Activity {
        try {
            // Log the activity data for debugging
            \Log::info('Creating activity', [
                'user_id' => $user->id,
                'type' => $type,
                'title' => $title,
                'description' => $description,
                'icon' => $icon,
                'color' => $color,
                'metadata' => $metadata,
            ]);

            $activity = Activity::create([
                'user_id' => $user->id,
                'type' => $type,
                'title' => $title,
                'description' => $description,
                'icon' => $icon,
                'color' => $color,
                'metadata' => $metadata,
            ]);

            \Log::info('Activity created successfully', ['activity_id' => $activity->id]);
            return $activity;
        } catch (\Exception $e) {
            \Log::error('Failed to create activity', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => [
                    'user_id' => $user->id,
                    'type' => $type,
                    'title' => $title,
                ]
            ]);
            return null;
        }
    }

    /**
     * Get recent activities for a user.
     *
     * @param User $user
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getRecentActivities(User $user, int $limit = 10)
    {
        try {
            // Log the user ID for debugging
            \Log::info('Fetching activities for user', ['user_id' => $user->id]);
            
            // Debug: Check if user exists
            if (!$user->exists) {
                \Log::error('User does not exist', ['user_id' => $user->id]);
                return collect();
            }
            
            // Debug: Check activities relationship
            if (!method_exists($user, 'activities')) {
                \Log::error('User model does not have activities() method');
                return collect();
            }
            
            // Debug: Get activities with raw query
            $query = $user->activities();
            \Log::debug('Activities query:', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);
            
            $activities = $query->latest('created_at')
                ->take($limit)
                ->get();
                
            \Log::info('Retrieved activities:', [
                'count' => $activities->count(),
                'activities' => $activities->toArray()
            ]);
            
            // Debug: Check database directly
            $directCount = \DB::table('activities')->where('user_id', $user->id)->count();
            \Log::info('Direct activities count from database:', ['count' => $directCount]);
            
            return $activities;
        } catch (\Exception $e) {
            \Log::error('Error fetching activities:', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return collect(); // Return empty collection on error
        }
    }
}
