<?php

return [
    'class' => 'yii\db\Connection',
//    'dsn' => 'mysql:host=localhost;dbname=vacations_db',
    'dsn' => 'mysql:host=localhost:3307;dbname=vacations_db',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
