<?php

namespace App\Services\User;

class UserTag
{
    public function getUserTag($user, $id)
    {
        return $user->tags()->find($id);
    }
}
