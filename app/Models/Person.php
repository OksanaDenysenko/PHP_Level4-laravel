<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Person extends Model
{
    protected $fillable=['id','external_id','name','height','mass','hair_color','skin_color','eye_color',
        'birth_year','gender','created','edited','url', 'planet_id', 'species_id'];

    public function planet(): BelongsTo
    {
        return $this->belongsTo(Planet::class);
    }

    public function spesies(): BelongsTo
    {
        return $this->belongsTo(Species::class);
    }

    public function films(): BelongsToMany
    {
        return $this->belongsToMany(Film::class);
    }

    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class);
    }

    public function starships(): BelongsToMany
    {
        return $this->belongsToMany(Starship::class);
    }
}
