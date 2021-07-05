<?php


namespace App;

use project\Database;
use project\Model;

class BracketsController
{
public static function processData($data, Model $model, Database $db){
    $model->init(BASE_PAIR_BRACKET,$data);
    $model->checkString();
    $model->addResultInDb($db);
    return $model->getResult();
}

public static function getData(Model $model, Database $db){

    return $model->getResultFromDb($db);
}

}