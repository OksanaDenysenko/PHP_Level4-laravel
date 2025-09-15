<?php

namespace App\Http\Controllers;


use App\Repository\FilmRepository;
use App\Repository\PersonRepository;

class TestController extends Controller
{
    public function index(): void
    {
        $date=new FilmRepository()->getIdByExternalId('2');
        $date=new PersonRepository()->getIdByExternalId('26');
        dump($date);
    }

}
