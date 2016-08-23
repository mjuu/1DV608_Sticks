<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 2016-08-18
 * Time: 13:50
 */
namespace controller;
class SticksController{

    public $stickV;
   // public $drawM;
    public $loggedU;
    public $stickMo;
    public function __construct(\view\SticksView $sticks, \view\LoggedUser $loggedUser){

        $this->loggedU=$loggedUser;
        $this->stickV = $sticks;
        //$this->drawM = new \model\DrawModel();
        $this->stickMo = new \model\StickModel();
    }

    public function doControl(){
       // var_dump( $user =$_SESSION['user']);

            if($this->stickV->checkIfDraw()===true){
                if($this->stickV->draw1()==true){

                    $this->stickV->render1();

                }elseif($this->stickV->draw2()==true){

                    $this->stickV->render2();
                }elseif($this->stickV->draw3()==true){
                    $this->stickV->render3();
                }
            }

        }

        public function refreshPage(){
            $refreshed = 0;
            if($this->stickV->restartClicked()==true){
                if($refreshed=0){
                    $this->stickV->refresh();
                    $refreshed=1;
                }

            }
        }

}