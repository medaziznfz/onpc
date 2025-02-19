<?php

use App\Events\NotificationSent;

if (!function_exists('notify')) {
    function notify($user, $title, $subtitle, $redirectLink)
    {
        return $user->notifications()->create([
            'title' => $title,
            'subtitle' => $subtitle,
            'redirect_link' => $redirectLink,
            'read' => false
        ]);
    }
}