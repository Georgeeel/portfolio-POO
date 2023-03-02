<?php
session_start();
define("PAGE_TITLE","Supprimer un projet");

require_once("../controllers/AccountController.php");
require_once("../controllers/ProjectController.php");
$accountController = new AccountController;
$accountController->isLogged();

$projectController = new ProjectController;
$project = $projectController->readOne($_GET["id_project"]);
if(isset($_POST["submit"])){
    $error = $projectController->deleteProjet($_POST['id_project']);
}


include("../assets/inc/head.php");
include("../assets/inc/header.php");

?>
<main class="container">
   <h2 class="text text-center mt-4">Compétences <?=$project->name?></h2>
   <div class="card offset-3 mt-5" style="width: 43rem;">
<!-- Message d'erreur -->
        <?php if(isset($error)){
            if($error["success"]){?>
                <div class="alert alert-success"><?=$error["message"]?></div>
                    <?php } else {?>
                <div class="alert alert-danger"><?=$error["message"]?></div>
                <?php } ?>
        <?php }  ?>
  <img src="/mon_portfolio/assets/image/projects/<?=$project->cover?>" class="card-img-top" alt="../assets/image/projects/<?=$project->cover?>">
    <div class="card-body">
        <h3 class="card-title"><b>Nom projet: </b> <?=$project->name?></h3>
        <p class="text-muted mt-2"> <b>Date de début: </b><?=$project->displayDateStart()?></p>
        <p class="text-muted"> <b>Date fin:</b>  
            <?php if(isset($project->date_end)){
                   echo  $project->displayDateEnd();
                }else{
                    echo "En cours";
                }
                ?>
        </p>
        <p class="text-muted fw-bold">Compétences:</p>
            <?php foreach($project->skills as $skill){ ?>
                    <li class="mx-4"><?=$skill->name ?></li>
            <?php }?>
        <a href="/mon_portfolio/admin/gestionProjet.php" class="mt-4 btn btn-primary">Retour</a>
        <form action="#" method="post">
            <input type="hidden" name="id_project" value="<?= $project->id_project?>">
            <button type="submit" name="submit" class="btn btn-danger mt-2 text-end">Supprimer</button>
        </form>
    </div>
</div>
</main>