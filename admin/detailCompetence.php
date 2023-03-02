<?php
session_start();
define("PAGE_TITLE","Detail compétence");

require_once("../controllers/AccountController.php");
require_once("../controllers/SkillController.php");

$accountController = new AccountController;
$accountController->isLogged();

$skills = new SkillController;
$skill = $skills->readOne($_GET['id_skill']);

include("../assets/inc/head.php");
include("../assets/inc/header.php");
?>
<main class="container">
   <h2 class="text text-center mt-4">Compétences <?=$skill->name?></h2>

<div class="card offset-3 mt-5" style="width: 45rem;">
  <img src="/mon_portfolio/assets/image/skills/<?=$skill->picture?>" class="card-img-top" alt="../assets/image/skills/<?=$skill->picture?>">
  <div class="card-body">
    <h5 class="card-title"><?=$skill->name?></h5>
    <div class="progress mt-2">
        <div class="progress-bar progress-bar-striped bg-dark progress-bar-animated" role="progressbar" aria-valuenow="<?=$skill->level?>" aria-valuemin="0" aria-valuemax="135" style="width: <?=$skill->level?>%"></div>
    </div>
    <?php foreach($skill->projects as $project){  ?>
    <p class="card-text"><?=$project->name?></p>
    <?php } ?>
    <a href="/mon_portfolio/admin/gestionSkills.php" class="btn btn-primary">Retour</a>
</div>
</div>
</main>