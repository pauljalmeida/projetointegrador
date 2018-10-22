<?php
namespace App;

use SON\Init\Bootstrap;

class Init extends Bootstrap
{
    /**
     * Rotas do admin
     * @return array da rota com Controller e Método chamado pela URL
     */
    protected function initRoutes()
    {        

        /**
        * Defina os arrays de rotas de seu sistema logo abaixo deste bloco de comentário (em linhas anteriores ao método setRoutes);
        * Cada declaração contém o caminho(rota), o Controller e o método deste Controller. O método do Controller será o responsável por dizer ao seu sistema o que aquela URL fará.
        * Exs.:
        * 
        * $ar['cliente'] = array('route' => '/cliente', 'controller' => 'cliente', 'action' => 'clienteListar');             * 
        * Neste exemplo, ao acessar o endereço www.dominiodesuaaplicacao.com.br/cliente, a aplicação entenderá que está 
        *sendo chamado o controller Cliente e o método clienteListar deste controller. Neste método serão definadas as ações que 
        *serão realizadas, ou seja, a listagem de clientes. Utilize, no array, o nome do controller sempre em minúsculas (cliente).
        * 
        * $ar['cliente-cadastrar'] = array('route' => '/cliente-cadastrar', 'controller' => 'cliente', 'action' => 'clienteCadastrar');     
        * Neste exemplo, ao acessar o endereço www.dominiodesuaaplicacao.com.br/cliente-cadastrar, a aplicação entenderá que 
        *está sendo chamado o controller Cliente e o método clienteCadastrar deste controller. Neste método serão definadas 
        *as ações que serão realizadas, ou seja, o formulário de cadastro de clientes. Utilize, no array, o nome do controller 
        *sempre em minúsculas (cliente).
        */         

        // Rota da página inicial da aplicação. Chama o Controller Index, método (action) index() 

        $ar['/'] = array('route' => '/', 'controller' => 'index', 'action' => 'index');

         //Rota da página de login
         $ar['login'] = array('route' => '/login', 'controller' => 'login', 'action' => 'loginHome');

         //Rota página login-erro
         $ar['login-erro'] = array('route' => '/login-erro', 'controller' => 'login-erro', 'action' => 'iniciarSessao');
 
         //Rota página login-esqueceu-senha
         $ar['login-esqueceu-senha'] = array('route' => '/login-esqueceu-senha', 'controller' => 'login', 'action' => 'esqueceuSenha');
 
         //Rota para gerar chave de acesso
         $ar['login-recuperar-senha'] = array('route' => '/login-recuperar-senha', 'controller' => 'login', 'action' => 'recuperarSenha');
 
         //Rota retificar senha se tiver a chave
         $ar['retificar-senha'] = array('route' => '/retificar-senha', 'controller' => 'login', 'action' => 'retificarSenha');
 
         // Rota da página de sucesso alteração de senha de usuario
         $ar['usuario-retificar-senha'] = array('route' => '/usuario-retificar-senha', 'controller' => 'usuario', 'action' => 'usuarioRetificarSenha'); 
 
         //Rota gerar chave de acesso
         $ar['login-alterar-senha'] = array('route' => '/login-alterar-senha', 'controller' => 'login', 'action' => 'loginAlterarSenha');
 
         //Rota para alterar a senha primeiro acesso se tiver o código e a chave
         $ar['alterar-senha-primeiro-acesso'] = array('route' => '/alterar-senha-primeiro-acesso', 'controller' => 'login', 'action' => 'alterarSenhaPrimeiroAcesso');
 
         //Rota cadastrar nova senha - primeiro acesso
         $ar['usuario-senha-primeiro-acesso'] = array('route' => '/usuario-senha-primeiro-acesso', 'controller' => 'usuario', 'action' => 'usuarioCadastrarSenhaPrimeiroAcesso');
         
         //Rota para validar sessão
         $ar['inicia-sessao'] = array('route' => '/inicia-sessao', 'controller' => 'login', 'action' => 'iniciarSessao');
 
         //Rota para logoff
         $ar['sair'] = array('route' => '/sair', 'controller' => 'login', 'action' => 'logoff');
 
         // Rota da listagem de usuarios     
         $ar['usuario'] = array('route' => '/usuario', 'controller' => 'usuario', 'action' => 'usuarioListar');
      
         // Rota da página inicial de cadastro de usuarios
         $ar['usuario-cadastrar'] = array('route' => '/usuario-cadastrar', 'controller' => 'usuario', 'action' => 'usuarioCadastrar');
  
         // Rota da página de confirmação de cadastro de usuarios
         $ar['usuario-cadastrar-salvar'] = array('route' => '/usuario-cadastrar-salvar', 'controller' => 'usuario', 'action' => 'usuarioCadastrarSalvar'); 
  
         // Rota da página inicial de edição de usuario
         $ar['usuario-editar'] = array('route' => '/usuario-editar', 'controller' => 'usuario', 'action' => 'usuarioEditar');  
  
         // Rota da página de confirmação de edição de usuario
         $ar['usuario-editar-salvar'] = array('route' => '/usuario-editar-salvar', 'controller' => 'usuario', 'action' => 'usuarioEditarSalvar');   
  
         // Rota usuarioda página de confirmação de exclusão de usuario
         $ar['usuario-deletar-confirmacao'] = array('route' => '/usuario-deletar-confirmacao', 'controller' => 'usuario', 'action' => 'usuarioDeletarConfirmacao');                   
  
         // Rota da página de exclusão definitva de usuario
         $ar['usuario-deletar-salvar'] = array('route' => '/usuario-deletar-salvar', 'controller' => 'usuario', 'action' => 'usuarioDeletarSalvar');  
 
         // Rota da página de sucesso alteração de senha de usuario
         $ar['usuario-alterar-senha'] = array('route' => '/usuario-alterar-senha', 'controller' => 'usuario', 'action' => 'usuarioAlterarSenha'); 
 

        $ar['valida-login'] = array('route' => '/valida-login', 'controller' => 'login', 'action' => 'validarLogin');
        $ar['sair'] = array('route' => '/sair', 'controller' => 'login', 'action' => 'logoff');
        
        // Rota da listagem de clientes     
        $ar['cliente'] = array('route' => '/cliente', 'controller' => 'cliente', 'action' => 'clienteListar');
        
     
        // Rota da página inicial de cadastro de clientes
        $ar['cliente-cadastrar'] = array('route' => '/cliente-cadastrar', 'controller' => 'cliente', 'action' => 'clienteCadastrar');
 
        // Rota da página de confirmação de cadastro de clientes
        $ar['cliente-cadastrar-salvar'] = array('route' => '/cliente-cadastrar-salvar', 'controller' => 'cliente', 'action' => 'clienteCadastrarSalvar'); 
 
        // Rota da página inicial de edição de cliente
        $ar['cliente-editar'] = array('route' => '/cliente-editar', 'controller' => 'cliente', 'action' => 'clienteEditar');  
 
        // Rota da página de confirmação de edição de cliente
        $ar['cliente-editar-salvar'] = array('route' => '/cliente-editar-salvar', 'controller' => 'cliente', 'action' => 'clienteEditarSalvar');   
 
        // Rota da página de confirmação de exclusão de cliente
        $ar['cliente-deletar-confirmacao'] = array('route' => '/cliente-deletar-confirmacao', 'controller' => 'cliente', 'action' => 'clienteDeletarConfirmacao');                   
 
        // Rota da página de exclusão definitva de cliente
        $ar['cliente-deletar-salvar'] = array('route' => '/cliente-deletar-salvar', 'controller' => 'cliente', 'action' => 'clienteDeletarSalvar');  

        
        $ar['produtos'] = array('route' => '/produtos', 'controller' => 'produto', 'action' => 'produtosListar');  
        
        $ar['contato'] = array('route' => '/contato', 'controller' => 'contato', 'action' => 'contatoListar');   
        
         

        // Rota da listagem de categorias     
        $ar['categorias'] = array('route' => '/categorias', 'controller' => 'categoria', 'action' => 'categoriaListar');
        





         $ar['material'] = array('route' => '/material', 'controller' => 'material', 'action' => 'materialListar');
        
     
        // Rota da página inicial de cadastro de clientes
        $ar['material-cadastrar'] = array('route' => '/material-cadastrar', 'controller' => 'material', 'action' => 'materialCadastrar');
 
        // Rota da página de confirmação de cadastro de clientes
        $ar['material-cadastrar-salvar'] = array('route' => '/material-cadastrar-salvar', 'controller' => 'material', 'action' => 'materialCadastrarSalvar'); 
 
        // Rota da página inicial de edição de cliente
        $ar['material-editar'] = array('route' => '/material-editar', 'controller' => 'material', 'action' => 'materialEditar');  
 
        // Rota da página de confirmação de edição de cliente
        $ar['material-editar-salvar'] = array('route' => '/material-editar-salvar', 'controller' => 'material', 'action' => 'materialEditarSalvar');   
 
        // Rota da página de confirmação de exclusão de cliente
        $ar['material-deletar-confirmacao'] = array('route' => '/material-deletar-confirmacao', 'controller' => 'material', 'action' => 'materialDeletarConfirmacao');                   
 
        // Rota da página de exclusão definitva de cliente
        $ar['material-deletar-salvar'] = array('route' => '/material-deletar-salvar', 'controller' => 'material', 'action' => 'materialDeletarSalvar');  


         $ar['cate'] = array('route' => '/cate', 'controller' => 'cate', 'action' => 'cateListar');
        
     
        // Rota da página inicial de cadastro de cates
        $ar['cate-cadastrar'] = array('route' => '/cate-cadastrar', 'controller' => 'cate', 'action' => 'cateCadastrar');
 
        // Rota da página de confirmação de cadastro de cates
        $ar['cate-cadastrar-salvar'] = array('route' => '/cate-cadastrar-salvar', 'controller' => 'cate', 'action' => 'cateCadastrarSalvar'); 
 
        // Rota da página inicial de edição de cate
        $ar['cate-editar'] = array('route' => '/cate-editar', 'controller' => 'cate', 'action' => 'cateEditar');  
 
        // Rota da página de confirmação de edição de cate
        $ar['cate-editar-salvar'] = array('route' => '/cate-editar-salvar', 'controller' => 'cate', 'action' => 'cateEditarSalvar');   
 
        // Rota da página de confirmação de exclusão de cate
        $ar['cate-deletar-confirmacao'] = array('route' => '/cate-deletar-confirmacao', 'controller' => 'cate', 'action' => 'cateDeletarConfirmacao');                   
 
        // Rota da página de exclusão definitva de cate
        $ar['cate-deletar-salvar'] = array('route' => '/cate-deletar-salvar', 'controller' => 'cate', 'action' => 'cateDeletarSalvar');  

// Rota da listagem de status    
$ar['status'] = array('route' => '/status', 'controller' => 'status', 'action' => 'statusListar');
     
// Rota da página inicial de cadastro de statuss
$ar['status-cadastrar'] = array('route' => '/status-cadastrar', 'controller' => 'status', 'action' => 'statusCadastrar');

// Rota da página de confirmação de cadastro de statuss
$ar['status-cadastrar-salvar'] = array('route' => '/status-cadastrar-salvar', 'controller' => 'status', 'action' => 'statusCadastrarSalvar'); 

// Rota da página inicial de edição de status
$ar['status-editar'] = array('route' => '/status-editar', 'controller' => 'status', 'action' => 'statusEditar');  

// Rota da página de confirmação de edição de status
$ar['status-editar-salvar'] = array('route' => '/status-editar-salvar', 'controller' => 'status', 'action' => 'statusEditarSalvar');   

// Rota statusda página de confirmação de exclusão de status
$ar['status-deletar-confirmacao'] = array('route' => '/status-deletar-confirmacao', 'controller' => 'status', 'action' => 'statusDeletarConfirmacao');                   
// Rota da página de exclusão definitva de status
$ar['status-deletar-salvar'] = array('route' => '/status-deletar-salvar', 'controller' => 'status', 'action' => 'statusDeletarSalvar'); 

// Rota da listagem de niveis     
$ar['nivel'] = array('route' => '/nivel', 'controller' => 'nivel', 'action' => 'nivelListar');
     
// Rota da página inicial de cadastro de niveis
$ar['nivel-cadastrar'] = array('route' => '/nivel-cadastrar', 'controller' => 'nivel', 'action' => 'nivelCadastrar');

// Rota da página de confirmação de cadastro de niveis
$ar['nivel-cadastrar-salvar'] = array('route' => '/nivel-cadastrar-salvar', 'controller' => 'nivel', 'action' => 'nivelCadastrarSalvar'); 

// Rota da página inicial de edição de nivel
$ar['nivel-editar'] = array('route' => '/nivel-editar', 'controller' => 'nivel', 'action' => 'nivelEditar');  

// Rota da página de confirmação de edição de nivel
$ar['nivel-editar-salvar'] = array('route' => '/nivel-editar-salvar', 'controller' => 'nivel', 'action' => 'nivelEditarSalvar');   

// Rota nivelda página de confirmação de exclusão de nivel
$ar['nivel-deletar-confirmacao'] = array('route' => '/nivel-deletar-confirmacao', 'controller' => 'nivel', 'action' => 'nivelDeletarConfirmacao');                   

// Rota da página de exclusão definitva de nivel
$ar['nivel-deletar-salvar'] = array('route' => '/nivel-deletar-salvar', 'controller' => 'nivel', 'action' => 'nivelDeletarSalvar');  

 // Rota da listagem de acessos     
 $ar['acesso'] = array('route' => '/acesso', 'controller' => 'acesso', 'action' => 'acessoListar');
     
 // Rota da página inicial de cadastro de acessos
 $ar['acesso-cadastrar'] = array('route' => '/acesso-cadastrar', 'controller' => 'acesso', 'action' => 'acessoCadastrar');

 // Rota da página de confirmação de cadastro de acessos
 $ar['acesso-cadastrar-salvar'] = array('route' => '/acesso-cadastrar-salvar', 'controller' => 'acesso', 'action' => 'acessoCadastrarSalvar'); 

 // Rota da página inicial de edição de acesso
 $ar['acesso-editar'] = array('route' => '/acesso-editar', 'controller' => 'acesso', 'action' => 'acessoEditar');  

 // Rota da página de confirmação de edição de acesso
 $ar['acesso-editar-salvar'] = array('route' => '/acesso-editar-salvar', 'controller' => 'acesso', 'action' => 'acessoEditarSalvar');   

 // Rota acessoda página de confirmação de exclusão de acesso
 $ar['acesso-deletar-confirmacao'] = array('route' => '/acesso-deletar-confirmacao', 'controller' => 'acesso', 'action' => 'acessoDeletarConfirmacao');                   

 // Rota da página de exclusão definitva de acesso
 $ar['acesso-deletar-salvar'] = array('route' => '/acesso-deletar-salvar', 'controller' => 'acesso', 'action' => 'acessoDeletarSalvar');  


        $this->setRoutes($ar);
    }

    /**
     * Instancia o PDO
     * 
     * Você deverá alterar as configurações de seu banco logo abaixo (SGBD, host, usuário e senha). Como todo o código desta aplicação foi estruturado usando o PDO, você poderá usar diferentes bancos facilmente sem precisar fazer alterações no restante da aplicação. Abaixo, o SGBD foi definido como mysql. Caso sua aplicação utilize PostgreSQL, por exemplo, mude de mysql para pgsql
     *  
     * @return $db retorna uma instância da conexão
     */

    public static function getDb()
    {
        $db = new \PDO("mysql:host=localhost;dbname=gotasdesabor", "root", "", array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        return $db;
    }
}
