<?php

namespace App\DTOs\City;

readonly class CityDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $country
    ) {}
       
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'text' => ($this->name . ' - ' .$this->country)
        ];
    }
}
