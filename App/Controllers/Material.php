<?php
 
namespace App\Controllers;
 
use SON\Controller\Action;
use \SON\Di\Container;
use \SON\Init\Bootstrap;
use \Sirius\Upload\Handler;
use \Sirius\Upload\HandlerAggregate;
use \Eventviva\ImageResize;
 
class Material extends Action
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
    public function materialListar()
    {
      
    // // Diz ao Controller que utilizaremos a Model Cliente (tabela cliente)        
    // $material = Container::getClass("Material");
 
    // /**
    // * O Método select, da classe Table, retorna um array com o resultado do select, considerando o que foi passado como parâmetro. 
    // * Neste caso, passamos os seguintes parâmetros: 
    // * @param $campos = Informa quais os campos farão parte do select. Também pode ser usado *, para selecionar todos os campos
    // * @param $ordenarPor = Informa por campo será feita a ordenação e
    // * @param $ordenacao = Informa qual a ordem: ASC ou DESC
    // * Opcional: você ainda pode informar um quarto parâmetro, quando necessário.
    // * Ex.: $condicoes = "WHERE id > 20";
    // * Neste caso, bastaria adicionar o parâmetro $condicoes após $ordenacao
    // */
 
    // $campos = "*";
    // $ordenarPor = "id_categoria";
    // $ordenacao = "asc";
    // $materiais = $material->select($campos, $ordenarPor, $ordenacao);


// Diz ao Controller que utilizaremos a Model Cliente (tabela cliente)        
    $material = Container::getClass("MaterialCategoria");
 
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
 

    $fields = "p.id, p.descricao, p.nome_produto, p.imagem, c.nome";
    $conditions = "INNER JOIN categoria AS c ON p.id_categoria = c.id_categoria";

    $materiais = $material->select($fields, "c.nome", "asc", $conditions);
    


    

    
    

 
    // Envia o array de clientes do select acima para a view; 
    // Na view, faremos um for para exibir todos os dados de clientes deste array
    $this->view->materiais = $materiais;

        
    // Renderizando (chama a view: cliente/cliente.phtml). Esta view recebe o array $this->view->clientes. 
    //Ele será o responsável por exibir os dados na view
    $this->render('material');
    }
 
    // Exibe o formulário de cadastro de clientes
    public function materialCadastrar()
    {
        /** 
        * Renderizando. 
        * Chama a view cliente/cliente-cadastrar.phtml 
        * Caso não queira utilizar o template e imprimir apenas o content, usar $this->render('cliente-cadastrar', false);
        * Todo o conteúdo desta view (neste caso, o formulário de cadastro) será impresso, no layout, através do código echo $this->content(); que já está definido no arquivo layout.phtml
        */

         // Diz ao Controller que utilizaremos a Model Categoria  
        $categoria = Container::getClass("Categoria");
        $categorias = $categoria->select("*", "nome", "asc");

        $this->view->categorias = $categorias;
   
        $this->render('material-cadastrar');
 
    }
 
    // Salva o formulário de cadastro de clientes (INSERT)
    public function materialCadastrarSalvar()
    {
         // Diz ao Controller que utilizaremos a Model Cliente
        $material = Container::getClass("Material");       
 
         // Verifica se o arquivo foi enviado pelo formulário e chama a biblioteca para upload
         if (!empty($_FILES['imagem']['name'])) {
           
             // Instancia a classe Handler
             $destination = realpath('imagens');
             $fileHandler = new Handler($destination);
             $fileHandler->addRule('extension', array('allowed' => array('jpg', 'bmp', 'gif','jfif', 'png')), '{label} precisa ser alguma destas (jpg, bmp, gif e png)', 'A extensão do arquivo');
             $upload = new HandlerAggregate();
             $upload->addHandler('imagem', $fileHandler);
             $result = false;
             if ($_FILES) {
                 $result = $upload->process($_FILES);
                 $result->confirm();
 
                 foreach ($result as $key => $file) {
                     if ($file->isValid()) {
                         // Envia para a view a mensagem de confirmação de upload com o nome do arquivo.
                         $this->view->erro = false;
                         $this->view->mensagem = "Sucesso! O upload foi efetuado com sucesso: ".$file->name;
                         
                         // Instancia a biblioteca eventviva, para redimensionamento automático das imagens
                         // Redimensiona o banner
                         $image = new ImageResize("imagens/".$file->name);
                         $image->crop(800, 800, ImageResize::CROPCENTER);
                         $image->save("imagens/".$file->name);
 
                         // Cria e redimensiona o thumb
                         $image = new ImageResize("imagens/".$file->name);
                         $image->resizeToWidth(150);
                         $image->save("imagens/thumbs/".$file->name);
                         
                                        // Array com os campos e valores do BD para realizar o insert do arquivo no banco de dados, caso o upload tenha funcionado corretamente.
                
                                        // Array com os campos e valores do BD para realizar o insert.
                        // Estes valores foram passados pelo formulário de cadastro, via POST
                            $arrayBD = [
                            'nome_produto' => $_POST["nome"],
                            'descricao' => $_POST["descricao"],
                            'id_categoria' => $_POST["categoria"],
                            'imagem' => $file->name,
                            ];
                    
                    
                            // Chama o método insert() da classe Table.
                            // Basta passar o array ($arrayBD) como parâmetro para que o INSERT aconteça.
                            // Note que não foi preciso implementar nada em SQL pois tudo já está pronto.
                            $materiais = $material->insert($arrayBD);
                     } else {
                         // Envia para a view a mensagem de erro de upload com a mensagem específica
                         $this->view->erro = true;
                         $this->view->mensagem = "Erro! O seguinte erro ocorreu:<br/>";
                         $this->view->mensagem .= implode('<br>', $file->getMessages()); 
                     }
                 }
             }
 
         // Caso não tenha sido enviado arquivo, será gravada a URL
         } 
 
 
        // Renderizando e chamando a view que mostrará uma mensagem de confirmação
        $this->render('material-cadastrar-salvar');
 
    }
 
    // Exibe o formulário de edição de cliente (SELECT)
    public function materialEditar()
    {
  // Diz ao Controller que utilizaremos a Model Cliente
        $material = Container::getClass("Material");
 
        /**
         * O método findId() da classe Table retorna um array com todos os dados de um cliente e exige dois parâmetros. 
         * O primeiro parâmetro do método é o nome do campo da tabela onde será feita a consulta (neste caso, campo id).
         * O segundo parâmetro é o valor que será buscado neste campo. Neste caso, o valor do id que foi enviado por parâmetro na URL.
         * O método Bootstrap::getIdByUrl() retorna o valor do parâmetro que foi passado na URL (neste caso, o valor do id). 
         * Exemplo: www.projetointegrador.com.br/cliente-editar-salvar/12 informa que o ID do cliente que estamos fazendo a edição é 12
         * */
 
        $materiais = $material->findId("id", Bootstrap::getIdByUrl());
 
        // Atribui para a view;
        $this->view->material = $materiais;

        // Diz ao Controller que utilizaremos a Model Categoria  
        $categoria = Container::getClass("Categoria");
        $categorias = $categoria->select("*", "nome", "asc");

        $this->view->categorias = $categorias;


  
        // Renderizando
        $this->render('material-editar');
    }
 
    // Salva o formulário de edição de cliente (UPDATE)
    public function materialEditarSalvar()
    {
         // Instancia a classe Handler
         $destination = realpath('imagens');
         $fileHandler = new Handler($destination);
         $fileHandler->addRule('extension', array('allowed' => array('jpg', 'bmp', 'gif','jfif', 'png')), '{label} precisa ser alguma destas (jpg, bmp, gif e png)', 'A extensão do arquivo');
         $upload = new HandlerAggregate();
         $upload->addHandler('imagem', $fileHandler);
         $result = false;
         if ($_FILES) {
             $result = $upload->process($_FILES);
             $result->confirm();

             foreach ($result as $key => $file) {
                 if ($file->isValid()) {
                     // Envia para a view a mensagem de confirmação de upload com o nome do arquivo.
                     $this->view->erro = false;
                     $this->view->mensagem = "Sucesso! O upload foi efetuado com sucesso: ".$file->name;
                     
                     // Instancia a biblioteca eventviva, para redimensionamento automático das imagens
                     // Redimensiona o banner
                     $image = new ImageResize("imagens/".$file->name);
                     $image->crop(800, 800, ImageResize::CROPCENTER);
                     $image->save("imagens/".$file->name);

                     // Cria e redimensiona o thumb
                     $image = new ImageResize("imagens/".$file->name);
                     $image->resizeToWidth(150);
                     $image->save("imagens/thumbs/".$file->name);
                     
                                    // Array com os campos e valores do BD para realizar o insert do arquivo no banco de dados, caso o upload tenha funcionado corretamente.
            
                                    // Array com os campos e valores do BD para realizar o insert.
                    // Diz ao Controller que utilizaremos a Model Cliente
                    $material = Container::getClass("Material");        
            
                    // Array com os campos e valores do BD para realizar o update.
                    // Estes valores foram passados pelo formulário de edição, via POST
                    $arrayDados = [
                    'nome_produto' => $_POST["nome_produto"],
                    'descricao' => $_POST["descricao"],
                    'id_categoria' => $_POST["categoria"],
                    'imagem' => $file->name
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
                    $material->update($arrayDados, $arrayCondicao);  
                 } else {
                     // Envia para a view a mensagem de erro de upload com a mensagem específica
                     $this->view->erro = true;
                     $this->view->mensagem = "Erro! O seguinte erro ocorreu:<br/>";
                     $this->view->mensagem .= implode('<br>', $file->getMessages()); 
                 }
             }
         }
        
              
 
        // Renderizando
        $this->render('material-editar-salvar');
    }
 
    // Solicita confirmação de exclusão de cliente
    public function materialDeletarConfirmacao()
    {
   // Apenas exibirá a view de confirmação de exclusão
        $this->render('material-deletar-confirmacao');
    }
 
    // Exclui o cliente (DELETE)
    public function materialDeletarSalvar()
    {
 // Diz ao Controller que utilizaremos a Model Cliente
        $material = Container::getClass("Material");
 
        // O método abaixo deleterá o ID passado por parâmetro na URL e pelo método Bootstrap::getIdByUrl();
        // O primeiro parâmetro passado: "id" representa o nome do campo na tabela.
        $material->delete("id", Bootstrap::getIdByUrl());
  
        // Renderizando
        $this->render('material-deletar-salvar');
    }
    // Salva o formulário de cadastro de clientes (INSERT)


 
}