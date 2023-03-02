<?php
require_once(__DIR__."/../config/config.php");

require_once(__DIR__."/../models/MessageModel.php");

class MessageController{

    public function create($firstname, $lastname,$company,$object,$content,$email,$phone){
        //vérification des données 
        if(strlen($firstname)> 50){
            return [
                "succes" => false,
                "message" => "Le prénom doit contenir 50 caractères maximum"
            ];
        }
        if(strlen($lastname)> 50){
            return [
                "succes" => false,
                "message" => "Le nom de famille doit contenir 50 caractères maximum"
            ];
        }
        if(strlen($company)> 50){
            return [
                "succes" => false,
                "message" => "Le nom de entreprise doit contenir 50 caractères maximum"
            ];
        }
        if(strlen($object)> 255){
            return [
                "succes" => false,
                "message" => "Le sujer du message doit contenir 255 caractères maximum"
            ];
        }
        if(strlen($email)> 255){
            return [
                "succes" => false,
                "message" => "Le sujet du message doit contenir 255 caractères maximum"
            ];
        }
        //vérification email
       if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        return [
            "succes" => false,
            "message" => "Email incorrect"
        ];
       }
       if($phone != "" && !preg_match("~^(0[1-7][0-9]{8})$~",$phone)){
        return [
            "succes" => false,
            "message" => "Numéro de téléphone est incorrect"
        ];
       }
       //insertion du message dans la base de données
       global $pdo;

       $sql = "INSERT INTO message
                (firstname,lastname,company,object,content,email,phone)
                VALUES
                (:firstname,:lastname,:company,:object,:content,:email,:phone)
                ";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":firstname",$firstname);
        $statement->bindParam(":lastname",$lastname);
        $statement->bindParam(":object",$object);
        $statement->bindParam(":content",$content);
        $statement->bindParam(":email",$email);

        $company = ($company == "" ? null : $company);
        $statement->bindParam(":company",$company);

        $phone = ($phone == "" ? null : $phone);
        $statement->bindParam(":phone",$phone);

       $statement->execute();

       if(strlen($email)> 255){
        return [
            "succes" => false,
            "message" => "Le  message à était envoyé"
        ];
    }
        
    }
    public function readAll(){
        global $pdo;
        //je recuper  tout les messages
        $sql = "SELECT * FROM message";
        //preparation de la requête 
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $resultat = $statement->fetchAll(PDO::FETCH_CLASS, "MessageModel");
        return $resultat;

    }

    public function readOne($id){
        global $pdo;

        $sql = "SELECT * FROM message
                WHERE id_message = :id
                ";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id",$id,PDO::PARAM_INT);
        $statement->execute();

        $statement->setFetchMode(PDO::FETCH_CLASS, "MessageModel");
        $resultat = $statement->fetch();
        
        return $resultat;
    }

    public function deleteMess($id){
        global $pdo;

        $sql = "DELETE FROM message
                WHERE id_message = :id
                ";
                
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id",$id,PDO::PARAM_INT);
        $statement->execute();

        return [
            "success" => true,
            "message" => "Le message à été bien supprimer" 
        ];
        header("Location: /mon_portfolio/admin/message/index.php");
        exit();
    }
}

?>