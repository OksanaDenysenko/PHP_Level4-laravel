<?php

return [
    'endpoints' => [
        [
            'name' => 'vehicles',
            'url' => 'https://swapi-api.hbtn.io/api/vehicles/',
            'queue' => 1
        ],
        [
            'name' => 'starships',
            'url' => 'https://swapi-api.hbtn.io/api/starships/',
            'queue' => 1
        ],
        [
            'name' => 'planets',
            'url' => 'https://swapi-api.hbtn.io/api/planets/',
            'queue' => 1
        ],
        [
            'name' => 'species',
            'url' => 'https://swapi-api.hbtn.io/api/species/',
            'queue' => 2
        ],
        [
            'name' => 'films',
            'url' => 'https://swapi-api.hbtn.io/api/films/',
            'queue' => 3
        ],
        [
            'name' => 'people',
            'url' => 'https://swapi-api.hbtn.io/api/people/',
            'queue' => 4
        ],
    ],
];
