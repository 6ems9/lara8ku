<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $tags = $this->tags;
        foreach ($tags as $posttags) {
            $taging[] = $posttags->name;
        }
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'author' => $this->author->username,
            'category' => $this->category->name,
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'image' => $this->image,
            'tags' => $taging,
            
        ];

    }
}
