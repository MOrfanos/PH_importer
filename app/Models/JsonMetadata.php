<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JsonMetadata extends Model
{
    use HasFactory;

    protected $table = 'json_metadata';

    protected $fillable = [
        'url',
        'etag',
        'last_modified'
    ];
}
