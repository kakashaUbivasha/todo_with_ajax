<?php

namespace App\Services\Task;

use App\Models\Task;

class TaskService
{
    public function createTask($data, $user)
    {
        $task = Task::create([
            'title' => $data['title'],
            'text' => $data['text'],
            'user_id' => $user->id,
        ]);

        if (isset($data['tags'])) {
            $userTagIds = $user->tags()->pluck('id')->toArray();
            $validTagIds = array_intersect($data['tags'], $userTagIds);

            $task->tags()->attach($validTagIds);
        }

        return $task->load('tags');
    }
    public function updateTask($data, $task, $user)
    {
        $task->update([
            'title' => $data['title'],
            'text' => $data['text'],
        ]);

        if (isset($data['tags'])) {
            $userTagIds = $user->tags()->pluck('id')->toArray();
            $validTagIds = array_intersect($data['tags'], $userTagIds);

            $task->tags()->sync($validTagIds);
        }

        return $task->load('tags');
    }
    public function deleteTask($task)
    {
//        $task->tags()->detach();
        $task->delete();
    }
}
