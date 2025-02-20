<?php

use App\Models\User;

if (!function_exists('notify')) {
    function notify($userId, $title, $subtitle, $redirectLink)
    {
        // Retrieve the user by ID
        $user = User::find($userId);

        if (!$user) {
            return false; // User not found, handle error
        }

        // Create the notification
        return $user->notifications()->create([
            'title' => $title,
            'subtitle' => $subtitle,
            'redirect_link' => $redirectLink,
            'read' => false
        ]);
    }
}
