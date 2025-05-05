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
            $task->tags()->attach($data['tags']);
        }

        return $task->load('tags');
    }
    public function updateTask($data, $task)
    {
        $task->update([
            'title' => $data['title'],
            'text' => $data['text'],
        ]);

        if (isset($data['tags'])) {
            $task->tags()->sync($data['tags']);
        }

        return $task->load('tags');
    }
    public function deleteTask($task)
    {
//        $task->tags()->detach();
        $task->delete();
    }
}
