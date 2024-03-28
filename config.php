<?php

//Definindo fuso horário padrão
date_default_timezone_set('America/Sao_Paulo');

//Credenciais do Banco de Dados (constantes)
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBNAME', 'ecoguide');
define('PORT', 3306);

//Credenciais do Servidor de Email (constantes)
define('HOSTEMAIL', 'sandbox.smtp.mailtrap.io');
define('USEREMAIL', '5435f2f6775e8c');
define('PASSEMAIL', 'b132b7dd218173');
define('SMTPSECURE', 'PHPMailer::ENCRYPTION_STARTTLS');
define('PORTEMAIL', 465);
define('REMETENTE', 'ecoguide1997@gmail.com');
define('NOMEREMETENTE', 'Equipe Ecoguide');
?>