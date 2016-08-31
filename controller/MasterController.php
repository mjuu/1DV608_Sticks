<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 2016-08-18
 * Time: 20:38
 */
namespace controller;


use view\LoggedUser;
use view\Sticks;

class MasterController
{
    private $loginView;
    private $loginCont;
    private $loggedU;
    private $stickV;
    private $stickCon;

    /**
     * MasterController constructor.
     * @param \view\SticksView $stV
     * @param \view\LoginView $lv
     * @param LoginController $loginC
     * @param SticksController $sticksController
     * @param LoggedUser $loggedUser
     */
    public function __construct( \view\SticksView $stV ,\view\LoginView $lv, \controller\LoginController $loginC, \controller\SticksController $sticksController, \view\LoggedUser $loggedUser){
        $this->loginView = $lv;
        $this->loginCont = $loginC;
        $this->loggedU = $loggedUser;
        $this->stickV = $stV;
        $this->stickCon = $sticksController;

    }

    /**
     * Control this webbpage.
     */
    public function doControl(){
        
        //If user want to register pass them to register controller
        if($this->loginView->wantToRegisterURL()==true){
            $this->loginCont->registerControl();
            //Else if user is logged in and member url typed, show member page
        } //If user is logged in, redirect them to member area
        elseif($this->loginView->loggedIN() == 1){
            //If "member" is typed in url, send to member page
            if ($this->loggedU->memberPage() == true){
                $this->stickV->renderFallback();

            }elseif($this->stickV->draw1Clicked()||$this->stickV->draw2Clicked()||$this->stickV->draw3Clicked()===true) {
                $this->stickCon->doControl();
            }elseif($this->stickV->restartClicked()==true){
                $this->stickV->renderV1();
            }else{
                //send user back to member page if url is altered
                $this->stickV->renderFallback();
            }//do logout
            if ($this->loggedU->getLogout() == true) {
                $this->loggedU->doLogout();
            }
        }
        //if use is not logged in, show login page
        else{
            $this->loginCont->control();
        }
    }
}