<?php
session_start();
// inclusion controllers;
require_once("../controllers/SkillController.php");
require_once("../controllers/AccountController.php");

define("PAGE_TITLE", "Page Compétence");
$accountController = new AccountController;
$skillController = new SkillController;
//permet de vérifier que l'utilisateur soit connecté
$accountController->isLogged();
if(isset($_POST['submit'])){
   $error = $skillController->create($_POST['name'],$_POST['level'],$_FILES['picture']);
}

include("../assets/inc/head.php");
include("../assets/inc/header.php");
?>
<main class="container-fluid">
    <h3 class="text text-center mt-5">Ajouter une compétence</h3>
    <div class="row col-6 offset-3">
    <?php if(isset($error)){
        if(isset($error["success"])){ ?>
        <div class="alert alert-success"><?= $error["message"]?></div>
    <?php }
        else { ?>
        <div class="alert alert-danger"><?=$error["message"]?></div>
        <?php }
        }
    ?>
        <form action="" class="form-control" method="post" enctype="multipart/form-data">
            <label for="nom">Nom</label>
            <input type="text" name="name" id="nom" class="form-control" accept="image/jpg, image/png, image/jpeg">

            <label for="level">Niveau</label>
            <input type="text" name="level" id="level" class="form-control">

            <label for="picture">Image</label>
            <input type="file" name="picture" id="picture" class="form-control" >

            <button type="submit" name="submit" class="btn btn-success mt-2">Ajouter</button>
        </form>
        <div class="text-end mt-2">
            <a href="/mon_portfolio/admin/gestionSkills.php" class="btn btn-primary">Retour</a>
            <a href="/mon_portfolio/admin/index.php" class="btn btn-primary">Dashboard</a>
        </div>
    </div>
</main>
<?php include("../assets/inc/footer.php");?>