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
        <link rel="stylesheet" type="text/css" href="style/sobreNos.css">
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

        <div class="inicio">
            <img class="img-inicio" src="img/pitch.png" alt="Imagem dos membros do projeto apresentando pitch">
            <div class="sobre-conteudo-inicio">
                <p class="home-titulo-a"> COMO TUDO COMEÇOU... </p>
                <p class="home-texto-a"> A iniciativa que nasceu da união de mentes inovadoras da Etec de Carapicuíba 
                    durante uma visita técnica à renomada empresa HP, no final de 2022. 
                    Nosso compromisso com a responsabilidade ambiental foi catalisado pelo desafio proposto: 
                    criar uma solução para recolher resíduos eletrônicos mal descartados, implementando efetivamente a logística reversa. </p>
            </div>
        </div>   
        <br>       
               
        <div class="podio">
           <div class="sobre-conteudo-podio">
                <p class="home-titulo-a"> A CONQUISTA DO PÓDIO </p>
                <p class="home-texto-a"> Ao longo desse trajeto desafiador, mergulhamos em diversas etapas fundamentais que moldaram nossa jornada, 
                    cada fase foi uma oportunidade de aprendizado e crescimento. 
                    Com dedicação incansável na execução das atividades propostas, o projeto Ecoguide conquistou 
                    o reconhecimento ao ser classificado em 1° lugar pelos jurados. </p>
            </div>
            <img class="img-podio" src="img/hp.png" alt="Imagem dos participantes do evento na hp">
        </div> 
        <br> 

        <div class="reinventando">
           <img class="img-reinventando" src="img/reinventando.png" alt="Imagem de uma pessoa produzindo códigos">
           <div class="sobre-conteudo-reinventando">
                <p class="home-titulo-a"> REINVENTANDO ECOGUIDE </p>
                <p class="home-texto-a"> O início de 2023 marcou um novo capítulo para a Ecoguide. 
                    Diante da elaboração do TCC (Trabalho de Conclusão de Curso) a equipe concordou em resgatar a ideia do Ecoguide, 
                    adaptando-a para o novo cenário. Reconhecemos a importância de levar adiante nossa visão de um futuro mais sustentável. </p>
            </div>
        </div> 
        <br> 

        <div class="participacao">
           <div class="sobre-conteudo-participacao">
                <p class="home-titulo-a"> Participação na  #CPBR15 </p>
                <p class="home-texto-a"> Em julho, a Ecoguide atingiu mais um marco ao ser apresentada 
                    ao público durante a 15ª edição da Campus Party Brasil, no estande Centro Paula Souza. 
                    Enfrentamos desafios ao longo do caminho, no entanto eles moldaram a excelência do nosso projeto. </p>
                    <a href="https://www.cps.sp.gov.br/alunos-da-etec-de-carapicuiba-criam-sistema-de-coleta-de-eletronicos/" class="button"> Saiba mais ao acessar a matéria do CPS </a>    
            </div>
            <img class="img-participacao" src="img/cpbr.png" alt="Imagem do Arthur, Wesley, Luís Ricardo e Ana Paula, ao lado da superintendente do CPS, Laura Laganá, na Campus Party">
        </div>
        <br>          

        <div class="futuro">
           <img class="img-futuro" src="img/futuro.png" alt="Cidade sustentável ilustrativa">
           <div class="sobre-conteudo-futuro">
                <p class="home-titulo-a"> JUNTE-SE A NÓS </p>
                <p class="home-texto-a"> À medida que avançamos, vislumbramos um futuro onde a conscientização ambiental e
                     a logística reversa de resíduos eletrônicos se tornam não apenas uma necessidade, mas uma prática comum. 
                     O futuro sustentável começa agora, e convidamos você a fazer parte dessa transformação ambiental conosco.</p>
            </div>
        </div> 
        <br>        
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