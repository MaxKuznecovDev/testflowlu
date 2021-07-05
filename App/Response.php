<?php
namespace App;


use project\ResponseInt;

class Response implements ResponseInt
{
    private $response;

    public function getResponse($rawResponse, $requestMethod){

        switch ($requestMethod){
            case "POST":
                $this->response = $this->handlerPost($rawResponse);
                break;

            case "GET":
                $this->response = $this->handlerGet($rawResponse);
                break;
            case "ERROR":
                $this->response = $this->handlerError($rawResponse);
        }
    }

    private function handlerPost($rawResponse){

        return [
            'status_code' => 200,
            'status_text' => "POST request successful",
            'data' => $this->serialize($rawResponse)
        ];
    }


    private function handlerGet($rawResponse){

        return [
            'status_code' => 200,
            'status_text' => "GET request successful",
            'data' => $this->serialize($rawResponse)
        ];
    }
    private function handlerError($rawResponse){
        return [
            'status_code' => 500,
            'status_text' => "Server Error!",
            'data' => $this->serialize($rawResponse)
        ];
    }

    private function serialize($data){
        return json_encode($data);
    }

    public function send(){
        $stringResponse = "HTTP/1.0 {$this->response['status_code']} {$this->response['status_text']}";
        header($stringResponse);
        echo $this->response['data'];

    }

}