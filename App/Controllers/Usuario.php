<?php
 
namespace App\Controllers;
 
use SON\Controller\Action;
use \SON\Di\Container;
use \SON\Init\Bootstrap;
 
class Usuario extends Action
{
    protected $view;    
    public function __construct()
    {
        $this->view = new \stdClass();
    }
 
    /**
     * MÉTODOS DO CONTROLLER USUARIO
     * */    


    // Exibe a relação de usuarios (SELECT)
    public function usuarioListar()
    {
        // Diz ao Controller que utilizaremos a Model Usuario (tabela usuario)        
        $usuario = Container::getClass("Usuario");
     
        /**
        * O Método select, da classe Table, retorna um array com o resultado do select, considerando o que foi passado como parâmetro. 
        * Neste caso, passamos os seguintes parâmetros: 
        * @param $campos = Informa quais os campos farão parte do select. Também pode ser usado *, para selecionar todos os campos
        * @param $ordenarPor = Informa por campo será feita a ordenação e
        * @param $ordenacao = Informa qual a ordem: ASC ou DESC
        * Opcional: você ainda pode informar um quarto parâmetro, quando necessário.
        * Ex.: $condicoes = "WHERE id > 20";
        * Neste caso, bastaria adicionar o parâmetro $condicoes após $ordenacao
        */
     
        //Verificar se está sendo passado na URL a página atual, senao é atribuido a pagina
        $pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

        //quantidade de itens que irá mostrar por pagina
        $itens_por_pagina=11;

        //Calcular o inicio da visualizacao
        $inicio = ($itens_por_pagina*$pagina)-$itens_por_pagina;

        //Select filtando conforme pelo $inico e $itens por pagina
        $campos = "*";
        $ordenarPor = "primeiro_nome";
        $ordenacao = "asc LIMIT $inicio, $itens_por_pagina";
        $usuarios = $usuario->select($campos, $ordenarPor, $ordenacao); 

        // Envia o array de usuarios filtrado conforme pelo $inico e $itens por pagina do select acima para a view; 
        // Na view, faremos um for para exibir todos os dados de usuarios deste array
        $this->view->usuarios = $usuarios;

        //select com todas as linhas da tabela usuario cadastradas no banco
        $campos = "*";
        $ordenarPor = "primeiro_nome";
        $ordenacao = "asc";
        $usuarios_total = $usuario->select($campos, $ordenarPor, $ordenacao); 
       
        // Envia o array do total de usuarios do select acima para a view; 
        // Na view, faremos um for para exibir todos os dados de usuarios deste array
        $this->view->usuarios_total = $usuarios_total;

        // Diz ao Controller que utilizaremos a Model Acesso (tabela Acesso)        
        $acesso = Container::getClass("Acesso");

        $campos = "*";
        $ordenarPor = "nome_nivel";
        $ordenacao = "asc";
        $acessos = $acesso->select($campos, $ordenarPor, $ordenacao);
     
        // Envia o array de acessos do select acima para a view; 
        // Na view, faremos um for para exibir todos os dados de acessos deste array
        $this->view->acessos = $acessos;
            

   
        // Renderizando (chama a view: usuario/usuario.phtml). Esta view recebe o array $this->view->usuarios. 
        //Ele será o responsável por exibir os dados na view
        $this->render('usuario');
    }
 
    // Exibe o formulário de cadastro de usuarios
    public function usuarioCadastrar()
    {
        /** 
        * Renderizando. 
        * Chama a view usuario/usuario-cadastrar.phtml 
        * Caso não queira utilizar o template e imprimir apenas o content, usar $this->render('usuario-cadastrar', false);
        * Todo o conteúdo desta view (neste caso, o formulário de cadastro) será impresso, no layout, através do código echo $this->content(); que já está definido no arquivo layout.phtml
        */
   
        //$this->render('usuario-cadastrar');

        // Diz ao Controller que utilizaremos a Model Acesso (tabela Acesso)        
        $acesso = Container::getClass("Acesso");

        $campos = "*";
        $ordenarPor = "Id_acesso";
        $ordenacao = "asc";
        $acessos = $acesso->select($campos, $ordenarPor, $ordenacao);
     
        // Envia o array de acessos do select acima para a view; 
        // Na view, faremos um for para exibir todos os dados de acessos deste array
        $this->view->acessos = $acessos;
            
        //Ele será o responsável por exibir os dados na view
        $this->render('usuario-cadastrar');

    }
 
    // Salva o formulário de cadastro de usuarios (INSERT)
    public function usuarioCadastrarSalvar()
    {

        if (!isset($_SESSION)){
            session_start();
        }

        // Diz ao Controller que utilizaremos a Model usuario
        $usuario = Container::getClass("Usuario"); 

        $senha =$this->geraCodigoSenha(8, true, true, true, false);
        $_SESSION['sn']=$senha;
        $senha = md5($senha);  

        $ativo=1;
        $verifique=0;


        // echo 'primeiro_nome'.ucwords($_POST["primeiro_nome"]).'<br>';
        // echo 'sobrenome'.ucwords($_POST["sobrenome"]).'<br>';
        // echo 'siape'.$_POST["siape"].'<br>';
        // echo 'cargo'.$_POST["cargo"].'<br>';
        // echo 'senha'.$senha.'<br>';
        // echo 'email'.$_POST["email"].'<br>';
        // echo 'Id_acesso'.$_POST["Id_acesso"].'<br>';
        // echo 'ativo'.$ativo.'<br>';
        // echo 'verifique'.$verifique.'<br>';
 
        // Array com os campos e valores do BD para realizar o insert.
        // Estes valores foram passados pelo formulário de cadastro, via POST
        $arrayBD = [
        'primeiro_nome' => ucwords($_POST["primeiro_nome"]),
        'sobrenome' => ucwords($_POST["sobrenome"]),
        'siape' => $_POST["siape"],
        'cargo' => $_POST["cargo"],
        'senha' => $senha,
        'email' => $_POST["email"],
        'Id_acesso' => $_POST["Id_acesso"],
        'ativo' => $ativo,
        'verifique' => $verifique
        ];
 
        // Chama o método insert() da classe Table.
        // Basta passar o array ($arrayBD) como parâmetro para que o INSERT aconteça.
        // Note que não foi preciso implementar nada em SQL pois tudo já está pronto.
        $usuarios = $usuario->insert($arrayBD);
 
            // Renderizando e chamando a view que mostrará uma mensagem de confirmação
            $this->render('usuario-cadastrar-salvar');

    }

    // Mostra menssagem de erro caso houver erro no cadastro de usuarios (INSERT)
    public function usuarioCadastrarSalvarErro()
    {

        /** 
        * Renderizando. 
        * Chama a view usuario/usuario-cadastrar-salvar-erro-salvar-erro.phtml 
        * Caso não queira utilizar o template e imprimir apenas o content, usar $this->render('usuario-cadastrar-salvar-erro', false);
        * Todo o conteúdo desta view (neste caso, o formulário de cadastro) será impresso, no layout, através do código echo $this->content(); que já está definido no arquivo layout.phtml
        */

        // Renderizando e chamando a view que mostrará uma mensagem de erro
        $this->render('usuario-cadastrar-salvar-erro');

    }
 
    // Exibe o formulário de edição de usuario (SELECT)
    public function usuarioEditar()
    {
        // Diz ao Controller que utilizaremos a Model usuario
        $usuario = Container::getClass("Usuario");
 
        /**
         * O método findId() da classe Table retorna um array com todos os dados de um usuario e exige dois parâmetros. 
         * O primeiro parâmetro do método é o nome do campo da tabela onde será feita a consulta (neste caso, campo id).
         * O segundo parâmetro é o valor que será buscado neste campo. Neste caso, o valor do id que foi enviado por parâmetro na URL.
         * O método Bootstrap::getIdByUrl() retorna o valor do parâmetro que foi passado na URL (neste caso, o valor do id). 
         * Exemplo: www.projetointegrador.com.br/usuario-editar-salvar/12 informa que o ID do usuario que estamos fazendo a edição é 12
         * */
 
        $usuarios = $usuario->findId("id_usuario", Bootstrap::getIdByUrl());
 
        // Atribui para a view;
        $this->view->usuarios = $usuarios;
  
        // Renderizando
        //$this->render('usuario-editar');

        // Diz ao Controller que utilizaremos a Model Subema (tabela Acesso)        
        $acesso = Container::getClass("Acesso");

        $campos = "Id_acesso, nome_nivel";
        $ordenarPor = "Id_acesso";
        $ordenacao = "asc";
        $acessos = $acesso->select($campos, $ordenarPor, $ordenacao);
     
        // Envia o array de acessos do select acima para a view; 
        // Na view, faremos um for para exibir todos os dados de acessos deste array
        $this->view->acessos = $acessos;
            
            
        //Ele será o responsável por exibir os dados na view
        $this->render('usuario-editar');  
    }
 
    // Salva o formulário de edição de usuario (UPDATE)
    public function usuarioEditarSalvar()
    {
        // Diz ao Controller que utilizaremos a Model usuario
        $usuario = Container::getClass("Usuario");    


        // O método abaixo retorna o ID passado por parâmetro na URL
        $idUrl = Bootstrap::getIdByUrl();

        //select com todas as linhas da tabela usuario cadastradas no banco
        $campos = "*";
        $ordenarPor = "id_usuario";
        $ordenacao = "asc";
        $condicoes = "WHERE id_usuario = $idUrl";
        $usuarios = $usuario->select($campos, $ordenarPor, $ordenacao); 

        foreach ($usuarios as $user){ 
                $senha=$user["senha"];
        }

        // Array com os campos e valores do BD para realizar o update.
        // Estes valores foram passados pelo formulário de edição, via POST
        $arrayDados = [
        'primeiro_nome' => ucwords($_POST["primeiro_nome"]),
        'sobrenome' => ucwords($_POST["sobrenome"]),
        'siape' => $_POST["siape"],
        'cargo' => $_POST["cargo"],
        'senha' => $senha,
        'email' => $_POST["email"],
        'Id_acesso' => $_POST["Id_acesso"]
        
        ];       
 
        /**
        * Método público para atualizar os dados na tabela 
        * @param $arrayDados = Array de dados contendo colunas e valores que serão editados.
        * @param $arrayCondicao = Array de dados contendo colunas e valores para condição WHERE - Exemplo array('$id='=>1) 
        * Neste caso, estamos passando apenas a condição de que o id deverá ter o valor passado na URL (e recuperado através de $idUrl = Bootstrap::getIdByUrl() )
        */          
 
        $arrayCondicao = array('id_usuario='=>$idUrl);
        $usuario->update($arrayDados, $arrayCondicao);        
 
        // Renderizando
        $this->render('usuario-editar-salvar');    
    }
 
    // Solicita confirmação de exclusão de usuario
    public function usuarioDeletarConfirmacao()
    {
        // Apenas exibirá a view de confirmação de exclusão
        $this->render('usuario-deletar-confirmacao');
    }
 
    // Exclui o usuario (DELETE)
    public function usuarioDeletarSalvar()
    {
         // Diz ao Controller que utilizaremos a Model Usuario
        $usuario = Container::getClass("Usuario");
 
        // O método abaixo deleterá o ID passado por parâmetro na URL e pelo método Bootstrap::getIdByUrl();
        // O primeiro parâmetro passado: "id" representa o nome do campo na tabela.
        $usuario->delete("id_usuario", Bootstrap::getIdByUrl());
  
        // Renderizando
        $this->render('usuario-deletar-salvar');
    }

    // Alterar senha usuario que esqueceu a senha e ja passou pelos procedimentos de confirmação de email existente e gera chava de retificação
    public function usuarioRetificarSenha()
    {
        if(!isset($_SESSION)) {
            session_start();
        }

        // Diz ao Controller que utilizaremos a Model usuario
        $usuario = Container::getClass("Usuario");   

        if ((!empty($_POST['chave'])) == $_SESSION['chave']) {
            // O método abaixo retorna o ID passado por parâmetro na URL
            $idUsuario = $_SESSION['id_usuario'];

            //select com todas as linhas da tabela usuario cadastradas no banco
            $campos = "*";
            $ordenarPor = "id_usuario";
            $ordenacao = "asc";
            $condicoes = "WHERE id_usuario = $idUsuario";
            $usuarios = $usuario->select($campos, $ordenarPor, $ordenacao); 


            foreach ($usuarios as $user){ 
                if ($idUsuario==($user["id_usuario"])) {                
                    $primeiro_nome=ucwords($user["primeiro_nome"]);
                    $sobrenome=ucwords($user["sobrenome"]);
                    $siape=$user["siape"];
                    $cargo=$user["cargo"];
                    $email=$user["email"];
                    $verifique=$user["verifique"];
                }
            }

            $senha = $_POST['senha'];
            $senha = md5($senha); 

            // Array com os campos e valores do BD para realizar o update.
            // Estes valores foram passados pelo formulário de edição, via POST
            $arrayDados = [
            'primeiro_nome' => $primeiro_nome,
            'sobrenome' => $sobrenome,
            'siape' => $siape,
            'cargo' => $cargo,
            'senha' => $senha,
            'email' => $email,
            'verifique' => $verifique
            ];   

     
            /**
            * Método público para atualizar os dados na tabela 
            * @param $arrayDados = Array de dados contendo colunas e valores que serão editados.
            * @param $arrayCondicao = Array de dados contendo colunas e valores para condição WHERE - Exemplo array('$id='=>1) */       
     
            $arrayCondicao = array('id_usuario='=>$idUsuario);
            $usuario->update($arrayDados, $arrayCondicao); 
            
                unset($_SESSION['chave']);
                unset($_SESSION['email']);
                unset($_SESSION['id_usuario']); 
                unset($_SESSION['senha']); 
                unset($_SESSION['verifique']);      
                session_destroy();
            
            // Renderizando
            $this->render('usuario-sucesso-alterar-senha');  
        }      
        else{
                    unset($_SESSION['chave']);
                    unset($_SESSION['email']);
                    unset($_SESSION['id_usuario']); 
                    unset($_SESSION['senha']);   
                    unset($_SESSION['verifique']);    
                    session_destroy();
                    // Renderizando
                    $this->render('usuario-erro-alterar-senha');
            }
        }

    // Alterar senha usuario primeiro acesso e ja passou pelos procedimentos de confirmação de email existente e gera chava de acesso
    public function usuarioCadastrarSenhaPrimeiroAcesso()
    {
        if(!isset($_SESSION)) {
            session_start();
        }

        // Diz ao Controller que utilizaremos a Model usuario
        $usuario = Container::getClass("Usuario");   

        if ((!empty($_POST['chave'])) == $_SESSION['chave']) {
            // O método abaixo retorna o ID passado por parâmetro na URL
            $idUsuario = $_SESSION['id_usuario'];

            //select com todas as linhas da tabela usuario cadastradas no banco
            $campos = "*";
            $ordenarPor = "id_usuario";
            $ordenacao = "asc";
            $condicoes = "WHERE id_usuario = $idUsuario";
            $usuarios = $usuario->select($campos, $ordenarPor, $ordenacao); 


            foreach ($usuarios as $user){ 
                if ($idUsuario==($user["id_usuario"])) {                
                    $primeiro_nome=ucwords($user["primeiro_nome"]);
                    $sobrenome=ucwords($user["sobrenome"]);
                    $siape=$user["siape"];
                    $cargo=$user["cargo"];
                    $email=$user["email"];
                    $verifique=$user["verifique"];
                }
            }

            $senha = $_POST['senha'];
            $senha = md5($senha); 
            $verifique=1;

            // Array com os campos e valores do BD para realizar o update.
            // Estes valores foram passados pelo formulário de edição, via POST
            $arrayDados = [
            'primeiro_nome' => $primeiro_nome,
            'sobrenome' => $sobrenome,
            'siape' => $siape,
            'cargo' => $cargo,
            'senha' => $senha,
            'email' => $email,
            'verifique' => $verifique
            ];   

     
            /**
            * Método público para atualizar os dados na tabela 
            * @param $arrayDados = Array de dados contendo colunas e valores que serão editados.
            * @param $arrayCondicao = Array de dados contendo colunas e valores para condição WHERE - Exemplo array('$id='=>1) */       
     
            $arrayCondicao = array('id_usuario='=>$idUsuario);
            $usuario->update($arrayDados, $arrayCondicao); 
            
                unset($_SESSION['chave']);
                unset($_SESSION['id_usuario']); 
                unset($_SESSION['senha']);
                unset($_SESSION['verifique']);      
                session_destroy();
            
            // Renderizando
            $this->render('usuario-sucesso-cadastrar-senha');  
        }      
        else{
                    unset($_SESSION['chave']);
                    unset($_SESSION['email']);
                    unset($_SESSION['id_usuario']); 
                    unset($_SESSION['senha']);
                    unset($_SESSION['verifique']);       
                    session_destroy();
                    
                    // Renderizando
                    $this->render('usuario-erro-cadastrar-senha');
            }
        }

    public function geraCodigoSenha($tamanho, $maiusculas, $minusculas, $numeros, $simbolos){

        $codigo=0;

      $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
      $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
      $nu = "0123456789"; // $nu contem os números
      $si = "!#$%&()_+="; // $si contem os símbolos
     
      if ($maiusculas){
            // se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $codigo
            $codigo .= str_shuffle($ma);
      }
     
        if ($minusculas){
            // se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $codigo
            $codigo .= str_shuffle($mi);
        }
     
        if ($numeros){
            // se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $codigo
            $codigo .= str_shuffle($nu);
        }
     
        if ($simbolos){
            // se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $codigo
            $codigo .= str_shuffle($si);
        }
     
        // retorna a codigo embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
        return substr(str_shuffle($codigo),0,$tamanho);

    }
    }