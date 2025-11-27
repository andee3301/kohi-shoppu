<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class UserService
{
    public static function getUserIdFromSession(): string
    {
        if (Session::exists('user_id')) {
            return (string) Session::get('user_id');
        }

        $userId = fake()->uuid();
        Session::put('user_id', $userId);

        return $userId;
    }
}
