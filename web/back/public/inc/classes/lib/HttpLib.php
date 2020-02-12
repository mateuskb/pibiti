<?php 

class HttpLib {

    public function get_authorization($headers) {
        $auth = isset($headers['Authorization'][0]) ? $headers['Authorization'][0] : '';
        if (empty($auth)){
            return '';
        } else {
            try {
                $arr = explode(' ',trim($auth));

                $tipo_auth = $arr[0];
                $auth = $arr[1];
                
                switch ( $tipo_auth ){

                    case 'Basic':
                        $decoded = base64_decode($auth);
                        $arr = explode(':', $decoded);
                        $resp = [
                            "username"=> arr[0],
                            "password"=> arr[1]
                        ];

                        return $resp; 
                        //return $resp;                    
                    
                    case 'Bearer':
                        return  'Deu bearer';
                    
                    default:
                        return false;
                }
            } catch (Exception $e){
                return false;
            }
        }
    }
}   