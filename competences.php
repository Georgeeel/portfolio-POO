<?php
//Commencer par l'appel du controller 
require("./controllers/SkillController.php");
$controller = new SkillController;
//inclusion de la constante du titre de la page 
 $skills = $controller->readAll();
?>

<main class="container-fluid" style="background-color: #C7C7C7;" >
    <h2 class="text text-center p-3" id="competence">Compétences</h2>
    <div class="row p-5">
        <div class="col-md-7">
            <?php 
                // Afficher les compétences grâce à une boucle
                foreach($skills as $skill){ ?>
                    <!-- nom de compétences -->
                <h6 class="text-center"><?=$skill->name?></h6>    
            <div class="progress col-md-8 offset-2">
                <div class="progress progress-bar progress-bar-striped bg-dark progress-bar-animated" role="progressbar" aria-valuenow="<?=$skill->level?>" aria-valuemin="0" aria-valuemax="135" style="width: <?=$skill->level?>%"></div>
            </div>
            <?php } ?>
        </div>
        <div class="col-md-4 mt-5 my-5">
            <a href="/mon_portfolio/assets/cv/cv_Avramescu_Georgel.pdf" target="_blank" download="cv_Avramescu_Georgel.pdf" class="btn btn-dark btn-lg mt-5">TÉLÉCHARGER MON CV</a>
        </div>
    </div >
</main>


