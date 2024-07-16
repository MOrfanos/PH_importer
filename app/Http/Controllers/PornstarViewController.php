<?php

namespace App\Http\Controllers;

use App\Contracts\StorageServiceInterface;
use App\Models\Pornstar;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;

class PornstarViewController
{
    public function __construct(protected StorageServiceInterface $storageService)
    {
    }

    public function index(): Factory|Application|View|ApplicationContract
    {
        return view('pornstars.index');
    }

    public function show(Pornstar $pornstar): Factory|Application|View|ApplicationContract
    {
        $pornstar->loadMissing(['stats', 'attributes', 'thumbnails']);

        return view('pornstars.show', compact('pornstar'));
    }
}
