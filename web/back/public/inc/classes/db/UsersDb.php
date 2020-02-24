<?php 

require __DIR__ . '/../../../../vendor/autoload.php';

require_once(__dir__.'/../lib/DbLib.php');
require_once(__dir__.'/../lib/JwtLib.php');

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
        // Vars
        $id_usuario = 0;
        $id_login = 0;
        $username = '';
        $password = '';
        $hash = '';
        $dt_now = '';
        $dt_now_verifier = '';
        $last_movement = '';


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
        $hash_criado = password_hash($password, PASSWORD_BCRYPT, OPTIONS_HASH);
        $data['data']['hashCriado'] = $hash_criado;
        */

        if(empty($data['errors'])):
            if(!isset($this->conn)):
                $data['errors']['conn'] = 'Erro na conexão com o banco de dados!';
            else:
                try{
                    $this->conn->beginTransaction();
                    
                    $sql = "
                        SELECT 
                            usr_pk,
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

                    $id_usuario = !empty($resp['usr_pk']) ? $resp['usr_pk'] : 0;
                    $hash = !empty($resp['usr_c_hash']) ? $resp['usr_c_hash'] : '';

                    if ($id_usuario < 1):
                        $data['errors']['idUsuario'] = 'Usuário não identificado! Por favor, entre em contato.';
                    endif;

                    if (empty($hash)):
                        $data['errors']['hash'] = 'Hash não identificado! Por favor, entre em contato.';
                    endif;
                    
                    //$data['date'] = date("Y-m-d h:i:s");
                    // $data['resp'] = $resp;
                    // $data['hash'] = $hash;
                    // $data['password'] = $password;
                    if(!password_verify($password, $hash)):
                        $data['errors']['password'] = 'Senha inválida.'; 
                    endif;

                    //$data['data']['hash'] = $resp['usr_c_hash'];

                    if(empty($data['errors'])):
        
                        $dt_now = (new DateTime('now', new DateTimeZone("UTC")));
                        $dt_now = $dt_now->format("Y-m-d h:i:s");
                        $dt_now_verifier = (new DateTime('now', new DateTimeZone("UTC")))->modify(TIME_VERIFIER ." minutes");
                        $dt_now_verifier = $dt_now_verifier->format("Y-m-d h:i:s");
                        
                        $sql = "
                            SELECT 
                                log_pk,
                                log_dt_last_movement, 
                                log_b_logado	
                            FROM
                                logins
                            ORDER BY
                                log_pk DESC
                            LIMIT 1
                        ";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->execute();
                        $resp = $stmt->fetch(PDO::FETCH_ASSOC); 
                        $id_login = !empty($resp['log_pk']) ? $resp['log_pk'] : 0;
                        $last_movement = !empty($resp['log_dt_last_movement']) ? $resp['log_dt_last_movement'] : '';
                        $logado = !empty($resp['log_b_logado']) ? $resp['log_b_logado'] : 0;
        
                        if (!empty($last_movement) & $id_login > 0): 
                            
                            if (($dt_now_verifier >= $last_movement) || (!$logado)): 
                                if($logado):
                                    $sql = '
                                        UPDATE 
                                            logins
                                        SET 
                                            log_b_logado = 0
                                        WHERE 
                                            log_pk = :id_login
                                        ;
                                        
                                    ';
                                    $stmt = $this->conn->prepare($sql);
                                    $stmt->bindValue(':id_login', $id_login, PDO::PARAM_INT);                        
                                    $stmt->execute();
                                endif;

                                $sql = '
                                    INSERT 
                                        INTO logins(
                                            log_fk_user,
                                            log_dt_acessado,
                                            log_dt_last_movement,
                                            log_b_logado
                                        ) VALUES (
                                            :id_usuario,
                                            :dt_now,
                                            :dt_now,
                                            1
                                        )
                                    ;
                                    
                                ';
                                $stmt = $this->conn->prepare($sql);
                                $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);                        
                                $stmt->bindValue(':dt_now', $dt_now, PDO::PARAM_STR);                        
                                $stmt->execute();
                                
                                $sql = '
                                    SELECT 
                                        log_pk	
                                    FROM
                                        logins
                                    ORDER BY
                                        log_pk DESC
                                    LIMIT 1
                                    ;
                                    
                                ';
                                $stmt = $this->conn->prepare($sql);               
                                $stmt->execute();
                                $resp = $stmt->fetch(PDO::FETCH_ASSOC); 

                                $id_login = !empty($resp['log_pk']) ? $resp['log_pk'] : 0;

                                // $data['idLogin'] = $id_login;

                                if ($id_login < 1):
                                    $data['errors']['login'] = "Erro ao fazer login! Por favor entre em contato.";
                                endif;
                                
                            else:
                                $data['errors']['login'] = 'Usuário já logado.';
                            endif;
                        else:
                            $sql = '
                                INSERT 
                                    INTO logins(
                                        log_fk_user,
                                        log_dt_acessado,
                                        log_dt_last_movement,
                                        log_b_logado
                                    ) VALUES (
                                        :id_usuario,
                                        :dt_now,
                                        :dt_now,
                                        1
                                    )
                                ;
                                
                            ';
                            $stmt = $this->conn->prepare($sql);
                            $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);                        
                            $stmt->bindValue(':dt_now', $dt_now, PDO::PARAM_STR);                        
                            $stmt->execute();
                            
                            $sql = '
                                SELECT 
                                    log_pk	
                                FROM
                                    logins
                                ORDER BY
                                    log_pk DESC
                                LIMIT 1
                                ;
                                
                            ';
                            $stmt = $this->conn->prepare($sql);               
                            $stmt->execute();
                            $resp = $stmt->fetch(PDO::FETCH_ASSOC); 

                            $id_login = !empty($resp['log_pk']) ? $resp['log_pk'] : 0;

                            // $data['idLogin'] = $id_login;

                            if ($id_login < 1):
                                $data['errors']['login'] = "Erro ao fazer login! Por favor entre em contato.";
                            endif;
                     
                        endif;
                        
                        if(empty($data['errors'])):
                            $array = [
                                'usr_pk'=>$id_usuario,
                                'log_pk'=>$id_login
                            ];
                            $jwt = (new JwtLib())->encode($array);

                            if(!$jwt):
                                $data['errors']['jwt'] = "Erro ao criar JWT.";
                            endif;

                        endif;
                    endif;
                
                } catch (Exception $e){
                    $data['errors']['conn'] = "Erro na conexão com o banco de dados: " . $e;
                }
            endif; 

            if(empty($data['errors'])):
                $data['ok'] = true;
                $data['data'] = $jwt;
                $this->conn->commit();
            else:
                $this->conn->rollback(); 
            endif;
        endif;
        
        return $data;

    }

    public function logout($input) {
        // Vars
        $id_usuario = 0;
        $id_login = 0;

        $data = [
            'ok'=>false,
            'errors'=>[],
            'data'=>false
        ];
        
        if(isset($input)){
            $id_usuario = array_key_exists("usr_pk",$input) ? $input['usr_pk'] : '';
            $id_login = array_key_exists("log_pk",$input) ? $input['log_pk'] : '';
        };
        
        if ($id_usuario < 1):
            $data['errors']['idUsuario'] = 'idUsuario não indicado!';
        endif;
        if ($id_login < 1):
            $data['errors']['idLogin'] = 'idLogin não indicado!';
        endif;
        
        //$data['idUsuario'] = $id_usuario;
        //$data['idLogin'] = $id_login;
        

        if(empty($data['errors'])):
            if(!isset($this->conn)):
                $data['errors']['conn'] = 'Erro na conexão com o banco de dados!';
            else:
                try{
                    $this->conn->beginTransaction();
                    
                    $sql = '
                        UPDATE 
                            logins
                        SET 
                            log_b_logado = 0
                        WHERE 
                            log_pk = :id_login AND
                            log_fk_user = :id_usuario
                        ;
                        
                    ';
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindValue(':id_login', $id_login, PDO::PARAM_INT);                        
                    $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);                        
                    $stmt->execute();
                
                } catch (Exception $e){
                    $data['errors']['conn'] = "Erro na conexão com o banco de dados: " . $e;
                }
            endif; 
            if(empty($data['errors'])):
                $data['ok'] = true;
                $data['data'] = true;
                $this->conn->commit();
            else:
                $this->conn->rollback(); 
            endif;
        endif;
        
        return $data;

    }

    public function permission() {
        // VARS
        $dt_now = '';
        $dt_now_verifier = '';
        $last_movement = '';
        $logado = '';


        $data = [
            'ok'=>false,
            'errors'=>[],
            'data'=>false
        ];

        if(empty($data['errors'])):
            if(!isset($this->conn)):
                $data['errors']['conn'] = 'Erro na conexão com o banco de dados!';
            else:
                try{
                    $this->conn->beginTransaction();

                    $dt_now = (new DateTime('now', new DateTimeZone("UTC")));
                    $dt_now = $dt_now->format("Y-m-d h:i:s");
                    $dt_now_verifier = (new DateTime('now', new DateTimeZone("UTC")))->modify(TIME_VERIFIER ." minutes");
                    $dt_now_verifier = $dt_now_verifier->format("Y-m-d h:i:s");
                    
                    $sql = "
                        SELECT 
                            log_dt_last_movement, 
                            log_b_logado	
                        FROM
                            logins
                        ORDER BY
                            log_pk DESC
                        LIMIT 1
                    ";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute();
                    $resp = $stmt->fetch(PDO::FETCH_ASSOC); 
                    $last_movement = !empty($resp['log_dt_last_movement']) ? $resp['log_dt_last_movement'] : '';
                    $logado = !empty($resp['log_b_logado']) ? $resp['log_b_logado'] : 0;

                    if (!empty($last_movement)): 
                        if (($dt_now_verifier >= $last_movement) || (!$logado)):
                            $data['data'] = true;
                        endif;
                    else:
                        $data['data'] = true;
                    endif;

                } catch (Exception $e){
                    $data['errors']['conn'] = "Erro na conexão com o banco de dados: " . $e;
                }
            endif; 

            if(empty($data['errors'])):
                $data['ok'] = true;
                $this->conn->commit();
            else:
                $this->conn->rollback(); 
            endif;
        endif;
        
        return $data;
    }

    public function verify($input) {
        // Vars
        $id_usuario = 0;
        $id_login = 0;
        $logado = 0;
        $dt_now = '';
        $dt_now_verifier = '';
        $last_movement = '';

        $data = [
            'ok'=>false,
            'errors'=>[],
            'data'=>false
        ];
        
        if(isset($input)){
            $id_usuario = array_key_exists("usr_pk",$input) ? $input['usr_pk'] : '';
            $id_login = array_key_exists("log_pk",$input) ? $input['log_pk'] : '';
        };
        
        if ($id_usuario < 1):
            $data['errors']['idUsuario'] = 'idUsuario não indicado!';
        endif;
        if ($id_login < 1):
            $data['errors']['idLogin'] = 'idLogin não indicado!';
        endif;
        
        //$data['idUsuario'] = $id_usuario;
        //$data['idLogin'] = $id_login;
        

        if(empty($data['errors'])):
            $dt_now = (new DateTime('now', new DateTimeZone("UTC")));
            $dt_now = $dt_now->format("Y-m-d h:i:s");
            $dt_now_verifier = (new DateTime('now', new DateTimeZone("UTC")))->modify(TIME_VERIFIER ." minutes");
            $dt_now_verifier = $dt_now_verifier->format("Y-m-d h:i:s");
                                
            if(!isset($this->conn)):
                $data['errors']['conn'] = 'Erro na conexão com o banco de dados!';
            else:
                try{
                    $this->conn->beginTransaction();
                    
                    $sql = '
                        SELECT 
                            *
                        FROM
                            logins
                        WHERE 
                            log_pk = :id_login AND
                            log_fk_user = :id_usuario
                        ;
                        
                    ';
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindValue(':id_login', $id_login, PDO::PARAM_INT);                        
                    $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);                        
                    $stmt->execute();
                    $resp = $stmt->fetch(PDO::FETCH_ASSOC); 
                    
                    $last_movement = !empty($resp['log_dt_last_movement']) ? $resp['log_dt_last_movement'] : '';
                    $logado = !empty($resp['log_b_logado']) ? $resp['log_b_logado'] : 0;

                    if (!empty($last_movement) & $id_login > 0): 
                            
                        if (($dt_now_verifier >= $last_movement) || (!$logado)): 
                            if($logado):
                                $sql = '
                                    UPDATE 
                                        logins
                                    SET 
                                        log_b_logado = 0
                                    WHERE 
                                        log_pk = :id_login
                                    ;
                                    
                                ';
                                $stmt = $this->conn->prepare($sql);
                                $stmt->bindValue(':id_login', $id_login, PDO::PARAM_INT);                        
                                $stmt->execute();
                            endif;
                            $data['errors']['login'] = 'Usuário desconectado.';
                        else:
                            $resp = $this->new_movement($id_usuario, $id_login);
                            if(!($resp['ok'] & $resp['data'])):
                                $data['errors']['newMovement'] = "Não foi possível adicionar novo movimento!";
                            endif;
                        endif;
                    endif;
                } catch (Exception $e){
                    $data['errors']['conn'] = "Erro na conexão com o banco de dados: " . $e;
                }
            endif; 
            if(empty($data['errors'])):
                $data['ok'] = true;
                $data['data'] = true;
                $this->conn->commit();
            else:
                $this->conn->rollback(); 
            endif;
        endif;
        
        return $data;

    }

    public function new_movement($id_usuario, $id_login){
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
                UPDATE 
                    logins
                SET 
                    log_dt_last_movement = :dt_now
                WHERE 
                    log_pk = :id_login AND
                    log_fk_user = :id_usuario
                ;
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id_login', $id_login, PDO::PARAM_INT);                        
            $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);  
            $stmt->bindValue(':dt_now', $dt_now, PDO::PARAM_STR);  
            $stmt->execute();

        } catch (Exception $e){
            $data['errors']['conn'] = "Erro na conexão com o banco de dados: " . $e;
        }

        if(empty($data['errors'])):
            $data['ok'] = true;
            $data['data'] = true;
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
    
}
