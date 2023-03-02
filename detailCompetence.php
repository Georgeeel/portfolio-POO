<?php
//Contoller
require_once("./controllers/SkillController.php");
$controller = new SkillController;
//titre de la page
define("PAGE_TITLE", "Detail compétences");
$skill = $controller->readOne($_GET['id']);
$skills = $controller->readAll();

?>
<main>
    <h1>test</h1>
    <?php foreach($skill->projects as $project){ ?>
        <p><?= $project->name?></p>
    
    
  <?php }?>
</main>
