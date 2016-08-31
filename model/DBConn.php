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

}