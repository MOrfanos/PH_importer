<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PornstarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (is_null($this->resource)) {
            return [];
        }

        return [
            'info' => PornstarBasicInfoResource::make($this->resource),
            'attributes' => AttributeResource::make($this->whenLoaded('attributes')),
            'stats' => StatResource::make($this->whenLoaded('stats')),
            'thumbnails' => ThumbnailResource::collection($this->whenLoaded('thumbnails')),
        ];
    }
}
