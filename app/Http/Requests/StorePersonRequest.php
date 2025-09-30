<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePersonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100', 'unique:people,name'],
            'height' => ['nullable', 'numeric', 'min:1'],
            'mass'=>['nullable', 'numeric', 'min:1'],
            'hair_color'=>['nullable', 'string', 'max:50'],
            'skin_color'=>['nullable', 'string', 'max:50'],
            'eye_color'=>['nullable', 'string', 'max:50'],
            'birth_year'=>['nullable', 'string', 'max:50'],
            'gender'=>['nullable', 'string', 'max:100', 'in:male,female,n/a,none,hermaphrodite'],
            'homeworld'=>[],
            'films'=>[],
            'species'=>[],
            'vehicles'=>[],
            'starships'=>[],


            // Поля ForeignId (Один до Багатьох)
            'planet_id' => ['nullable', 'integer', 'exists:planets,id'],
            'species_id' => ['nullable', 'integer', 'exists:species,id'],

            // Поля Many-to-Many (Масив ID фільмів)
            'film_ids' => ['nullable', 'array'],
            'film_ids.*' => ['integer', 'exists:films,id'],
        ];
    }
}
