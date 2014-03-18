<?php
/**
 * @package DataProvider.php
 * @author  Faisal<faisal@nascenia.com>
 * @created 2014 - 03 - 18
 * @version 2014 - 03 - 18
 */

class DataProvider {

    private static $userId;

    public function getDbAdapter() {
        $dsn = 'mysql:dbname=qgen;host=127.0.0.1';
        $user = 'root';
        $password = 'root';
        try {
            $dbh = new PDO($dsn, $user, $password);
            return $dbh;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function __construct() {
        if ($this->getUserId() !== null) return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return self::$userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        self::$userId = $userId;
    }

    public function contactList() {

        $sqlStatement = $this->getDbAdapter()->prepare("SELECT * FROM contact WHERE owner = :owner");
        $sqlStatement->execute(array(":owner"=>$this->getUserId()));
        $resultSet = $sqlStatement->fetchAll(PDO::FETCH_ASSOC);
        return $resultSet;

    }

}
