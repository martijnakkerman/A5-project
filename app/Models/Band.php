<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Band extends Model
{
    use HasFactory;

    protected $table = 'band';

    protected $fillable = [
        'name',
        'description',
        'biography',
        'image_path',
        'text_color',
        'background_color',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_band');
    }
    public function embeds() {
        return $this->hasMany('App\Models\Embed', 'band_id');
    }
}
