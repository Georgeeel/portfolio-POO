<?php
session_start();
define("PAGE_TITLE", "Messagerie");

require_once(__DIR__."/../../controllers/AccountController.php");
$accountController = new AccountController;
$accountController->isLogged();

require_once(__DIR__."/../../controllers/MessageController.php");
$messagesController = new MessageController;
$messages = $messagesController->readAll();
include("../../assets/inc/head.php");
include("../../assets/inc/header.php");
?>
<main class="container">
    <h3 class="text text-center mt-5">MESSAGES</h3>
    <table class="table table-hover table-light mt-5">
        <tr>
            <th scope="row">Nom</th>
            <th scope="row">Prénom</th>
            <th scope="row">Email</th>
            <th scope="row">Sujet</th>
            <th scope="row">Action</th>
        </tr>
        <tr>
            <?php foreach($messages as $message){?>
                <td><?=$message->firstname?></td>
                <td><?=$message->lastname?></td>
                <td><?=$message->email?></td>
                <td><?=$message->object?></td>
                <td class="d-flex">
                    <form action="detailMessage.php" method="get">
                        <button type="submit" value="<?=$message->id_message?>" class="mx-2" name="id_message">&#128269;</button>
                    </form>
                    <form action="supprimerMessage.php" method="get">
                        <button type="submit" value="<?=$message->id_message?>" name="id_message">&#128686;</button>
                    </form>
                </td>
        </tr>
            <?php } ?>


    </table>
     
</main>