<?php
session_start();
define("PAGE_TITLE", "Modifier une compétence");

require_once("../controllers/AccountController.php");
require_once("../controllers/SkillController.php");

$accountController = new AccountController;
$accountController->isLogged();

$skillController = new SkillController;
$skill = $skillController->readOne($_GET["id_skill"]);


include("../assets/inc/head.php");
include("../assets/inc/header.php");
if(isset($_POST["submit"])){
    $error = $skillController->updateSkill($_POST["id_skill"],$_POST["name"], $_POST["level"], $_FILES["picture"]);
}
var_dump($_POST);
?>
<main class="container">
    <h3 class="text text-center mt-5">Modifier une compétence <?=$skill->name?></h3>
    <?php if(isset($error)){
            if($error["success"]){?>
                <div class="alert alert-success"><?=$error["message"]?></div>
           <?php } else {?>
                <div class="alert alert-danger"><?=$error["message"]?></div>
            <?php }?>
    <?php  }  ?>
    <form action="#" method="POST" class="form-group col-6 offset-3 mt-5" enctype="multipart/form-data">
        <input type="hidden" name="id_skill" value="<?= $skill->id_skill?>">
        <label for="">Nom:</label>
        <input type="text" name="name" class="form-control mb-2" value="<?=$skill->name?>">

        <label for="picture">Photo:</label>
        <input type="file" name="picture" id="picture" class="form-control mb-2"
        accept="image/png, image/jpg, image/webp">

        <label for="level">Niveau</label>
        <input type="text" name="level" class="form-control mb-2" value="<?=$skill->level?>">
        <p>Niveau doit avoir entre 1 et 130</p>

        <button type="submit" name="submit" class="btn btn-success mt-2">Modifier</button>
        <div class="text-end mt-2">
            <a href="/mon_portfolio/admin/gestionSkills.php" class="btn btn-primary">Retour</a>
        </div>
    </form>
</main>