<?php
return [
    'default' => [
        'options' => [
            'CURLOPT_RETURNTRANSFER' => true,
            'CURLOPT_HEADER' => true,
            'CURLOPT_TIMEOUT' => 30,
        ],
        'headers' => [
            'Content-Type' => 'application/json',
        ],
    ],
];