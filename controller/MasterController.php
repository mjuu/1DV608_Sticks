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
    private $uploadView;
    private $view;
    private $loginView;
    private $loginDal;
    private $loginCont;
    private $loggedU;

    private $stickV;

    /**
     * MasterController constructor.
     * @param Sticks $stV
     * @param \view\UploadView $uploadView
     * @param \view\View $view
     * @param \view\LoginView $lv
     * @param \model\LoginDAL $ld
     * @param LoginController $loginC
     */
    public function __construct( \view\Sticks $stV ,\view\UploadView $uploadView, \view\View $view,\view\LoginView $lv, \model\LoginDAL $ld, \controller\LoginController $loginC)
    {
        $this->uploadView = $uploadView;
        $this->view = $view;
        $this->loginView = $lv;
        $this->loginDal= $ld;
        $this->loginCont = $loginC;
        $this->loggedU = new LoggedUser();
        $this->stickV = $stV;

    }

    /**
     * Control this webbpage.
     */
    public function doControl(){

        //If user want to register pass them to register controller
        if($this->loginView->wantToRegisterURL()==true){
            $this->loginCont->registerControl();
            //Else if user is logged in and member url typed, show member page
        }
        //If user is logged in, redirect them to member area
        elseif($this->loginView->loggedIN() == 1){
            //If "member" is typed in url, send to member page
            if ($this->loggedU->memberPage() == true) {
                $this->loggedU->render();
            }else{
                //send user back to member page if url is altered
                $this->loggedU->render();
            }//do logout
            if ($this->loggedU->getLogout() == true) {
                $this->loggedU->doLogout();
            }
        }//if use is not logged in, show login page
        else{
            $this->loginCont->control();
        }
    }
}