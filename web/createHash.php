<?php
define("OPTIONS_HASH", 
        [
            'cost' => 12
        ]
    );

$password = 'ServerNegatePassWord';

print($password);

$hash_criado = password_hash('ServerNegatePassWord', PASSWORD_BCRYPT, OPTIONS_HASH);

print($hash_criado);

$verify = password_verify($password, $hash_criado); // $2y$12$YUehdI4CZ9wh4B8za.Tz5e6j0Zk.OJLmOl.EtzCiQpxA4zsHfA.cK

if ($verify){
    print("Verificado com sucesso");
}