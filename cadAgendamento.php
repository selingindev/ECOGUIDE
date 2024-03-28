<?php

session_start(); //Iniciando a sessão

ob_start(); //Limpa o buffer de saída

//incluir o arquivo config
include_once "./config.php";

//Incluir o arquivo com a conexão com o banco de dados
include_once "./conexao.php";

$dados1 = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if(empty($dados1['cep'])){
    $retornar = ['erro' => true, 'mensagem' => "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo cep</div>"];
}elseif(empty($dados1['quant_resid'])){
    $retornar = ['erro' => true, 'mensagem' => "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo quantidade de resíduos</div>"];
}elseif(empty($dados1['data_coleta'])){
    $retornar = ['erro' => true, 'mensagem' => "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo data da coleta</div>"];
}else{

    if(!isset($dados1['cat_azul'])){
        $dados1['cat_azul'] = 0;
    }
    if(!isset($dados1['cat_vermelho'])){
        $dados1['cat_vermelho'] = 0;
    }
    if(!isset($dados1['cat_amarelo'])){
        $dados1['cat_amarelo'] = 0;
    }
    if(!isset($dados1['cat_branco'])){
        $dados1['cat_branco'] = 0;
    }
    
    $idLogado = $_SESSION['id'];

    $query_agendamentos = "INSERT INTO agendamento (id_usuario, cep, quant_resid, data_coleta, cat_azul, cat_vermelho, cat_amarelo, cat_branco) 
    VALUES (:id_usuario, :cep, :quant_resid, :data_coleta, :cat_azul, :cat_vermelho, :cat_amarelo, :cat_branco)";
    $cad_agendamentos = $conn->prepare($query_agendamentos);
    $cad_agendamentos->bindParam(':id_usuario', $_SESSION['id']);
    $cad_agendamentos->bindParam(':cep', $dados1['cep']);
    $cad_agendamentos->bindParam(':quant_resid', $dados1['quant_resid']);
    $cad_agendamentos->bindParam(':data_coleta', $dados1['data_coleta']);
    $cad_agendamentos->bindParam(':cat_azul', $dados1['cat_azul']);
    $cad_agendamentos->bindParam(':cat_vermelho', $dados1['cat_vermelho']);
    $cad_agendamentos->bindParam(':cat_amarelo', $dados1['cat_amarelo']);
    $cad_agendamentos->bindParam(':cat_branco', $dados1['cat_branco']);
    $cad_agendamentos->execute();
    
    if($cad_agendamentos->rowCount()){
        $retornar = ['erro' => false, 'mensagem' => " <div class='alert alert-success' role='alert' style=''>
        <h4 class='alert-heading'>Agendamento realizado com sucesso!</h4>
        <p>Em breve estaremos no endereço solicitado para recolher o resíduo eletrônico.</p></div>"];
    }else{
        $retornar = ['erro' => true, 'mensagem' => "<div class='alert alert-danger' role='alert'>Erro: Não foi possível realizar o cadastro</div>"];
    }
}

echo json_encode($retornar);

?>