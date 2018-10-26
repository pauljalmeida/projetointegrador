<?php 

namespace App\Controllers;

use SON\Controller\Action;
use \SON\Di\Container;
use \SON\Init\Bootstrap;
use \SON\Auth\Auth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

    public function loginHome()
    {

        // Renderizando, sem o arquivol layout.phtml
        $this->render('login');

    }

    /**
     *  Faz a validação do login, recebendo como parâmetros o login e senha digitados no formulário.
     *  Caso os dados estejam incorretos, redireciona novamente ao login, com variável de erro setada, para exibir mensagem de erro de login na view.
     */

    public function iniciarSessao()
    {

        if(!isset($_SESSION)) {
            session_start();
        }  


        if (!empty($_POST)) {
            $arquivo = Container::getClass("Login");

            if ($arquivo->validateLogin($_POST["siape"], $_POST["senha"])){ 

                if ($_SESSION['verifique']==0) {
                        $this->render('login-alterar-senha');
                }  
                elseif (($_SESSION['verifique']==1) && $arquivo->validateLogin($_POST["siape"], $_POST["senha"])){
                     $_SESSION['logado'] = true; 
                    // Após o login, redireciona o usuário para a view início.
                    
                    
                    $this->render('inicia-sessao'); 
                } 

            // Se der erro no login, retorna para a view login, com variável de erro setada para exibir mensagem de erro de login na view. 
            } else {
                $this->view->erro = true;
                $this->render('login-erro');
                } 
        }
        elseif (isset($_SESSION['logado'])) { //se usuario ja estiver conectado acessa o sistema.

            $categoria = Container::getClass("Categoria");

            $campos = "*";
            $ordenarPor = "nome";
            $ordenacao = "asc";
            $categorias = $categoria->select($campos, $ordenarPor, $ordenacao);
         
            // Envia o array de categorias do select acima para a view; 
            // Na view, faremos um for para exibir todos os dados de categorias deste array
            $this->view->categorias = $categorias;

                $this->render('inicia-sessao');
        }
        else{

            $this->render('login'); //se nao estiver conectado vai p/ login.
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
        else{
            $this->render('login');
        }

    }
    //Encaminha o usuário para view login-esqueceu-senha
    public function esqueceuSenha(){
        $this->render('login-esqueceu-senha');
    }
    
    //Verifica se o email informado existe no banco de dados e retorna com a chave de acesso
    public function recuperarSenha(){
        if (!empty($_POST)) {

        $this-> geraChaveRetificacao($_POST["email"]);

        }
    }

    public function geraChaveRetificacao($email){
        
            if(!isset($_SESSION)) {
                session_start();
            }

            $arquivo = Container::getClass("Login");

            if ($arquivo->validateEmail($_POST["email"])==1){       

                // Após o informar se estiver correto, gera a chave de acesso
                $chave = sha1($_SESSION['id_usuario']. $_SESSION['senha']);
                $_SESSION['chave']= $chave;
                //retorna para view login-recuperar-senha
                $this->render('login-recuperar-senha'); 
            }
            elseif ($arquivo->validateEmail($_POST["email"])==0){

                //retorna para view para informar que este email nao é castrado
                $this->render('login-email-inexistente'); 
            }
    }

    public function retificarSenha(){
        if(!isset($_SESSION)) {
                session_start();
            }

        if ((!empty($_POST['chave'])) == $_SESSION['chave']) {

            //mostra view com menssagem de sucesso
            $this->render('login-cadastrar-nova-senha');
           
        }
        else{

            //mostra view com a mensagem de erro
            $this->render('login-chave-inexistente');
        }
    }

    public function loginAlterarSenha(){
        if (!empty($_POST)) {

        $this-> geraChaveAcesso($_POST["senha_provisoria"]);

        }
    }

    public function geraChaveAcesso($senha_provisoria){
        
            if(!isset($_SESSION)) {
                session_start();
            }

            $arquivo = Container::getClass("Login");

            if ($arquivo->validateSenhaProvisoria($_POST["email"], $_POST["senha_provisoria"])==1){       

                // Após o informar se estiver correto, gera a chave de acesso
                $chave = sha1($_SESSION['id_usuario']. $_SESSION['senha']);
                $_SESSION['chave']= $chave;
                //retorna para view login-alterar-senha-primeiro-acesso
                $this->render('login-alterar-senha-primeiro-acesso'); 
            }
            elseif ($arquivo->validateSenhaProvisoria($_POST["email"], $_POST["senha_provisoria"])==0){

                //retorna para view para informar que este email nao é castrado
                $this->render('login-senha-provisoria-inexistente'); 
            }
    }

    public function alterarSenhaPrimeiroAcesso(){
        if(!isset($_SESSION)) {
                session_start();
            }

        if ((!empty($_POST['chave'])) == $_SESSION['chave']) {

            //mostra view com menssagem de sucesso
            $this->render('cadastrar-senha-primeiro-acesso');
           
        }
        else{

            //mostra view com a mensagem de erro
            $this->render('login-chave-acesso-inexistente');
        }
    }
    public function enviarEmail(){
        
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'user@example.com';                 // SMTP username
    $mail->Password = 'secret';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
            $mail->setFrom('from@example.com', 'Mailer');
            $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
    $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');

            //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }
}
             