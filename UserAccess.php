<?php
/**
 * @package UserAccess.php
 * @author  Faisal<faisal@nascenia.com>
 * @created 2014 - 03 - 18
 * @version 2014 - 03 - 18
 */

class UserAccess {

    private $rawString = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";

    private $incrementId = 570;

    function __construct() {}

    public function getUserDetailsFromToken($token) {
        return $this->decodeToken($token);
    }

    public function generateToken($userId) {
        return $this->encodeToken($userId);
    }

    private function encodeToken($intUserId) {
        $randomString = str_shuffle($this->rawString);
        $tokenStringPart1  = substr($randomString,10,9);
        $tokenStringPart2  = substr($randomString,20,9);

        $currentTime = time();
        $encodedTime = base64_encode($currentTime);
        $fineEncodedTime = str_ireplace("==","",$encodedTime);

        $encodedId = base64_encode($intUserId+$this->incrementId);
        $fineEncodedId = str_ireplace("==","",$encodedId);

        $fullToken = $tokenStringPart1 . $fineEncodedTime . $tokenStringPart2 . $fineEncodedId;

        return $fullToken;
    }

    private function decodeToken($token) {

        $encodedTime = base64_decode(substr($token,9,14)."==");
        $intTime = (int) $encodedTime;

        $encodedId = base64_decode(substr($token,32,strlen($token)));
        $intUserId = (int) $encodedId;

        $expiredOn = time() - $intTime;
        $originalUserId = $intUserId - $this->incrementId;

        $arrUserDetails = array(
            'userId'        => $originalUserId ? $originalUserId : 0,
            'tokenLife'     => $expiredOn <= 7200 ? 7200 - $expiredOn : 0
        );

        return $arrUserDetails;
    }
}
