<?php

session_start(); //Iniciando a sessão

ob_start(); //Limpa o buffer de saída

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
        <title>Ecoguide - Validar Código</title>
        <link rel="icon" type="imagem/png" href="img/icon.png">
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <link rel="stylesheet" type="text/css" href="style/recuperacaosenha.css"> 
    </head>
    <body>

        <?php
            //Receber os dados do formulário
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            //Acessar o IF quando o usuário clicar no botão "login" do formulário
            if(!empty($dados['ValCodigo'])){
                //var_dump($dados);
                //var_dump($_SESSION['id']);
                //var_dump($_SESSION['email']);

                //Recuperar os dados do usuário no banco de dados
                $query_usuario = "SELECT id, nome, sobrenome, email, senha_usuario 
                                    FROM usuarios 
                                    WHERE id =:id
                                    AND email =:email 
                                    AND codigo_autenticacao =:codigo_autenticacao
                                    LIMIT 1";

                //Preparar Query
            $result_usuario = $conn->prepare($query_usuario);

            //Substituir o link da Query pelo valor que vem do formulário
            $result_usuario->bindParam(':id', $_SESSION['id']);
            $result_usuario->bindParam(':email', $_SESSION['email']);
            $result_usuario->bindParam(':codigo_autenticacao', $dados['codigo_autenticacao']);

            //Executar a Query
            $result_usuario->execute();

                //Acessar o IF quando encontrar o usuário no banco de dados
                if(($result_usuario) and ($result_usuario->rowCount() != 0)){

                //Ler os registros retornados do banco de dados
                $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);

                //Query para salvar o código e a data gerada no banco de dados
                $query_up_usuario = "UPDATE usuarios SET
                                    codigo_autenticacao = NULL,
                                    data_codigo_autenticacao = NULL
                                    WHERE id =:id
                                    LIMIT 1";

                //Preparar a Query
                $result_up_usuario = $conn->prepare($query_up_usuario);

                //Substituir o link da Query pelos respectivos valores
                $result_up_usuario->bindParam('id', $_SESSION['id']);

                //Executando a Query
                $result_up_usuario->execute();

                //Salvar os dados do usuário na sessão
                $_SESSION['nome'] = $row_usuario['nome'];
                $_SESSION['codigo_autenticacao'] = true;

                // Redirecionar o usuário
                header('Location: dashboard.php');

                }else{
                    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Código inválido!</p>";
                    //header("Location: index.php");
                    //exit();
                }
            }
            //Imprimir a mensagem da sessão
            if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
        ?>

        <!--Início do formulário de validação de login-->
        <div class="box-principal">
            <section class="conteudo-principal">              
                <img class="conteudo-logo" src="img/logo.png">           
                <form method="POST" action="">
                    <p class="titulo-acesso"> Código enviado no <br> email cadastrado!  </p>
                    <label class="label-acesso"> Insira o código recebido</label>
                    <input type="text" id="codigo_autenticacao" name="codigo_autenticacao" placeholder="contém 6 dígitos" maxlength="6" required>	
                    <input class="button-acesso" type="submit" name="ValCodigo" value="Validar">
                </form>
                <!-- Remove todos os caracteres não numéricos -->
                <script>
                    const numericTextInput = document.getElementById('codigo_autenticacao');

                    numericTextInput.addEventListener('input', function (event) {
                        const inputValue = event.target.value;
                        event.target.value = inputValue.replace(/\D/g, '');
                    });
                </script>                   
            </section>
        </div>
        <!--Fim do formulário de validação de login-->  
    </body>
    <footer>
            <p class="copy"> &copy; 2023 Ecoguide. Todos os direitos reservados.</p>
    </footer>
</html>