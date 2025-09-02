<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Film extends Model
{
    protected $fillable=['id','external_id','title','episode_id','opening_crawl','director',
        'producer','release_date','created','edited','url'];

    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class);
    }

    public function planets(): BelongsToMany
    {
        return $this->belongsToMany(Planet::class);
    }

    public function starships(): BelongsToMany
    {
        return $this->belongsToMany(Starship::class);
    }

    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class);
    }

    public function species(): BelongsToMany
    {
        return $this->belongsToMany(Species::class);
    }
}
