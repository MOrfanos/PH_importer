<?php

namespace App\Services;

use App\Contracts\MetadataStorageInterface;
use App\Models\JsonMetadata;
use Carbon\Carbon;

class MetadataStorage implements MetadataStorageInterface
{
    public function storeMetadata($response): void
    {
        JsonMetadata::create([
            'url' => config('import.pornstars_url'),
            'etag' => $response->header('etag'),
            'last_modified' => Carbon::parse($response->header('last-modified'))->format('Y-m-d H:i:s'),
        ]);
    }
}
