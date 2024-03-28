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
        <title>Ecoguide</title>
        <link rel="icon" type="imagem/png" href="img/icon.png">
        <link rel="stylesheet" type="text/css" href="style/acesso.css">
        <link rel="stylesheet" type="text/css" href="style/style.css">
    </head>

    <body>

    <?php
        //Receber dados do formulário
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        //Acessa o IF quando o usuário clicar no botão "cadastrar"
        if(!empty($dados['SendCadUser'])){
            var_dump($dados);

            //Criptografar senha
            $senha_cripto = password_hash($dados['senha_usuario'], PASSWORD_DEFAULT);

            //Criar Query para cadastrar no banco de dados
           $query_usuario = "INSERT INTO usuarios (nome, sobrenome, email, senha_usuario) VALUES (:nome, :sobrenome, :email, :senha_usuario)";

           //Preparar a Query
           $cad_usuario = $conn->prepare($query_usuario);

           //Substituir link pelos valores vindos do formulário
           $cad_usuario->bindParam(':nome', $dados['nome']);
           $cad_usuario->bindParam(':sobrenome', $dados['sobrenome']);
           $cad_usuario->bindParam(':email', $dados['email']);
           $cad_usuario->bindParam(':senha_usuario', $senha_cripto);

           //Executar a Query
           $cad_usuario->execute();

           //Acessa o IF quando cadastrar o registro no banco de dados
           if($cad_usuario->rowCount()){

                //Criar mensagem e atribuir para variável global
                $_SESSION['msg'] = "<p style='color: green'>Usuário cadastrado com sucesso</p>";

                //Redirecionar o Usuário para página de Login
                header("Location: index.php");
                exit();
           }else {

                //Criar mensagem e atribuir para variável global
                $_SESSION['msg'] = "<p style='color: #f00'>Erro: Não Foi possível realizar o cadastro de usuário</p>";
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

                <!--Início do formulário de Cadastro-->
                <form method="POST" action="" id="form">
                    <p class="titulo-acesso"> Crie sua conta </p>
                    <label for="firstname">Nome</label>
                    <input type="text" id="firstname" name="nome" placeholder="nome" required>
                    <label for="lastname">Sobrenome</label>
                    <input type="text" id="lastname" name="sobrenome" placeholder="sobrenome" required>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="endereço de email válido" required>
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="senha_usuario" placeholder="mínimo 8 caracteres" required>
                                        
                    <input class="button-acesso" type="submit" name="SendCadUser" value="cadastrar">                                        
                    
                    <p class="redirecionamento"><a href="index.php">Já fez o cadastro? Realize o login!</a></p>
                </form> 
                          
                <!--Fim do formulário de Cadastro-->      
            </section>
        </div>        
    </body>
    <footer>
        <p class="copy"> &copy; 2023 Ecoguide. Todos os direitos reservados.</p>
    </footer>
</html>