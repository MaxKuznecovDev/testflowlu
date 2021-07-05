<?php

namespace App;
use project\Database;
use project\Model;

class BracketsModel implements Model
{
        private $basePairOfBrackets;
        private $buffer=[];
        private $inputStr;
        private $result;

        public function init($basePairArr,$inputStr){
            $this->basePairOfBrackets = $basePairArr;
            $this->inputStr = $this->secureString($inputStr);
        }
        public function checkString(){
            $strArr = str_split($this->inputStr);
            foreach ($strArr as $char){
                if($this->checkTypeBracket($char,0)){
                    array_push($this->buffer,$char);
                }
                if($this->checkTypeBracket($char,1)){
                    foreach ($this->basePairOfBrackets as $pairOfBrackets){
                        if($this->noMatchInBuffer($pairOfBrackets, $char)){
                            $this->result = "false";
                            return;
                        }elseif($this->matchInBuffer($pairOfBrackets, $char)){
                            array_pop($this->buffer);
                        }
                    }
                }
            }
            if(empty($this->buffer)){
                $this->result =  "true";
            }else {
                $this->result =  "false";
            }

        }
        public function addResultInDb(Database $db){
            $db->executeRequest("addResult", [$this->inputStr, $this->result]);
        }
        public function getResultFromDb(Database $db){
            return $db->executeRequest("getResult");
        }
        private function checkTypeBracket($char,$type){
            foreach ($this->basePairOfBrackets as $brackets){
                if($brackets[$type] ===$char){
                    return true;
                }
            }
            return false;
        }
        private function noMatchInBuffer($pairOfBrackets,$char){
            if($pairOfBrackets[1] === $char && end($this->buffer) !== $pairOfBrackets[0]){
                return true;
            }
            return false;
        }
        private function matchInBuffer($pairOfBrackets,$char){
            if($pairOfBrackets[1] === $char && end($this->buffer) == $pairOfBrackets[0]){
                return true;
            }
            return false;
        }
        private function secureString($str){
            return htmlspecialchars(stripslashes(trim($str)));
        }
        public function getResult(){
            return $this->result;
        }

}