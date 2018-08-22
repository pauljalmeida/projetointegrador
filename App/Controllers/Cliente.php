<?php
 
namespace App\Controllers;
 
use SON\Controller\Action;
use \SON\Di\Container;
use \SON\Init\Bootstrap;
 
class Cliente extends Action
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
    public function clienteListar()
    {
      
    // Diz ao Controller que utilizaremos a Model Cliente (tabela cliente)        
    $cliente = Container::getClass("Cliente");
 
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
 
    $campos = "id, nome, email, descricao";
    $ordenarPor = "nome";
    $ordenacao = "asc";
    $clientes = $cliente->select($campos, $ordenarPor, $ordenacao);
 
    // Envia o array de clientes do select acima para a view; 
    // Na view, faremos um for para exibir todos os dados de clientes deste array
    $this->view->clientes = $clientes;
        
    // Renderizando (chama a view: cliente/cliente.phtml). Esta view recebe o array $this->view->clientes. 
    //Ele será o responsável por exibir os dados na view
    $this->render('cliente');
    }
 
    // Exibe o formulário de cadastro de clientes
    public function clienteCadastrar()
    {
        /** 
        * Renderizando. 
        * Chama a view cliente/cliente-cadastrar.phtml 
        * Caso não queira utilizar o template e imprimir apenas o content, usar $this->render('cliente-cadastrar', false);
        * Todo o conteúdo desta view (neste caso, o formulário de cadastro) será impresso, no layout, através do código echo $this->content(); que já está definido no arquivo layout.phtml
        */
   
        $this->render('cliente-cadastrar');
 
    }
 
    // Salva o formulário de cadastro de clientes (INSERT)
    public function clienteCadastrarSalvar()
    {
         // Diz ao Controller que utilizaremos a Model Cliente
        $cliente = Container::getClass("Cliente");        
 
        // Array com os campos e valores do BD para realizar o insert.
        // Estes valores foram passados pelo formulário de cadastro, via POST
        $arrayBD = [
        'nome' => $_POST["nome"],
        'email' => $_POST["email"],
        'descricao' => $_POST["descricao"]
        ];
 
        // Chama o método insert() da classe Table.
        // Basta passar o array ($arrayBD) como parâmetro para que o INSERT aconteça.
        // Note que não foi preciso implementar nada em SQL pois tudo já está pronto.
        $clientes = $cliente->insert($arrayBD);
 
        // Renderizando e chamando a view que mostrará uma mensagem de confirmação
        $this->render('cliente-cadastrar-salvar');
 
    }
 
    // Exibe o formulário de edição de cliente (SELECT)
    public function clienteEditar()
    {
  // Diz ao Controller que utilizaremos a Model Cliente
        $cliente = Container::getClass("Cliente");
 
        /**
         * O método findId() da classe Table retorna um array com todos os dados de um cliente e exige dois parâmetros. 
         * O primeiro parâmetro do método é o nome do campo da tabela onde será feita a consulta (neste caso, campo id).
         * O segundo parâmetro é o valor que será buscado neste campo. Neste caso, o valor do id que foi enviado por parâmetro na URL.
         * O método Bootstrap::getIdByUrl() retorna o valor do parâmetro que foi passado na URL (neste caso, o valor do id). 
         * Exemplo: www.projetointegrador.com.br/cliente-editar-salvar/12 informa que o ID do cliente que estamos fazendo a edição é 12
         * */
 
        $clientes = $cliente->findId("id", Bootstrap::getIdByUrl());
 
        // Atribui para a view;
        $this->view->clientes = $clientes;
  
        // Renderizando
        $this->render('cliente-editar');
    }
 
    // Salva o formulário de edição de cliente (UPDATE)
    public function clienteEditarSalvar()
    {
  // Diz ao Controller que utilizaremos a Model Cliente
        $cliente = Container::getClass("Cliente");        
 
        // Array com os campos e valores do BD para realizar o update.
        // Estes valores foram passados pelo formulário de edição, via POST
        $arrayDados = [
        'nome' => $_POST["nome"],
        'email' => $_POST["email"],
        'descricao' => $_POST["descricao"]
        ];        
 
        // O método abaixo retorna o ID passado por parâmetro na URL
        $idUrl = Bootstrap::getIdByUrl();
 
        /**
        * Método público para atualizar os dados na tabela 
        * @param $arrayDados = Array de dados contendo colunas e valores que serão editados.
        * @param $arrayCondicao = Array de dados contendo colunas e valores para condição WHERE - Exemplo array('$id='=>1) 
        * Neste caso, estamos passando apenas a condição de que o id deverá ter o valor passado na URL (e recuperado através de $idUrl = Bootstrap::getIdByUrl() )
        */          
 
        $arrayCondicao = array('id='=>$idUrl);
        $cliente->update($arrayDados, $arrayCondicao);        
 
        // Renderizando
        $this->render('cliente-editar-salvar');
    }
 
    // Solicita confirmação de exclusão de cliente
    public function clienteDeletarConfirmacao()
    {
   // Apenas exibirá a view de confirmação de exclusão
        $this->render('cliente-deletar-confirmacao');
    }
 
    // Exclui o cliente (DELETE)
    public function clienteDeletarSalvar()
    {
 // Diz ao Controller que utilizaremos a Model Cliente
        $cliente = Container::getClass("Cliente");
 
        // O método abaixo deleterá o ID passado por parâmetro na URL e pelo método Bootstrap::getIdByUrl();
        // O primeiro parâmetro passado: "id" representa o nome do campo na tabela.
        $cliente->delete("id", Bootstrap::getIdByUrl());
  
        // Renderizando
        $this->render('cliente-deletar-salvar');
    }
    // Salva o formulário de cadastro de clientes (INSERT)


 
}