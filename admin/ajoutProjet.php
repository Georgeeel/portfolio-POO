<?php
session_start();
// require_once("../config/config.php");
define("PAGE_TITLE", "Page projet");
//controllers
require_once("../controllers/SkillController.php");
require_once("../controllers/AccountController.php");
require_once("../controllers/ProjectController.php");

$accountController = new AccountController;
//permet de vérifier que l'utilisateur soit connecté
$accountController->isLogged();

$skillController = new SkillController;
// Récupération de toutes les compétences
$skills = $skillController->readAll();


$projetController = new ProjectController;
if(isset($_POST["submit"]) && isset($_POST["name"]) && isset($_FILES["cover"]) && isset($_POST["description"])
 && isset($_POST["link_site"]) && isset($_POST["link_git"]) && isset($_POST["date_start"]) && isset($_POST["date_end"])){

   $error = $projetController->create($_POST["name"],$_FILES["cover"],$_POST["description"],$_POST["link_site"],$_POST["link_git"],
    $_POST["date_start"],$_POST["date_end"],$_POST["skills"]);
    
 }



include("../assets/inc/head.php");
include("../assets/inc/header.php");
?>
<main class="container-fluid">
    <h3 class="text text-center mt-4">Ajouter une projet</h3>
    <!-- message de confirmation -->
    <?php if(isset($error)){
        if(isset($error["success"])){ ?>
        <div class="alert alert-success"><?= $error["message"]?></div>
    <?php }
        else { ?>
        <div class="alert alert-danger"><?=$error["message"]?></div>
        <?php }
        }
    ?>
    <div class="row col-6 offset-3">
        <form action="" class="form-control mt-4" method="post" enctype="multipart/form-data">
            <label for="nom">Nom</label>
            <input type="text" name="name" id="" class="form-control">

            <label for="cover">Image</label>
            <input type="file" name="cover" id="" class="form-control">

            <label for="description">Description</label>
            <input type="text" name="description" id="" class="form-control">

            <label for="link_git">Lien GitHub</label>
            <input type="url" name="link_git" id="" class="form-control">

            <label for="link_site">Lien Site</label>
            <input type="url" name="link_site" id="" class="form-control">

            <label for="date_start">Date début projet</label>
            <input type="date" name="date_start" id="" class="form-control">

            <label for="date_end">Date fin projet</label>
            <input type="date" name="date_end" id="" class="form-control">

            <label for="skills">Compétences</label>
            <select name="skills[]" id="skills" class="form-control" multiple>
                <?php foreach($skills as $skill) { ?>
                    <option value="<?= $skill->id_skill ?>"><?= $skill->name ?></option>
                <?php } ?>
            </select>
            
            <button type="submit" name="submit" class="btn btn-success mt-2">Ajouter</button>
        </form>
    </div>
</main>
<?php include("../assets/inc/footer.php");?>