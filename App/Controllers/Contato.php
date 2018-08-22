<?php
 
namespace App\Controllers;
 
use SON\Controller\Action;
use \SON\Di\Container;
use \SON\Init\Bootstrap;

 
class Contato extends Action
{
    protected $view;    
    public function __construct()
    {
        $this->view = new \stdClass();
    }
 
    /**
     * MÉTODOS DO CONTROLLER CLIENTES
     * */    
 
    // Exibe a relação de clientes (SELECT)
    public function contatoListar()
    {
      
            
    // Renderizando (chama a view: cliente/cliente.phtml). Esta view recebe o array $this->view->clientes. 
    //Ele será o responsável por exibir os dados na view
    $this->render('contato');
    }


    // Salva o formulário de cadastro de clientes (INSERT)
    public function contatoCadastrarSalvar()
    {
         // Diz ao Controller que utilizaremos a Model Cliente
        $contato = Container::getClass("Contato");        
 
        // Array com os campos e valores do BD para realizar o insert.
        // Estes valores foram passados pelo formulário de cadastro, via POST
        $arrayBD = [
        'nome' => $_POST["nome"],
        'email' => $_POST["email"],
        'descricao' => $_POST["descricao"],
        'valor' => $_POST["valor"]
        ];
 
        // Chama o método insert() da classe Table.
        // Basta passar o array ($arrayBD) como parâmetro para que o INSERT aconteça.
        // Note que não foi preciso implementar nada em SQL pois tudo já está pronto.
        $contato = $contato->insert($arrayBD);
 
        // Renderizando e chamando a view que mostrará uma mensagem de confirmação
        $this->render('contato-cadastrar-salvar');
 
    }
 
   
 
}