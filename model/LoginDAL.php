<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 2016-08-18
 * Time: 23:26
 */
namespace model;

class LoginDAL{
    public $error;
    public $username;
    public $password;
    public $loggedIn = true;
    public $notLoggedIn = -1;
    private $pdo;

    /**
     * LoginDAL constructor.
     */
    public function __construct(){

        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' .DB_LOGIN_NAME;
        try {
            $this->pdo = new \PDO($dsn, DB_USER, DB_PASS);
        } catch (\PDOException $e) {
            exit('Connection error LOGIN');
        }
    }

    /**
     * Function for login.
     * Checks username and password.
     * If user enter correct credentials a session will be set to "loggedIn".
     * If username or password don't match a error code will be set.
     * @param $username
     * @param $pass
     */
    public function doLogin($username, $pass){

       var_dump($username);
       var_dump($pass);
        $sql = "SELECT username FROM ".DB_LOGIN_TABLE." WHERE username = :usernameInput";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':usernameInput',$username);
        $query->execute();
        $result1 = $query->fetchColumn();

        $sql = "SELECT password FROM ".DB_LOGIN_TABLE." WHERE password = :passwordInput";
        $query = $this->pdo->prepare($sql);

        $query->bindParam(':passwordInput',$pass);
        $query->execute();
        $result2 = $query->fetchColumn();

        if($result1 != false & $result2 !=false){
            if($username === $result1) {
                $_SESSION['user'] = $username;
                $_SESSION['pass'] = $pass;
                $_SESSION['loggedIn'] = $this->loggedIn;
            }
        }else{
            $_SESSION['NotLoggedIn'] =$this->notLoggedIn;
        }
    }

    /**
     * Check if user exist in the database.
     * @param $username
     * @return mixed
     */
    public function checkUserExist($username){

        $sql = "SELECT * FROM ".DB_LOGIN_TABLE." WHERE username = :usernameInput";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':usernameInput',$username);
        $query->execute();
        $result = $query->fetch(\PDO::FETCH_ASSOC);
        return $result;

    }
    public function usernameAvailable($user){
        $username1 = $this->checkUserExist($user);
        if($username1['username'] === $user){
            return false;
        }
        return true;
    }

    /**
     * Register a new user
     * @param $username
     * @param $password
     * @return bool
     */
    public function doRegisterNewUser($username, $password){

        $sql = "INSERT INTO " . DB_LOGIN_TABLE . "(user_id,username,password) VALUES('' ,:username,:password)";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':username', $username);
        $query->bindParam(':password', $password);
        return $query->execute();

    }
}