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

    public function setArray()
    {
        $this->gameEnded = false;
        $this->userWin = false;
        $this->cpuWin = false;
        $this->setArr(22);
    }

    public function setArrAfterDraw($value)
    {

        $this->setArr($value);
    }

    public function getCpu()
    {
        return $this->cpu;
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

    public function getArr()
    {
        return $this->array1;
    }

    public function getGameEnded()
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
    public function calcDraws($value)
    {
        return $this->array1 = array_splice($this->array1, $value);
    }

    public function printArr($arr)
    {
        if (empty($arr) !== true)
            return implode('', $arr);
    }


    /**
     * @param $arr
     */
    public function arraySize($arr)
    {
        echo count($arr);
    }

    public function getArrSize()
    {
        return count($this->array1);
    }


    public function sticksChecks($stick)
    {
        $getSessionValue = $_SESSION['sticks'];
        if ($getSessionValue === 3 && $stick = 3) {
            return true;
        } elseif ($getSessionValue === 2 && $stick = 2) {
            return true;
        } elseif ($getSessionValue === 2 && $stick >= 3) {
            echo 'test >2';
            return false;
        }
        if ($getSessionValue === 1 && $stick >= 2) {
            return false;
        } elseif ($getSessionValue === 1 && $stick = 1) {
            echo 'test >1';
            return true;
        } elseif ($getSessionValue === 0 && $stick >= 1) {
            echo 'test 0';
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
            if($val==0){
                if($us==1){

                    echo 'test1';
                      $this->userWin = false;
                       $this->cpuWin = true;
                }elseif($us==2){
                      $this->userWin = true;
                      $this->cpuWin = false;
                    echo 'test2';
                }
            }else{

            }
            return $this->array1;
        }
    }

    public function cpu()
    {
        $variable = rand(1, 3);
        $getSessionValue = $_SESSION['sticks'];

        $this->lastDraw=2;
        if ($getSessionValue >= 6) {
            $this->calcD($variable,2);
            $this->cpu = $variable;
            $_SESSION['cpu'] = $this->cpu;
        } elseif ($getSessionValue === 5) {
            $this->calcD(1,2);
            $_SESSION['cpu'] = '1';
        } elseif ($getSessionValue === 4) {
            $this->calcD(1,2);
            $_SESSION['cpu'] = '1';
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

    public function setUserDraw(){
        $this->lastDraw=1;
    }

}