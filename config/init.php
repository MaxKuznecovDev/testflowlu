<?php
define("DEBUG",0 );
define("DB_CONNECTION", ['dsn'=>"mysql:host=localhost;dbname=testflowlu_db;charset=utf8","userName"=>"root","password"=>"root" ]);
define("BASE_PAIR_BRACKET", [
    ["(",")"],
    ["[","]"],
    ["<",">"],
    ["{","}"]
]);