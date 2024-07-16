<?php

namespace App\Models;

use App\Traits\HandlesImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pornstar extends Model
{
    use HasFactory;
    use HandlesImages;

    protected $fillable = [
        'id',
        'name',
        'license',
        'wlStatus',
        'customId',
        'link',
        'aliases',
        'hash',
    ];

    protected $appends = ['cachedThumbnails'];

    protected $casts = [
        'aliases' => 'array',
    ];

    public function attributes(): HasOne
    {
        return $this->hasOne(Attribute::class, 'pornstar_id');
    }

    public function stats(): HasOne
    {
        return $this->hasOne(Stat::class, 'pornstar_id');
    }

    public function thumbnails(): HasMany
    {
        return $this->hasMany(Thumbnail::class, 'pornstar_id');
    }

    public function getCachedThumbnailsAttribute(): array
    {
        $images = [];
        foreach ($this->thumbnails as $thumbnail) {
            $images[] = $this->downloadImage(strtolower(class_basename($this)), $thumbnail);
        }

        return $images;
    }
}
