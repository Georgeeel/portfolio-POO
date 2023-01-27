<?php
//inclusion models 
require_once("./models/ProjectModel.php");
//inclusion la connexion avec la bdd
require_once("./config/config.php");

class ProjectController{

    public function readAll():array{
        global $pdo;
        //la requete pour récupérer toutes les projet 
        $sql = "SELECT * FROM project";
        //préparer la requete 
        $statement = $pdo->prepare($sql);
        //execution
        $statement->execute();

        $resultat = $statement->fetchAll(PDO::FETCH_CLASS,"ProjectModel");

        return $resultat;

    }
}


?>