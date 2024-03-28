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
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ecoguide</title>
        <link rel="icon" type="imagem/png" href="img/icon.png">
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <link rel="stylesheet" type="text/css" href="style/acesso.css"> 
    </head>

    <body>

    <?php

        //Exemplo criptografar senha
        //echo password_hash(123456, PASSWORD_DEFAULT);

        //Receber os dados do formulário
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        //Acessar o IF quando o usuário clicar no botão "login" do formulário
        if(!empty($dados['SendLogin'])){
            //var_dump($dados);

            //Recuperar os dados do usuário no banco de dados
            $query_usuario = "SELECT id, nome, sobrenome, email, senha_usuario 
                                FROM usuarios 
                                WHERE email =:email 
                                LIMIT 1";

            //Preparar Query
           $result_usuario = $conn->prepare($query_usuario);

           //Substituir o link da Query pelo valor que vem do formulário
           $result_usuario->bindParam(':email', $dados['email']);

           //Executar a Query
           $result_usuario->execute();

           //Acessar o IF quando encontrar o usuário no banco de dados
           if(($result_usuario) and ($result_usuario->rowCount() != 0)){

            //Ler os registros retornados do banco de dados
            $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
            //var_dump($row_usuario);

            //Acessar IF quando a senha consiste com a cadastrada no banco de dados (se é válida)
            if(password_verify($dados['senha_usuario'], $row_usuario['senha_usuario'])){

                //Salvar os dados do usuário na sessão
                $_SESSION['id'] = $row_usuario['id'];
                $_SESSION['email'] = $row_usuario['email'];

                //Recuperar a data atual
                $data = date('Y-m-d H:i:s');

                //Gerar código randômico (aleatório) entre 100000 e 999999
                $codigo_autenticacao = mt_rand(100000, 999999);
                //var_dump($codigo_autenticacao);

                //Query para salvar o código e a data gerada no banco de dados
                $query_up_usuario = "UPDATE usuarios SET
                        codigo_autenticacao =:codigo_autenticacao,
                        data_codigo_autenticacao =:data_codigo_autenticacao
                        WHERE id =:id
                        LIMIT 1";

                //Preparar a Query
                $result_up_usuario = $conn->prepare($query_up_usuario);

                //Substituir o link da Query pelos respectivos valores
                $result_up_usuario->bindParam(':codigo_autenticacao', $codigo_autenticacao);
                $result_up_usuario->bindParam(':data_codigo_autenticacao', $data);
                $result_up_usuario->bindParam('id', $row_usuario['id']);

                //Executando a Query
                $result_up_usuario->execute();

                //Incluindo o Composer
                require './lib/vendor/autoload.php';

                //Criar objeto e instanciar a classe do PHPMailer
                $mail = new PHPMailer();

                // Verificar se envia o e-mail corretamente com try catch
                try {
                    // Imprimir os erro com debug
                    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;  

                    // Permitir o envio do e-mail com caracteres especiais
                    $mail->CharSet = 'UTF-8';

                    //Set mailer to use smtp
	$mail->isSMTP();
    //Define smtp host
        $mail->Host = "smtp.gmail.com";
    //Enable smtp authentication
        $mail->SMTPAuth = true;
    //Set smtp encryption type (ssl/tls)
        $mail->SMTPSecure = "tls";
    //Port to connect smtp
        $mail->Port = "587";
    //Set gmail username
        $mail->Username = "ecoguide1997@gmail.com";
    //Set gmail password
        $mail->Password = "mcvf pflr vzal jupt";
    //Email subject
        $mail->Subject = "Seu código de verificação de login";
    //Set sender email
        $mail->setFrom('ecoguide1997@gmail.com');
    //Enable HTML
        $mail->isHTML(true);
    //Attachment
        //$mail->addAttachment('img/attachment.png');
    //Email body
    $mail->Body    = "<div style='font-weight:bold; font-family:'Poppins',sans-serif;'><h1 style='font-weight:bold; font-size:20px;'>Olá, " . $row_usuario['nome'] . ".</h1> <p>Para nos ajudar a confirmar a sua identidade no site da Ecoguide, precisamos verificar o seu endereço de email.
    </p><p>Este código pode ser usado apenas uma vez. Caso não tenha solicitado um código, ignore este email. Nunca compartilhe este código com ninguém.</p>
    <p>Seu código de verificação de login de 6 digitos é: <span style='font-weight:bold;'> $codigo_autenticacao</span></p></div>";

    // Conteúdo do e-mail em formato texto
    $mail->AltBody = "Olá, " . $row_usuario['nome'] . ". \n\nPara nos ajudar a confirmar a sua identidade no site da Ecoguide, precisamos verificar o seu endereço de email.
    \n\nEste código pode ser usado apenas uma vez. Caso não tenha solicitado um código, ignore este email. Nunca compartilhe este código com ninguém.\n\n
    Seu código de verificação de login de 6 digitos é: $codigo_autenticacao\n";
    //Add recipient
        $mail->addAddress($row_usuario['email'], $row_usuario['nome']);
    //Finally send email
        if ( $mail->send() ) {
            echo "Email Sent..!";
        }else{
            echo "Message could not be sent. Mailer Error: ";
        }
    //Closing smtp connection
        $mail->smtpClose();

                    // Redirecionar o usuário
                    header('Location: validarCodigo.php');

                } catch (Exception $e) { // Acessa o catch quando não é enviado e-mail corretamente
                    //echo "E-mail não enviado com sucesso. Erro: {$mail->ErrorInfo}";
                    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: E-mail não enviado com sucesso!</p>";
                }

            } else{
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário ou senha inválidos!</p>";
            }

           } else{
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário ou senha inválidos!</p>";
           }
        }

        //Imprimir a mensagem da sessão
        if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
    ?>

        <!--Início do conteúdo da página-->
        <div class="box-principal">
            <section class="conteudo-principal">
                <div class="conteudo-textual">
                    <img class="conteudo-logo" src="img/logo.png">                    
                    <p class="conteudo-titulo"> Você tem algum eletrônico quebrado e não sabe onde descartá-lo? </p>
                    <p class="conteudo-texto"> Fazemos coletas de resíduo eletrônico, em busca de promover a reciclagem e a reutilização de componentes eletrônicos, para construir um mundo mais sustentável. </p>
                </div>
                <!--Fim do conteúdo da página-->

                <!--Início do formulário de Login-->
                <div class="conteudo-forms"> 
                    <form method="POST" action="" id="form">
                        <p class="titulo-acesso"> Faça o seu login </p>                        
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="email cadastrado" required>
                        <label for="password">Senha</label>
                        <input type="password" id="password" name="senha_usuario" placeholder="mínimo 8 caracteres" required>
                        
                        <input class="button-acesso" type="submit" name="SendLogin" value="login">

                        <p class="redirecionamento"><a href="cadastro.php"> Não tem conta? cadastre-se agora!</a></p>   
                    </form>
                    <script src="js/verificacaoLogin.js"></script> 
                    <div class="redefinicao-senha">
                        <p class="redirecionamento-redefinicao-senha"><a href="recuperarSenha.php"> Esqueceu a sua senha? </a></p>
                    </div>                         
                </div>    
                <!--Fim do formulário de Login-->           
            </section>
        </div> 
    </body>
    <footer>
        <p class="copy"> &copy; 2023 Ecoguide. Todos os direitos reservados.</p>
    </footer>
</html>