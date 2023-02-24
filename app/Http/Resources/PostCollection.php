<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function($resource) use($request) {
            return [
                'id' => $resource->id,
                'name' => $resource->name,
                'image' => $resource->image,
                'content' => $resource->content,
                'userId' => $resource->userId,
                'is_public' => $resource->is_public,
                'created_at' => $resource->created_at
            ];
        });
    }
}