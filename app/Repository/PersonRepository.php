<?php

namespace App\Repository;

use App\Models\Person;

class PersonRepository extends Repository
{
    protected string $model = Person::class;
}
