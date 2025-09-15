<?php

namespace App\Repository;

use App\Models\Person;

class PersonRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(Person::class);
    }
}
