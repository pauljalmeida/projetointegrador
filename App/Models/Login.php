<?php

namespace App\Models;

use \App\Init;

class Login
{
    protected $db;
    protected $table = "usuario";

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function validateLogin($username, $password){

       if(!isset($_SESSION))
        {
           session_start();
        }

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE siape = :username AND senha = md5(:password) AND ativo = 1");  


        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);
        $stmt->execute();
        /*echo "<pre>"; 
        var_dump($stmt->rowCount());
        die("parado aqui");*/
        // Caso os dados enviados retornem um usuário válido.
        if ($stmt->rowCount() == 1){

            $dados = $stmt->fetch();  
            $_SESSION['id_usuario'] = $dados["id_usuario"];
            $_SESSION['siape'] = $dados["siape"];         
            $_SESSION['login'] = $dados["primeiro_nome"];
            $_SESSION['verifique'] = $dados["verifique"];             

            return true;

        } else {

            return false;            
        }        
       
    }

    public function validateEmail($email){

        if(!isset($_SESSION))
        {
           session_start();
        }

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE BINARY email = :email AND ativo = 1 ");   

        $stmt->bindParam(":email", $email);
        $stmt->execute();
        /*echo "<pre>"; 
        var_dump($stmt->rowCount());
        die("parado aqui");*/

        // Caso os dados enviados retornem um email válido.
        if ($stmt->rowCount() == 1){

            $dados = $stmt->fetch();  
            $_SESSION['id_usuario'] = $dados["id_usuario"]; 
            $_SESSION['senha'] = $dados["senha"];
            $_SESSION['email'] = $dados["email"];  
            $_SESSION['verifique'] = $dados["verifique"];       
            $_SESSION['email'] = true;             

            return true;

        } else {

            return false;            
        }
    }  

    public function validateSenhaProvisoria($email, $password){

        if(!isset($_SESSION))
        {
           session_start();
        }

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE BINARY email= :email AND senha = md5(:password) AND ativo = 1 ");   

        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->execute();
        /*echo "<pre>"; 
        var_dump($stmt->rowCount());
        die("parado aqui");*/

        // Caso os dados enviados retornem um email válido.
        if ($stmt->rowCount() == 1){

            $dados = $stmt->fetch();  
            $_SESSION['id_usuario'] = $dados["id_usuario"]; 
            $_SESSION['senha'] = $dados["senha"];      
            $_SESSION['verifique'] = $dados["verifique"]; 
            $_SESSION['senha'] = true;             

            return true;

        } else {

            return false;            
        }       
       
    }
    
}