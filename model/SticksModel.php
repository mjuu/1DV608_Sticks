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
    public $cpu;
    public $userWin;
    public $cpuWin;
    public $gameEnded;
    public $lastDraw;
    public $userDraw;
    public $scoreUSER='';
    public $scoreCPU='';

    /**
     * This function sets the array to size 22 and fills it.
     * Adding score to the session.
     */
    public function setArray(){
        $this->gameEnded = false;
        $this->userWin = false;
        $this->cpuWin = false;
        $this->setArr(22);
        if(isset($_SESSION['UserScore'])!=true){
            $_SESSION['CPUScore']='';
            $_SESSION['UserScore']='';
        }
    }

    /**
     * Returns 'true' if user wins else returns 'false'.
     * @return mixed
     */
    public function getUserWin(){
        return $this->userWin;
    }

    /**
     * Returns 'true' if user CPU else returns 'false'.
     * @return mixed
     */
    public function getCPUWin(){
        return $this->cpuWin;
    }

    /**
     * Set userWin to 'true' if user wins and cpuWin to 'false'.
     */
    public function setUSERWin(){
        $this->userWin = true;
        $this->cpuWin = false;
    }

    /**
     * Set cpuWins to 'true' if CPU wins and userWins to 'false'.
     */
    public function setCPUWin(){
        $this->userWin = false;
        $this->cpuWin = true;
    }

    /**
     * Returns user score.
     * @return string
     */
    public function getScoreUser(){

        if(isset($_SESSION['UserScore'])) {
            $te = $_SESSION['UserScore'];
            return 'USER[' . $te . ']';
        }
    }

    /**
     * Returns CPU score
     * @return string
     */
    public function getScoreCPU(){
        if(isset($_SESSION['CPUScore'])){
            $te =$_SESSION['CPUScore'];
            return 'CPU['.$te.']';
        }
    }

    /**
     * Return the array
     * @return mixed
     */
    public function getArr(){
        return $this->array1;
    }

    /**
     * Returns the winner if game has ended
     * @return string
     */
    public function getWinner(){
        if ($this->userWin === true) {
            return '<br><h1>USER WIN!</h1>';
        } elseif ($this->cpuWin === true) {
            return '<h1>CPU WIN!</h1>';
        } else {
            return '';
        }
    }

    /**
     * Set an array with a size and fill it with 'I'.
     * @param $arrSize size of the array
     * @return array
     */
    public function setArr($arrSize){
        $_SESSION['sticks'] = $arrSize;
        if ($arrSize > 0) {
            return $this->array1 = array_fill(1, $arrSize, 'I ');
        }
    }

    /**
     * Return a sting of the array
     * @param $arr
     * @return string
     */
    public function printArr($arr){
        if (empty($arr) !== true)
            return implode('', $arr);
    }

    /**
     * Returns the size of the array
     * @return int
     */
    public function getArrSize(){
        return count($this->array1);
    }


    /**
     * Checks if user draw value is valid. User cant draw higher value if the sticks are fewer.
     * @param $stick
     * @return bool
     */
    public function sticksChecks($stick){

        //Get stick value from the session
        $getSessionValue = $_SESSION['sticks'];
        if ($getSessionValue === 3 && $stick = 3) {
            return true; // return true if sticks left is 3 and user want to draw 3.
        } elseif ($getSessionValue === 2 && $stick = 2) {
            return true; // return true if sticks left is 2 and user want to draw 2.
        } elseif ($getSessionValue === 2 && $stick >= 3) {
            return false; // return false if sticks left is 2 and user want to draw 3.
        }
        if ($getSessionValue === 1 && $stick >= 2) {
            return false; // return false if sticks left is 1 and user want to draw 2 or 3.
        } elseif ($getSessionValue === 1 && $stick = 1) {
            return true; // return true if sticks left is 1 and user want to draw 1.
        } elseif ($getSessionValue === 0 && $stick >= 1) {
            return false; // return false if sticks left is 0 and user want to draw 1 or more.
        } else {
            return true;
        }
    }

    /**
     * The main function for the Sticks game.
     * This function subtract the user and cpu draw
     * Returns the new array
     * @param $value
     * @param $user
     * @return mixed
     */
    public function calcD($value,$user){
        //Check if 'sticks' is set in the session
        if (isset($_SESSION['sticks']) == true) {

            //Get sticks left from session
            $getSessionValue = $_SESSION['sticks'];

            //Subtract the sticks with desired value and set $val to the new value.
            $val = $getSessionValue - $value;

            //Set the sticks left in session
            $_SESSION['sticks'] = $val;

            //Setting the array to current stick value that is left.
            $this->setArr($val);

            //if array is zero, set winner
            if($val==0){
                if($user==1){ //If user=1 draw the last stick
                    //Give score to CPU
                    $_SESSION['CPUScore']+=1;

                    //Set winner
                    $this->userWin = false;
                    $this->cpuWin = true;
                }elseif($user==2){ //If CPU=2 draw the last stick
                    //Give score to User
                    $_SESSION['UserScore']+=1;

                    //Set winner
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