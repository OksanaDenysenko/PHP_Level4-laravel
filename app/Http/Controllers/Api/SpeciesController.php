<?php

namespace App\Http\Controllers\Api;

use App\Services\SpeciesService;
use Illuminate\Routing\Controller;

class SpeciesController extends Controller
{
    use LookupResponse;

    public function __construct(protected SpeciesService $service)
    {
    }
}
