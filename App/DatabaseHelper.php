<?php

namespace App;


use project\Database;
use project\ResponseInt;

class DatabaseHelper implements Database
{
    private $pdo;
    private $response;

    public function __construct( ResponseInt $response){
        $this->response =  $response;
        try {

            $this->pdo = new \PDO(DB_CONNECTION["dsn"],DB_CONNECTION["userName"],DB_CONNECTION["password"]);

        }catch (\PDOException $Exception){
            $this->writeToLog('error_db_connection');
            $this->sendError();
        }

    }

    public function executeRequest($methodRequest,$requestParam=[]){

        switch ($methodRequest){
            case "addResult":
                $response = $this->tryTransaction([$this,'addResult'],'error_addResult',$requestParam);
                break;

            case "getResult":
                $response = $this->tryTransaction([$this,'getResult'],'error_getResult');
                break;

        }
        return $response;
    }

    private function tryTransaction($handler,$statusError,$requestParam=[]){
        try {
            $this->pdo->beginTransaction();
            $res =  $handler($requestParam);
            $this->pdo->commit();
            return $res;
        }catch (\Exception $e){
            $this->pdo->rollBack();
            $this->writeToLog($statusError);
            $this->sendError();
        }

    }
    private function addResult($requestParam){
        $strQuery = "INSERT INTO requesthistory(string,result) VALUE (?,?)";
        $res =$this->query($strQuery,$requestParam);

       return $res;

    }

    private function getResult(){
            $strQuery = "SELECT string,result
                         FROM requesthistory";
            $res = $this->query($strQuery,[],\PDO::FETCH_ASSOC);

        return $res;

    }


    private function query($strQuery,$arrQueryParams = [], $typeOutput = \PDO::FETCH_NUM){
            $res = $this->pdo->prepare($strQuery);
            $res->execute($arrQueryParams);
             $res  = $res->fetchAll($typeOutput);
             return $res;

    }
    private function sendError(){
        $this->response->getResponse(['error'], "ERROR");
        $this->response->send();
        die();
   }

    private function writeToLog($data) {
        $log = "\n------------------------\n";
        $log .= date("h:i:s m.d.y")." ".$data;
        $log .= "\n------------------------\n";
        file_put_contents('app\log\error.log', $log, FILE_APPEND);
        return true;
    }

}