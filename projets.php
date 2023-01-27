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
        <h1 class="text text-center mt-4">Project</h1>
    <div class="row">
        <table>
            <!-- <?php var_dump($projects)?> -->
        </table>
    </div>
</div>

</main>

<?php include("./assets/inc/footer.php");?>
