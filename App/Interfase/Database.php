<?php


namespace project;


interface Database
{

    public function executeRequest($methodRequest,$requestParam);


}