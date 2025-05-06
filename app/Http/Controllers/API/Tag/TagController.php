<?php

namespace App\Http\Controllers\API\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\TagRequest;
use App\Services\Tag\TagService;
use App\Services\User\TokenAuthService;
use App\Services\User\UserTag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Request $request, TokenAuthService $tokenAuthService)
    {
        $user = $tokenAuthService->getUser($request);
        $this->errorMessage($user, 'Unauthorized', 401);
        return response()->json($user->tags()->get());
    }
    public function show(Request $request, $id, TokenAuthService $tokenAuthService)
    {
        $user = $tokenAuthService->getUser($request);
        $this->errorMessage($user, 'Unauthorized', 401);
        $tag = $user->tags()->find($id);
        $this->errorMessage($tag, 'Tag not found');
        return response()->json($tag);
    }
    public function store(TagRequest $request, TokenAuthService $tokenAuthService, TagService $tagService)
    {
        $user = $tokenAuthService->getUser($request);
        $this->errorMessage($user, 'Unauthorized', 401);
        $tag = $tagService->createTag($request->validated(), $user);
        return response()->json(['message' => 'Тэг создан', 'tag' => $tag], 201);
    }
    public function update(TagRequest $request, $id, TokenAuthService $tokenAuthService, TagService $tagService, UserTag $userTag)
    {
        $user = $tokenAuthService->getUser($request);
        $this->errorMessage($user, 'Unauthorized', 401);
        $tag = $userTag->getUserTag($user, $id);
        $this->errorMessage($tag, 'Tag not found');
        $updatedTag = $tagService->updateTag($request->validated(), $tag);
        return response()->json(['message' => 'Тэг обновлен', 'tag' => $updatedTag], 200);
    }
    public function destroy(Request $request,$id, TokenAuthService $tokenAuthService, TagService $tagService, UserTag $userTag)
    {
        $user = $tokenAuthService->getUser($request);
        $this->errorMessage($user, 'Unauthorized', 401);
        $tag = $userTag->getUserTag($user, $id);
        $this->errorMessage($tag, 'Tag not found');
        $tagService->deleteTag($tag);
        return response()->json(['message'=> 'Тэг удален'], 200);
    }
    private function errorMessage($value, $message, $code = 404)
    {
        if (!$value) {
            abort(response()->json(['message' => $message], $code));
        }
    }
}
