<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 2015-10-26
 * Time: 20:35
 */


require_once("controller/MasterController.php");
require_once("controller/LoginController.php");
require_once("model/LoginDAL.php");
require_once("model/DBConn.php");
require_once("view/LoginView.php");
require_once("view/LoggedUser.php");
require_once("conf/conf.php");
require_once("view/SticksView.php");
require_once("Settings.php");

if (Settings::DISPLAY_ERRORS) {
    	error_reporting(-1);
    	ini_set('display_errors', 'ON');
    }

session_start();

$stV = new view\Sticks();
$loggU = new \view\LoggedUser();

$lv = new \view\LoginView();

$ld = new \model\LoginDAL();
$lc = new \controller\LoginController($loggU,$lv,$ld);
$c = new controller\MasterController($stV, $lv, $ld, $lc);

$c->doControl();
