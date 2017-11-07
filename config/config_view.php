<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$scripts = [
    '*' => [
        [
            'link' => 'https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js',
            'part' => 'head'
        ],
        [
            'link' => 'https://oss.maxcdn.com/respond/1.4.2/respond.min.js',
            'part' => 'head'
        ],
        [
            'link' => '/public/js/jquery/jquery-3.2.1.min.js',
            'part' => 'body_end'
        ],
        
        [
            'link' => '/public/bootstrap/js/bootstrap.min.js',
            'part' => 'body_end'
        ],
        [
            'link' => '/public/bootstrap/js/jasny-bootstrap.min.js',
            'part' => 'body_end'
        ],
        [
            'link' => '/public/bootstrap-fileinput/js/fileinput.min.js',
            'part' => 'body_end'
        ]
    ],
    'currency_list' =>[
        [
        'link' => '/public/js/currency.js',
        'part' => 'body_end'
        ]
    ]
];

