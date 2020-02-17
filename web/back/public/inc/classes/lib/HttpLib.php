<?php 

require_once($classes_url.'/lib/JwtLib.php');

class HttpLib {

    public function get_authorization($headers) {
        $auth = isset($headers['Authorization'][0]) ? $headers['Authorization'][0] : '';
        if (empty($auth)):
            return false;
        else:
            try {
                $arr = explode(' ',trim($auth));

                $tipo_auth = $arr[0];
                $auth = $arr[1];
                
                switch ( $tipo_auth ):

                    case 'Basic':
                        $decoded = base64_decode($auth);
                        $arr = explode(':', $decoded);
                        $resp = [];
                        $resp['username'] = $arr[0];
                        $resp['password'] = $arr[1];

                        return $resp; 
                        //return $resp;                    
                    
                    case 'Bearer':
                        $auth = (new JwtLib())->decode($auth);
                        return  $auth;
                    
                    default:
                        return false;
                endswitch;
            } catch (Exception $e){
                return false;
            }
        endif;
    }
}   