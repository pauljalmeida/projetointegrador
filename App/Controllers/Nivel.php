<?php
 
namespace App\Controllers;
 
use SON\Controller\Action;
use \SON\Di\Container;
use \SON\Init\Bootstrap;
 
class Nivel extends Action
{
    protected $view;    
    public function __construct()
    {
        $this->view = new \stdClass();
    }
 
    /**
     * MÉTODOS DO CONTROLLER NIVEL
     * */    
 
    // Exibe a relação de niveis (SELECT)
    public function nivelListar()
    {
        // Diz ao Controller que utilizaremos a Model Nivel (tabela nivel)        
        $nivel = Container::getClass("Nivel");
     
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
        $campos = "Id_nivel, nome";
        $ordenarPor = "Id_nivel";
        $ordenacao = "asc LIMIT $inicio, $itens_por_pagina";
        $niveis = $nivel->select($campos, $ordenarPor, $ordenacao); 

        // Envia o array de niveis filtrado conforme pelo $inico e $itens por pagina do select acima para a view; 
        // Na view, faremos um for para exibir todos os dados de niveis deste array
        $this->view->niveis = $niveis;

        //select com todas as linhas da tabela nivel cadastradas no banco
        $campos = "Id_nivel, nome";
        $ordenarPor = "Id_nivel";
        $ordenacao = "asc";
        $niveis_total = $nivel->select($campos, $ordenarPor, $ordenacao); 
       
        // Envia o array do total de niveis do select acima para a view; 
        // Na view, faremos um for para exibir todos os dados de niveis deste array
        $this->view->niveis_total = $niveis_total;
        
        // Renderizando (chama a view: nivel/nivel.phtml). Esta view recebe o array $this->view->niveis. 
        //Ele será o responsável por exibir os dados na view
        $this->render('nivel');
    }
 
    // Exibe o formulário de cadastro de niveis
    public function nivelCadastrar()
    {
        /** 
        * Renderizando. 
        * Chama a view nivel/nivel-cadastrar.phtml 
        * Caso não queira utilizar o template e imprimir apenas o content, usar $this->render('nivel-cadastrar', false);
        * Todo o conteúdo desta view (neste caso, o formulário de cadastro) será impresso, no layout, através do código echo $this->content(); que já está definido no arquivo layout.phtml
        */
   
        $this->render('nivel-cadastrar');
    }
 
    // Salva o formulário de cadastro de niveis (INSERT)
    public function nivelCadastrarSalvar()
    {
        // Diz ao Controller que utilizaremos a Model Nivel
        $nivel = Container::getClass("Nivel");        
 
        // Array com os campos e valores do BD para realizar o insert.
        // Estes valores foram passados pelo formulário de cadastro, via POST
        $arrayBD = [
        'nome' => $_POST["nome"]
        ];
 
        // Chama o método insert() da classe Table.
        // Basta passar o array ($arrayBD) como parâmetro para que o INSERT aconteça.
        // Note que não foi preciso implementar nada em SQL pois tudo já está pronto.
        $niveis = $nivel->insert($arrayBD);
 
        if ($_SESSION['sucesso'] ==1) {
            // Renderizando e chamando a view que mostrará uma mensagem de confirmação
            $this->render('nivel-cadastrar-salvar');
        }
        else{
            //chamando a funcao para renderizar a view que mostrará uma mensagem de erro
            $this->nivelCadastrarSalvarErro();
        }
 
    }

    // Mostra menssagem de erro caso houver erro no cadastro de niveis (INSERT)
    public function nivelCadastrarSalvarErro()
    {

        /** 
        * Renderizando. 
        * Chama a view nivel/nivel-cadastrar-salvar-erro-salvar-erro.phtml 
        * Caso não queira utilizar o template e imprimir apenas o content, usar $this->render('nivel-cadastrar-salvar-erro', false);
        * Todo o conteúdo desta view (neste caso, o formulário de cadastro) será impresso, no layout, através do código echo $this->content(); que já está definido no arquivo layout.phtml
        */

        // Renderizando e chamando a view que mostrará uma mensagem de erro
        $this->render('nivel-cadastrar-salvar-erro');

    }
 
    // Exibe o formulário de edição de nivel (SELECT)
    public function nivelEditar()
    {
        // Diz ao Controller que utilizaremos a Model nivel
        $nivel = Container::getClass("Nivel");
 
        /**
         * O método findId() da classe Table retorna um array com todos os dados de um nivel e exige dois parâmetros. 
         * O primeiro parâmetro do método é o nome do campo da tabela onde será feita a consulta (neste caso, campo id).
         * O segundo parâmetro é o valor que será buscado neste campo. Neste caso, o valor do id que foi enviado por parâmetro na URL.
         * O método Bootstrap::getIdByUrl() retorna o valor do parâmetro que foi passado na URL (neste caso, o valor do id). 
         * Exemplo: www.projetointegrador.com.br/nivel-editar-salvar/12 informa que o ID do nivel que estamos fazendo a edição é 12
         * */
 
        $niveis = $nivel->findId("Id_nivel", Bootstrap::getIdByUrl());
 
        // Atribui para a view;
        $this->view->niveis = $niveis;
  
        // Renderizando
        $this->render('nivel-editar');  
    }
 
    // Salva o formulário de edição de nivel (UPDATE)
    public function nivelEditarSalvar()
    {
        // Diz ao Controller que utilizaremos a Model nivel
        $nivel = Container::getClass("Nivel");        
 
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
 
        $arrayCondicao = array('Id_nivel='=>$idUrl);
        $nivel->update($arrayDados, $arrayCondicao);        
 
        // Renderizando
        $this->render('nivel-editar-salvar');    
    }
 
    // Solicita confirmação de exclusão de nivel
    public function nivelDeletarConfirmacao()
    {
        // Apenas exibirá a view de confirmação de exclusão
        $this->render('nivel-deletar-confirmacao');
    }
 
    // Exclui o nivel (DELETE)
    public function nivelDeletarSalvar()
    {
         // Diz ao Controller que utilizaremos a Model nivel
        $nivel = Container::getClass("Nivel");
 
        // O método abaixo deleterá o ID passado por parâmetro na URL e pelo método Bootstrap::getIdByUrl();
        // O primeiro parâmetro passado: "id" representa o nome do campo na tabela.
        $nivel->delete("Id_nivel", Bootstrap::getIdByUrl());
  
        // Renderizando
        $this->render('nivel-deletar-salvar');
    }
}