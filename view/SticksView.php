<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 2016-08-18
 * Time: 13:50
 */

namespace view;
use model\StickModel;
class SticksView{

    private static $draw1 = 'draw::1';
    private static $draw2 = 'draw::2';
    private static $draw3 = 'draw::3';
    private $user;
    private $logV;
    private static $reStart = 'StickView::restart';
    private $stickModel;
    private $loggedU;
    private $sticksLeft;
    private $backupArr;
    private $finished;

    /**
     * SticksView constructor.
     */
    public function __construct(){

        $this->logV = new \view\LoginView();
        $this->stickModel = new StickModel();
        $this->loggedU = new LoggedUser();

        //Setting up the game
        $this->stickModel->startGame();

        //If user is logged in,  set session variables
       if($this->logV->loggedIN()==true){
            $this->sticksLeft = $_SESSION['sticks'];
        }

        //Restart the game
        if($this->restartGame()==true){
            $this->stickModel->restartGame();
        }
    }

    /**
     * Returns true if user want to draw 1 stick
     * @return bool
     */
    public function draw1(){
        if($this->draw1Clicked()===true) {
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Returns true if user want to draw 2 stick
     * @return bool
     */
    public function draw2(){
        if($this->draw2Clicked()===true) {
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Returns true if user want to draw 2 stick
     * @return bool
     */
    public function draw3(){
        if($this->draw3Clicked()===true) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * If user want to draw 1 stick, then this will render that draw.
     */
    public function render1(){
        //If sticks left is less than 1 render fallback view
        if($this->sticksLeft <1){
            $this->renderFallback();
        }else{
            //Check if draw is valid and do the draw and render the new view
            if($this->stickModel->sticksChecks(1)==true){
                $this->stickModel->calcD(1,1);
                $this->stickModel->setUserDraw();
                $this->renderV2();
            }
        }
    }

    /**
     * If user want to draw 2 stick, then this will render that draw.
     */
    public function render2(){
        //If sticks left is less than 2 render fallback view
        if($this->sticksLeft <2){
            $this->renderFallback();
        }else{
            //Check if draw is valid and do the draw and render the new view
            if($this->stickModel->sticksChecks(2)==true){
                $this->stickModel->calcD(2,1);
                $this->stickModel->setUserDraw();
                $this->renderV2();
            }
        }
    }

    /**
     * If user want to draw 3 stick, then this will render that draw.
     */
    public function render3(){
        //If sticks left is less than 3 render fallback view
        if($this->sticksLeft <3){
            $this->renderFallback();
        }else{
            //Check if draw is valid and do the draw and render the new view
            if($this->stickModel->sticksChecks(3)==true){
                $this->stickModel->calcD(3,1);
                $this->stickModel->setUserDraw();
                $this->renderV2();
            }
        }
    }

    /**
     * Returns true if user click on the restart button
     * @return bool
     */
    public function restartGame(){
        if((isset($_GET[self::$reStart]))===true){
            return true;
        }
    }

    /**
     * Redirect user to the right page if page is not loaded correctly
     */
    public function redirect(){
        return header("Location:?restart");
    }

    /**
     * Checks if any of the draw buttons was clicked and then return true for that button if clicked else return false.
     * @return bool
     */
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

    /**
     * Sets user draws and returns what user and CPU did draw
     * @return string
     */
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

    /**
     * The Main view
     * User see this view when they have logged in.
     * This function returns a html page
     */
    public function renderV1(){
       // echo 'V1';
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
        if($this->stickModel->getArrZero()===0){ //$this->arraySizeCheck()===0
            echo $this->printSticks(0,0);
            $this->finished = true;
        }else{
            echo $this->printSticksNR($this->stickModel->getArrSize());//
        }
        echo $this->mainEnd();

        //Shows sticks
        echo $this->displayStart();
        if($this->stickModel->getArrZero()===0){ //$this->arraySizeCheck()===0
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
        if($this->finished !=true){
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

    /**
     * The second view.
     * After a draw this view is shown.
     */
    public function renderV2(){
        //echo 'V2';
        if($_SESSION['sticks']==0){
        }else{
            //after user draw, cpu draw
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
        if($this->stickModel->getArrZero()===0){
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

    /**
     * If the user change the url this view will be shown.
     */
    public function renderFallback(){
        //echo 'fallback';

        //If user change the url this will fill the array with correct value
        if($this->sticksLeft>0){
            $this->backupArr =$this->stickModel->setArr($this->sticksLeft);
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
            $this->finished = true;
        }else{
            echo $this->printSticksNR($this->sticksLeft);
        }
        echo $this->mainEnd();
        echo $this->displayStart();
        if($this->stickModel->getBackupArrSize($this->backupArr)>0){
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

        if($this->finished !=true){
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

    /**
     * Building html tag.
     * @return string
     */
    public function htmlStart(){
        return '
<!doctype html>
<html>';
    }

    /**
     * End of html tag.
     * @return string
     */
    public function htmlEnd(){
        return '
</html>';
    }

    /**
     * Building head tag with title and meta data.
     * @return string
     */
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

    /**
     * Builds header tag.
     * @return string
     */
    public function headerStart(){
        return '
     <header>';
    }

    /**
     * Header tag end.
     * @return string
     */
    public function headerEnd(){
        return '
    </header>';
    }

    /**
     * Builds aside 1 tag.
     * @return string
     */
    public function displayStart(){
        return '
        <aside class="aside aside-1">';
    }

    /**
     * Builds aside 2 tag.
     * @return string
     */
    public function UserCPUDrawsStart(){
        return '
        <aside class="aside aside-2">';
    }

    /**
     * Builds aside 3 tag.
     * @return string
     */
    public function infoStart(){
        return '
        <aside class="aside aside-3">';
    }

    /**
     * Builds aside 4 tag.
     * @return string
     */
    public function drawStickStart(){
        return '
        <aside class="aside aside-4">';
    }

    /**
     * Aside end tag.
     * @return string
     */
    public function asideEnd(){
        return '
        </aside>';
    }

    /**
     * Builds nav with logout button.
     * @return string
     */
    public function nav(){
       return '
     <nav>'. $this->loggedU->logoutBTN().'</nav>';
    }

    /**
     * Builds body tag.
     * @return string
     */
    public function bodyStart(){
        return '
<body>';
    }

    /**
     * Builds wrapper tag.
     * @return string
     */
    public function wrapperStart(){
        return '
<div id="wrapper">';
    }

    /**
     * Wrapper end tag.
     * @return string
     */
    public function wrapperEnd(){
        return '
    </div>';
    }

    /**
     * Builds main tag.
     * @return string
     */
    public function mainStart(){
        return '
    <main>';
    }

    /**
     * Main end tag.
     * @return string
     */
    public function mainEnd(){
        return '
    </main>';
    }

    /**
     * Builds content tag.
     * @return string
     */
    public function contentStart(){
        return '
    <div class="content">';
    }

    /**
     * Content end tag.
     * @return string
     */
    public function contentEnd(){
        return '
    </div>';
    }

    /**
     * Body end tag.
     * @return string
     */
    public function bodyEnd(){
        return '
    </body>';
    }

    /**
     * Builds footer tag.
     * @return string
     */
    public function footerStart(){
        return '
    <footer>';
    }

    /**
     * Footer end tag.
     * @return string
     */
    public function footerEnd(){
        return '
    </footer>';
    }

    /**
     * Builds H1 tag with welcome message
     * @return string
     */
    public function userWelcome(){
        return '
     <H1>Welcome '.$this->user.' to the Stick game</H1>';
    }

    /**
     * Prints how many sticks left and draws the sticks.
     * @param $sticksValue
     * @param $printSticks
     * @return string
     */
    public function printSticks($sticksValue,$printSticks){
        return ' 
     <p><h3>There is <p id="stickValue">'.$sticksValue.'</p>  sticks left</h3></p>
     <p id="sticks">'.$printSticks.'</p>';
    }

    /**
     * Prints how many sticks left.
     * @param $sticksValue
     * @return string
     */
    public function printSticksNR($sticksValue){
        return '
    <p><h3>There is <p id="stickValue">'.$sticksValue.'</p>  sticks left</h3></p>';
    }

    /**
     * Prints only sticks.
     * @param $printSticks
     * @return string
     */
    public function printOnlySticks($printSticks){
        return ' 
     <p id="sticks">'.$printSticks.'</p>';
    }

    /**
     * Show buttons for drawing sticks.
     * @return string
     */
    public function drawStick(){
        return '
		 <ol>
			 <li>'.$this->showDraw1(). ' 1 sticks</a></li>
			 <li>'.$this->showDraw2(). ' 2 sticks</a></li>
			 <li>'.$this->showDraw3(). ' 3 sticks</a></li>
		</ol>';
    }

    /**
     * Shows how the game works.
     * @return string
     */
    public function drawInfo(){
        return '
     <p><h2>Select number of sticks</h2></p>
	 <p>The player who draws the last stick looses</p>
	 <p id="score">Score
	 <br> '.$this->stickModel->getScoreUser().$this->stickModel->getScoreCPU().'</p>';
    }

    /**
     * Shows restart button.
     * @return string
     */
    public function showRestartButton1(){
        return "<a href='?" . self::$reStart . "' id='restart1'> Restart!</a>";
    }

    /**
     * Show 'draw 1' button.
     * @return string
     */
    public function showDraw1(){
        return "<a href='?" . self::$draw1 . "'> Draw";
    }

    /**
     * Show 'draw 2' button.
     * @return string
     */
    public function showDraw2(){
        return "<a href='?" . self::$draw2 . "'> Draw";
    }

    /**
     * Show 'draw 3' button.
     * @return string
     */
    public function showDraw3(){
        return "<a href='?" . self::$draw3 . "'> Draw";
    }

    /**
     * Returns true if 'draw 1' button is clicked.
     * @return bool
     */
    public function draw1Clicked(){
        if((isset($_GET[self::$draw1]))===true){
            return true;
        }
    }

    /**
     * Returns true if 'draw 2' button is clicked.
     * @return bool
     */
    public function draw2Clicked(){
        if((isset($_GET[self::$draw2]))===true){
            return true;
        }
    }
    /**
     * Returns true if 'draw 3' button is clicked.
     * @return bool
     */
    public function draw3Clicked(){
        if((isset($_GET[self::$draw3]))===true){
            return true;
        }
    }

    /**
     * Returns true if 'restart' button is clicked.
     * @return bool
     */
    public function restartClicked(){
        if((isset($_GET[self::$reStart]))===true){
            return true;
        }
    }

    
}