<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatResource extends JsonResource
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
            'subscriptions',
            'monthlySearches',
            'views',
            'videosCount',
            'premiumVideosCount',
            'whiteLabelVideoCount',
            'rank',
            'rankPremium',
            'rankWl',
        ]);
    }
}
