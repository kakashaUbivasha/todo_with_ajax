<?php

namespace App\Http\Controllers\API\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskRequest;
use App\Services\Task\TaskService;
use App\Services\User\TokenAuthService;
use App\Services\User\UserTask;
use Illuminate\Http\Request;

class TaskController extends Controller
{
        public function index(Request $request, TokenAuthService $authService)
        {
            $user = $authService->getUser($request);
            $this->errorMessage($user, 'Unauthorized', 401);
            return response()->json($user->tasks()->with('tags')->get());
        }
        public function show(Request $request, $id, TokenAuthService $authService)
        {
            $user = $authService->getUser($request);
            $this->errorMessage($user, 'Unauthorized', 401);
            $task = $user->tasks()->with('tags')->find($id);
            $this->errorMessage($task, 'Task not found');
            return response()->json($task);
        }

        public function store(TaskRequest $request, TaskService $taskService, TokenAuthService $authService)
        {
            $user = $authService->getUser($request);
            $this->errorMessage($user, 'Unauthorized', 401);
            $task = $taskService->createTask($request->validated(), $user);
            return response()->json(['message' => 'Задача создана', 'task' => $task], 201);
        }
        public function update(TaskRequest $request, $id, TaskService $taskService, TokenAuthService $authService, UserTask $userTask)
        {
            $user = $authService->getUser($request);
            $this->errorMessage($user, 'Unauthorized', 401);
            $task = $userTask->getUserTask($user, $id);
            $this->errorMessage($task, 'Task not found');
            $updatedTask = $taskService->updateTask($request->validated(), $task, $user);
            return response()->json(['message' => 'Задача обновлена', 'task' => $updatedTask], 201);
        }
        public function destroy(Request $request, $id, TaskService $taskService, TokenAuthService $authService, UserTask $userTask)
        {
            $user = $authService->getUser($request);
            $this->errorMessage($user, 'Unauthorized', 401);
            $task = $userTask->getUserTask($user, $id);
            $this->errorMessage($task, 'Task not found');
            $taskService->deleteTask($task);
            return response()->json(['message'=> 'Задача удалена'], 200);
        }
    private function errorMessage($value, $message, $code = 404)
    {
        if (!$value) {
            abort(response()->json(['message' => $message], $code));
        }
    }
}
