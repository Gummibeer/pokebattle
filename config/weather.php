<?php

return [
    'ratio' => [
        'sun',
        'sun',
        'sun',
        'sun',
        'sun',
        'sun',
        'sun',
        'fog',
        'fog',
        'fog',
        'cloud',
        'cloud',
        'cloud',
        'cloud',
        'cloud',
        'drizzle',
        'drizzle',
        'rain',
        'rain',
        'rain',
        'lightning',
        'lightning',
        'snow',
        'snow',
        'snow',
        'hail',
        'hail',
        'wind',
        'wind',
        'wind',
        'tornado',
    ],

    'cloud' => [
        'type' => 'cloud',
        'temp' => floor(rand(10, 30)),
        'wind' => floor(rand(5, 25)),
        'types' => [
            'normal', 'fighting',
        ],
    ],
    'drizzle' => [
        'type' => 'drizzle',
        'temp' => floor(rand(5, 20)),
        'wind' => floor(rand(2, 10)),
        'types' => [
            'bug', 'poison', 'grass',
        ],
    ],
    'fog' => [
        'type' => 'fog',
        'temp' => floor(rand(5, 25)),
        'wind' => floor(rand(0, 1)),
        'types' => [
            'dark', 'ghost', 'psychic',
        ],
    ],
    'hail' => [
        'type' => 'hail',
        'temp' => floor(rand(-20, 0)),
        'wind' => floor(rand(5, 10)),
        'types' => [
            'ice',
        ],
    ],
    'lightning' => [
        'type' => 'lightning',
        'temp' => floor(rand(5, 20)),
        'wind' => floor(rand(10, 20)),
        'types' => [
            'electric', 'steel',
        ],
    ],
    'rain' => [
        'type' => 'rain',
        'temp' => floor(rand(10, 20)),
        'wind' => floor(rand(2, 10)),
        'types' => [
            'water',
        ],
    ],
    'snow' => [
        'type' => 'snow',
        'temp' => floor(rand(-15, 5)),
        'wind' => floor(rand(0, 10)),
        'types' => [
            'ice',
        ],
    ],
    'wind' => [
        'type' => 'wind',
        'temp' => floor(rand(10, 25)),
        'wind' => floor(rand(25, 40)),
        'types' => [
            'flying', 'fairy',
        ],
    ],
    'sun' => [
        'type' => 'sun',
        'temp' => floor(rand(20, 40)),
        'wind' => floor(rand(0, 2)),
        'types' => [
            'fire', 'ground', 'rock',
        ],
    ],
    'tornado' => [
        'type' => 'tornado',
        'temp' => floor(rand(5, 15)),
        'wind' => floor(rand(40, 100)),
        'types' => [
            'dragon',
        ],
    ],
];