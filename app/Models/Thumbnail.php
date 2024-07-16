<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thumbnail extends Model
{
    use HasFactory;

    protected $fillable = [
        'pornstar_id',
        'height',
        'width',
        'type',
        'urls',
    ];

    protected $casts = [
        'urls' => 'array'
    ];

    protected $hidden = [
        'id',
        'pornstar_id',
        'created_at',
        'updated_at',
    ];
}
