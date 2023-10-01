<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Embed extends Model
{
    use HasFactory;
    protected $table = 'embed';

    protected $fillable = [
        'embed_url',
        'band_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
