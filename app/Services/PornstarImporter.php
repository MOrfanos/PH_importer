<?php

namespace App\Services;

use App\Contracts\MetadataStorageInterface;
use App\Contracts\PornstarImporterInterface;
use App\Contracts\PornstarProcessorInterface;
use App\Contracts\StorageServiceInterface;
use App\Models\JsonMetadata;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PornstarImporter implements PornstarImporterInterface
{
    public function __construct(
        protected MetadataStorageInterface $metadataStorage,
        protected PornstarProcessorInterface $pornstarProcessor,
        protected StorageServiceInterface $storageService
    )
    {}

    public function import(): void
    {
        $latestRequest = JsonMetadata::latest()->first();

        $headers = $this->prepareHeaders($latestRequest);

        $response = Http::withHeaders($headers)->get(config('import.pornstars_url'));

        if (
            $response->status() === Response::HTTP_NOT_MODIFIED ||
            $response->header('etag') === $latestRequest?->etag
        ) {
            Log::info('Skip importing pornstars, JSON has not changed');
            die;
        }

        $this->storageService->deleteDirectoryContents(config('import.pornstars_thumbnails_directory'));

        $this->metadataStorage->storeMetadata($response);

        $this->pornstarProcessor->process($response->json()['items']);
    }

    protected function prepareHeaders($latestRequest): array
    {
        if ($latestRequest) {
            return [
                'If-None-Match' => $latestRequest->etag,
                'If-Modified-Since' => $latestRequest->last_modified,
            ];
        }

        return [];
    }
}
