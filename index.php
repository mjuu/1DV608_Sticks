<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 2015-10-26
 * Time: 20:35
 */


require_once("controller/MasterController.php");
require_once("controller/LoginController.php");
require_once ("controller/SticksController.php");
require_once("model/LoginDAL.php");
require_once("model/DBConn.php");
require_once ("model/SticksModel.php");
require_once ("model/DrawModel.php");
require_once("view/LoginView.php");
require_once("view/LoggedUser.php");
require_once ("conf/conf.php");
//require_once("conf/conf.php");
require_once("view/SticksView.php");
require_once("Settings.php");

if (Settings::DISPLAY_ERRORS) {
    	error_reporting(-1);
    	ini_set('display_errors', 'ON');
    }

session_start();

$stickV = new view\SticksView();
$lv = new \view\LoginView();
$ld = new \model\LoginDAL();
$loggU = new \view\LoggedUser();

$stC = new controller\SticksController($stickV,$loggU);

$lc = new \controller\LoginController($loggU,$lv,$ld, $stC);

$c = new controller\MasterController($stickV, $lv, $ld, $lc,$stC,$loggU);

$c->doControl();
