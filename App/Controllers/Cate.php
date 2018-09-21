<?php
 
namespace App\Controllers;
 
use SON\Controller\Action;
use \SON\Di\Container;
use \SON\Init\Bootstrap;
 
class Cate extends Action
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
    public function cateListar()
    {
      
    // Diz ao Controller que utilizaremos a Model cate (tabela cate)        
    $cate = Container::getClass("Cate");
 
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
 
    $campos = "*";
    $ordenarPor = "nome";
    $ordenacao = "asc";
    $cates = $cate->select($campos, $ordenarPor, $ordenacao);
 
    // Envia o array de clientes do select acima para a view; 
    // Na view, faremos um for para exibir todos os dados de clientes deste array
    // Diz ao Controller que utilizaremos a Model Cliente (tabela cliente)        
    $categoria = Container::getClass("Categoria");

    $campos = "*";
    $ordenarPor = "nome";
    $ordenacao = "asc";
    $categorias = $categoria->select($campos, $ordenarPor, $ordenacao);
 
    // Envia o array de categorias do select acima para a view; 
    // Na view, faremos um for para exibir todos os dados de categorias deste array
    $this->view->categorias = $categorias;
    $this->view->cates = $cates;
        
    // Renderizando (chama a view: cate/cate.phtml). Esta view recebe o array $this->view->cates. 
    //Ele será o responsável por exibir os dados na view
    $this->render('cate');
    }
 
    // Exibe o formulário de cadastro de cates
    public function cateCadastrar()
    {
        /** 
        * Renderizando. 
        * Chama a view cate/cate-cadastrar.phtml 
        * Caso não queira utilizar o template e imprimir apenas o content, usar $this->render('cate-cadastrar', false);
        * Todo o conteúdo desta view (neste caso, o formulário de cadastro) será impresso, no layout, através do código echo $this->content(); que já está definido no arquivo layout.phtml
        */
   
// Diz ao Controller que utilizaremos a Model Cliente (tabela cliente)        
$categoria = Container::getClass("Categoria");

$campos = "*";
$ordenarPor = "nome";
$ordenacao = "asc";
$categorias = $categoria->select($campos, $ordenarPor, $ordenacao);

// Envia o array de categorias do select acima para a view; 
// Na view, faremos um for para exibir todos os dados de categorias deste array
$this->view->categorias = $categorias;

        $this->render('cate-cadastrar');
 
    }
 
    // Salva o formulário de cadastro de cates (INSERT)
    public function cateCadastrarSalvar()
    {
         // Diz ao Controller que utilizaremos a Model cate
        $cate = Container::getClass("Cate");        
 
        // Array com os campos e valores do BD para realizar o insert.
        // Estes valores foram passados pelo formulário de cadastro, via POST
        $arrayBD = [
        'nome' => $_POST["nome"]
        ];
 
        // Chama o método insert() da classe Table.
        // Basta passar o array ($arrayBD) como parâmetro para que o INSERT aconteça.
        // Note que não foi preciso implementar nada em SQL pois tudo já está pronto.
        $cates = $cate->insert($arrayBD);
 
        // Renderizando e chamando a view que mostrará uma mensagem de confirmação
        $this->render('cate-cadastrar-salvar');
 
    }
 
    // Exibe o formulário de edição de cate (SELECT)
    public function cateEditar()
    {
  // Diz ao Controller que utilizaremos a Model cate
        $cate = Container::getClass("Cate");
 
        /**
         * O método findId() da classe Table retorna um array com todos os dados de um cliente e exige dois parâmetros. 
         * O primeiro parâmetro do método é o nome do campo da tabela onde será feita a consulta (neste caso, campo id).
         * O segundo parâmetro é o valor que será buscado neste campo. Neste caso, o valor do id que foi enviado por parâmetro na URL.
         * O método Bootstrap::getIdByUrl() retorna o valor do parâmetro que foi passado na URL (neste caso, o valor do id). 
         * Exemplo: www.projetointegrador.com.br/cliente-editar-salvar/12 informa que o ID do cliente que estamos fazendo a edição é 12
         * */
 
        $cates = $cate->findId("id_categoria", Bootstrap::getIdByUrl());
        
 
        // Atribui para a view;
        $this->view->cates = $cates;
  
        // Renderizando
        $this->render('cate-editar');
    }
 
    // Salva o formulário de edição de cate (UPDATE)
    public function cateEditarSalvar()
    {
  // Diz ao Controller que utilizaremos a Model cate
        $cate = Container::getClass("Cate");        
 
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
 
        $arrayCondicao = array('id_categoria='=>$idUrl);
        $cate->update($arrayDados, $arrayCondicao);        
 
        // Renderizando
        $this->render('cate-editar-salvar');
    }
 
    // Solicita confirmação de exclusão de cate
    public function cateDeletarConfirmacao()
    {
   // Apenas exibirá a view de confirmação de exclusão
        $this->render('cate-deletar-confirmacao');
    }
 
    // Exclui o cate (DELETE)
    public function cateDeletarSalvar()
    {
 // Diz ao Controller que utilizaremos a Model cate
        $cate = Container::getClass("Cate");

        
 
        // O método abaixo deleterá o ID passado por parâmetro na URL e pelo método Bootstrap::getIdByUrl();
        // O primeiro parâmetro passado: "id" representa o nome do campo na tabela.
        $cate->delete("id_categoria", Bootstrap::getIdByUrl());
  
        // Renderizando
        $this->render('cate-deletar-salvar');
    }
    // Salva o formulário de cadastro de clientes (INSERT)


 
}