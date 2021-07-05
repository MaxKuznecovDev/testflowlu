<?php
require_once './vendor/autoload.php';
require_once 'config/init.php';


use App\BracketsModel;
use App\DatabaseHelper;
use App\Request;
use App\BracketsController;
use App\Response;


$request = new Request();
if($request->requestMethod === "POST"){
    $response = new Response();
    $result = BracketsController::processData($request->requestBody,new BracketsModel(),new DatabaseHelper( $response));

    $response->getResponse(["success"=>$result], "POST");
    $response->send();
}elseif($request->requestMethod === "GET"){
    $response = new Response();
    $result = BracketsController::getData(new BracketsModel(),new DatabaseHelper( $response));

    $response->getResponse($result, "GET");
    $response->send();
}


