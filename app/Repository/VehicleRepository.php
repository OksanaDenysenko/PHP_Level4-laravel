<?php

namespace App\Repository;

use App\Models\Vehicle;

class VehicleRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(Vehicle::class);
    }

}
