<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($resource) use ($request) {
            return [
                'id' => $resource->id,
                'name' => $resource->name,
                'email' => $resource->email,
                'phone' => $resource->phone,
                'address' => $resource->address,
                'created_at' => $resource->created_at,
            ];
        })->all();
    }
}
