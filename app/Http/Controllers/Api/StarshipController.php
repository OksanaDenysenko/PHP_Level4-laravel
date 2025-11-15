<?php

namespace App\Http\Controllers\Api;

use App\Services\StarshipService;
use Illuminate\Routing\Controller;

class StarshipController extends Controller
{
    use LookupResponse;

    public function __construct(protected StarshipService $service)
    {
    }
}
