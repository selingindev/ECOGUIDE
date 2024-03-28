<?php

session_start(); //Iniciando a sessão

ob_start(); //Limpa o buffer de saída

//incluir o arquivo config
include_once "./config.php";

//Destruir a sessão
unset($_SESSION['id'], $_SESSION['nome'], $_SESSION['email'], $_SESSION['codigo_autenticacao']);

//Acessar o IF quando o usuário não estiver logado e redirecionar para a página de login
if((!isset($_SESSION['id'])) and (!isset($_SESSION['email'])) and (!isset($_SESSION['codigo_autenticacao']))){
    $_SESSION['msg'] = "<p style='color: green;'>Deslogado com sucesso</p>";
        
        //Reredicionar o usuário para o index
        header("Location: index.php");

        //Pausar o processamento
        exit();        
}
?>
