<?php

namespace App\Services\User;

class UserTask
{
    public function getUserTask($user, $id)
    {
        return $user->tasks()->find($id);
    }
}
