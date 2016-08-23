<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 2016-08-18
 * Time: 13:50
 */

namespace view;
use model\StickModel;
require_once ("model/SticksModel.php");
class SticksView{

    private static $draw1 = 'draw::1';
    private static $draw2 = 'draw::2';
    private static $draw3 = 'draw::3';
    private  $user;
    public $message;
    public $started;
    private $logV;
    public static $startURL ='start';

    public static $startG = 'start';
    public static $reStart = 'restart';
    public $stickModel;
    public $drawMo;
    public $dfull;
    public $loggedU;
    public $sticksLeft;
    public $backupArr;

    public $finnished;

    public function __construct(){

        $this->logV = new \view\LoginView();
        $this->stickModel = new StickModel();
        $this->loggedU = new LoggedUser();

        $this->startGame();
        if($this->logV->loggedIN()==true){
            $this->user=$_SESSION['user'];
            $this->sticksLeft = $_SESSION['sticks'];
        }
        if($this->restartGame()==true){
            $this->stickModel->setArr(22);
        }
    }

    public function draw1(){
        if($this->draw1Clicked()===true) {
            return true;
        }
        else{
            return false;
        }
    }
    public function draw2(){
        if($this->draw2Clicked()===true) {
            return true;
        }
        else{
            return false;
        }
    }
    public function draw3(){
        if($this->draw3Clicked()===true) {
            return true;
        }
        else {
            return false;
        }
    }
    public function render1(){
        $this->stickModel->calcD(1);
        echo 'USER : 1';
        $this->renderV2();
    }
    public function render2(){
        $this->stickModel->calcD(2);
        echo 'USER : 2';
        $this->renderV2();
    }
    public function render3(){
        $this->stickModel->calcD(3);
        echo 'USER : 3';
        $this->renderV2();
    }
    public function startGame(){
        if(isset($_SESSION['sticks'])!=true){
            $this->stickModel->setArray();
        }
    }

    public function restartGame(){
        if((isset($_GET[self::$reStart]))===true){
            return true;
        }
    }
    public function redirect(){
        return header("Location:?restart");
    }

    public function refresh(){
        return header("Refresh:0");
    }

    public function checkIfDraw(){
        if($this->draw1Clicked()===true){
            return true;
        }elseif ($this->draw2Clicked()===true){
            return true;
        }elseif ($this->draw3Clicked()===true){
            return true;
        }else{
            return false;
        }
    }

    public function gameFinished(){
        return $this->finnished;
    }

    public function cpuDraw(){
        echo $this->stickModel->cpu();
        echo '<br>'.$this->stickModel->getArrSize();
        $this->renderV1();
    }

    public function renderV1(){

        //echo 'USER :'.$draw;
        echo '<br>';
        //echo $this->stickModel->cpu();
        //$this->stickModel->calcD($draw);

        echo $this->htmlStart();
        echo $this->headStart();
        echo $this->nav();
        echo $this->bodyStart();
        echo $this->userWelcome();

        if($this->arraySizeCheck()===0){
            echo $this->printSticks(0,0);
            $this->finnished = true;
        }else{
           // echo $this->printSticks($this->stickModel->getArrSize(),$this->stickModel->printArr($slk));
           echo $this->printSticks($this->stickModel->getArrSize(),$this->stickModel->printArr($this->stickModel->getArr()));
        }

       if($this->finnished !=true){
           echo $this->drawStick();
       }
        echo $this->showRestartButton();
        echo $this->bodyEnd();
        echo $this->htmlEnd();
    }

    public function renderV2(){

        //echo 'USER :'.$draw;
        echo '<br>';
        echo $this->stickModel->cpu();
        //$this->stickModel->calcD($draw);

        echo $this->htmlStart();
        echo $this->headStart();
        echo $this->nav();
        echo $this->bodyStart();
        echo $this->userWelcome();

        if($this->arraySizeCheck()===0){
            echo $this->printSticks(0,0);
            $this->finnished = true;
        }else{
            echo $this->printSticks($this->stickModel->getArrSize(),$this->stickModel->printArr($this->stickModel->getArr()));
        }

        if($this->finnished !=true){
            echo $this->drawStick();
        }
        echo $this->showRestartButton();
        echo $this->bodyEnd();
        echo $this->htmlEnd();
    }
    public function renderFallback(){

        if($this->sticksLeft>0){
            $this->backupArr = array_fill(1,$this->sticksLeft, 'A');
        }
        echo $this->htmlStart();
        echo $this->headStart();
        echo $this->nav();
        echo $this->bodyStart();
        echo $this->userWelcome();
        if($this->sticksLeft===0){
            echo $this->printSticks(0,0);
            $this->finnished = true;
        }
        if(count($this->backupArr>0)){
            echo $this->printSticks($this->sticksLeft,$this->stickModel->printArr($this->backupArr));
        }else{
            $this->printSticks($this->sticksLeft,0);
        }

        if($this->finnished !=true){
            echo $this->drawStick();
        }else{
           // echo $this->showStartButton();
            echo $this->showRestartButton();
        }

        echo $this->bodyEnd();
        echo $this->htmlEnd();
    }

    public function arraySizeCheck(){
        if($this->stickModel->getArrSize()===0){
            return 0;
        }
    }


    public function htmlStart(){
        return '
<!doctype html>
    <html>';
    }

    public function htmlEnd(){
        return '
</html>';
    }

    public function headStart(){
        return '
<head>
    <title>Sticks</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="red">
</head>';
    }

    public function nav(){
       return '
    <nav>'. $this->loggedU->logoutBTN().'</nav>';
    }

    public function bodyStart(){
        return '
    <body>';
    }
    public function bodyEnd(){
        return '
    </body>';
    }
    public function userWelcome(){
        return '
     <H1>Welcome '.$this->user.' to the Stick game</H1>';
    }
    public function printSticks($sticksValue,$printSticks){
        return ' 
     <p><h2>There is '.$sticksValue.' sticks left</h2></p>
     <p style=\'font-family: "Courier New", Courier, monospace\'>'.$printSticks.'</p>';
    }
    public function drawStick(){
        return '
     <p><h2>Select number of sticks</h2></p>
	 <p>The player who draws the last stick looses</p>
		 <ol>
			 <li>'.$this->showDraw1(). ' 1 stick</a></li>
			 <li>'.$this->showDraw2(). ' 2 sticks</a></li>
			 <li>'.$this->showDraw3(). ' 3 sticks</a></li>
		</ol>';
    }
    public function showStartButton(){
        return "<a href='?" . self::$startG . "'> Play!</a>";
    }
    public function showRestartButton(){
        return "<a href='?" . self::$reStart . "'> Restart!</a>";
    }
    public function showDraw1()
    {
        return "<a href='?" . self::$draw1 . "'> Draw</a>";
    }

    public function showDraw2()
    {
        return "<a href='?" . self::$draw2 . "'> Draw</a>";
    }

    public function showDraw3()
    {
        return "<a href='?" . self::$draw3 . "'> Draw</a>";
    }

    public function draw1Clicked(){
        if((isset($_GET[self::$draw1]))===true){
            return true;
        }
    }

    public function draw2Clicked()
    {
        if((isset($_GET[self::$draw2]))===true){
            return true;
        }
    }
    public function draw3Clicked()
    {
        if((isset($_GET[self::$draw3]))===true){
            return true;
        }
    }
    public function restartClicked()
    {
        if((isset($_GET[self::$reStart]))===true){
            return true;
        }
    }

    public function getStartURL()
    {
        if((isset($_GET[self::$startURL]))===true){
            return true;
        }
    }


    
}