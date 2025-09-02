<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Species extends Model
{
    protected $fillable=['id','external_id','name','classification','designation','average_height',
        'skin_colors','hair_colors','eye_colors','average_lifespan','language','created','edited',
        'url','planet_id'];

    public function people(): HasMany
    {
        return $this->hasMany(Person::class);
    }

    public function films(): BelongsToMany
    {
        return $this->belongsToMany(Film::class);
    }

    public function planets(): BelongsToMany
    {
        return $this->belongsToMany(Planet::class);
    }
}
