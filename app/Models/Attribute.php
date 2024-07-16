<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'pornstar_id',
        'hairColor',
        'ethnicity',
        'tattoos',
        'piercings',
        'breastSize',
        'breastType',
        'gender',
        'orientation',
        'age',
    ];

    protected $hidden = [
        'id',
        'pornstar_id',
        'created_at',
        'updated_at',
    ];
}
