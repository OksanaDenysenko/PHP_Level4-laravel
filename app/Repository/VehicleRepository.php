<?php

namespace App\Repository;

use App\Models\Vehicle;

class VehicleRepository extends Repository
{
     protected string $model {
        get {
            return Vehicle::class;
        }
    }
}
