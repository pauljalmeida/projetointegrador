<?php

namespace App\Controllers;

use SON\Controller\Action;
use \SON\Di\Container;

class Index extends Action
{

    protected $view;

    public function __construct()
    {
        $this->view = new \stdClass();
    }
        
    public function index()
    {

        /**
         * Exemplo de uso de variáveis 
         */

        $this->view->x = 1;
        $nomes = array();
        $nomes[] = "Rafael";
        $nomes[] = "Maria";
        
        // Atribuindo as variáveis para view
        $this->view->nomes = $nomes;
        $this->view->x;
        
        /** 
        * Renderizando. 
        * Chama a view index/index.phtml e passa as variáveis acima para usar nesta view
        * Caso não queira utilizar o template e imprimir apenas o content, usar $this->render('index', false);
        * Todo o conteúdo desta view será impresso, no layout, através do código echo $this->content(); que já está definido no arquivo layout.phtml
        */
        
        $this->render('index');
       
    }
    
}
