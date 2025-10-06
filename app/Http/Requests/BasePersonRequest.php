<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BasePersonRequest extends FormRequest
{
    /**
     * Get the base validation rules for the people form.
     * @return array[]
     */
    public function baseRules(): array
    {
        return [
            'height' => ['nullable', 'numeric', 'min:1'],
            'mass' => ['nullable', 'numeric', 'min:1'],
            'hair_color' => ['required', 'string', 'max:50'],
            'skin_color' => ['required', 'string', 'max:50'],
            'eye_color' => ['required', 'string', 'max:50'],
            'birth_year' => ['required', 'string', 'max:50', 'regex:/^(\d+(\.\d+)?)?\s*(BBY|ABY|)$/i'],
            'gender' => ['required', 'string', 'max:100', 'in:male,female,n/a,hermaphrodite'],
            'planet_id' => ['nullable', 'integer', 'exists:planets,id'],
            'species_id' => ['nullable', 'integer', 'exists:species,id'],
            'film_ids' => ['nullable', 'array'],
            'film_ids.*' => ['integer', 'exists:films,id'],
            'vehicle_ids' => ['nullable', 'array'],
            'vehicle_ids.*' => ['integer', 'exists:vehicles,id'],
            'starship_ids' => ['nullable', 'array'],
            'starship_ids.*' => ['integer', 'exists:starships,id'],
        ];
    }
}
