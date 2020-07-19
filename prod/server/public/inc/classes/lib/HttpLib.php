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
                        break;            
                    
                    case 'Bearer':
                        $payload = (new JwtLib())->decode($auth);
                        $payload = $this->payload_to_array($payload);
                        return $payload;
                        break;
                    default:
                        return false;
                        break;            
                endswitch;
            } catch (Exception $e){
                return false;
            }
        endif;
    }

    private function payload_to_array($payload) {
        $array = [];
        
        try{
            $usr_pk = $payload->usr_pk;
            $log_pk = $payload->log_pk;
            $array['usr_pk'] = $usr_pk;
            $array['log_pk'] = $log_pk;

            return $array;
        } catch (Exception $e) {
            return false;
        }
    
    }
}   