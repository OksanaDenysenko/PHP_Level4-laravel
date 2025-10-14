<?php

namespace App\Http\Controllers\Api;

use App\Services\VehicleService;
use Illuminate\Routing\Controller;

class VehicleController extends Controller
{
    use LookupResponse;

    public function __construct(protected VehicleService $service)
    {
    }
}
