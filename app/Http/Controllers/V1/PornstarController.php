<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PornstarBasicInfoResource;
use App\Http\Resources\PornstarResource;
use App\Models\Pornstar;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Request;

class PornstarController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $validated = $request->validate([
            'page' => 'required|integer|min:1',
            'per_page' => 'sometimes|integer|min:1|max:50',
        ]);

        return PornstarBasicInfoResource::collection(
            Pornstar::paginate(
                $validated['per_page'] ?? 10
            )
        );
    }

    public function show(Pornstar $pornstar): PornstarResource
    {
        return PornstarResource::make(
            $pornstar->loadMissing(['stats', 'attributes', 'thumbnails'])
        );
    }
}
