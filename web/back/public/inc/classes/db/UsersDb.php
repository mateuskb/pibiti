<?php 

require __DIR__ . '/../../../../vendor/autoload.php';

require_once(__dir__.'/../lib/DbLib.php');

include_once __dir__.'/../../consts/consts.php';


class UserDb {
    var $conn;
    function __construct($_conn=NULL) {
        if($_conn):
            try{
                $this->conn = is_object($_conn) ? $_conn : (new DbLib())->connect();
            }catch (Exception $e){
                $this->conn = false;
            }
        else:
            try{
                $this->conn = (new DbLib())->connect();
            }catch (Exception $e){
                $this->conn = false;
            }
        endif;

    }

    public function login($input) {
        $data = [
            'ok'=>false,
            'errors'=>[],
            'data'=>[]
        ];
        
        if(isset($input)){
            $username = array_key_exists("username",$input) ? $input['username'] : '';
            $password = array_key_exists("password",$input) ? $input['password'] : '';
        };
        
        if (empty($username)):
            $data['errors']['username'] = 'Username não indicado!';
        endif;
        if (empty($password)):
            $data['errors']['password'] = 'Senha não indicada!';
        endif;
        
        /*
        HOW TO HASH PASSWORD
        $hash = password_hash($password, PASSWORD_BCRYPT, OPTIONS_HASH);
        $data['data']['hash'] = $hash;
        */

        if(empty($data['errors'])):
            if(!isset($this->conn)):
                $data['errors']['conn'] = 'Erro na conexão com o banco de dados!';
            else:
                $sql = "
                    SELECT 
                        usr_c_hash
                    FROM
                        users
                    WHERE
                        usr_c_username = :username
                ";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':username', $username, PDO::PARAM_STR);
                $stmt->execute();
                $resp = $stmt->fetch(PDO::FETCH_ASSOC); 

                $hash = !empty($resp['usr_c_hash']) ? $resp['usr_c_hash'] : '';

                if (empty($hash)):
                    $data['errors']['hash'] = 'Hash não identificado! Por favor, entre em contato.';
                endif;
                
                if (password_verify($password, $hash)) { 
                    $data['data'] = 'Password is valid!'; 
                } else { 
                    $data['data'] = 'Invalid password.'; 
                }  

                //$data['data']['hash'] = $resp['usr_c_hash'];

            endif; 

            if(empty($data['errors'])):
                $data['ok'] = true;
            endif;
        endif;
        
        return $data;

    }
}