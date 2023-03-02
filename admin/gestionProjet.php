<?php
session_start();
define('PAGE_TITLE','Gestion des projets');

//controllers
require_once("../controllers/AccountController.php");
require_once("../controllers/ProjectController.php");

$accountController = new AccountController;
$accountController->isLogged();

$projetController = new ProjectController;
$projets = $projetController->readAll();


include("../assets/inc/head.php");
include("../assets/inc/header.php");

?>

<main class="container">
    <h4 class="text text-center mt-4">Gestion des projets</h4>
    <div class=" text text-start">
        <a href="/mon_portfolio/admin/ajoutProjet.php" class="btn btn-success mx-4">Ajouter un projet</a>
        <a href="/mon_portfolio/admin/index.php" class="btn btn-primary">Dashboard</a>
    </div>
    <table class="table table-striped table-secondary mt-4">
        <tr class="text text-center">
            <th scope="col">Image</th>
            <th scope="col">Nom</th>
            <th scope="col">Date de début</th>
            <th scope="col">Date de fin</th>
            <th scope="col">Lien site</th>
            <th scope="col">Lien GitHub</th>
            <th scope="col">Action</th>
        </tr>
        <?php foreach($projets as $projet){ ?>
            <tr class="text text-center">
                <td style="width:20%;height:20%;"><img style="width:30%;height:20%;" src="../assets/image/projects/<?= $projet->cover ?>"alt="Couverture de <?= $projet->name ?>"></td>
                <td><?= $projet->name ?></td>
                <!-- Date début site -->
                <td><?= $projet->displayDateStart()?></td>
                <!-- la date fin de projet si est finit -->
                <td>
                    <?php if(isset($projet->date_end)){ ?>
                        <?= $projet->displayDateEnd()?>
                    <?php } else { ?>
                        <p class="text text-center">En cours</p>
                    <?php } ?>
                </td>
                <td>
                <!-- si le site il est en ligne -->
                    <?php if(isset($projet->link_site)){?>
                        <?= $projet->link_site?>
                   <?php } else { ?>
                        <p class="text text-center">-</p>
                   <?php } ?>
                </td>
                <td>
                    <?php if(isset($projet->link_git)){?>
                        <a href="<?=$projet->link_git ?>">GitHub</a>
                    <?php } else { ?>
                        <p class="text text-center">-</p>
                    <?php } ?>
                </td>
                <td>
                    <form action="/mon_portfolio/admin/modifProjet.php/" method="get">
                        <button type="submit" class="btn bg-warning" name="id_project" value="<?=$projet->id_project?>">&#128393;</button>
                    </form>
                    <form action="/mon_portfolio/admin/supprimerProjet.php" method="GET">
                        <button type="submit" name="id_project" class=" btn btn-danger mt-2" value="<?=$projet->id_project?>">&#128686;</button>
                    </form>
                </td>    
            </tr>
        <?php } ?>
    </table>
</main>