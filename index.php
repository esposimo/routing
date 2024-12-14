<?php


require './vendor/autoload.php';

$logic = [
    'request_uri' =>
    [
        'logic' => 'equal', // qui ci metti la classe che fa l'assert
        'values' => [ // qui ci metti i valori accettati dalla classe in logic
            'api', 'websocket' , 'blog'
        ],
        'and' => [
            'request_action' =>
            [
                'logic' => 'equal',
                'values' => ''
            ]
        ]
    ]
];


print_r(\smn\routing\Request::getInfoRequest());
echo PHP_EOL;






