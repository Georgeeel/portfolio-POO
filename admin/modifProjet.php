<?php
session_start();
define('PAGE_TITLE','Modifier un projet');

require_once("../controllers/AccountController.php");
// je ajoute la connexion
$accountController = new AccountController;
$accountController->isLogged();
//skillController
require_once("../controllers/SkillController.php");
$skillController = new SkillController;
$skills = $skillController->readAll();

require_once("../controllers/ProjectController.php");
$projectController = new ProjectController;
//function pour lire un projet
$project = $projectController->readOne($_GET["id_project"]);

if(isset($_POST["submit"]) && isset($_POST["id_project"]) && isset($_POST["name"]) && isset($_FILES["cover"]) && isset($_POST["link_site"]) && isset($_POST["link_git"]) && isset($_POST["description"]) && isset($_POST["date_end"]) && isset($_POST["date_start"]) && isset($_POST["skills"])){
    $error = $projectController->updateProjet($_POST["id_project"],$_POST["name"],$_FILES["cover"],$_POST["link_site"],$_POST["link_git"],$_POST["description"],$_POST["date_end"],$_POST["date_start"],$_POST["skills"]);
}
var_dump($_POST);


include("../assets/inc/head.php");
include("../assets/inc/header.php");

?>
<main class="container">
    <h4 class="text text-center mt-4">Modifier un projet </h4>
    <div class="row col-6 offset-3">
        <?php if(isset($error)){
            if($error["success"]){ ?>
                <div class="alert alert-success"><?=$error["message"]?></div>
            <?php } else {?>
                <div class="alert alert-danger"><?=$error["message"]?></div>
            <?php  } ?>
        <?php } ?>
        <form action="" class="form-control mt-4" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_project" value="<?=$project->id_project?>">
            <label for="nom">Nom</label>
            <input type="text" name="name" id="nom" class="form-control" value="<?=$project->name?>">

            <label for="cover">Image</label>
            <input type="file" name="cover" class="form-control" accept="image/png, image/jpg, image/webp">

            <label for="description">Description</label>
            <input type="text" name="description" id="description" class="form-control" value="<?=$project->description?>">

            <label for="link_git">Lien GitHub</label>
            <input type="url" name="link_git" id="link_git" value="<?=$project->link_git?>" class="form-control">

            <label for="link_site">Lien Site</label>
            <input type="url" name="link_site" id="link_site" value="link_site" class="form-control">

            <label for="date_start">Date début projet</label>
            <input type="date" name="date_start" id="date_start" value="<?=$project->date_start?>"class="form-control">

            <label for="date_end">Date fin projet</label>
            <input type="date" name="date_end" id="date_end" value="<?=$project->date_end?>" class="form-control">

            <label for="skills">Compétences</label>
            <select name="skills[]" id="skills" class="form-control" multiple >
                <?php foreach($skills as $skill) { ?>
                    <option value="<?= $skill->id_skill ?>"><?= $skill->name ?></option>
                <?php } ?>
            </select>
            <button type="submit" name="submit" class="btn btn-success mt-2">Modifier</button>
            <div class="text-start mt-2">
                <a href="/mon_portfolio/admin/gestionProjet.php" class="btn btn-primary">Retour</a>
            </div>
        </form>
    </div>
</main>

<?php include("../assets/inc/footer.php");?>

