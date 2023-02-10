<?php
//Commencer par l'appel du controller 
//require(controllers/...)
//inclusion inc(head,header,footer)
//inclusion du controller 
require("./controllers/ProjectController.php");
define("PAGE_TITLE", "Projets");
//instanciation de notre controller
$controller = new ProjectController;
// j'appelle de la méthode permettant de récupérer la methode readAll
$projects = $controller->readAll();
?>

<?php include("./assets/inc/head.php");?>
<?php include("./assets/inc/header.php");?>

<main>
    <div class="container">
        <div class="row justify-content-around">
            <?php foreach($projects as $project){?>
            <div class="card border-dark my-4" style="width: 18rem;">
                <img src="./assets/image/projects/<?= $project->cover ?>" class="pic-card" alt="Couverture de <?= $project->name ?>">
                <h5 class="card-title mt-3 mb-3 text-center"><?=$project->name?></h5>
                <p class="card-text">This is a company that builds websites, web apps and e-commerce solutions.</p> 
                <div class="d-flex justify-content-between">
                    <div >
                        <?php foreach($project->skills as $skill){?>
                            <b><?=$skill->name?></b>
                        <?php } ?>
                    </div>
                    <div>
                        <!-- si mon projet existe sur en server  il affiche le lien // à rajouter des favicons-->
                        <?php if(isset($project->link_site)){?>
                            <a  href="<?=$project->link?>"><img src="./assets/image/mesImage/link-30.png" alt=""></a>
                        <?php } ?>
                        <!-- à rajouter des favicons -->
                        <?php if(isset($project->link_git)){?>   
                            <a  href="https://github.com/Georgeeel"><img src="./assets/image/mesImage/icons8-github-30.png" alt=""></a>
                        <?php }?>
                    </div> 
                </div>
                <div class="d-flex justify-content-between">
                    <div class="my-3 text-muted">
                        Date :
                            <?= $project->displayDateStart() ?>
                            <?php if(isset($projet->date_end)) { ?>
                                <?= $project->displayDateEnd() ?>
                            <?php } ?>
                    </div>
                    <div>
                        <a href="/mon_portfolio/projet/<?= $project->id_project ?>"><button class="btn bg-secondary my-2" type="submit">Afficher</button></a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</main>

<?php include("./assets/inc/footer.php");?>