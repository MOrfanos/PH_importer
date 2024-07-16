<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasFactory;

    protected $fillable = [
        'pornstar_id',
        'subscriptions',
        'monthlySearches',
        'views',
        'videosCount',
        'premiumVideosCount',
        'whiteLabelVideoCount',
        'rank',
        'rankPremium',
        'rankWl',
    ];

    protected $hidden = [
        'id',
        'pornstar_id',
        'created_at',
        'updated_at',
    ];
}
