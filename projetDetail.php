<?php 

// Commencer par l'appel du controller
require("./controllers/projectController.php");

// Instanciation de notre controller
$controller = new ProjectController;


// Appel de la méthode permettant de récupérer les détails du projet
$project = $controller->readOne($_GET["id"]);


// Définition de la constante du titre de la page, que nous utilisons dans le head
define("PAGE_TITLE", "Détails");

?>
<?php include ("./assets/inc/head.php") ?>
<?php include ("./assets/inc/header.php") ?>
<main>
    <div class="text-center">
        <h1 class="mt-4 mb-5">Détails du projet :<br> <?= $project->name ?> </h1>
        <div class="container ">
            <div class="row ">
                <div class="col">
                    <div id="carouselDetail" class="carousel slide" data-bs-ride="carousel">
                        
                        <div class="carousel-inner">

                            <?php foreach($project->pictures as $key=>$picture){
                            ?>

                            <div class="carousel-item <?= ($key == 0 ? 'active' : '')?> ">
                                <img src="../assets/image/mesImage/<?=$picture->path ?>" alt="<?=$picture->alt?>" class="picture_carousel">
                                <div class="carousel-caption d-none d-md-block">
                                    <p><?=$picture->caption ?></p>
                                </div>
                            </div>
                            
                            <?php
                            } 
                            ?>

                            <button class="carousel-control-prev " type="button" data-bs-target="#carouselDetail" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden ">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselDetail" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col my-auto">
                    <h5> Description </h5>
                    <p><?= $project->description ?></p>
                    <p>Créé le : <?= $project->displayDateStart() ?> </p>
                    <?php if(isset($projet->date_end)) { ?>
                        <p> Fini le :
                        <?= $project->displayDateEnd() ?>
                        <?php } ?></p>
                        <div class="row justify-content-center mb-4 ">
                            <p class="mb-1">Compétences utilisées:</p>
                            <?php foreach($project->skills as $skill)
                                { ?>
                                <div  class="col-2 ">
                                     <?= $skill->name ?>
                                </div>
                           <?php }?>
                        </div>   
                        <a href= <?= $project->link_git ?> class="btn btn-dark">Lien Github</a>
                        <a href=<?= $project->link_site ?> class="btn btn-dark">Lien Site</a>
                                      
                </div>
            </div>
        <div class="container mt-5 mb-3">
        <a href= "/mon_portfolio/index.php"class="btn btnProject">Retour</a>
        </div>
   
</main>

<?php include ("./assets/inc/footer.php") ?>