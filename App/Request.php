<?php

namespace app;


class Request
{
    public $requestMethod;
    public $requestBody;



    public function __construct()
    {
        $this->requestMethod = $_SERVER["REQUEST_METHOD"];
        $this->getRequestBody();
    }


    private function getRequestBody(){

        if($this->requestMethod === "POST" ){
            $this->requestBody = $this->normalizeRequestBody($this->getRawRequestBody());
        }

    }

    private function normalizeRequestBody($rawRequestBody){
     return json_decode($rawRequestBody);
    }


    private function getRawRequestBody(){
        return file_get_contents("php://input");
    }

}