<?php

namespace App\Services;

use App\Contracts\StorageServiceInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class StorageService implements StorageServiceInterface
{
    public function exists(string $path): bool
    {
        return Storage::exists($path);
    }

    public function put(string $path, string $content): void
    {
        Storage::put($path, $content);
    }

    public function get(string $url): string
    {
        return Http::get($url)->body();
    }

    public function deleteDirectoryContents(string $directory): void
    {
        $files = Storage::allFiles($directory);
        Storage::delete($files);

        $directories = Storage::allDirectories($directory);
        foreach ($directories as $dir) {
            $this->deleteDirectoryContents($dir);
        }

        Storage::deleteDirectory($directory);
    }

}
