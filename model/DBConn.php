<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 2016-08-18
 * Time: 12:03
 */
namespace model;
class DBConn{
    private $pdo;

    /**
     * Making a connection to the database
     * and returns the connection
     * @return \PDO
     */
    public function conn(){
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAMEFILE;
        try {
            $this->pdo = new \PDO($dsn, DB_USER, DB_PASS); //DB_PASS
            return $this->pdo;
        } catch (\PDOException $e) {
            exit('Connection error DB');
        }
    }

    /**
     * Get public file list
     * @return array of the table
     */
    public function getPublicFileList(){

        $sql = "SELECT * FROM ".DB_TABELLFILE;
        $query = $this->pdo->prepare($sql);
        $query->execute();
       return $results = $query->fetchAll();
    }

    /**
     * Get private file list for the logged in user
     * @return mixed
     */
    public function getPrivateFileList(){

        $username1 =$_SESSION['user'];
        $sql = "SELECT * FROM ". DB_TABELLFILEPRIVATE ." WHERE username = :username";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':username',$username1);
        $query->execute();
        return $results = $query->fetchAll();
    }

}