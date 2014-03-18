<?php
/**
 * @package SuperGull.php
 * @author  Faisal<faisal@nascenia.com>
 * @created 2014 - 03 - 18
 * @version 2014 - 03 - 18
 */

class SuperGlue {

    private $_ListInvalidMethodOutside = array(
        'getService','glue','login','getUserDetailsFromToken'
    );

    public function glue($method,$class = null) {

        if(in_array($method,$this->_ListInvalidMethodOutside)) throw new Exception("Invalid method");
        // will do same for other required methods like getService etc...

        if($class === null) {
            if(method_exists($this,$method)) {
                $this->{$method}();
            }
            throw new Exception("Selected method $method not found in class : ". __CLASS__, 403);
        }
        elseif(file_exists($class.".php")) {
            require_once $class . ".php";
            $object = new $class();
            if(method_exists($object,$method)) {
                return $object->{$method}();
            }
            else
                throw new Exception("Selected method $method not found in class : ". $class, 403);
        }
        else {
            throw new Exception("No Class Found named : ". $class, 404);
        }
    }

} 