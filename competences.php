<?php
//Commencer par l'appel du controller 
require("./controllers/SkillController.php");
$controller = new SkillController;
//inclusion de la constante du titre de la page 
define("PAGE_TITLE", "Compétences");

 $skills = $controller->readAll();
?>

<?php include("./assets/inc/head.php");?>
<?php include("./assets/inc/header.php");?>

<main class="container">
        <h2 class="text text-center mt-3">Compétences</h2>
        <div class="row col-6">
                <?php 
                // Afficher les compétences grâce à une boucle
                foreach($skills as $skill){
                ?>
                <!-- nom de compétences -->
                <a href="/mon_portfolio/competence/<?=$skill->id_skill?>" class="text-decoration-none text-dark fw-bold"
                type="submit"><?=$skill->name?></a>
            
            <div class="progress mt-2">
                <div class="progress-bar progress-bar-striped bg-dark progress-bar-animated" role="progressbar" aria-valuenow="<?=$skill->level?>" aria-valuemin="0" aria-valuemax="135" style="width: <?=$skill->level?>%"></div>
            </div>
            <?php } ?>
        </div>
        <div class="d-flex justify-content-end">
                    <h4>CV à ajouter</h4>
        </div>
</main>

<?php include("./assets/inc/footer.php");?>
