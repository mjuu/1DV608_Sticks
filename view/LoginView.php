<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 2016-08-18
 * Time: 23:58
 */
namespace view;

use model\LoginDAL;

class LoginView{

    private static $login = 'LoginView::Login';
    private static $username = 'LoginView::UserName';
    private static $usernameReg = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $repassword = 'LoginView::rePassword';
    private static $messageId = 'LoginView::Message';
    private static $registerButton = "LoginView::register";
    private static $registerURL = "register";
    public  $usernameStatus = false;
    public  $passwordStatus = false;
    public  $loginFailed = false;
    public  $loggedin;
    public $loginDAL;
    public $regFail = true;
    public $message;
    public $isUsernameAvailable = null;
    private static $loginURL = "login";
    private static $backButton = "";


    /**
     * LoginView constructor.
     */
    public function __construct(){
        $this->loginDAL = new LoginDAL();
        $this->loggedin =-1;
}

    /**
     * If user is not logged in this will show the login page
     */
    public function render(){
        if($this->loggedIN() ==0||-1 ){
            $this->doLogin();
        }
    }

    /**
     * Sends username and password to the login function
     */
    public function login(){
        $this->loginDAL->doLogin($this->getUsername(),$this->getPassword());
    }

    public function checkName(){
        $available = $this->loginDAL->usernameAvailable($this->getUsername());
        if($available == true){
            $this->isUsernameAvailable = $available;
            return true;
        }
        $this->isUsernameAvailable = $available;
        $this->message = 'user exist';
        //echo 'name is in use';
        return false;
    }
    /**
     * Register a new user.
     * Sends the credentials to loginDAL that creates a new user.
     */
    public function register(){

        if($this->regFail == false) {
                      $this->loginDAL->doRegisterNewUser($this->getUsername(), $this->getPassword());
          // $this->loginDAL->doRegisterNewUser($this->getUsername(), $this->getPassword());
           // echo 'username fail';
        }
    }

    /**
     * Generate the login page
     * Checks so the input data from user is valid and then
     * returned the correct error message to the login view.
     */
    public function  doLogin(){

        $message='';
        if(!$this->wantToLogin()==true ){
            $message="";
        }
        elseif($this->wantToLogin()==true && $this->getUsername()==false || $this->getUsername()==''){
            $message="Empty username";
        }elseif($this->wantToLogin()==true &&$this->getUsername()==''){
            $message="Wrong username";
        }elseif($this->getPassword()==false || $this->getPassword()==''){
            $message="Wrong password";
        }else{
            $message = "Wrong username and pass";
        }
        echo $this->generateLoginFormHTML($message);
    }

    /**
     * Generate the register page.
     * Checks user import so the data is correct.
     */
    public function doRegister(){

        $message = "Password miss match";
        if(!$this->wantToRegister() == true && $this->regFail==true){
            $message = "Enter Username and password";
        }
        elseif($this->wantToRegister() ==true && $this->getUsername() == false || $this->getUsername()==''){
            $message="Empty username";
        }elseif($this->wantToRegister() == true && $this->getPassword() =='') {
            $message="Empty password";
        }elseif($this->wantToRegister() ==true && $this->getPassword() && $this->getRePassword() == false){
            $message = "Password miss match";
        }elseif($this->wantToRegister() ==true && $this->getPassword() === $this->getRePassword()){
           if($this->checkName() == true){
               $this->regFail =false;
               $message = "Register completed! Please use the new credentials";
           }else{
               $message = "Username is taken";
           }
        }
        echo $this->generateRegisterFormHTML($message);
    }


    /**
     * Generate the login page
     * @param $message the message to show the user
     * @return string
     */
    private function generateLoginFormHTML($message) {


        return '
          <html>
          <head>
             <title>Sticks Login</title>
             <meta charset="UTF-8">
             <meta name="viewport" content="width=device-width, initial-scale=1.0">
             <meta name="theme-color" content="yellow">
          </head>
          <nav>'.$this->showBackButton().''.$this->showRegisterButton().'</nav>
          <body>	
				<form action ="" method="post" >
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					<label for="' . self::$username . '">Username :</label>
					<input type="text" id="' . self::$username . '" name="' . self::$username . '" value="" />
					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
          </body>
        </html>		
		';
    }

    /**
     * Generate the register page
     * @param $message to show the information to user
     * @return string
     */
    private function generateRegisterFormHTML($message) {
        return '
          <html>
          <head>
             <title>Sticks Login</title>
             <meta charset="UTF-8">
             <meta name="viewport" content="width=device-width, initial-scale=1.0">
             <meta name="theme-color" content="blue">
          </head>
          <nav>'.$this->showBackButton().''.$this->showRegisterButton().'</nav>
          <body>	
				<form action ="" method="post" >
				<fieldset>
					<legend>Register a new account </legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					<label for="' . self::$usernameReg . '">Username :</label>
					<input type="text" id="' . self::$usernameReg . '" name="' . self::$usernameReg . '" value="" />
					<br>
					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />
                    <br>
					<label for="' . self::$repassword . '">Retype Password :</label>
					<input type="password" id="' . self::$repassword . '" name="' . self::$repassword . '" />
					<input type="submit" name="' . self::$registerButton . '" value="register" />
				</fieldset>
			</form>
          </body>
        </html>	
		';
    }

    /**
     * Check if user is logged in by looking at the session.
     * Returns integers of the status.
     * 1 is equal to logged in
     * -1 is equal to Not logged in
     * @return int
     */
    public function loggedIN(){
        if(isset($_SESSION['loggedIn'])) {
            $fd = $_SESSION['loggedIn'];
            if($fd ==1){
               return $this->loggedin=1;
            }else{
                $this->loginFailed == true;
                return $this->loggedin = -1;
            }
        }

    }

    /**
     * Shows the Sign up link
     * @return string
     */
    public function showRegisterButton(){
        return "<a href='?" . self::$registerURL. "'> Sign up</a>";
    }

    /**
     * Returns true if user clicked on register link
     * @return bool
     */
    public static function wantToRegisterURL(){
        return isset($_GET[self::$registerURL]);
    }

    /**
     * Returns if user clicked on register button
     * @return bool
     */
    public static function wantToRegister(){
        return isset($_POST[self::$registerButton]);
    }

    /**
     * Returns true if user clicked on login button
     * @return bool
     */
    public static function wantToLogin(){
        return isset($_POST[self::$login]);
    }

    /**
     * Returns the username if set otherwise true/false
     * @return mixed
     */
    public static function getUsername(){
        if(isset($_POST[self::$username]))
            return $_POST[self::$username];
    }

    /**
     * Returns the password if set
     * @return string
     */
    public static function getPassword(){
        if(isset($_POST[self::$password]))
          return $_POST[self::$password];
        else
            return '';
    }

    /**
     * Returns the password if set
     * @return string
     */
    public static function getRePassword(){
        if(isset($_POST[self::$repassword]))
            return $_POST[self::$repassword];
        else
            return '';
    }

    /**
     * Shows a link to login page
     * @return string
     */
    public function showloginButton(){
        return "<a href='?" . self::$loginURL. "'> Sign in</a>";
    }

    /**
     * Shows a link back to root
     * @return string
     */
    public function showBackButton(){
        return "<a href='?" . self::$backButton. "'> Back to Start</a>";
    }

    /**
     * Returns true if user clicked on login link
     * @return bool
     */
    public function loginLinkClicked(){
        return isset($_GET[self::$loginURL]);
    }
    
    /**
     * Redirect user back to the member area
     */
    public function redirect() {
        header("Location: ?restart");
    }

    public function refreshPage(){
        header("Refresh:0");
    }
}