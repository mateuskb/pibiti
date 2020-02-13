<?php 

require __DIR__ . '/../../../../vendor/autoload.php';

require_once(__dir__.'/../lib/DbLib.php');


class UserDb {

    function __construct($_conn=NULL) {
        if(!is_null($_conn)):
            $this->_conn = is_object($_conn) ? $_conn : false;
        else:
            try{
                $this->_conn = (new DbLib());
            }catch (Exception $e){
                $this->_conn = false;
            }
        endif;

    }

    public function login($input) {

        if(!$this->_conn):
            return 'Erro na conexão com o banco de dados!';
        else:
            $username = array_key_exists("username",$input) ? $input['username'] : '';
            $password = array_key_exists("password",$input) ? $input['password'] : '';
            return "Username = $username \n Password = $password \n Conection = Conectado";
        endif; 
    }
}