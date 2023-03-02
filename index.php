<?php
//Commencer par l'appel du controller 
//require(controllers/...)
//définition de la constante du titre de la page , que nous utilisons dans le head
define("PAGE_TITLE", "Accueil");
?>

<?php include("./assets/inc/head.php");?>
<?php include("./assets/inc/header.php");?>


<main class="container-fluid" id="introduction" > 
    <section class="d-flex flex-column justify-content-center">
      <div class="col-md-12 text-center">
          <h2 class="text text-danger pt-5">Avramescu Georgel</h2>
          <hr>
          <h3 class="pb-4">Développeur web junior - Intégrateur</h3>
          <a href="#contact" class="btn btn-dark btn-lg">Me contacter</a>
      </div>
    </section>
</main>
  <?php include("apropos.php") ?>
  <?php include("competences.php") ?>
  <?php include("projets.php") ?>
  <?php include("contact.php") ?>

<?php include("./assets/inc/footer.php");?>
