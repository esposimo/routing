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


/**
 *  Classe request uri che accetta una logica e dei valori. Il valore è descritto in values e deve essere del tipo richiesto da logic
 *  La classe and effettua un assert su ciò che c'è dentro (in maniera ricorsiva)
 *
 */


$url = '/cnt/action/other/data';
$request_uri = $logic['request_uri'];

echo var_dump(smn\routing\logic\Assert::Equal($request_uri['values'], 'api'));




