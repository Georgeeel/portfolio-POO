<?php
session_start();

define("PAGE_TITLE", "Connexion");
require_once("../controllers/AccountController.php");
$controller = new AccountController;

if(isset($_POST["valider"]) && isset($_POST["email"]) && isset($_POST['password'])){
    //quand on valide le formulaire 
    $error = $controller->login($_POST['email'],$_POST['password']);
    
}

//LEs deux lignes suivantes permettent d'ajouter un nouveau admin avec la date par default
//$result = $controller->create("toto@outlook.fr","Cristaline10@");
//var_dump($result);

?>
<?php include("../assets/inc/head.php");?>
<?php include("../assets/inc/header.php");?>

<main class="container">
    <h4 class="text text-center mt-5">Bienvenue</h4>
    <div class="row col-6 mt-5 offset-3">
        <!-- message en cas d'erreur  -->
    <?php if(isset($error)){?>
        <div class="alert alert-danger">
            <?=$error["message"]?>
        </div>
    <?php } ?>
    <form action="" method="POST" class="form-control">
        <label for="email">Email</label>
        <input type="email" name="email" id="" class="form-control">
        <label for="pass">Password</label>
        <input type="password" name="password" id="pass" class="form-control">
        <button type="submit" name="valider" class="btn btn-dark mt-3">Se connecter</button>
    </form>
    </div>
</main>
<?php include("../assets/inc/footer.php");?>