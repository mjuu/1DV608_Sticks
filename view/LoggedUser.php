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

    private static $member = "LoggedUser::member";
    private static $logout = "LoggedUser::logout";
    public $stickModel;

    /**
     * LoggedUser constructor.
     */
    public function __construct(){
        $this->stickModel = new StickModel();
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
     * Restart the game on request
     */
    public function restartGame(){
        $this->stickModel->setArray();

    }

}