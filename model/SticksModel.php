<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 2016-08-18
 * Time: 13:50
 */
namespace model;
class StickModel
{

    public $array1;
    public $cpu;
    public $userWin;
    public $cpuWin;
    public $gameEnded;
    public $lastDraw;
    public $userDraw;
    public $scoreUSER='';
    public $scoreCPU='';

    public function setArray()
    {
        $this->gameEnded = false;
        $this->userWin = false;
        $this->cpuWin = false;
        $this->setArr(22);
        if(isset($_SESSION['UserScore'])!=true){
            $_SESSION['CPUScore']='';
            $_SESSION['UserScore']='';
        }
    }

    public function getUserWin()
    {
        return $this->userWin;
    }

    public function getCPUWin()
    {
        return $this->cpuWin;
    }

    public function setUSERWin()
    {
        $this->userWin = true;
        $this->cpuWin = false;
    }

    public function setCPUWin()
    {
        $this->userWin = false;
        $this->cpuWin = true;
    }

    public function getScoreUser(){

        if(isset($_SESSION['UserScore'])) {
            $te = $_SESSION['UserScore'];
            return 'USER[' . $te . ']';
        }
    }
    public function getScoreCPU(){
        if(isset($_SESSION['CPUScore'])){
            $te =$_SESSION['CPUScore'];
            return 'CPU['.$te.']';
        }
    }

    public function getArr()
    {
        return $this->array1;
    }

    public function getGameEnded() //not using
    {
        return $this->gameEnded;
    }

    public function getWinner()
    {
        if ($this->userWin === true) {
            $this->getGameEnded = true;

            return '<br><h1>USER WIN!</h1>';
        } elseif ($this->cpuWin === true) {
            $this->getGameEnded = true;

            return '<h1>CPU WIN!</h1>';
        } else {
            $this->gameEnded = false;
            return '';
        }
    }

    /**
     * Return an array
     * @param $arrSize user choose size
     * @return array
     */
    public function setArr($arrSize)
    {
        $_SESSION['sticks'] = $arrSize;
        if ($arrSize > 0) {
            return $this->array1 = array_fill(1, $arrSize, 'I ');
        }
    }

    /**
     * Substract array with user value
     * @param $arr array to alter
     * @param $value substraction value
     * @return array
     */
    public function calcDraws($value) //not using
    {
        return $this->array1 = array_splice($this->array1, $value);
    }

    /**
     * Return a sting of the array
     * @param $arr
     * @return string
     */
    public function printArr($arr)
    {
        if (empty($arr) !== true)
            return implode('', $arr);
    }


    /**
     * @param $arr
     */
    public function arraySize($arr) //not useing
    {
        echo count($arr);
    }

    public function getArrSize()
    {
        return count($this->array1);
    }


    /**
     * Checks if user draw value is valid. User cant draw higher value if the sticks are fewer.
     * @param $stick
     * @return bool
     */
    public function sticksChecks($stick){
        $getSessionValue = $_SESSION['sticks'];
        if ($getSessionValue === 3 && $stick = 3) {
            return true;
        } elseif ($getSessionValue === 2 && $stick = 2) {
            return true;
        } elseif ($getSessionValue === 2 && $stick >= 3) {
            return false;
        }
        if ($getSessionValue === 1 && $stick >= 2) {
            return false;
        } elseif ($getSessionValue === 1 && $stick = 1) {
            return true;
        } elseif ($getSessionValue === 0 && $stick >= 1) {
            return false;
        } else {
            return true;
        }
    }

    public function calcD($value,$user){

        $us = $user;
        if (isset($_SESSION['sticks']) == true) {
            $getSessionValue = $_SESSION['sticks'];
            $val = $getSessionValue - $value;
            $_SESSION['sticks'] = $val;
            $this->setArr($val);

            //if array is zero, set winner
            if($val==0){
                if($us==1){

                    //Give score to CPU
                    $_SESSION['CPUScore']+=1;
                      $this->userWin = false;
                       $this->cpuWin = true;
                }elseif($us==2){
                    //Give score to User
                    $_SESSION['UserScore']+=1;
                      $this->userWin = true;
                      $this->cpuWin = false;
                }
            }else{

            }
            return $this->array1;
        }
    }

    /**
     * Simple AI that plays with user.
     * CPU draw random number 1-3 if sticks are more than 9.
     * Setting the last draw as CPU after runtime.
     */
    public function cpu()
    {
        $variable = rand(1, 3);
        $getSessionValue = $_SESSION['sticks'];
        $this->lastDraw=2;
        if ($getSessionValue >= 9) {
            $this->calcD($variable,2);
            $_SESSION['cpu'] = $variable;
        }elseif ($getSessionValue === 8){
            $this->calcD($variable,2);
            $_SESSION['cpu'] = $variable;
        } elseif ($getSessionValue === 7){
            $this->calcD(2,2);
            $_SESSION['cpu'] = '2';
        } elseif ($getSessionValue === 6){
            $this->calcD(1,2);
            $_SESSION['cpu'] = '1';
        } elseif ($getSessionValue === 5) {
            $this->calcD($variable,2);
            $_SESSION['cpu'] = $variable;
        } elseif ($getSessionValue === 4) {
            $this->calcD(3,2);
            $_SESSION['cpu'] = '3';
        } elseif ($getSessionValue === 3) {
            $this->calcD(2,2);
            $_SESSION['cpu'] = '2';
        } elseif ($getSessionValue === 2) {
            $this->calcD(1,2);
            $_SESSION['cpu'] = '1';
        } elseif ($getSessionValue === 1) {
            $this->calcD(1,2);
            $_SESSION['cpu'] = '1';
        } elseif ($getSessionValue === 0) {
            }
        }

    /**
     * Setting the last draw as the User
     */
    public function setUserDraw(){
        $this->lastDraw=1;
    }

}