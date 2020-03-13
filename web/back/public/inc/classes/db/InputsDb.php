<?php 

require __DIR__ . '/../../../../vendor/autoload.php';

require_once(__dir__.'/../lib/DbLib.php');
require_once(__dir__.'/../lib/JwtLib.php');

include_once __dir__.'/../../consts/consts.php';
include_once __dir__.'/UsersDb.php';


class InputsDb {
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

    public function get_inputs(){
        
        $in_transaction = false;

        $data = [
            'ok'=>false,
            'errors'=>[],
            'data'=>false
        ];

        if($this->conn->inTransaction()):
            $in_transaction = true;
        endif;

        try{
            $dt_now = (new DateTime('now', new DateTimeZone("UTC")));
            $dt_now = $dt_now->format("Y-m-d h:i:s");

            if(!$in_transaction):
                $this->conn->beginTransaction();
            endif;

            $sql = "
                SELECT
                    *
                FROM
                    inputs
                ORDER BY
                    inp_pk DESC
                LIMIT 1
                ;
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $resp = $stmt->fetch(PDO::FETCH_ASSOC); 
            $data['data'] = $resp;
        } catch (Exception $e){
            $data['errors']['conn'] = "Erro na conexão com o banco de dados: " . $e;
        }

        if(empty($data['errors'])):
            $data['ok'] = true;
            if(!$in_transaction):
                $this->conn->commit();
            endif;
        else:
            if(!$in_transaction):
                $this->conn->rollback(); 
            endif;
        endif;
        return $data;
    }

    public function c_inputs($input) {
        // Vars
        $id_usuario = 0;
        $id_login = 0;
        $dt_now = '';
        $inputs = [];

        $data = [
            'ok'=>false,
            'errors'=>[],
            'data'=>false
        ];
        
        if(isset($input)){
            $id_usuario = array_key_exists("usr_pk",$input) ? $input['usr_pk'] : '';
            $id_login = array_key_exists("log_pk",$input) ? $input['log_pk'] : '';
            $inputs = array_key_exists("inputs",$input) ? $input['inputs'] : [];
        };
        
        if ($id_usuario < 1):
            $data['errors']['idUsuario'] = 'idUsuario não indicado!';
        endif;

        if ($id_login < 1):
            $data['errors']['idLogin'] = 'idLogin não indicado!';
        endif;
        
        //$data['idUsuario'] = $id_usuario;
        //$data['idLogin'] = $id_login;

        foreach(INPUTS_AVAILABLE as $ia){
            if (!array_key_exists($ia ,$inputs)):
                $data['errors']['inputs'][$ia] = 'Input não registrado!';
            endif;
        }

        if(empty($data['errors'])):

            $resp = (new UserDb())->verify($input);

            if (!$resp['ok'] & !$resp['data']):
                $data['errors']['404'] = "Usuário inválido.";
            endif;

            if(empty($data['errors'])):
                #$dt_now = (new DateTime('now', new DateTimeZone("UTC")));
                #$dt_now = $dt_now->format("Y-m-d h:i:s");
                               
                if(!isset($this->conn)):
                    $data['errors']['conn'] = 'Erro na conexão com o banco de dados!';
                else:
                    try{
                        $this->conn->beginTransaction();
                        
                        $sql = '
                            INSERT 
                                INTO inputs (
                                    inp_b_rele1,
                                    inp_b_rele2
                                ) VALUES (
                                    :inp_b_rele1,
                                    :inp_b_rele2
                                )
                            
                        ';
                        $stmt = $this->conn->prepare($sql);
                        $stmt->bindValue(':inp_b_rele1', $inputs['inp_b_rele1'], PDO::PARAM_INT);                        
                        $stmt->bindValue(':inp_b_rele2', $inputs['inp_b_rele2'], PDO::PARAM_INT);                        
                        $stmt->execute();
                    
                    } catch (Exception $e){
                        $data['errors']['conn'] = "Erro na conexão com o banco de dados: " . $e;
                    }
                endif; 
            endif;
            if(empty($data['errors'])):
                $data['ok'] = true;
                $data['data'] = true;
                if($this->conn->inTransaction()):
                    $this->conn->commit();
                endif;
            else:
                if($this->conn->inTransaction()):
                    $this->conn->rollback(); 
                endif;
            endif;
        endif;
        
        return $data;

    }
    
}