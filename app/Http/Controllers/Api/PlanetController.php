<?php

namespace App\Http\Controllers\Api;

use App\Services\PlanetService;
use Illuminate\Routing\Controller;

class PlanetController extends Controller
{
    use LookupResponse;

    public function __construct(protected PlanetService $service)
    {
    }
}
