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
        * Neste exemplo, ao acessar o endereço www.dominiodesuaaplicacao.com.br/cliente, a aplicação entenderá que está sendo chamado o controller Cliente e o método clienteListar deste controller. Neste método serão definadas as ações que serão realizadas, ou seja, a listagem de clientes. Utilize, no array, o nome do controller sempre em minúsculas (cliente).
        * 
        * $ar['cliente-cadastrar'] = array('route' => '/cliente-cadastrar', 'controller' => 'cliente', 'action' => 'clienteCadastrar');     
        * Neste exemplo, ao acessar o endereço www.dominiodesuaaplicacao.com.br/cliente-cadastrar, a aplicação entenderá que está sendo chamado o controller Cliente e o método clienteCadastrar deste controller. Neste método serão definadas as ações que serão realizadas, ou seja, o formulário de cadastro de clientes. Utilize, no array, o nome do controller sempre em minúsculas (cliente).
        */         

        // Rota da página inicial da aplicação. Chama o Controller Index, método (action) index() 

        $ar['/'] = array('route' => '/', 'controller' => 'index', 'action' => 'index');

        $ar['login'] = array('route' => '/login', 'controller' => 'login', 'action' => 'login');

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
        $ar['links'] = array('route' => '/links', 'controller' => 'links', 'action' => 'linksListar');   
         

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
        $db = new \PDO("mysql:host=localhost;dbname=projetointegrador", "root", "", array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        return $db;
    }
}
