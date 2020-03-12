<?php 

require __DIR__ . '/../../../../vendor/autoload.php';

require_once(__dir__.'/../lib/DbLib.php');
require_once(__dir__.'/../lib/JwtLib.php');

include_once __dir__.'/../../consts/consts.php';


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
    
}