<?php
require_once("controllers/MessageController.php");
$message = new MessageController;
if(isset($_POST['submit'])){
    $error = $message->create($_POST['firstname'],$_POST['lastname'],$_POST['company'],$_POST['content'],$_POST['object'],$_POST['email'],$_POST['phone']);
}
?>


<main class="container-fluid p-5" style="background-color: #B2B2B2;">
<h3 class="text text-center mt-4" id="contact">Contact</h3>
<div class="col-10">
<?php if(isset($error)){
        if(isset($error["success"])){ ?>
        <div class="alert alert-success"><?= $error["message"]?></div>
    <?php }
        else { ?>
        <div class="alert alert-danger"><?=$error["message"]?></div>
        <?php }
        }
    ?>
  </div>
 <form class="col-8 offset-2" method="post" action="">
  <div class="form-row row">
    <div class="form-group col-md-6">
      <label for="nom">Nom</label>
      <input type="text" class="form-control mb-2" id="name" name="lastname" placeholder="Nom:">
    </div>
    <div class="form-group col-md-6">
      <label for="prenom">Prénom</label>
      <input type="text" class="form-control mb-2" id="prenom"  name="firstname" placeholder="Prénom">
    </div>
  </div>
  <div class="form-row">
    <div class="form-row row">
        <div class="form-group col-md-6">
            <label for="company">Entreprise</label>
            <input type="text" class="form-control mb-2" id="company" name="company" placeholder="Entreprise">
        </div>
        <div class="form-group col-md-6">
          <label for="phone">Téléphone</label>
          <input type="string" class="form-control mb-2" id="phone" name="phone" placeholder="0606060606">
        </div>
    </div>
    <div class="form-group ">
            <label for="email">Email</label>
            <input type="email" class="form-control mb-2" id="email" name="email" placeholder="abc@gmail.fr">
        </div>
    <div class="form-group ">
      <label for="object">Object </label>
      <input type="text" class="form-control mb-2" name="object" id="object">
    </div>
    <div class="form-group ">
      <label for="content">Message:</label>
      <textarea class="form-control" name="content" id="content"></textarea>
    </div>
  
  <button type="submit" name="submit" class="btn btn-primary mt-2">Valider</button>
</form>
    
</main>