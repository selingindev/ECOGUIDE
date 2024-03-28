<?php
session_start(); //Iniciando a sessão

ob_start(); //Limpa o buffer de saída

//Importar as classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//incluir o arquivo config
include_once "./config.php";

//Incluir o arquivo com a conexão com o banco de dados
include_once "./conexao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ecoguide</title>
        <link rel="icon" type="imagem/png" href="img/icon.png">
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <link rel="stylesheet" type="text/css" href="style/recuperacaosenha.css"> 
    </head>
    <body>

        <?php
            //Receber os dados de todos os campos
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            //Acessar o IF quando o usuário clicar no botão recuperar do formulário
            if(!empty($dados['SendRecuperarSenha'])){
                //var_dump($dados);

                //QUERY para recuperar os dados do usuário do banco de dados
                $query_usuario = "SELECT id, nome, sobrenome, email 
                            FROM usuarios
                            WHERE email =:email
                            LIMIT 1";

                //Preparar a QUERY
                $result_usuario = $conn->prepare($query_usuario);

                //Substitui o link da query pelo valor que vem do formulário
                $result_usuario->bindParam(':email', $dados['email']);

                //Executar a QUERY
                $result_usuario->execute();

                //Acessar o IF quando encontrar usuário no Banco de Dados
                if(($result_usuario) and ($result_usuario->rowCount() != 0)){
                    //Ler os registros retornados do banco de dados
                    $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
                    //var_dump($row_usuario);

                    //Gerar a chave para recuperar a senha
                    $chave_recuperar_senha = password_hash($row_usuario['id'] . $row_usuario['email'], PASSWORD_DEFAULT);
                    //var_dump($chave_recuperar_senha);

                    //Editar o usuário e salvar a chave recuperar senha
                    $query_up_usuario = "UPDATE usuarios
                                SET chave_recuperar_senha =:chave_recuperar_senha
                                WHERE id =:id
                                LIMIT 1";

                    //Preparar a QUERY
                    $editar_usuario = $conn->prepare($query_up_usuario);

                    //Substitui o link da query pelo valor que vem do formulário
                    $editar_usuario->bindParam(':chave_recuperar_senha', $chave_recuperar_senha);
                    $editar_usuario->bindParam(':id', $row_usuario['id']);

                    //Executar a QUERY
                    if($editar_usuario->execute()){

                        //Gerar o link de recuperar senha
                        $link = "http://localhost/Ecoguide/atualizarSenha.php?chave=$chave_recuperar_senha";
                        //var_dump($link);

                    //Incluindo o Composer
                    require './lib/vendor/autoload.php';

                    //Criar objeto e instanciar a classe do PHPMailer
                    $mail = new PHPMailer(true);

                    // Verificar se envia o e-mail corretamente com try catch
                    try {

                        // Imprimir os erro com debug
                        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;

                        // Permitir o envio do e-mail com caracteres especiais
                        $mail->CharSet = 'UTF-8';

                        // Definir para usar SMTP
                        $mail->isSMTP();         
    
                        // Servidor de envio de e-mail
                        $mail->Host       = HOSTEMAIL; 

                        // Indicar que é necessário autenticar
                        $mail->SMTPAuth   = true;     

                        // Usuário/e-mail para enviar o e-mail                              
                        $mail->Username   = USEREMAIL; 

                        // Senha do e-mail utilizado para enviar e-mail                  
                        $mail->Password   = PASSEMAIL;      

                        // Ativar criptografia                         
                        $mail->SMTPSecure = SMTPSECURE;  

                        // Porta para enviar e-mail          
                        $mail->Port       = PORTEMAIL;

                        // E-mail do rementente
                        $mail->setFrom(REMETENTE, NOMEREMETENTE);

                        // E-mail de destino
                        $mail->addAddress($row_usuario['email'], $row_usuario['nome']);

                        // Definir formato de e-mail para HTML
                        $mail->isHTML(true);  

                        // Título do e-mail
                        $mail->Subject = 'Recuperar senha';

                        // Conteúdo do e-mail em formato HTML
                        $mail->Body    = "Olá, " . $row_usuario['nome'] . ". <br><br>Percebemos que você esqueceu sua senha de acesso à nossa plataforma e estamos aqui para ajudar. <br><br>
                        Para continuar o processo de recuperação da sua senha, clique no link abaixo ou copie e cole o endereço no seu navegador: <br><br><a href='" . $link . "'>" . $link . "</a>
                        <br><br>Caso não tenha solicitado essa alteração, ignore este email. Sua senha permanecerá a mesma até que você ative este código.<br>";

                        // Conteúdo do e-mail em formato texto
                        $mail->AltBody = "Olá, " . $row_usuario['nome'] . ". \n\nPercebemos que você esqueceu sua senha de acesso à nossa plataforma e estamos aqui para ajudar.\n\n
                        Para continuar o processo de recuperação da sua senha, clique no link abaixo ou copie e cole o endereço no seu navegador: \n\n" . $link . "
                        \n\nCaso não tenha solicitado essa alteração, ignore este email. Sua senha permanecerá a mesma até que você ative este código.\n";

                        // Enviar e-mail
                        $mail->send();

                        //Criar variável global com a mensagem de sucesso
                        $_SESSION['msg'] = "<p style='color: green;'>Enviado e-mail com as instruções para recuperar a senha. Acesse a sua caixa de email para recuperar sua senha!</p>";

                        // Redirecionar o usuário
                        header('Location: index.php');

                        //Pausar o procedimento
                        exit();

                    } catch (Exception $e) { // Acessa o catch quando não é enviado e-mail corretamente
                        //echo "E-mail não enviado com sucesso. Erro: {$mail->ErrorInfo}";
                        $_SESSION['msg'] = "<p style='color: #f00;'>Erro: E-mail não enviado com sucesso!</p>";
                    }

                    }else{
                        $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Tente novamente!</p>";
                    }

                }else{
                    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Email não encontrado. Verifique se não existem erros de digitação ou tente um email diferente.</p>";
                }
            }

            //Imprimir a mensagem da sessão
            if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
        ?>

        <!--Início do formulário de recuperação de senha-->
        <div class="box-principal">
            <section class="conteudo-principal">              
                <img class="conteudo-logo" src="img/logo.png">           
                <form method="POST" action="">
                    <p class="titulo-acesso"> Recupere a sua senha  </p>
                    <label class="label-acesso"> Insira o email cadastrado  </label>
                    <input type="email" name="email" placeholder="email" required>
                    <input class="button-acesso" type="submit" name="SendRecuperarSenha" value="recuperar">
                    <p class="redirecionamento"><a href="index.php">Lembrou a senha? Faça o seu login!</a></p>
                </form>                   
            </section>
        </div>
        <!--Fim do formulário de recuperação de senha--> 
    </body>
    <footer>
            <p class="copy"> &copy; 2023 Ecoguide. Todos os direitos reservados.</p>
    </footer>
</html>