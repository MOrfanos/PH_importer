<?php

namespace App\Contracts;

interface StorageServiceInterface
{
    public function exists(string $path): bool;
    public function put(string $path, string $content): void;
    public function get(string $url): string;
    public function url(string $url): string;
    public function deleteDirectoryContents(string $directory): void;
}
