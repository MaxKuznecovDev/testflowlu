<?php


namespace project;



interface ResponseInt
{
    public function getResponse($rawResponse, $requestMethod);
}