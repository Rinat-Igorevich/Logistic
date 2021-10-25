<?php
require 'config.php';

function getPDO()
{
    $dsn = 'mysql:host=' . DB_CONNECTION_HOST . ';
                dbname=' . DB_CONNECTION_DB_NAME;

    return new PDO(
        $dsn,
        DB_CONNECTION_USER_NAME,
        DB_CONNECTION_PASSWORD
    );
}