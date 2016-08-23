<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 2016-08-18
 * Time: 22:36
 */
namespace view;
use model\StickModel;

class LoggedUser{

    private static $member = "member";
    private static $logout = "logout";
    private static $privateUpload = "privateUp";
    private static $draw1 = "draw=1";
    private $stickView;
    public $stickModel;

    /**
     * LoggedUser constructor.
     */
    public function __construct(){
        $this->stickModel = new StickModel();

    }

    /**
     * Shows the member area page to the user
     */
    public function render(){

       // echo $this->logoutBTN();
        $user =$_SESSION['user'];
        //echo '<H1>Welcome '.$user.' to the Stick game</H1>';
        //echo $this->stickView->render();


        
      echo  '<!doctype html>
        <html>
          <head>
             <title>Sticks</title>
             <meta charset="UTF-8">
             <meta name="viewport" content="width=device-width, initial-scale=1.0">
             <meta name="theme-color" content="red">
          </head>
          <nav>'. $this->logoutBTN().'</nav>
          <body>
                <H1>Welcome '.$user.' to the Stick game</H1>
                '.$this->stickView->render().'				
				
                
          </body>
        </html>';
      
    }


    /**
     * Returns true/false if user want go to member area
     * @return bool
     */
    public function memberPage(){
        return isset($_GET[self::$member]);
    }

    /**
     * Returns true/false if user want to logout
     * @return bool
     */
    public function getLogout(){
        return isset($_GET[self::$logout]);
    }
    
    /**
     * Show logout button
     * @return string
     */
    public function logoutBTN(){
         return "<a href='?" . self::$logout. "'> Sign out</a>";
    }

    /**
     * Do logout.
     * Destroys the sessions and then redirecting the user to the main page.
     */
    public function doLogout(){
        session_destroy();
        return header("Location: ?");
    }

    /**
     * Redirect to the member area
     */
    public function redirect(){
       return header("Location:?member");
    }
    public function restartGame(){
        $this->stickModel->setArray();

    }

}