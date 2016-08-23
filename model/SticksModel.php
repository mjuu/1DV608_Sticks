<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 2016-08-18
 * Time: 13:50
 */
namespace model;
class StickModel{

    public $array1;

    public function setArray(){
        $this->setArr(22);
    }

    public function setArrAfterDraw($value){

        $this->setArr($value);
    }

    public function getArr(){
        return $this->array1;
    }
    /**
     * Return an array
     * @param $arrSize user choose size
     * @return array
     */
    public function setArr($arrSize){
        $_SESSION['sticks']=$arrSize;
        if($arrSize>0){
            return  $this->array1= array_fill(1,$arrSize, 'A');
        }
    }

    /**
     * Substract array with user value
     * @param $arr array to alter
     * @param $value substraction value
     * @return array
     */
    public  function calcDraws($value){
        return $this->array1=array_splice($this->array1,$value);
    }


    public function printArr($arr){

        if(empty($arr)==false){
            foreach ($arr as $i =>$value) {
                echo $value;
            }
        }

    }

    /**
     * @param $arr
     */
    public function arraySize($arr){
       echo count($arr);
    }

    public function getArrSize(){
        return count($this->array1);
    }

    public function drawFull(){
        return $this->printArr($this->array1);
    }

    public function calcD($value){
        if(isset($_SESSION['sticks'])==true){
            $getSessionValue = $_SESSION['sticks'];
            $val = $getSessionValue-$value;
            $_SESSION['sticks']=$val;
            $this->setArr($val);

            return $this->array1;
        }
    }

    public function cpu(){
        $variable = rand(1,3);
        $getSessionValue = $_SESSION['sticks'];

        if($getSessionValue>=6){
            $this->calcD($variable);
            echo 'CPU: '.$variable;
        }elseif($getSessionValue===5){
                $this->calcD(1);
            echo 'CPU: 1';
        }elseif($getSessionValue===4){
            $this->calcD(1);
            echo 'CPU: 1';
        }elseif($getSessionValue===3){
            $this->calcD(2);
            echo 'CPU: 2';
            echo 'User lose';
        }elseif ($getSessionValue===2){
            $this->calcD(1);
            echo 'CPU: 2';
            echo 'User lose';
        }elseif ($getSessionValue===1){
            echo 'session: '.$getSessionValue;
            $this->calcD(1);
            echo 'CPU: 1';
            echo 'User win';
            echo 'session: '.$getSessionValue;

        }elseif ($getSessionValue===0){
            echo 'User loose';
        }
    }

}