<?php
use \Firebase\JWT\JWT;

require __DIR__ . '/../../../../vendor/autoload.php';

include_once __dir__.'/../../consts/consts.php';

class JwtLib {
    public function encode($array) {
        try{
            if(is_array($array)):
                return(JWT::encode($array, JWT_KEY, 'RS256'));
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
                return(JWT::decode($token, JWT_KEY, array('RS256')));
            else:
                return false;
            endif;
        } catch (Exception $e){
            return false;
        }

    }
    private function validade($array){
        
    }
}