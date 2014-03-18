<?php
/**
 * @package Controller.php
 * @author  Faisal<faisal@nascenia.com>
 * @created 2014 - 03 - 18
 * @version 2014 - 03 - 18
 */
require_once "UserAccess.php";

class Controller {

    public function __construct() {}

    public function getService($class) {
        if(file_exists($class.".php")){
            require_once $class. ".php";
            $object = new $class();
            return $object;
        }
        throw new Exception("No Class Found named : " . $class , 404);
    }
} 