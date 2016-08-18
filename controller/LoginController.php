<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 2016-08-18
 * Time: 18:47
 */
namespace controller;

class LoginController{

    private $loggedU;
    private $loginView;
    private $loginDal;

    /**
     * LoginController constructor.
     * @param \view\LoggedUser $loggedUser
     * @param \view\LoginView $lv
     * @param \model\LoginDAL $ld
     */
    public function __construct( \view\LoggedUser $loggedUser ,\view\LoginView $lv, \model\LoginDAL $ld)
    {
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
            /*TODO*/
            /** Write better redirect function */
            if($this->loginView->loggedIN()==1){
               $this->loginView->redirect();

             //  $this->loginView->render();
             //   $this->loginView->refreshPage();
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