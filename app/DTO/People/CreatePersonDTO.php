<?php

namespace App\DTO\People;

use Illuminate\Contracts\Support\Arrayable;

readonly class CreatePersonDTO implements Arrayable
{
    public function __construct(
        public string $name,
        public ?float $height,
        public ?float $mass,
        public string $hair_color,
        public string $skin_color,
        public string $eye_color,
        public string $birth_year,
        public string $gender,
        public ?int   $planet_id,
        public ?int   $species_id,
        public array  $films,
        public array  $vehicles,
        public array  $starships,
    ) {}

    /**
     * The method creates CreatePersonDTO from array
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            height: $data['height'],
            mass: $data['mass'],
            hair_color: $data['hair_color'],
            skin_color: $data['skin_color'],
            eye_color: $data['eye_color'],
            birth_year: $data['birth_year'],
            gender: $data['gender'],
            planet_id: $data['planet_id'],
            species_id: $data['species_id'],
            films: $data['film_ids'] ?? [],
            vehicles: $data['vehicle_ids'] ?? [],
            starships: $data['starship_ids'] ?? [],
        );
    }

    /**
     * The method converts the DTO to an array
     * @return array
     */
    public function toArray(): array
    {
        return (array) $this;
    }
}
