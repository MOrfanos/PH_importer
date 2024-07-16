<?php

namespace App\Traits;

use App\Contracts\StorageServiceInterface;

trait HandlesImages
{
    public function setStorageService(StorageServiceInterface $storageService): void
    {
        $this->storageService = $storageService;
    }

    public function downloadImage($modelName, $thumbnail): array
    {
        $imagePath = "public/$modelName/{$thumbnail->type}/{$thumbnail->pornstar_id}/";

        $images = [];
        foreach ($thumbnail->urls as $url) {
            $imageName = basename($url);

            if (!$this->storageService->exists($imagePath . $imageName)) {
                $imageContent = $this->storageService->get($url);
                $this->storageService->put($imagePath . $imageName, $imageContent);
            }

            $images = [
                'url' => $this->storageService->url($imagePath . $imageName),
                'height' => $thumbnail->height,
                'width' => $thumbnail->width,
                'type' => $thumbnail->type,
            ];
        }

        return $images;
    }
}
