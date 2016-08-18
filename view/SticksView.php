<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 2016-08-18
 * Time: 13:50
 */
namespace view;
class Sticks{
    private static $logout = 'LoginView::Logout';
    private static $username = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $draw1 = 'draw=1';
    private static $draw2 = 'draw=2';
    private static $draw3 = 'draw=3';
    private static $messageId = 'LoginView::Message';
    private $sticks;
    private $logV;
    private $logUV;
    public $array1;

    public function __construct()
    {
       // $this->logUV = new \view\LoggedUser();
    //    $this->logV = new \view\LoginView();
       // $this->fillArr();
        
    }

    public function render(){
    echo $this->showDraw1();


        return '

        <!doctype html>
        <html>
          <head>
             <title>Sticks</title>
             <meta charset="UTF-8">
             <meta name="viewport" content="width=device-width, initial-scale=1.0">
             <meta name="theme-color" content="blue">
          </head>
          <body>
				<p></p><h2>There is x sticks left</h2>
                <p style=\'font-family: "Courier New", Courier, monospace\'>IIIIIIIIIIIIIIIIIIIIII</p>
				<p></p><h2>Select number of sticks</h2>
				<p>The player who draws the last stick looses</p><ol><li>'.$this->showDraw1().'Draw 1 stick</a></li><li>'.$this->showDraw2().'Draw 2 sticks</a></li><li>'.$this->showDraw3().'Draw 3 sticks</a></li><ol>
          </body>
        </html>
        ';
    }

    /*TODO*/
    public function fillArr(){
     $this->array1= array_fill(1,22, 'A');
        //foreach ($this->array1 as $i =>$value){
         //   echo $value ;
       // }
    }
    public  function calcDraws($value){
      return  array_splice($this->array1,$value);
    }
    public function getDraws(){
        if(isset($_GET[self::$draw1])) {
            if($_GET[self::$draw1] == 'draw=1')
            return 1;
        }

    }
    public function showDraw1(){
        //$this->sticks=$nr;
        return "<a href='?" . self::$draw1. "'> Draw</a>";
    }

    public function showDraw2(){
        //$this->sticks=$nr;
        return "<a href='?" . self::$draw2. "'> Draw</a>";
    }
    public function showDraw3(){
        //$this->sticks=$nr;
        return "<a href='?" . self::$draw3. "'> Draw</a>";
    }
    public function getDraw(){
            return isset($_GET[self::$draw1]);
}

}