<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
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

        return $this->resource->only([
            'hairColor',
            'ethnicity',
            'tattoos',
            'piercings',
            'breastSize',
            'breastType',
            'gender',
            'orientation',
            'age',
        ]);
    }
}
