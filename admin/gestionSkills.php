<?php
session_start();
define('PAGE_TITLE','Gestion des compétences');
//inclusion controller
require_once("../controllers/AccountController.php");
require_once("../controllers/SkillController.php");
//récupérer les compéténces et la function readAll pour afficher toutes mes compétencess* 
$accountController = new AccountController;
$accountController->isLogged();

$skillController = new SkillController;
$skills = $skillController->readAll();

include("../assets/inc/head.php");
include("../assets/inc/header.php");

?>
<main class="container">
    <h3 class="text text-center mt-4">Gestion des compétences</h3>
    <div class="text-start">
        <a href="/mon_portfolio/admin/ajoutCompetence.php" class="btn btn-dark mx-">Ajouter une compétence</a>
        <a href="/mon_portfolio/admin/index.php" class="btn btn-primary">Dashboard</a>
    </div>
    <table class="table table-striped table-light mt-5">
        <tr class="text text-center">
            <th scope="col">Photo</th>
            <th scope="col">Nom</th>
            <th scope="col">Action</th>
        </tr>
        <?php foreach($skills as $skill){?>
        <tr class="text text-center">
                <td style="width:30%;height:20%;"><img style="width:30%;height:30%;" src="../assets/image/skills/<?= $skill->picture ?>"></td>
                <td><?= $skill->name ?></td>
                <td >
                <form action="/mon_portfolio/admin/detailCompetence.php/" method="get">
                        <button type="submit" class="bg-dark"  value="<?=$skill->id_skill?>" name="id_skill">&#128269;</button>
                    </form>
                    <form action="/mon_portfolio/admin/modifierSkill.php/" method="get">
                        <button type="submit" class="mt-2 bg-success " value="<?=$skill->id_skill?>" name="id_skill">&#128393;</button>
                    </form>
                    <form action="/mon_portfolio/admin/supprimerSkill.php/" method="get">
                        <button type="submit" class="mt-2 bg-danger" value="<?=$skill->id_skill?>" name="id">&#128686;</button>
                    </form>
                </td>
        </tr>
        <?php } ?>
    </table>
</main> 