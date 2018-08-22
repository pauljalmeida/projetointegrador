<?php

namespace App\Controllers;

use SON\Controller\Action;
use \SON\Di\Container;
use \SON\Init\Bootstrap;
use \SON\Auth\Auth;

/**
 * Class Login
 *
 * Controller de login
 */

class Login extends Action
{

    protected $view;

    /**
     *  Chama a página de login
     */

    public function Login()
    {

        // Renderizando, sem o arquivol layout.phtml
        $this->render('login');

    }

    /**
     *  Faz a validação do login, recebendo como parâmetros o login e senha digitados no formulário.
     *  Caso os dados estejam incorretos, redireciona novamente ao login, com variável de erro setada, para exibir mensagem de erro de login na view.
     */

    public function validarLogin()
    {        

        $arquivo = Container::getClass("Login");        

        if ($arquivo->validateLogin($_POST["nome"], $_POST["senha"])){  

            if(!isset($_SESSION)) {
               session_start();
            }                 

            // Após o login, redireciona o usuário para a view início.            
            $this->render('index');

        // Se der erro no login, retorna para a view login, com variável de erro setada para exibir mensagem de erro de login na view.
        } else {
            $this->view->erro = true;
            $this->render('index');
        }

    }

    /**
     *  Encerra a sessão e redireciona o usuário para a página de login
     */
    public function logoff()
    {
        if(!isset($_SESSION)) {
           session_start();
        }
        if (isset($_SESSION['logado'])){
            unset($_SESSION['logado']);
            session_destroy();
            $this->render('login');
        }

    }
    
}
