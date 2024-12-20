<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    
    
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(fn($post) => new PostResource($post)),
            'links' => [
                'self' => url('/api/posts'),
            ],
        ];
    }
}
