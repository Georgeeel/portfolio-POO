<?php
require_once(__DIR__."/../config/config.php");
require_once(__DIR__."/../models/SkillModel.php");
require_once(__DIR__."/../models/SkillProjectModel.php");
require_once(__DIR__."/../models/ProjectModel.php");

class SkillController{
    //créer les méthodes permettant des récupérer les skills readAll etc
    public function readAll(){
        global $pdo;
        //reqête sql 
        $sql = "SELECT * FROM skill";

        $statement = $pdo-> prepare($sql);

        $statement->execute();

        $result  = $statement->fetchAll(PDO::FETCH_CLASS,"SkillModel");

        foreach($result as $skill){
            $this->loadProjectsFromSkill($skill);
        }

        return $result;
    }

    public function readOne($id_skill){
        global $pdo;
        //requête pour afficher une compéténce 
        $sql = " SELECT * FROM skill
                WHERE id_skill = :id_skill
                ";
                //   :id = paramètres nommée
        $statement = $pdo->prepare($sql);

        $statement->bindParam(":id_skill",$id_skill,PDO::PARAM_INT);
        //execution de la requête
        $statement->execute();

        $statement->setFetchMode(PDO::FETCH_CLASS,"SkillModel");

        $skill = $statement->fetch();

        $this->loadProjectsFromSkill($skill);

        return $skill;
    }
    //function pour récuperer 
    public function loadProjectsFromSkill(SkillModel $skill)
    {
        global $pdo;
        $sql = "SELECT project.id_project, project.name
                FROM project
                INNER JOIN skill_project
                ON skill_project.id_project = project.id_project
                INNER JOIN skill 
                ON skill.id_skill = skill_project.id_skill
                WHERE skill.id_skill = :id
                ";

        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id", $skill->id_skill, PDO::PARAM_INT);
        $statement->execute();

        $skill->projects = $statement->fetchAll(PDO::FETCH_CLASS,"ProjectModel");
    }
    
   
    public function create($name, $picture,$level){
       if(isset($_FILES["picture"]["tmp_name"]) && $_FILES["picture"]["tmp_name"] == true){
        //1- on récupère l'extension du fichier image à l'aide de pathinfo()
        $extFichier = pathinfo($_FILES["picture"]["name"], PATHINFO_EXTENSION);
        // 2- on crée un nom unique pour l'image
        $picture = "competence_". uniqid() . "." . $extFichier;
        // 3- on déplace l'image pour la mettre dans le dossier /mesImage
        move_uploaded_file($_FILES["picture"]["tmp_name"], "../assets/image/skills/" . $picture);


       }
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

    public function updateSkill($id_skill, $name,$level,$picture){
        //vérification des images
        if(isset($_FILES["picture"]["tmp_name"]) && $_FILES["picture"]["tmp_name"] == true){
            $extFichier = pathinfo($_FILES["picture"]["name"],PATHINFO_EXTENSION);
            $picture = "competence_" . uniqid() . "." .$extFichier;
            move_uploaded_file($_FILES["picture"]["tmp_name"], "../assets/image/skills/" . $picture);
            // supprimer l'ancienne image
        }
        //vérification nom
        if(strlen($name) > 255){
            return [
                "success" =>true,
                "message" => "Le nom doit contenir 255 caractères maximum"
            ];
        }
        if($level > 135 || $level < 1){
            return [
                "success" => true,
                "message" => "Le niveau doit compris entre 1 et 130"
            ];
        }

        global $pdo;
        $sql =" UPDATE skill
                SET `name` = :name,
                `level` = :level,
                `picture` = :picture
                WHERE `id_skill` = :id_skill
                ";
        //préparation de la requete 
        $statement =$pdo->prepare($sql);

        $statement->bindParam(":id_skill",$id_skill);
        $statement->bindParam(":name",$name);
        $statement->bindParam(":level",$level, PDO::PARAM_INT);
        $statement->bindParam(":picture",$picture);

        $statement->execute();

        return[
            "success" => true,
            "message" =>"La compétence à été bien modifié"
        ];

    }

    public function deleteSkill($id){
        global $pdo;
        $sql = "DELETE FROM `skill`
                WHERE `id_skill` = :id
                ";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id",$id, PDO::PARAM_INT);
        $statement->execute();


        return[
            "success" => true,
            "message" => "La compétence à été bien supprimer"
        ];
        header("Location:../admin/index.php");
            exit();
    }
}
?>