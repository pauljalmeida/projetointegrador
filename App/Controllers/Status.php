<?php
 
namespace App\Controllers;
 
use SON\Controller\Action;
use \SON\Di\Container;
use \SON\Init\Bootstrap;
 
class Status extends Action
{
    protected $view;    
    public function __construct()
    {
        $this->view = new \stdClass();
    }
 
    /**
     * MÉTODOS DO CONTROLLER STATUS
     * */    
 
    // Exibe a relação de status (SELECT)
    public function statusListar()
    {
        // Diz ao Controller que utilizaremos a Model Status (tabela status)        
        $status = Container::getClass("Status");
     
        /**
        * O Método select, da status Table, retorna um array com o resultado do select, considerando o que foi passado como parâmetro. 
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
        $campos = "id_status, nome";
        $ordenarPor = "id_status";
        $ordenacao = "asc LIMIT $inicio, $itens_por_pagina";
        $statuss = $status->select($campos, $ordenarPor, $ordenacao); 

        // Envia o array de statuss filtrado conforme pelo $inico e $itens por pagina do select acima para a view; 
        // Na view, faremos um for para exibir todos os dados de statuss deste array
        $this->view->statuss = $statuss;

        //select com todas as linhas da tabela status cadastradas no banco
        $campos = "id_status, nome";
        $ordenarPor = "id_status";
        $ordenacao = "asc";
        $statuss_total = $status->select($campos, $ordenarPor, $ordenacao); 
       
        // Envia o array do total de statuss do select acima para a view; 
        // Na view, faremos um for para exibir todos os dados de statuss deste array
        $this->view->statuss_total = $statuss_total;
            
        // Renderizando (chama a view: status/status.phtml). Esta view recebe o array $this->view->statuss. 
        //Ele será o responsável por exibir os dados na view
        $this->render('status');
    }
 
    // Exibe o formulário de cadastro de statuss
    public function statusCadastrar()
    {
        /** 
        * Renderizando. 
        * Chama a view status/status-cadastrar.phtml 
        * Caso não queira utilizar o template e imprimir apenas o content, usar $this->render('status-cadastrar', false);
        * Todo o conteúdo desta view (neste caso, o formulário de cadastro) será impresso, no layout, através do código echo $this->content(); que já está definido no arquivo layout.phtml
        */
   
        $this->render('status-cadastrar');
    }
 
    // Salva o formulário de cadastro de statuss (INSERT)
    public function statusCadastrarSalvar()
    {
        // Diz ao Controller que utilizaremos a Model Status
        $status = Container::getClass("Status");        
 
        // Array com os campos e valores do BD para realizar o insert.
        // Estes valores foram passados pelo formulário de cadastro, via POST
        $arrayBD = [
        'nome' => $_POST["nome"]
        ];
 
        // Chama o método insert() da status Table.
        // Basta passar o array ($arrayBD) como parâmetro para que o INSERT aconteça.
        // Note que não foi preciso implementar nada em SQL pois tudo já está pronto.
        $statuss = $status->insert($arrayBD);
 
        if ($_SESSION['sucesso'] ==1) {
            // Renderizando e chamando a view que mostrará uma mensagem de confirmação
            $this->render('status-cadastrar-salvar');
        }
        else{
            //chamando a funcao para renderizar a view que mostrará uma mensagem de erro
            $this->statusCadastrarSalvarErro();
        }
 
    }

    // Mostra menssagem de erro caso houver erro no cadastro de statuss (INSERT)
    public function statusCadastrarSalvarErro()
    {

        /** 
        * Renderizando. 
        * Chama a view status/status-cadastrar-salvar-erro-salvar-erro.phtml 
        * Caso não queira utilizar o template e imprimir apenas o content, usar $this->render('status-cadastrar-salvar-erro', false);
        * Todo o conteúdo desta view (neste caso, o formulário de cadastro) será impresso, no layout, através do código echo $this->content(); que já está definido no arquivo layout.phtml
        */

        // Renderizando e chamando a view que mostrará uma mensagem de erro
        $this->render('status-cadastrar-salvar-erro');

    }
 
    // Exibe o formulário de edição de status (SELECT)
    public function statusEditar()
    {
        // Diz ao Controller que utilizaremos a Model Status
        $status = Container::getClass("Status");
 
        /**
         * O método findId() da status Table retorna um array com todos os dados de um entidade e exige dois parâmetros. 
         * O primeiro parâmetro do método é o nome do campo da tabela onde será feita a consulta (neste caso, campo id).
         * O segundo parâmetro é o valor que será buscado neste campo. Neste caso, o valor do id que foi enviado por parâmetro na URL.
         * O método Bootstrap::getIdByUrl() retorna o valor do parâmetro que foi passado na URL (neste caso, o valor do id). 
         * Exemplo: www.projetointegrador.com.br/entidade-editar-salvar/12 informa que o ID do entidade que estamos fazendo a edição é 12
         * */
 
        $statuss = $status->findId("id_status", Bootstrap::getIdByUrl());
 
        // Atribui para a view;
        $this->view->statuss = $statuss;
  
        // Renderizando
        $this->render('status-editar');  
    }
 
    // Salva o formulário de edição de status (UPDATE)
    public function statusEditarSalvar()
    {
        // Diz ao Controller que utilizaremos a Model Status
        $status = Container::getClass("Status");        
 
        // Array com os campos e valores do BD para realizar o update.
        // Estes valores foram passados pelo formulário de edição, via POST
        $arrayDados = [
        'nome' => $_POST["nome"]
        ];       
 
        // O método abaixo retorna o ID passado por parâmetro na URL
        $idUrl = Bootstrap::getIdByUrl();
 
        /**
        * Método público para atualizar os dados na tabela 
        * @param $arrayDados = Array de dados contendo colunas e valores que serão editados.
        * @param $arrayCondicao = Array de dados contendo colunas e valores para condição WHERE - Exemplo array('$id='=>1) 
        * Neste caso, estamos passando apenas a condição de que o id deverá ter o valor passado na URL (e recuperado através de $idUrl = Bootstrap::getIdByUrl() )
        */          
 
        $arrayCondicao = array('id_status='=>$idUrl);
        $status->update($arrayDados, $arrayCondicao);        
 
        // Renderizando
        $this->render('status-editar-salvar');    
    }
 
    // Solicita confirmação de exclusão de status
    public function statusDeletarConfirmacao()
    {
        // Apenas exibirá a view de confirmação de exclusão
        $this->render('status-deletar-confirmacao');
    }
 
    // Exclui o status (DELETE)
    public function statusDeletarSalvar()
    {
         // Diz ao Controller que utilizaremos a Model Status
        $status = Container::getClass("Status");
 
        // O método abaixo deleterá o ID passado por parâmetro na URL e pelo método Bootstrap::getIdByUrl();
        // O primeiro parâmetro passado: "id" representa o nome do campo na tabela.
        $status->delete("id_status", Bootstrap::getIdByUrl());
  
        // Renderizando
        $this->render('status-deletar-salvar');
    }
}