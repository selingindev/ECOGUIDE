<?php

session_start(); //Iniciando a sessão

ob_start(); //Limpa o buffer de saída

//incluir o arquivo config
include_once "./config.php";

//Incluir o arquivo com a conexão com o banco de dados
include_once "./conexao.php";

$pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_NUMBER_INT);

$idLogado = $_SESSION['id'];

if(!empty($pagina)){

    //Calcular o início da visualização
    $qnt_result_pg = 10; //Quantidade de registro por página
    $inicio = ($pagina * $qnt_result_pg) - $qnt_result_pg; //Conta para exibir o registro na página em que o usuário se localiza

$query_agendamento = "SELECT id_agend, id_usuario, cep, quant_resid, data_coleta, cat_azul, cat_vermelho, cat_amarelo, cat_branco FROM agendamento 
WHERE id_usuario = $idLogado
ORDER BY id_agend 
DESC LIMIT $inicio, $qnt_result_pg";
$result_agendamento = $conn->prepare($query_agendamento);
$result_agendamento->execute();

$dados1 = " <div class='table-responsive'>
            <table class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th style='background-color: #035950; color:#FFF;'>ID</th>
                        <th style='background-color: #035950; color:#FFF;'>CEP</th>
                        <th style='background-color: #035950; color:#FFF;'>Quantidade de Resíduos</th>
                        <th style='background-color: #035950; color:#FFF;'>Data da Coleta</th>
                        <th style='background-color: #035950; color:#FFF;'>Categoria</th>
                    </tr>
                </thead>
            <tbody>";

while($row_agendamento = $result_agendamento->fetch(PDO::FETCH_ASSOC)){
$categorias = array();
    //var_dump($row_agendamento);
    extract($row_agendamento);

    if($row_agendamento['cat_azul'] == 1){
        $categorias[] = "Azul";
    }

    if($row_agendamento['cat_vermelho'] == 1){
        $categorias[] = "Vermelho";
    }

    if($row_agendamento['cat_amarelo'] == 1){
        $categorias[] = "Amarelo";
    }

    if($row_agendamento['cat_branco'] == 1){
        $categorias[] = "Branco";
    }

    $categoria_textos = implode(", ", $categorias);

    
    $dados1 .= "<tr>
                    <td>$id_agend</td>
                    <td>$cep</td>
                    <td>$quant_resid</td>
                    <td>$data_coleta</td>
                    <td>$categoria_textos</td>
                 </tr>";
}

$dados1 .="</tbody>
        </table>
    </div>";

    //Paginação - somar a quantidade de usuários
    $query_pg = "SELECT COUNT(id_agend) AS num_result FROM agendamento WHERE id_usuario = $idLogado";
    $result_pg = $conn->prepare($query_pg);
    $result_pg->execute();
    $row_pg = $result_pg->fetch(PDO::FETCH_ASSOC);

    //Quantidade de páginas
    $quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg); //Cálculo dos resultados por página
    
    $max_links = 1;

    $dados1 .= '<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">';

    $dados1 .= "<li class='page-item'><a href='#' style='color: #035950;' class='page-link' onclick='listarAgendamento(1)'><b> << </b></a></li>";

    for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
        if($pag_ant >= 1){
            $dados1 .= "<li class='page-item'><a style='color: #7C7C7C;' class='page-link' href='#' onclick='listarAgendamento($pag_ant)'>$pag_ant</a></li>";
        }
    }
    
    $dados1 .= "<li class='page-item active'><a style='background-color: #035950; border-color:#035950;' class='page-link' href='#'>$pagina</a></li>";

    for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
        if($pag_dep <= $quantidade_pg){
            $dados1 .= "<li class='page-item'><a style='color: #7C7C7C;' class='page-link' href='#' onclick='listarAgendamento($pag_dep)'>$pag_dep</a></li>";
        }
        
    }

    $dados1 .= "<li class='page-item'><a style='color: #035950;' class='page-link' href='#' onclick='listarAgendamento($quantidade_pg)'><b> >> </b></a></li>";
    $dados1 .= '</ul></nav>';

echo $dados1;

} else{
    echo "<div class='alert alert-danger' role='alert'>Você não possui agendamentos ainda!</div>";
}

?>


