<?php
/**

 * return array with controllers names without authorization. */
return [
        'cv' =>['*'],
    'app' => [
        'app' => ['*'],
        'user' => [
            'login',
            'signup'
        ]
    ]
    ];