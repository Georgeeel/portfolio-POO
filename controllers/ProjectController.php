<?php
//inclusion la connexion avec la bdd
require_once(__DIR__."/../config/config.php");
//inclusion models 
require_once(__DIR__."/../models/ProjectModel.php");
require_once(__DIR__."/../models/PictureModel.php");
require_once(__DIR__."/../models/SkillModel.php");



class ProjectController{
     
    public function readAll():array{
        global $pdo;
        //la requête pour récupérer toutes les projets
        $sql = "SELECT * FROM project";
        //préparer la requete 
        $statement = $pdo->prepare($sql);
        //execution
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_CLASS,"ProjectModel");

        foreach($result as $project){
            $this->loadSkillsFromProject($project);
        }
        
        return $result;

    }

    public function readOne($id):ProjectModel{
        global $pdo;
        //requête pour afficher un projet 
        $sql = "SELECT * FROM project
                WHERE id_project = :id
                ";
                //                  id = paramètres nommée
        $statement = $pdo->prepare($sql);

        $statement->bindParam(":id",$id,PDO::PARAM_INT);
        //execution de la requête
        $statement->execute();

        $statement->setFetchMode(PDO::FETCH_CLASS,"ProjectModel");

        $result = $statement->fetch();


        // Requête pour récupération des images
        $sql = "SELECT * FROM picture
                WHERE id_project = :id
                ";

        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id", $id,PDO::PARAM_INT);
        $statement->execute();

        $result->pictures = $statement->fetchAll(PDO::FETCH_CLASS, "PictureModel");

        //requête récupération des skills
        $this->loadSkillsFromProject($result);

        return $result;
    }
    public function loadSkillsFromProject(ProjectModel $project){
        global $pdo;

        $sql = "SELECT 
            skill.id_skill, skill.name, skill.level, skill.picture
        FROM skill
        INNER JOIN skill_project ON skill_project.id_skill = skill.id_skill
        INNER JOIN project ON project.id_project = skill_project.id_project
        WHERE project.id_project = :id
        ";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id", $project->id_project, PDO::PARAM_INT);
        $statement->execute();
        $project->skills = $statement->fetchAll(PDO::FETCH_CLASS,"SkillModel");

    }

    public function create($name,$cover,$link_site,$link_git,$description,$date_end,$date_start, $skills){
        //verification $_FILES
        if(isset($_FILES['cover']['tmp_name']) && $_FILES['cover']['tmp_name'] == true){
            $extFichier = pathinfo($_FILES['cover']["name"],PATHINFO_EXTENSION);
            $cover = 'cover_'. uniqid() . "." . $extFichier;
            move_uploaded_file($_FILES['cover']['tmp_name'], "../assets/image/projects/" . $cover);
            
        }
        //vérification de URL
        if(!filter_var($link_site,FILTER_VALIDATE_URL) == false){
            
            return [
                "success" => false,
                "message" => "Lien incorrect"
            ];
        }
        global $pdo;
        $sql = "INSERT INTO project
                (
                    name,
                    cover,
                    link_site,
                    link_git,
                    description,
                    date_start,
                    date_end
                )
                VALUES
                (
                    :name,
                    :cover,
                    :link_site,
                    :link_git,
                    :description,
                    :date_start,
                    :date_end
                )
                ";

        $name = htmlspecialchars(trim(ucfirst($_POST['name'])));
        $link_git = htmlspecialchars(trim(ucfirst($_POST['link_git'])));
        $description = htmlspecialchars(trim(ucfirst($_POST['description'])));
        $date_start = htmlspecialchars(trim($_POST['date_start']));
        $date_end = htmlspecialchars(trim($_POST['date_end']));

        $statement = $pdo->prepare($sql);
        //parametres nommés
        $statement->bindParam(":name",$name);
        $statement->bindParam(":cover",$cover);
        $statement->bindParam(":description",$description);
        $statement->bindParam(":date_start",$date_start);

        //si la $date_end est vide, il prend par default la valeur null
        $date_end = ($date_end == '' ? null : $date_end);
        $statement->bindParam(":date_end",$date_end);

        $link_site = ($link_site == '' ? null : $link_site);
        $statement->bindParam(":link_site",$link_site);

        $link_git = ($link_git == '' ? null : $link_git);
        $statement->bindParam(":link_git",$link_git);

        $statement->execute();
        
        $id_project = $pdo->lastInsertId();
        if(count($skills)> 0){
            foreach($skills as $id_skill){
                $sql = "INSERT INTO skill_project
                (id_project, id_skill)
                VALUES
                (:id_project, :id_skill)";

                $statement = $pdo->prepare($sql);

                $statement->bindParam(":id_project", $id_project);
                $statement->bindParam(":id_skill", $id_skill);
                $statement->execute();
            }
        }
        return [
            "success" => true,
            "message" => "Un nouveau projet à été crée"
        ]; 

    }
    public function updateProjet($id_project,$name,$cover,$link_site,$link_git,$description,$date_end,$date_start,$skills){
        //vérification image
        if(isset($_FILES['cover']['tmp_name']) && $_FILES['cover']['tmp_name'] == true){
            $extFichier = pathinfo($_FILES['cover']["name"],PATHINFO_EXTENSION);
            $cover = 'cover_'. uniqid() . "." . $extFichier;
            move_uploaded_file($_FILES['cover']['tmp_name'], "../assets/image/projects/" . $cover);
        } 
        //vérification email
        if(!filter_var($link_site,FILTER_VALIDATE_URL) == false){
            
            return [
                "success" => false,
                "message" => "Lien incorrect"
            ];
        }
        global $pdo;
        $sql ="UPDATE project
                SET `name`= :name,
                    `cover`= :cover,
                    `link_site`= :link_site,
                    `link_git`= :link_git,
                    `description`= :description,
                    `date_end`= :date_end,
                    `date_start`= :date_start
                WHERE `id_project`= :id_project
                ";

        $statement = $pdo->prepare($sql);
        //parametres nommés
        $statement->bindParam(":id_project",$id_project);
        $statement->bindParam(":name",$name,PDO::PARAM_STR);
        $statement->bindParam(":description",$description,PDO::PARAM_STR);
        $statement->bindParam(":date_start",$date_start);
    
        //si la $date_end est vide, il prend par default la valeur null
        //$date_end = ($date_end == '' ? null : $date_end);
        $statement->bindParam(":date_end",$date_end);
    
        $link_site = ($link_site == '' ? null : $link_site);
        $statement->bindParam(":link_site",$link_site);
    
        $link_git = ($link_git == '' ? null : $link_git);
        $statement->bindParam(":link_git",$link_git);

        $cover = ($cover == '' ? null : $cover);
        $statement->bindParam(":cover",$cover);
    
        $statement->execute();

        
        //je recuper  dernier id inserer 
        $id_project = $pdo->lastInsertId();
        if(count($skills)> 0){
            foreach($skills as $id_skill){
                $sql = "UPDATE skill_project
                        SET `id_skill` = :id_skill
                        WHERE `id_project` = :id_project
                ";
                $statement = $pdo->prepare($sql);
    
                $statement->bindParam(":id_project", $id_project);
                $statement->bindParam(":id_skill", $id_skill);
                $statement->execute();
            }
        }
        return [
            "success" => true,
            "message" => "Le projet" .$name ."à été bien modifier"
        ];
    }

    public function deleteProjet($id_project){
        global $pdo;
        $sql = "DELETE FROM project
                WHERE id_project = :id_project";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id_project",$id_project,PDO::PARAM_INT);
        $statement->execute();

        return[
            "success" => true,
            "message" => "Le projet à été bien supprimer"
        ];
        header("Location:../admin/index.php");
            exit();
    }
   
}

?>