<?php

namespace App\Http\Controllers\Api;

use App\Services\FilmService;
use Illuminate\Routing\Controller;

class FilmController extends Controller
{
    use LookupResponse;

    public function __construct(protected FilmService $service)
    {
    }
}
