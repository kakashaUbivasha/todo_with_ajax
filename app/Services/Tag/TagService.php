<?php

namespace App\Services\Tag;

use App\Models\Tag;

class TagService
{
    public function createTag($data, $user)
    {
        $tag = Tag::create([
            'title' => $data['title'],
            'user_id' => $user->id,
        ]);
        return $tag;
    }
    public function updateTag($data, $tag)
    {
       $tag->update([
          'title' => $data['title'],
       ]);
       return $tag;
    }
    public function deleteTag($tag)
    {
        $tag->delete();
    }

}
