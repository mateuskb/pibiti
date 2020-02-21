<?php
require __DIR__ . '/../../../../vendor/autoload.php';

use \Firebase\JWT\JWT;

include_once __dir__.'/../../consts/consts.php';

class JwtLib {
    public function encode($array) {
        try{
            if(is_array($array)):
                return(JWT::encode($array, JWT_KEY));
            else:
                return false;
            endif;
        } catch (Exception $e){
            return false;
        }
    }
    public function decode($token) {
        try{
            if(is_string($token) & !empty($token)):
                return(JWT::decode($token, JWT_KEY, array("HS256")));
            else:
                return false;
            endif;
        } catch (Exception $e){
            return 'ERROR: '.$e;
        }

    }
}