<?php 
include('PHPMailer/PHPMailerAutoload.php');


$Mailer = new PHPMailer();
//Define que usaremos SMTP
$Mailer->IsSMTP();

//Envia Email em HTML
$Mailer->isHTML(true);

//Aceitar caracteres especiais
$Mailer->charset = 'UTF-8';

//Configurações SMTP
$Mailer->SMTPAuth = true;
$Mailer->SMTPSecure = 'tsl';

//Definir nome do Servidor
$Mailer->Host = 'smtp-mail.outlook.com';

//Definir Porta de Saida utilizada para enviar os emails pelo servidor
$Mailer->Port = 587; //Outlook.com

//Definir Dados do Usuario e Senha utilizado para enviar os emails pelo servidor
$Mailer->Username = 'pauljalmeida@hotmail.com'; //Outlook.com
$Mailer->Password = 'Heitor2703'; //Outlook.com

//Email do Remetente
$Mailer->From = 'pauljalmeida@hotmail.com';//Outlook.com

//Nome do Remetente
$Mailer->FromName = 'Remetente';

//Assunto da mensagem
$Mailer->Subject = 'Testando Mailer do Email';

//Conteudo da Mensagem
$Mailer->Body = 'Conteudo_do_Email';

//Corpo da Mensagem Modo de Texto
$Mailer->AltBody = 'Conteudo_do_Email_em_texto';

//Destinatario
$Mailer->AddAddress('pauljalmeida@gmail.com');

 if($Mailer->Send()){
  echo "Email Enviado com Sucesso";
 }else{
  echo "ERRO ao tentar Enviar " . $Mailer->ErrorInfo;
 }

?>
 

