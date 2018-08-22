<?php

namespace App\Models;

use \App\Init;

class Login
{
    protected $db;
    protected $table = "usuarios";

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function validateLogin($username, $password){

        if(!isset($_SESSION))
        {
           session_start();
        }

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE nome = :username AND senha = :password");   
                
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);
        $stmt->execute();


        // Caso os dados enviados retornem um usuário válido.
        if ($stmt->rowCount() == 1){

            $dados = $stmt->fetch();            
            $_SESSION['login'] = $dados["nome"];
            $_SESSION['logado'] = true;             

            return true;

        } else {

            return false;            
        }        
       
    }
    
}