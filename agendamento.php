<?php

session_start(); //Iniciando a sessão

ob_start(); //Limpa o buffer de saída

//incluir o arquivo config
include_once "./config.php";

//Incluir o arquivo com a conexão com o banco de dados
include_once "./conexao.php";

//Acessar o IF quando o usuário não estiver logado e redirecionar para a página de login
if((!isset($_SESSION['id'])) and (!isset($_SESSION['email'])) and (!isset($_SESSION['codigo_autenticacao']))){
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário realizar o login para acessar a página</p>";
        
        //Reredicionar o usuário para o index
        header("Location: index.php");

        //Pausar o processamento
        exit();        
}
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
      <title>Ecoguide</title>
      <link rel="icon" type="imagem/png" href="img/icon.png">
      <link rel="stylesheet" type="text/css" href="style/style.css">
      <link rel="stylesheet" type="text/css" href="style/agendamento.css">
      <link rel="stylesheet" type="text/css" href="style/dashboard.css">
  </head>
  <body>
      <!-- Conteúdos nav -->
      <header class="cabecalho">   
            <div class="cabecalho-itens">
                <div class="cabecalho-logo"> 
                    <a href="dashboard.php">
                        <img class="cabecalho-img" src="img/logo_white.png" alt="Logo da Ecoguide">
                    </a> 
                </div>              
                <div class="cabecalho-user">
                    <p class="nome-user"> Olá, <?php echo $_SESSION['nome']; ?>! </p>
                    <!-- Mode Toggle -->
                    <div>
                        <img id="mode-toggle" src="img/mode.png" title="Clique para alternar o Modo claro/escuro">
                    </div>
                    <script src="js/modeToggle.js"></script> 
                    <a href="logout.php" title="Tem certeza de que deseja sair da sua conta?">
                        <img class="logout-img" src="img/logout.png" alt="Icon logout">
                    </a>                    
                </div>
            </div> 
      </header>
    

      <!-- Histórico de coletas e botão de agendamento -->
      <div class="container">
          <div class="row mt-4"> 
              <div class="top col-lg-12 d-flex justify-content-between align-items-center">
                  <div>
                      <h1 class="titulo">Seus agendamentos</h1>
                  </div>
                  <div>
                      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cadAgendamentoModal">
                          Agendar coleta
                      </button>
                  </div>
              </div>
          </div>
          <br>
                    
          <span id="msgAlerta"></span>

          <div class="row">
              <div class="col-lg-12">          
                  <span class="listar-agendamentos"></span>
              </div>
          </div>          
      </div>

      <!-- Ferramenta de libras -->
      <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
          <div class="vw-plugin-top-wrapper"></div>
        </div>
      </div>
      <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
      <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
      </script>

      <!-- Chatbot -->
      <script>
        window.addEventListener('mouseover', initLandbot, { once: true });
        window.addEventListener('touchstart', initLandbot, { once: true });
        var myLandbot;
        function initLandbot() {
          if (!myLandbot) {
            var s = document.createElement('script');s.type = 'text/javascript';s.async = true;
            s.addEventListener('load', function() {
              myLandbot = new Landbot.Popup({
                configUrl: 'https://storage.googleapis.com/landbot.online/v3/H-1667423-Q398F7MJ4J1KXVRK/index.json',
              });
            });
            s.src = 'https://cdn.landbot.io/landbot-3/landbot-3.0.0.js';
            var x = document.getElementsByTagName('script')[0];
            x.parentNode.insertBefore(s, x);
          }
        }
      </script>
      
      <!-- Modal -->
      <div class="modal fade" id="cadAgendamentoModal" tabindex="-1" aria-labelledby="cadAgendamentoModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content" style="padding: 2%;">
                  <div class="modal-header">
                    <h1 class="modal-title" id="cadAgendamentoModalLabel" style="font-family: 'Anton', sans-serif; color: #7C7C7C; font-size: 2rem;">Agende a sua coleta!</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" style="font-family: 'Poppins', sans-serif; font-size: 1rem;">
                    <span id="msgAlertaErroCad"></span>
                    <p>Ficamos feliz com a sua decisão de ajudar o planeta Terra! Preencha os campos abaixo para agendar a sua coleta:</p>
                    <form id="cad-agendamento-form">
                      <div class="mb-3">
                        <label for="cep" class="col-form-label"><b> CEP: </b></label>
                        <input type="text" name="cep" class="form-control" id="cep" placeholder="Insira o CEP de onde será realizada a coleta" maxlength="9" required>
                      </div>
                      <div class="mb-3">
                        <label for="quant_resid" class="col-form-label"><b> Quantidade de resíduos a serem descartados: </b></label>
                        <input type="number" name="quant_resid" class="form-control" id="quant_resid" placeholder="Insira a quantidade de resíduos" maxlength="9" max="99999" required>
                      </div>
                      <div class="mb-3">
                        <label for="data_coleta" class="col-form-label"><b> Dia da coleta: </b></label>
                        <input type="date" name="data_coleta" class="form-control" id="data_coleta" required>
                      </div>
                      <div class="mb-3">
                        <label for="categoria" class="col-form-label"><b> Categoria do resíduo: </b> <br> <i> Consulte o chatbot caso tenha dúvida em relação a categoria </i></label>
                        <div class="container">
                            <label title="Exemplo: baterias, celulares, cabos e computadores."> Azul
                                <input type="checkbox" name="cat_azul" value="1">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="container">
                            <label title="Exemplo: televisores e acessórios de áudio."> Vermelho
                                <input type="checkbox" name="cat_vermelho" value="1">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="container">
                            <label title="Exemplo: eletrodomésticos."> Amarelo
                                <input type="checkbox" name="cat_amarelo" value="1">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="container">
                            <label title="Outros."> Branco
                                <input type="checkbox" name="cat_branco" value="1">
                                <span class="checkmark"></span>
                            </label>
                        </div>           
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" style="background-color: #7C7C7C" data-bs-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-success" style="background-color: #035950;" id="cad-agendamento-btn" value=" Agendar ">
                      </div>
                    </form>
                    <script src="js/agendamento.js"></script>              
                  </div>
              </div>
          </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
      <script src="js/custom.js"></script>

  </body>
</html>