<?php
use \Firebase\JWT\JWT;
define('JWT_KEY','fjksdh78whfu7823hr23r#$2378fsdffuwehas489ry43bnferiufad34trfdhuj7nfwef');

class JwtLib {
    public function encode($array) {
        try{
            if(is_array($array)):
                return(JWT::encode($array, JWT_KEY, 'RS256'));
            else:
                return 'num é array';
                return false;
            endif;
        } catch (Exception $e){
            return 'Erro:'.$e;
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

$jwt = new JwtLib;

$array = [
    'usr_pk'=>1,
    'log_pk'=>10
];

$token = $jwt->encode($array);

echo $token;