<?php
session_start(); //Iniciando a sessão

ob_start(); //Limpa o buffer de saída

//incluir o arquivo config
include_once "./config.php";

//Incluir o arquivo com a conexão com o banco de dados
include_once "./conexao.php";

//Receber a chave
$chave_recuperar_senha = filter_input(INPUT_GET, 'chave', FILTER_DEFAULT);
//var_dump($chave_recuperar_senha);

if(empty($chave_recuperar_senha)){

    //Criar variável global com a mensagem de erro
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link inválido!</p>";

    // Redirecionar o usuário
    header('Location: index.php');

    //Pausar o procedimento
    exit();
}else{

    //QUERY para recuperar dados do usuário no banco de dados
    $query_usuario = "SELECT id 
        FROM usuarios
        WHERE chave_recuperar_senha =:chave_recuperar_senha
        LIMIT 1";

    //Preparar a QUERY
    $result_usuario = $conn->prepare($query_usuario);

    //Substitui o link da query pelo valor que vem do formulário
    $result_usuario->bindParam(':chave_recuperar_senha', $chave_recuperar_senha);

    //Executar a QUERY
    $result_usuario->execute();

    if($result_usuario->rowCount() === 0){
    
    //Criar variável global com a mensagem de erro
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link inválido! Certifique-se de ter copiado corretamente o link.</p>";

    // Redirecionar o usuário
    header('Location: index.php');

    //Pausar o procedimento
    exit();
    }else{
        //Ler os registros retornados do banco de dados
        $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
    }
}
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
        //Receber dados do formulário
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        //Acessar IF quando o usuário clicar no botão atualizar do formulário
        if(!empty($dados['SendNovaSenha'])){
            var_dump($dados);

            //Criptografar a senha
            $senha_usuario = password_hash($dados['senha_usuario'], PASSWORD_DEFAULT);
            $chave_recuperar_senha = 'NULL';

            //Editar o usuário e salvar a nova senha
            $query_up_usuario = "UPDATE usuarios
                        SET senha_usuario =:senha_usuario,
                        chave_recuperar_senha =:chave_recuperar_senha
                        WHERE id =:id
                        LIMIT 1";

            //Preparar a QUERY
            $editar_usuario = $conn->prepare($query_up_usuario);

            //Substitui o link da query pelo valor que vem do formulário
            $editar_usuario->bindParam(':senha_usuario', $senha_usuario);
            $editar_usuario->bindParam(':chave_recuperar_senha', $chave_recuperar_senha);
            $editar_usuario->bindParam(':id', $row_usuario['id']);

            //Executar a QUERY
            if($editar_usuario->execute()){

                //Criar variável global com a mensagem de sucesso
                $_SESSION['msg'] = "<p style='color: green;'>Senha atualizada com sucesso!</p>";

                // Redirecionar o usuário
                header('Location: index.php');

                //Pausar o procedimento
                exit();

            }else{
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Tente novamente!</p>";
            }
        }

        //Imprimir a mensagem da sessão
        if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>

        <!--Início do formulário de atualização de senha -->
        <div class="box-principal">
                <section class="conteudo-principal">              
                    <img class="conteudo-logo" src="img/logo.png">           
                    <form method="POST" action="">
                        <p class="titulo-acesso"> Atualize a senha  </p>
                        <label class="label-acesso"> Insira a sua nova senha </label>
                        <input type="password" name="senha_usuario" placeholder="senha" required>
                        <input  class="button-acesso" type="submit" name="SendNovaSenha" value="atualizar">
                        <p class="redirecionamento"><a href="index.html">Lembrou a senha? Faça o seu login!</a></p>
                    </form>                   
                </section>
        </div> 
        <!--Fim do formulário de atualização de senha--> 
    </body>
    <footer>
            <p class="copy"> &copy; 2023 Ecoguide. Todos os direitos reservados.</p>
    </footer>
</html>