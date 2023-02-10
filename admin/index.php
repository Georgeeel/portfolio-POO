<?php
session_start();
// require_once("../config/config.php");
define("PAGE_TITLE", "Accueil admin");
require_once("../controllers/AccountController.php");

$accountController = new AccountController;
//permet de vérifier que l'utilisateur soit connecté
$accountController->isLogged();

include("../assets/inc/head.php");
include("../assets/inc/header.php");
?>
<main class="container-fluid">
    <h3>Vous êtes connectée</h3>
    <p>Votre email: <?=$_SESSION["email"]?></p>
    <div class="d-flex ">
        <a href="/mon_portfolio/admin/ajoutProjet.php" class="btn btn-success mx-4">Ajouter un projet</a>
        <a href="/mon_portfolio/admin/ajoutCompetence.php" class="btn btn-dark">Ajouter une compétence</a>
    </div>
</main>
<?php include("../assets/inc/footer.php");?>