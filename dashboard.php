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
        <title>Ecoguide</title>
        <link rel="icon" type="imagem/png" href="img/icon.png">
        <link rel="stylesheet" type="text/css" href="style/style.css">        
        <link rel="stylesheet" type="text/css" href="style/dashboard.css">
        <link rel="stylesheet" href="bootstrap-4.1.3/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="bootstrap-4.1.3/js/bootstrap.min.js"> </script>
    </head>

    <body>
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
        
        <div class="introducao">
            <div class="home-conteudo-introducao"> 
                <p class="home-titulo-a"> O DESCARTE INADEQUADO DE RESÍDUO ELETRÔNICO CAUSA DANOS GRAVES AO MEIO AMBIENTE </p>
                <p class="home-texto-a"> Visando atender a essa necessidade, 
                    criamos o nosso projeto de coleta de resíduo eletrônico sustentável. 
                    Buscamos incentivar a população a descartar corretamente esses materiais, 
                    além de promover a logística reversa de componentes eletrônicos.  </p>
                <a href="agendamento.php" class="button"> Faça o agendamento da coleta! </a>
            </div>
            <img class="img-intro" src="img/home_intro.png" alt="Ilustação de pessoas cuidando do planeta">
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
        <br> 
        
        <div class="vantagens">
            <img class="img-descarte" src="img/descate_ilustra.png" alt="Ilustração eletrônicos sendo descartados">
            <div class="home-conteudo-vantagens"> 
                <p class="home-titulo-b"> AS VANTAGENS DE DESCARTAR OS SEUS ELETRÔNICOS COM CONSCIÊNCIA AMBIENTAL </p>
                <br>
                <div class="item-vantagens"> 
                    <img class="img-check" src="img/check.png" alt="Símbolo check">
                    <p class="home-texto-b"> Responsabilidade ambiental, evitando que o resíduo eletrônico acabe em aterros sanitários e prejudique a natureza. </p>
                </div>
                <br>
                <div class="item-vantagens"> 
                    <img class="img-check" src="img/check.png" alt="Símbolo check">
                    <p class="home-texto-b"> A reciclagem de eletrônicos cria uma economia circular, e menos recursos naturais são utilizados. </p>
                </div>
                <br>
                <div class="item-vantagens"> 
                    <img class="img-check" src="img/check.png" alt="Símbolo check">
                    <p class="home-texto-b"> Opção de usar o nosso serviço de coleta em domicílio, se tornando fácil e seguro para você descartar eletrônicos. </p>
                </div>
            </div>
        </div>
        <br> 
        <div class="container-ods">
            <div class="informacoes-ods">
                <img class="img-ods" src="img/ods.png" alt="Juntos contribuímos com os seguintes: OBJETIVOS DE DESENVOLVIMENTO SUSTENTÁVEL">
            </div>
            <div class="informacoes-ods">
                <img class="img-ods" src="img/ods3.png" alt="3. Assegurar uma vida saudável e promover o bem-estar para todos, em todas as idades">
            </div>
            <div class="informacoes-ods">
                <img class="img-ods" src="img/ods8.png" alt="8. Promover o crescimento econômico sustentado, inclusivo e sustentável, o emprego pleno e produtivo e o trabalho decente para todos">
            </div>
            <div class="informacoes-ods">
                <img class="img-ods" src="img/ods9.png" alt="9. Construir infraestruturas resilientes, promover a industrialização inclusiva e sustentável e fomentar a inovação">
            </div>
            <div class="informacoes-ods">
                <img class="img-ods" src="img/ods11.png" alt="11. Tornar as cidades e os assentamentos humanos inclusivos, seguros, resilientes e sustentáveis">
            </div>
            <div class="informacoes-ods">
                <img class="img-ods" src="img/ods12.png" alt="12. Assegurar padrões de produção e de consumo sustentáveis">
            </div>
            <div class="informacoes-ods">
                <img class="img-ods" src="img/ods13.png" alt="13. Tomar medidas urgentes para combater a mudança do clima e seus impactos">
            </div>
            <div class="informacoes-ods">
                <img class="img-ods" src="img/ods17.png" alt="17. Fortalecer os meios de implementação e revitalizar a parceria global para o desenvolvimento sustentável">
            </div>
        </div>
        <br>

        <div class="frase">
            <p class="home-titulo-a"> UNA-SE A NÓS NESSA INICIATIVA, AJUDE A CONSTRUIR UM MUNDO SUSTENTÁVEL PARA AS FUTURAS GERAÇÕES </p>
            <img class="img-cidade" src="img/cidade.png" alt="Imagem ilustrativa de uma cidade sustentável">
        </div>
        
    </body>

    <footer>
        <div>
            <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="parallax">
                    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(3, 89, 80, 0.7" />
                    <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(3, 89, 80,0.5)" />
                    <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(3, 89, 80,0.3)" />
                    <use xlink:href="#gentle-wave" x="48" y="7" fill="#035950" />
                </g>
            </svg>
        </div>
        <div class="down">
            <br>
            <a href="dashboard.php">
                <img class="footer-img" src="img/logo_white.png" alt="Logo da Ecoguide">
            </a>
            <ul class="down-menu">
                <li><a href="dashboard.php"> Home </a></li>
                <li><a href="agendamento.php"> Agendamento </a></li>
                <li><a href="sobreNos.php"> Sobre nós </a></li>
            </ul>
            <br>
            <p class="copy"> &copy; 2023 Ecoguide. Todos os direitos reservados.</p> 
        </div>          
    </footer>
</html>