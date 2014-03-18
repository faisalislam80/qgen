<?php
/**
 * @package Login.php
 * @author  Faisal<faisal@nascenia.com>
 * @created 2014 - 03 - 18
 * @version 2014 - 03 - 18
 */

class Login {


    public function __construct() {}

    public function login($username,$password) {
        //login procedure todo
        ############# if all is valid then,
        require_once "UserAccess.php";
        $objUserAccess = new UserAccess();
        $getToken = $objUserAccess->generateToken(1); //$userId will be set here fixme
        return array(
            'token'      => $getToken,
            'userid'    => 1 //fixme
        );
    }
}