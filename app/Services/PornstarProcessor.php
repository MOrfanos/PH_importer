<?php

namespace App\Services;

use App\Contracts\PornstarProcessorInterface;
use App\Models\Attribute;
use App\Models\Pornstar;
use App\Models\Stat;
use App\Models\Thumbnail;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PornstarProcessor implements PornstarProcessorInterface
{
    public function process(array $items): void
    {
        $items = array_slice($items, 0, 50); //TODO remove this

        foreach ($items as $item) {
            try {
                $this->processItem($item);
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }

    protected function processItem(array $item): void
    {
        $item['newHash'] = md5(json_encode($item));

        DB::transaction(function () use ($item) {
            try {
                $pornstar = Pornstar::findOrFail($item['id']);

                if ($pornstar->hash !== $item['newHash']) {

                    $this->updatePornstar($pornstar, $item);
                }
            } catch (ModelNotFoundException) {
                $this->createPornstar($item);
            }
        });
    }

    protected function updatePornstar($pornstar, $item): void
    {
        $pornstar->update([
            'name' => $item['name'],
            'license' => $item['license'],
            'wlStatus' => $item['wlStatus'],
            'link' => $item['link'],
            'aliases' => $item['aliases'] ?? null,
            'hash' => $item['newHash'],
        ]);

        $this->updateRelations($item);
    }

    protected function createPornstar($item): void
    {
        Pornstar::create([
            'id' => $item['id'],
            'name' => $item['name'],
            'license' => $item['license'],
            'wlStatus' => $item['wlStatus'],
            'link' => $item['link'],
            'aliases' => $item['aliases'] ?? null,
            'hash' => $item['newHash'],
        ]);

        $this->updateRelations($item);
    }

    protected function updateRelations($item): void
    {
        if (isset($item['attributes'])) {
            $this->updateAttributes($item['id'], $item['attributes']);
        }

        if (isset($item['attributes']['stats'])) {
            $this->updateStats($item['id'], $item['attributes']['stats']);
        }

        if (isset($item['thumbnails'])) {
            $this->updateThumbnails($item['id'], $item['thumbnails']);
        }
    }

    protected function updateAttributes($pornstarId, $attributes): void
    {
        Attribute::updateOrCreate(
            [
                'pornstar_id' => $pornstarId
            ],
            [
                'hairColor' => $attributes['hairColor'] ?? null,
                'ethnicity' => $attributes['ethnicity'] ?? null,
                'tattoos' => $attributes['tattoos'] ?? null,
                'piercings' => $attributes['piercings'] ?? null,
                'breastSize' => $attributes['breastSize'] ?? null,
                'breastType' => $attributes['breastType'] ?? null,
                'gender' => $attributes['gender'] ?? null,
                'orientation' => $attributes['orientation'] ?? null,
                'age' => $attributes['age'] ?? null,
            ]
        );
    }

    protected function updateStats($pornstarId, $stats): void
    {
        Stat::updateOrCreate(
            [
                'pornstar_id' => $pornstarId
            ],
            [
                'subscriptions' => $stats['subscriptions'] ?? 0,
                'monthlySearches' => $stats['monthlySearches'] ?? 0,
                'views' => $stats['views'] ?? 0,
                'videosCount' => $stats['videosCount'] ?? 0,
                'premiumVideosCount' => $stats['premiumVideosCount'] ?? 0,
                'whiteLabelVideoCount' => $stats['whiteLabelVideoCount'] ?? 0,
                'rank' => $stats['rank'] ?? 0,
                'rankPremium' => $stats['rankPremium'] ?? 0,
                'rankWl' => $stats['rankWl'] ?? 0,
            ]
        );
    }

    protected function updateThumbnails($pornstarId, $thumbnails): void
    {
        foreach ($thumbnails as $thumbnail) {
            Thumbnail::updateOrCreate(
                [
                    'pornstar_id' => $pornstarId,
                    'type' => $thumbnail['type'],
                ],
                [
                    'height' => $thumbnail['height'] ?? null,
                    'width' => $thumbnail['width'] ?? null,
                    'urls' => $thumbnail['urls'],
                ]
            );
        }
    }
}
