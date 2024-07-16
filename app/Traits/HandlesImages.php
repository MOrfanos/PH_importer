<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

trait HandlesImages
{
    public function downloadImage($modelName, $thumbnail): array
    {
        $imagePath = "public/$modelName/{$thumbnail->type}/{$thumbnail->pornstar_id}/";

        $images = [];
        foreach ($thumbnail->urls as $url) {
            $imageName = basename($url);

            if (!Storage::exists($imagePath . $imageName)) {
                $imageContent = Http::get($url)->body();
                Storage::put($imagePath . $imageName, $imageContent);
            }

            $images = [
                'url' => Storage::url($imagePath . $imageName),
                'height' => $thumbnail->height,
                'width' => $thumbnail->width,
                'type' => $thumbnail->type,
            ];
        }

        return $images;
    }
}
