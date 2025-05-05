<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Http\Request;

class TokenAuthService
{
    public function getUser(Request $request)
    {
        return User::where('api_token', $request->bearerToken())->first();
    }
}
