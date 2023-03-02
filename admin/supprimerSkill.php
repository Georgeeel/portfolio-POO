<?php
session_start();
define("PAGE_TITLE","Detail compétence");

require_once("../controllers/AccountController.php");
require_once("../controllers/SkillController.php");

$accountController = new AccountController;
$accountController->isLogged();

$skillController = new SkillController;
$skill = $skillController->readOne($_GET['id']);
if(isset($_POST["submit"])){
    $error = $skillController->deleteSkill($_POST["id_skill"]);
}

include("../assets/inc/head.php");
include("../assets/inc/header.php");
?>
<main class="container">
   <h2 class="text text-center mt-4">Compétences <?=$skill->name?></h2>
   
<div class="card offset-3 mt-5" style="width: 45rem;">
<!-- Message d'erreur -->
        <?php if(isset($error)){
            if($error["success"]){?>
                <div class="alert alert-success"><?=$error["message"]?></div>
                    <?php } else {?>
                <div class="alert alert-danger"><?=$error["message"]?></div>
                <?php } ?>
        <?php }  ?>
  <img src="/mon_portfolio/assets/image/skills/<?=$skill->picture?>" class="card-img-top" alt="../assets/image/skills/<?=$skill->picture?>">
    <div class="card-body">
        <h5 class="card-title"><?=$skill->name?></h5>
        <div class="progress mt-2">
            <div class="progress-bar progress-bar-striped bg-dark progress-bar-animated" role="progressbar" aria-valuenow="<?=$skill->level?>" aria-valuemin="0" aria-valuemax="135" style="width: <?=$skill->level?>%"></div>%
        </div>
        <p class="card-text"></p>
        <a href="/mon_portfolio/admin/gestionSkills.php" class="btn btn-primary">Retour</a>
        <form action="#" method="post">
            <input type="hidden" name="id_skill" value="<?= $skill->id_skill?>">
            <button type="submit" name="submit" class="btn btn-danger mt-2 text-end">Supprimer</button>
        </form>
    </div>
</div>
</main>