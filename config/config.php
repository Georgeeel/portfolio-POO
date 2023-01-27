<?php

define("DB_HOST", "localhost");

//constante definit pour la BDD
define("DB_NAME","ag_portfolio_bon");
//constante definit pour le nom de l'utilisateur
define("DB_USER", "root");
//constante pour mdp à BDD
define("DB_PASSWORD","");

$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);









?>