<?php
 
namespace App\Controllers;
 
use SON\Controller\Action;
use \SON\Di\Container;
use \SON\Init\Bootstrap;
 
class Acesso extends Action
{
    protected $view;    
    public function __construct()
    {
        $this->view = new \stdClass();
    }
 
    /**
     * MÉTODOS DO CONTROLLER ACESSO
     * */    
 
    // Exibe a relação de acessos (SELECT)
    public function acessoListar()
    {
        // Diz ao Controller que utilizaremos a Model Acesso (tabela acesso)        
        $acesso = Container::getClass("Acesso");
     
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
        $ordenarPor = "Id_acesso";
        $ordenacao = "asc LIMIT $inicio, $itens_por_pagina";
        $acessos = $acesso->select($campos, $ordenarPor, $ordenacao); 

        // Envia o array de acessos filtrado conforme pelo $inico e $itens por pagina do select acima para a view; 
        // Na view, faremos um for para exibir todos os dados de acessos deste array
        $this->view->acessos = $acessos;

        //select com todas as linhas da tabela acesso cadastradas no banco
        $campos = "*";
        $ordenarPor = "Id_acesso";
        $ordenacao = "asc";
        $acessos_total = $acesso->select($campos, $ordenarPor, $ordenacao); 
       
        // Envia o array do total de acessos do select acima para a view; 
        // Na view, faremos um for para exibir todos os dados de acessos deste array
        $this->view->acessos_total = $acessos_total;
            
        // Renderizando (chama a view: acesso/acesso.phtml). Esta view recebe o array $this->view->acessos. 
        //Ele será o responsável por exibir os dados na view
        

        $categoria = Container::getClass("Categoria");

        $campos = "*";
        $ordenarPor = "nome";
        $ordenacao = "asc";
        $categorias = $categoria->select($campos, $ordenarPor, $ordenacao);
     
        // Envia o array de categorias do select acima para a view; 
        // Na view, faremos um for para exibir todos os dados de categorias deste array
        $this->view->categorias = $categorias;
        
            
        // Renderizando (chama a view: cate/cate.phtml). Esta view recebe o array $this->view->cates. 
        //Ele será o responsável por exibir os dados na view
     




        $this->render('acesso');
        
    }
 
    // Exibe o formulário de cadastro de acessos
    public function acessoCadastrar()
    {
        /** 
        * Renderizando. 
        * Chama a view acesso/acesso-cadastrar.phtml 
        * Caso não queira utilizar o template e imprimir apenas o content, usar $this->render('acesso-cadastrar', false);
        * Todo o conteúdo desta view (neste caso, o formulário de cadastro) será impresso, no layout, através do código echo $this->content(); que já está definido no arquivo layout.phtml
        */  $categoria = Container::getClass("Categoria");

        $campos = "*";
        $ordenarPor = "nome";
        $ordenacao = "asc";
        $categorias = $categoria->select($campos, $ordenarPor, $ordenacao);
     
        // Envia o array de categorias do select acima para a view; 
        // Na view, faremos um for para exibir todos os dados de categorias deste array
        $this->view->categorias = $categorias;
   
        $this->render('acesso-cadastrar');
    }
 
    // Salva o formulário de cadastro de acessos (INSERT)
    public function acessoCadastrarSalvar()
    {
        // Diz ao Controller que utilizaremos a Model acesso
        $acesso = Container::getClass("Acesso");        
 
        // Array com os campos e valores do BD para realizar o insert.
        // Estes valores foram passados pelo formulário de cadastro, via POST
        $arrayBD = [
        'nivel_usuario' => $_POST["nivel_usuario"],
        'nome_nivel' => $_POST["nome_nivel"]
        ];
 
        // Chama o método insert() da classe Table.
        // Basta passar o array ($arrayBD) como parâmetro para que o INSERT aconteça.
        // Note que não foi preciso implementar nada em SQL pois tudo já está pronto.
        $acessos = $acesso->insert($arrayBD);


        
        
            $this->render('acesso-cadastrar-salvar');
       
    }

    // Mostra menssagem de erro caso houver erro no cadastro de acessos (INSERT)
    public function acessoCadastrarSalvarErro()
    {

        /** 
        * Renderizando. 
        * Chama a view acesso/acesso-cadastrar-salvar-erro-salvar-erro.phtml 
        * Caso não queira utilizar o template e imprimir apenas o content, usar $this->render('acesso-cadastrar-salvar-erro', false);
        * Todo o conteúdo desta view (neste caso, o formulário de cadastro) será impresso, no layout, através do código echo $this->content(); que já está definido no arquivo layout.phtml
        */

        // Renderizando e chamando a view que mostrará uma mensagem de erro
        $this->render('acesso-cadastrar-salvar-erro');

    }
 
    // Exibe o formulário de edição de acesso (SELECT)
    public function acessoEditar()
    {
        // Diz ao Controller que utilizaremos a Model acesso
        $acesso = Container::getClass("Acesso");
 
        /**
         * O método findId() da classe Table retorna um array com todos os dados de um acesso e exige dois parâmetros. 
         * O primeiro parâmetro do método é o nome do campo da tabela onde será feita a consulta (neste caso, campo id).
         * O segundo parâmetro é o valor que será buscado neste campo. Neste caso, o valor do id que foi enviado por parâmetro na URL.
         * O método Bootstrap::getIdByUrl() retorna o valor do parâmetro que foi passado na URL (neste caso, o valor do id). 
         * Exemplo: www.projetointegrador.com.br/acesso-editar-salvar/12 informa que o ID do acesso que estamos fazendo a edição é 12
         * */
 
        $acessos = $acesso->findId("Id_acesso", Bootstrap::getIdByUrl());
 
        // Atribui para a view;
        $this->view->acessos = $acessos;
        $categoria = Container::getClass("Categoria");

        $campos = "*";
        $ordenarPor = "nome";
        $ordenacao = "asc";
        $categorias = $categoria->select($campos, $ordenarPor, $ordenacao);
     
        // Envia o array de categorias do select acima para a view; 
        // Na view, faremos um for para exibir todos os dados de categorias deste array
        $this->view->categorias = $categorias;
  
        // Renderizando
        $this->render('acesso-editar');  
    }
 
    // Salva o formulário de edição de acesso (UPDATE)
    public function acessoEditarSalvar()
    {
        // Diz ao Controller que utilizaremos a Model acesso
        $acesso = Container::getClass("Acesso");        
 
        // Array com os campos e valores do BD para realizar o update.
        // Estes valores foram passados pelo formulário de edição, via POST
        $arrayDados = [
        'nivel_usuario' => $_POST["nivel_usuario"],
        'nome_nivel' => $_POST["nome_nivel"]
        ];       
 
        // O método abaixo retorna o ID passado por parâmetro na URL
        $idUrl = Bootstrap::getIdByUrl();
 
        /**
        * Método público para atualizar os dados na tabela 
        * @param $arrayDados = Array de dados contendo colunas e valores que serão editados.
        * @param $arrayCondicao = Array de dados contendo colunas e valores para condição WHERE - Exemplo array('$id='=>1) 
        * Neste caso, estamos passando apenas a condição de que o id deverá ter o valor passado na URL (e recuperado através de $idUrl = Bootstrap::getIdByUrl() )
        */          
 
        $arrayCondicao = array('Id_acesso='=>$idUrl);
        $acesso->update($arrayDados, $arrayCondicao);        
 
        // Renderizando
        $this->render('acesso-editar-salvar');    
    }
 

    public function acessoDeletarConfirmacao()
    {
        // Apenas exibirá a view de confirmação de exclusão
        $this->render('acesso-deletar-confirmacao');
    }
 
    // Exclui o usuario (DELETE)
    public function acessoDeletarSalvar()
    {
         // Diz ao Controller que utilizaremos a Model Usuario
        $usuario = Container::getClass("Acesso");
 
        // O método abaixo deleterá o ID passado por parâmetro na URL e pelo método Bootstrap::getIdByUrl();
        // O primeiro parâmetro passado: "id" representa o nome do campo na tabela.
        $usuario->delete("Id_acesso", Bootstrap::getIdByUrl());
  
        // Renderizando
        $this->render('acesso-deletar-salvar');
    }

    
}