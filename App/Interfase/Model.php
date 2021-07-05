<?php


namespace project;


interface Model
{
    public function init($basePairArr,$inputStr);
    public function checkString();
    public function addResultInDb(Database $db);
    public function getResultFromDb(Database $db);
    public function getResult();
}