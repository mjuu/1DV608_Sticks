<?php
/**
 * Created by PhpStorm.
 * User: Benji
 * Date: 2016-08-18
 * Time: 17:24
 */
namespace model;
class DrawModel{
    public $stickModel;
    public $stickView;
    public $array1;
    
    public function __construct(){
        $this->stickModel = new \model\StickModel();
        $this->stickView = new \view\SticksView();
        //get array
        $this->array1 = $this->stickModel->getArr(22);
    }
    
    public function draw1(){
        
        //$this->stickModel->printArr($this->array1);
        echo '<br>';
        //Substract with 10 (minus 10)
        $this->array1= $this->stickModel->calcDraws($this->array1, 1);
        echo '<br>';
        $this->stickModel->printArr($this->array1);
        echo '<br>';
        //print array size
        $this->stickModel->arraySize($this->array1);
    }
    
    public function draw2(){
        $this->stickModel->printArr($this->array1);
        echo '<br>';
        //Substract with 10 (minus 10)
        $this->array1= $this->stickModel->calcDraws($this->array1, 2);
        echo '<br>';
        $this->stickModel->printArr($this->array1);
        echo '<br>';
        //print array size
        $this->stickModel->arraySize($this->array1);

    }
    
    public function draw3(){
        $this->stickModel->printArr($this->array1);
        echo '<br>';
        //Substract with 10 (minus 10)
        $this->array1= $this->stickModel->calcDraws($this->array1, 3);
        echo '<br>';
        $this->stickModel->printArr($this->array1);
        echo '<br>';
        //print array size
        $this->stickModel->arraySize($this->array1);

    }
    
    public function drawFull(){
        return $this->stickModel->printArr($this->array1);
    }
}
