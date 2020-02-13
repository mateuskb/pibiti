<?php
use \Firebase\JWT\JWT;

require __DIR__ . '/../../../vendor/autoload.php';

require_once(__dir__.'/../../consts/consts.php');

class JwtLib {
    public function encode($array) {
        if(is_array($array)):
            return(JWT::encode($array, consts.JWT_KEY, 'RS256'));
        else:
            return false;
        endif;
    }
    public function decode($array) {
        if(is_array($array)):
            return(JWT::encode($array, consts.JWT_KEY, 'RS256'));
        else:
            return false;
        endif;

    }
    private function validade($array){
        
    }
}