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
                if($this->conn->inTransaction()):
                    $this->conn->commit();
                endif;
            endif;
        else:
            if(!$in_transaction):
                if($this->conn->inTransaction()):
                    $this->conn->rollback(); 
                endif;
            endif;
        endif;
        return $data;
    }

    public function negate($input){
        
        $in_transaction = false;
        $id_input = 0;
        $hash = '';

        $data = [
            'ok'=>false,
            'errors'=>[],
            'data'=>false
        ];
        // $data['input'] = $input;

        if($this->conn->inTransaction()):
            $in_transaction = true;
        endif;

        if(isset($input)){
            $id_input = array_key_exists("idInput",$input) ? $input['idInput'] : 0;
            $hash = array_key_exists("hash",$input) ? $input['hash'] : '';
        };
        //$data['hash'] = $hash;

        if($id_input < 1):
            $data['errors']['idInput'] = 'Input não identificado.';
        endif;

        if(!password_verify(APP_NEGATE_KEY, $hash)):
            $data['errors']['password'] = 'Senha inválida.'; 
        endif;

        if (empty($data['errors'])):
            
            try{
                $dt_now = (new DateTime('now', new DateTimeZone("UTC")));
                $dt_now = $dt_now->format("Y-m-d h:i:s");

                if(!$in_transaction):
                    $this->conn->beginTransaction();
                endif;

                $sql = "
                    DELETE FROM
                        inputs 
                    WHERE 
                        inp_pk = :id_input

                    ;
                ";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':id_input', $id_input, PDO::PARAM_STR);
                $stmt->execute();

            } catch (Exception $e){
                $data['errors']['conn'] = "Erro na conexão com o banco de dados: " . $e;
            }
            
            if(empty($data['errors'])):
                $data['ok'] = true;
                $data['data'] = true;
                if(!$in_transaction):
                    if($this->conn->inTransaction()):
                        $this->conn->commit();
                    endif;
                endif;
            else:
                if(!$in_transaction):
                    if($this->conn->inTransaction()):
                        $this->conn->rollback(); 
                    endif;
                endif;
            endif;

        endif;
        return $data;
    }

    public function verify($inputs){

        $data = [
            'ok'=>false,
            'errors'=>[],
            'data'=>false
        ];
        // $data['input'] = $input;

        // if(isset($input)){
        //     $inputs = array_key_exists("inputs",$input) ? $input['inputs'] : [];
        // };
        //$data['hash'] = $hash;

        if (empty($data['errors'])):
            
            // TO DO
            // $data['inputs'] = $inputs;
            try {

                if(intval($inputs['inp_i_fonte']) < 12 || intval($inputs['inp_i_fonte'])> 30){
                    
                    $data['errors']['inputs'] = "Inputs podem causar dano!";
                }

            } catch (Exception $e){

                $data['errors']['inputs'] = "Inputs podem causar dano!";

            }

            if($inputs['inp_b_rele1'] == "1" & $inputs['inp_b_rele2'] == "1" & $inputs['inp_b_rele3'] == "1"):

                $data['errors']['inputs'] = "Inputs podem causar dano!";
        
            endif; 
            if($inputs['inp_b_rele4'] == "1" & $inputs['inp_b_rele5'] == "1" & $inputs['inp_b_rele6'] == "1"):
        
                $data['errors']['inputs'] = "Inputs podem causar dano!";
        
            endif; 
            if($inputs['inp_b_rele7'] == "1" & $inputs['inp_b_rele8'] == "1" & $inputs['inp_b_rele9'] == "1"):
        
                $data['errors']['inputs'] = "Inputs podem causar dano!";
            endif;
        
            
        endif;
        
        if(empty($data['errors'])):
            $data['ok'] = true;
            $data['data'] = true;
        endif;
        
        return $data;
    }

    public function c_inputs($input) {
        // Vars
        $id_usuario = 0;
        $in_transaction = false;
        $id_login = 0;
        $dt_now = '';
        $inputs = [];

        $data = [
            'ok'=>false,
            'errors'=>[],
            'data'=>false
        ];
        
        // $data['input'] = $input;

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
                $data['errors']['inputs'][$ia] = 'Input não registrado: '.$ia;
            endif;
        }

        if(empty($data['errors'])):

            $resp = (new UserDb())->verify($input);

            if (!$resp['ok'] & !$resp['data']):
                $data['errors']['404'] = "Usuário inválido.";
            endif;

            
            $resp = $this->verify($inputs);
            // $data['resp'] = $resp;
            if (!$resp['ok'] & !$resp['data']):
                $data['errors']['inputsValidation'] = "Inputs poderiam causar um dano ao módulo.";
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
                                    inp_b_rele2,
                                    inp_b_rele3,
                                    inp_b_rele4,
                                    inp_b_rele5,
                                    inp_b_rele6,
                                    inp_b_rele7,
                                    inp_b_rele8,
                                    inp_b_rele9,
                                    inp_b_rele10,
                                    inp_b_rele11,
                                    inp_b_rele12,
                                    inp_b_rele13,
                                    inp_i_fonte
                                ) VALUES (
                                    :inp_b_rele1,
                                    :inp_b_rele2,
                                    :inp_b_rele3,
                                    :inp_b_rele4,
                                    :inp_b_rele5,
                                    :inp_b_rele6,
                                    :inp_b_rele7,
                                    :inp_b_rele8,
                                    :inp_b_rele9,
                                    :inp_b_rele10,
                                    :inp_b_rele11,
                                    :inp_b_rele12,
                                    :inp_b_rele13,
                                    :inp_i_fonte
                                )
                            
                        ';
                        $stmt = $this->conn->prepare($sql);
                        $stmt->bindValue(':inp_b_rele1', $inputs['inp_b_rele1'], PDO::PARAM_INT);                        
                        $stmt->bindValue(':inp_b_rele2', $inputs['inp_b_rele2'], PDO::PARAM_INT);                        
                        $stmt->bindValue(':inp_b_rele3', $inputs['inp_b_rele3'], PDO::PARAM_INT);                        
                        $stmt->bindValue(':inp_b_rele4', $inputs['inp_b_rele4'], PDO::PARAM_INT);                        
                        $stmt->bindValue(':inp_b_rele5', $inputs['inp_b_rele5'], PDO::PARAM_INT);                        
                        $stmt->bindValue(':inp_b_rele6', $inputs['inp_b_rele6'], PDO::PARAM_INT);                        
                        $stmt->bindValue(':inp_b_rele7', $inputs['inp_b_rele7'], PDO::PARAM_INT);                        
                        $stmt->bindValue(':inp_b_rele8', $inputs['inp_b_rele8'], PDO::PARAM_INT);                        
                        $stmt->bindValue(':inp_b_rele9', $inputs['inp_b_rele9'], PDO::PARAM_INT);                        
                        $stmt->bindValue(':inp_b_rele10', $inputs['inp_b_rele10'], PDO::PARAM_INT);                        
                        $stmt->bindValue(':inp_b_rele11', $inputs['inp_b_rele11'], PDO::PARAM_INT);                        
                        $stmt->bindValue(':inp_b_rele12', $inputs['inp_b_rele12'], PDO::PARAM_INT);                        
                        $stmt->bindValue(':inp_b_rele13', $inputs['inp_b_rele13'], PDO::PARAM_INT);                        
                        $stmt->bindValue(':inp_i_fonte', $inputs['inp_i_fonte'], PDO::PARAM_INT);                        
                        $stmt->execute();
                    
                    } catch (Exception $e){
                        $data['errors']['conn'] = "Erro na execução do SQL: " . $e;
                    }
                endif; 
            endif;
            if(empty($data['errors'])):
                $data['ok'] = true;
                $data['data'] = true;
                if(!$in_transaction):
                    if($this->conn->inTransaction()):
                        $this->conn->commit();
                    endif;
                endif;
            else:
                if(!$in_transaction):
                    if($this->conn->inTransaction()):
                        $this->conn->rollback(); 
                    endif;
                endif;
            endif;
        endif;
        
        return $data;

    }
    
}