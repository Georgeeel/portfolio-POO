<?php
//Contoller
require_once("./controllers/ProjectController.php");
$controller = new ProjectController;

//titre de la page
define("PAGE_TITLE", "Detail");
$project = $controller->readOne($_GET['id']);

?>

<!-- inclusion partials -->
<?php include("./assets/inc/head.php");?>
<?php include("./assets/inc/header.php");?>

<main>
    <div class="slider">
        <div class="slides">
            <div class="slide"><img src="/mon_portfolio/assets/image/mesImage/destkop_fast_food.png" alt=""></div>
            <div class="slide"><img src="/mon_portfolio/assets/image/mesImage/tablette_fast_food.png" alt=""></div>
            <div class="slide"><img src="/mon_portfolio/assets/image/mesImage/phone_fast_food.png" alt=""></div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <h1>test</h1>
            <h3><?=$project->name?></h3>
        </div>
        <h3>Compétences</h3>

        <?php foreach($project->skills as $skill){?>
            <li><?= $skill->name ?></li>
        <?php } ?>
    </div>
</main>
<?php include("./assets/inc/footer.php");?>