<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 2016-08-18
 * Time: 22:36
 */
namespace view;
class LoggedUser{

    private static $member = "member";
    private static $logout = "logout";
    private static $privateUpload = "privateUp";
    private $stickView;

    /**
     * LoggedUser constructor.
     */
    public function __construct(){
        $this->stickView = new \view\Sticks();
    }

    /**
     * Shows the member area page to the user
     */
    public function render(){

       // echo $this->logoutBTN();
        $user =$_SESSION['user'];
        //echo '<H1>Welcome '.$user.' to the Stick game</H1>';
        //echo $this->stickView->render();

        //$arr = array_fill(1,22, 'A');
        //foreach ($arr as $i =>$value){
         //   echo $value ;
       // }

        /*TODO*/

        $this->stickView->fillArr();
        $this->stickView->calcDraws(3);
        var_dump($this->stickView->calcDraws(3));

        //var_dump($arr);
      echo  '<!doctype html>
        <html>
          <head>
             <title>Sticks</title>
             <meta charset="UTF-8">
             <meta name="viewport" content="width=device-width, initial-scale=1.0">
             <meta name="theme-color" content="blue">
          </head>
          <body>
                <H1>Welcome '.$user.' to the Stick game</H1>
				<p></p><h2>There is x sticks left</h2>
                <p style=\'font-family: "Courier New", Courier, monospace\'>IIIIIIIIIIIIIIIIIIIIII</p>
				<p></p><h2>Select number of sticks</h2>
				
				<p>'. $this->logoutBTN();'</p>
                
          </body>
        </html>';

        echo '<br>' ;
       // array_splice($arr,20);
       // foreach ($arr as $i =>$value){
       //     echo $value ;
       // }
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
}