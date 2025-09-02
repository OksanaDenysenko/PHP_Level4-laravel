<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Planet extends Model
{
    protected $fillable=['id','external_id','name','rotation_period','orbital_period','diameter','climate'
        ,'gravity','terrain','surface_water','population','created','edited','url'];

    public function people(): HasMany
    {
        return $this->hasMany(Person::class);
    }

    public function films(): BelongsToMany
    {
        return $this->belongsToMany(Film::class);
    }

    public function species(): BelongsToMany
    {
        return $this->belongsToMany(Species::class);
    }
}
