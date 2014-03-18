<?php
/**
 * @package Service.php
 * @author  Faisal<faisal@nascenia.com>
 * @created 2014 - 03 - 18
 * @version 2014 - 03 - 18
 */

require_once "Controller.php";
$controller = new Controller();

$token = isset($_REQUEST['token']) ? $_REQUEST['token'] : null;

$method = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;

global $userId;

$userId = (isset($_REQUEST['userid'])) ? $_REQUEST['userid'] : null;


if($method == 'login') {
    $response = $controller->getService('Login')->login("","");
    echo json_encode($response);
    die;
}

if ($token) {
#######################

    $blnUserFound = false;

    try {
        global $userDetails;
        $userDetails = $controller->getService('UserAccess')->getUserDetailsFromToken($token);

        $tokenLife = $userDetails['tokenLife'] > 0 ? $userDetails['tokenLife'] : 0;
        if ($tokenLife == 0) {
            die (json_encode(array(
                'message' => "Token got expired"
            )));
        }

        $intUserId = $userDetails['userId'];

        if($intUserId == $userId) {
            $controller->getService('DataProvider')->setUserId($intUserId);
        }
        else die(json_encode(array(
           'message' => "Invalid token or user id"
        )));

        if ($method) {
            $superGlue = $controller->getService('SuperGlue');
            try {
                $response = $superGlue->glue($method,"DataProvider");
                echo json_encode($response);
            }
            catch (Exception $e) {
                echo json_encode(array(
                    'message'   => "Service un-available right now. Your query send to customer care",
                    'internalMessage' => $e->getMessage()
                ));
                die;
            }

        }

    }
    catch (Exception $e) {
        $intCode = $e->getCode();
        if ($intCode == 404) {
            echo json_encode(array(
                'message'   => "Service un-available right now. Your query send to customer care",
                'internalMessage' => $e->getMessage()
            ));
            die;
        }
    }

#######################
    die;
}

die (json_encode(array(
    'message'   => "No token found"
)));