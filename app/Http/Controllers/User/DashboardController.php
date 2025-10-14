<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard.
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        
        // Debug: Directly query the database for activities
        $recentActivities = \DB::table('activities')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // If no activities, create a test one
        if ($recentActivities->isEmpty()) {
            $now = now();
            $activityId = \DB::table('activities')->insertGetId([
                'user_id' => $user->id,
                'type' => 'test',
                'title' => 'Test Activity',
                'description' => 'This is a test activity',
                'icon' => 'bell',
                'color' => 'text-blue-500',
                'metadata' => json_encode(['test' => true]),
                'created_at' => $now,
                'updated_at' => $now
            ]);
            
            // Refetch activities
            $recentActivities = \DB::table('activities')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }
        
        // Convert to collection of objects for the view
        $recentActivities = collect($recentActivities);
        
        return view('user.dashboard', [
            'recentActivities' => $recentActivities,
            'user' => $user,
        ]);
    }
}
