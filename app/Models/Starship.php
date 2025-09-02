<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Starship extends Model
{
    protected $fillable=['id','external_id','name','model','manufacturer','cost_in_credits','length',
        'max_atmosphering_speed', 'crew','passengers','cargo_capacity','consumables','hyperdrive_rating',
        'MGLT','starship_class','created','edited','url'];

    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class);
    }

    public function films(): BelongsToMany
    {
        return $this->belongsToMany(Film::class);
    }
}
