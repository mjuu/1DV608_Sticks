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

session_start();

$stV = new view\Sticks();
$loggU = new \view\LoggedUser();

$lv = new \view\LoginView();
$up = new \view\UploadView();
$v = new view\View();

$ld = new \model\LoginDAL();
$lc = new \controller\LoginController($loggU,$lv,$ld);
$c = new controller\MasterController($stV,$up,$v, $lv, $ld, $lc);

$c->doControl();
