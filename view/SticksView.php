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
        if($this->sticksLeft <1){
            $this->renderFallback();
        }else{
            if($this->stickModel->sticksChecks(1)==true){
                $this->stickModel->calcD(1,1);
                $this->stickModel->setUserDraw();
                $this->renderV2();
            }
        }
    }
    public function render2(){
        if($this->sticksLeft <2){
            $this->renderFallback();
        }else{
            if($this->stickModel->sticksChecks(2)==true){
                $this->stickModel->calcD(2,1);
                $this->stickModel->setUserDraw();
                $this->renderV2();
            }
        }
    }
    public function render3(){
        if($this->sticksLeft <3){
            $this->renderFallback();
        }else{
            if($this->stickModel->sticksChecks(3)==true){
                $this->stickModel->calcD(3,1);
                $this->stickModel->setUserDraw();
                $this->renderV2();
            }
        }
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

    public function sticksDrawed(){

            $userDraw='';
            if($this->draw1Clicked()){
                $userDraw='1';
            }elseif ($this->draw2Clicked()){
                $userDraw='2';
            }elseif ($this->draw3Clicked()){
                $userDraw='3';
            }
            return '
        <div class="draws">USER Draw: '.$userDraw.'
        <br>CPU Draw: '.$_SESSION['cpu'].'</div>';

    }

    public function renderV1(){
      //  echo 'V1';
        echo $this->htmlStart();
        echo $this->headStart();
        echo $this->bodyStart();
        echo $this->wrapperStart();
        echo $this->contentStart();

        echo $this->headerStart();
        echo $this->nav();
        echo $this->userWelcome();

        echo $this->headerEnd();

        echo $this->mainStart();
        if($this->arraySizeCheck()===0){
            echo $this->printSticks(0,0);
            $this->finnished = true;
        }else{
            echo $this->printSticksNR($this->stickModel->getArrSize());//
        }
        echo $this->mainEnd();

        //Shows sticks
        echo $this->displayStart();
        if($this->arraySizeCheck()===0){
            // echo $this->printSticks('0','Restart if you want to play again');
        }elseif($this->stickModel->getUserWin()==NULL &&$this->stickModel->getCPUWin()==NULL){
            echo $this->printOnlySticks($this->stickModel->printArr($this->stickModel->getArr()));
        }

        //Shows how many sticks was drown and who wins
        echo $this->UserCPUDrawsStart();

        if($this->restartClicked()!=true && isset($_SESSION['cpu'])==true){
            echo $this->sticksDrawed();
        }
        echo $this->stickModel->getWinner();
        echo $this->asideEnd();

        //shows info how to play
        echo $this->infoStart();
        echo $this->drawInfo();
        echo $this->asideEnd();

        echo $this->drawStickStart();
        if($this->finnished !=true){
            echo $this->drawStick();
        }
        echo $this->asideEnd();

        echo $this->footerStart();
        echo $this->showRestartButton1();
        echo $this->footerEnd();
        echo $this->wrapperEnd();
        echo $this->bodyEnd();
        echo $this->htmlEnd();

    }


    public function renderV2(){
        //echo 'V2';
        if($_SESSION['sticks']==0){
        }else{
            echo $this->stickModel->cpu();
        }
        echo $this->htmlStart();
        echo $this->headStart();
        echo $this->bodyStart();
        echo $this->wrapperStart();
        echo $this->contentStart();

        echo $this->headerStart();
        echo $this->nav();
        echo $this->userWelcome();

        echo $this->headerEnd();

        //Shows how many sticks left
        echo $this->mainStart();
        if($this->stickModel->getUserWin()==NULL &&$this->stickModel->getCPUWin()==NULL){
            echo $this->printSticksNR($this->stickModel->getArrSize());
        }
        echo $this->mainEnd();


        //Shows sticks
        echo $this->displayStart();
        if($this->arraySizeCheck()===0){
        }elseif($this->stickModel->getUserWin()==NULL &&$this->stickModel->getCPUWin()==NULL){
            echo $this->printOnlySticks($this->stickModel->printArr($this->stickModel->getArr()));
        }
        echo $this->asideEnd();

        //Shows how many sticks was drown and who wins
        echo $this->UserCPUDrawsStart();
        echo $this->sticksDrawed();
        echo $this->stickModel->getWinner();
        echo $this->asideEnd();

        if($this->stickModel->getUserWin()==NULL &&$this->stickModel->getCPUWin()==NULL){
            echo $this->infoStart();
            echo $this->drawInfo();
            echo $this->asideEnd();
            echo $this->drawStickStart();
            echo $this->drawStick();
            echo $this->asideEnd();
        }else{

        }
        //show footer with restart button
        echo $this->footerStart();
        echo $this->showRestartButton1();
        echo $this->footerEnd();

        echo $this->contentEnd();
        echo $this->wrapperEnd();
        echo $this->bodyEnd();
        echo $this->htmlEnd();


    }

    public function renderFallback(){

       // echo 'fallback';
        /*TODO*/
        if($this->sticksLeft>0){
            $this->backupArr = array_fill(1,$this->sticksLeft, 'I ');
        }

        echo $this->htmlStart();
        echo $this->headStart();
        echo $this->bodyStart();
        echo $this->wrapperStart();
        echo $this->contentStart();
        echo $this->headerStart();
        echo $this->nav();
        echo $this->userWelcome();
        echo $this->headerEnd();

        //Shows how many sticks left
        echo $this->mainStart();
        if($this->sticksLeft===0){
            echo $this->printSticksNR(0);
            $this->finnished = true;
        }else{
            echo $this->printSticksNR($this->sticksLeft);
        }
        echo $this->mainEnd();
        echo $this->displayStart();
        if(count($this->backupArr>0)){
            echo $this->printOnlySticks($this->stickModel->printArr($this->backupArr));
        }else{
            $this->printSticks($this->sticksLeft,'2');
        }
        echo $this->asideEnd();
        //Shows how many sticks was drown and who wins
        echo $this->UserCPUDrawsStart();
        echo $this->sticksDrawed();
        echo $this->stickModel->getWinner();
        echo $this->asideEnd();

        if($this->finnished !=true){
            //shows info how to play
            echo $this->infoStart();
            echo $this->drawInfo();
            echo $this->asideEnd();
            //Shows links to draw sticks
            echo $this->drawStickStart();
            if($this->stickModel->getUserWin()==NULL &&$this->stickModel->getCPUWin()==NULL){
                echo $this->drawStick();
            }
            echo $this->asideEnd();

        }else{
        }

        //show footer with restart button
        echo $this->footerStart();
        echo $this->showRestartButton1();
        echo $this->footerEnd();

        echo $this->contentEnd();
        echo $this->wrapperEnd();
        echo $this->bodyEnd();
        echo $this->htmlEnd();

    }

    //remove this
    /*TODO*/
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
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>';
    }

    public function headerStart(){
        return '
     <header>';
    }

    public function headerEnd(){
        return '
    </header>';
    }

    public function displayStart(){
        return '
        <aside class="aside aside-1">';
    }
    public function UserCPUDrawsStart(){
        return '
        <aside class="aside aside-2">';
    }
    public function infoStart(){
        return '
        <aside class="aside aside-3">';
    }
    public function drawStickStart(){
        return '
        <aside class="aside aside-4">';
    }

    public function asideEnd(){
        return '
        </aside>';
    }
    public function nav(){
       return '
     <nav>'. $this->loggedU->logoutBTN().'</nav>';
    }

    public function bodyStart(){
        return '
<body>';
    }
    public function wrapperStart(){
        return '
<div id="wrapper">';
    }
    public function wrapperEnd(){
        return '
    </div>';
    }
    public function mainStart(){
        return '
    <main>';
    }
    public function mainEnd(){
        return '
    </main>';
    }
    public function contentStart(){
        return '
    <div class="content">';
    }
    public function contentEnd(){
        return '
    </div>';
    }
    public function bodyEnd(){
        return '
    </body>';
    }

    public function footerStart(){
        return '
    <footer>';
    }
    public function footerEnd(){
        return '
    </footer>';
    }
    public function userWelcome(){
        return '
     <H1>Welcome '.$this->user.' to the Stick game</H1>';
    }
    public function printSticks($sticksValue,$printSticks){
        return ' 
     <p><h3>There is <p id="stickValue">'.$sticksValue.'</p>  sticks left</h3></p>
     <p id="sticks">'.$printSticks.'</p>';
    }

    public function printSticksNR($sticksValue){
        return '
    <p><h3>There is <p id="stickValue">'.$sticksValue.'</p>  sticks left</h3></p>';
    }

    public function printOnlySticks($printSticks){
        return ' 
     <p id="sticks">'.$printSticks.'</p>';
    }

    public function drawStick(){
        return '
		 <ol>
			 <li>'.$this->showDraw1(). ' 1 sticks</a></li>
			 <li>'.$this->showDraw2(). ' 2 sticks</a></li>
			 <li>'.$this->showDraw3(). ' 3 sticks</a></li>
		</ol>';
    }
    public function drawInfo(){
        return '
     <p><h2>Select number of sticks</h2></p>
	 <p>The player who draws the last stick looses</p>
	 <p id="score">Score
	 <br> '.$this->stickModel->getScoreUser().$this->stickModel->getScoreCPU().'</p>';
    }

    public function showRestartButton1(){
        return "<a href='?" . self::$reStart . "' id='restart1'> Restart!</a>";
    }
    /*TODO*/ //remove?
    public function showRestartButton(){
        return "<a href='?" . self::$reStart . "' id='restart'> Restart!</a>";
    }
    public function showDraw1()
    {
        return "<a href='?" . self::$draw1 . "'> Draw";
    }

    public function showDraw2()
    {
        return "<a href='?" . self::$draw2 . "'> Draw";
    }

    public function showDraw3()
    {
        return "<a href='?" . self::$draw3 . "'> Draw";
    }

    public function draw1Clicked(){
        if((isset($_GET[self::$draw1]))===true){
            return true;
        }
    }

    public function draw2Clicked(){
        if((isset($_GET[self::$draw2]))===true){
            return true;
        }
    }
    public function draw3Clicked(){
        if((isset($_GET[self::$draw3]))===true){
            return true;
        }
    }
    public function restartClicked(){
        if((isset($_GET[self::$reStart]))===true){
            return true;
        }
    }

    
}