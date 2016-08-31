<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 2016-08-18
 * Time: 18:47
 */
namespace controller;

class LoginController{

    public $loggedU;
    public $loginView;
    private $loginDal;
    public $stickC;

    /**
     * LoginController constructor.
     * @param \view\LoggedUser $loggedUser
     * @param \view\LoginView $lv
     * @param \model\LoginDAL $ld
     * @param SticksController $sticksController
     */
    public function __construct( \view\LoggedUser $loggedUser ,\view\LoginView $lv, \model\LoginDAL $ld, \controller\SticksController $sticksController)
    {
        $this->stickC=$sticksController;
        $this->loggedU = $loggedUser;
        $this->loginView = $lv;
        $this->loginDal= $ld;
    }

    /**
     * Control login functions
     */
    public function control(){
        //Show login page
        if($this->loginView->loggedIN()!=1){
            $this->loginView->render();
        }
        //user clicked on login button and want to login
        if($this->loginView->wantToLogin() == true){
            $this->loginView->login();
            if($this->loginView->loggedIN()==1){
               $this->loginView->redirect();

            }
        }

    }

    /**
     * Do register controls
     */
    public function registerControl(){
        //Checks user input
        $this->loginView->doRegister();
        //User want to register
        if($this->loginView->wantToRegister() == true){
            //do register

               if($this->loginView->checkName() == true){
                   $this->loginView->register();
               }else{
               }
        }
    }
}