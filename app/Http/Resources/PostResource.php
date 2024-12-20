<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
   
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'content'   => $this->content,
            'author'    => [
                'id'   => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'likes_count' => $this->likes_count,
            'tags'      => $this->tags->pluck('name'),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
