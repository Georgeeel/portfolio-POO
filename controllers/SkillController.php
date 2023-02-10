<?php
require_once(__DIR__."/../config/config.php");
require_once(__DIR__."/../models/SkillModel.php");
require_once(__DIR__."/../models/SkillProjectModel.php");


class SkillController{
    //créer les méthodes permettant des récupérer les skills readAll etc
    public function readAll(){
        global $pdo;
        //reqête sql 
        $sql = "SELECT * FROM skill";

        $statement = $pdo-> prepare($sql);

        $statement->execute();

        $result  = $statement->fetchAll(PDO::FETCH_CLASS,"SkillModel");

        return $result;
    }

    public function readOne($id){
        global $pdo;
        //requête pour afficher un projet 
        $sql = "SELECT * FROM skill
                WHERE id_skill = :id
                ";
                //                  id = paramètres nommée
        $statement = $pdo->prepare($sql);

        $statement->bindParam(":id",$id,PDO::PARAM_INT);
        //execution de la requête
        $statement->execute();

        //$statement->setFetchMode(PDO::FETCH_CLASS,"SkilltModel");

        $result = $statement->fetch();

        return $result;
    }
    // public function readCompetence(){
    //     global $pdo;

    //     $sql = "SELECT project.id_project, project.name, project.link_git, skill.id_skill, skill.name
    //             FROM project
    //             LEFT JOIN skill_project ON project.id_project = skill_project.id_project
    //             LEFT JOIN skill ON skill_project.id_skill = skill.id_skill
    //             ";
    //     $statement = $pdo->prepare($sql);
    //     $statement->execute();

    //     $result = $statement->fetchAll();
    //     return $result;
       
    // }
    public function create($name, $picture,$level){
        
       if(isset($_FILES["picture"]["tmp_name"]) && $_FILES["picture"]["tmp_name"] == true){
        //1- on récupère l'extension du fichier image à l'aide de pathinfo()
        $extFichier = pathinfo($_FILES["picture"]["name"], PATHINFO_EXTENSION);
        // 2- on crée un nom unique pour l'image
        $picture = "competence_". uniqid() . "." . $extFichier;
        // 3- on déplace l'image pour la mettre dans le dossier /mesImage
        move_uploaded_file($_FILES["picture"]["tmp_name"], "../assets/image/skills/" . $picture);


       }
        global $pdo;
        $name = htmlspecialchars(trim(ucfirst($_POST['name'])));
        $level = htmlspecialchars(trim(ucfirst($_POST['level'])));

       global $pdo;

        $sql = "INSERT INTO  skill 
                (
                    level,
                    name,
                    picture
                ) 
                VALUES
                (   :level,
                    :name,
                    :picture
                )";
        $statement = $pdo->prepare($sql);

        $statement ->bindParam(":level",$level);
        $statement ->bindParam(":name", $name);
        $statement ->bindParam(":picture",$picture);

        $statement->execute();

        return [
            "success" => true,
            "message" => "Compétence ajoutée !"
        ];

    }
   
}



?>