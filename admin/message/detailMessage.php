<?php
session_start();
define("PAGE_TITLE", "Détail message");

require_once(__DIR__."/../../controllers/AccountController.php");
$accountController = new AccountController;
$accountController->isLogged();

require_once(__DIR__."/../../controllers/MessageController.php");
$messageController = new MessageController;
$message = $messageController->readOne($_GET["id_message"]);

include("../../assets/inc/head.php");
include("../../assets/inc/header.php");

?>
<main class="container">
    <h3 class="text text-center mt-5">Détail message <?=$message->id_message?></h3>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <cite title="Source Title"><?=$message->firstname?> <?=$message->lastname?></cite><br>
                <p class="text text-end"><small><?=$message->datetime?></small></p>
            </div>
        <cite title="Source Title">Email : <?=$message->email?></cite><br>
            <?php
                if(isset($message->company)){
                echo "<cite title='Source Title'>Entreprise: ". $message->company. "</cite><br>";
                }   
            ?>
             <?php
            if(isset($message->phone)){
               echo "<cite title='Source Title'>Téléphone: ". $message->phone. "</cite><br>";
            }   
        ?>
        </div>
        <div class="card-body">
            <blockquote class="blockquote mb-0">
            <p><?=$message->object?></p>
            <footer class="blockquote-footer"><?=$message->content?></footer>
            </blockquote>
        </div>
    </div>
    <a href="/mon_portfolio/admin/message/index.php" class="btn btn-info mt-2">Retour</a>
</main>