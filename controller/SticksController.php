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
    public $loggedU;

    /**
     * SticksController constructor.
     * @param \view\SticksView $sticks
     * @param \view\LoggedUser $loggedUser
     */
    public function __construct(\view\SticksView $sticks, \view\LoggedUser $loggedUser){
        $this->loggedU=$loggedUser;
        $this->stickV = $sticks;
    }

    /**
     * Do draw control.
     * If user want to draw 'n'-number this control will make the draw happen
     */
    public function doControl(){
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
}