<?php

if (IS_RELEASE) {
 // release db connect
}

if (!IS_TEST) {
    return [
        'host' => 'localhost',
        'user' => 'root',
        'password' => '123',
        'database' => 'local_db'
    ];
}

// test db config
return [
    'host' => 'localhost',
    'user' => 'root',
    'password' => '123',
    'database' => 'test_db'
];
