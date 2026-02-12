<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Camera extends Model
{
    protected $table = 'camaras';

    protected $fillable = [
        'name',
        'location',
        'stream_url',
        'preview_url',
    ];
}
