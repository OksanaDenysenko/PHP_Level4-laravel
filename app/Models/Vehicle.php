<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vehicle extends Model
{
    protected $fillable=['id','external_id','name','model','manufacturer','cost_in_credits','length',
        'max_atmosphering_speed', 'crew','passengers','cargo_capacity','consumables','vehicle_class',
        'created','edited','url'];

    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class);
    }

    public function films(): BelongsToMany
    {
        return $this->belongsToMany(Film::class);
    }
}
