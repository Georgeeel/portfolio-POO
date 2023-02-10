<?php
require_once("../models/AccountModel.php");
require_once("../config/config.php");


//ce controller nous servira à créer de nouveaux compte, à nous connecter, et à vérifier la connexion 
//quand on navigue dans la partie admin du site
class AccountController{

    public function create(string $email, string $password){
        //vérification de l'email
       if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        //quand le function il trouve un return et il est false la function s'arret
        return [
            "success" => false,
            "message" => "Email incorrect"
        ];
        //verification de mot de passe
        if(strlen($password)< 8){
            return [
                "succes" => false,
                "message" => "Mot de pass trop court"
            ];
        }
        //vérification force pour la mot de passe 
        if(!preg_match("~^\S*(?=\S*[a-zA-Z])(?=\S*[0-9])(?=\S*[\W])\S*$~",$password)){
            return [
                "success" => false,
                "message"=> "Le mot de passe doit contenir au moins une lettre, un chiffre
                et un character spécial"
            ];
        }

       }
        // Si nous sommes arrivés jusque là, c'est que notre nouvel account est correct : insérons-le dans la base de données !
        global $pdo;

        $sql = "INSERT INTO account
                (email, password)
                VALUES
                (:email, :password)
                ";
        $statement = $pdo->prepare($sql);

        //hachage de mot de passe avant d'inseration dans la bdd
        $password = password_hash($password,PASSWORD_DEFAULT);

        $statement->bindParam(":email",$email);
        $statement->bindParam(":password", $password);

        $statement->execute();

        // Renvoi d'un tableau associatif permettant de connaître le succès (ou non) de la méthode
        return [
            "success" => true,
            "message" => "Compte utilisateur crée"
        ]; 
    }

    public function login(string $email, string $password){
        global $pdo;
        //Première étape : récupére un compte utilsateur correspondant à cet email
        $sql = "SELECT *
                FROM account
                WHERE email = :email
                ";
        $statement = $pdo->prepare($sql);
        
        $statement->bindParam(":email",$email);
        $statement->execute();

        //vérifion si au moins un compte à été trouvé
        if($statement->rowCount() > 0){
            //deuxième étape: vérifier le mot de passe
            $statement->setFetchMode(PDO::FETCH_CLASS,"AccountModel");
            $account = $statement->fetch();

            if(password_verify($password, $account->password)){
                // la personne est connectée
                //grâce à la session email on sait est-se que la personne est connecté
                $_SESSION["email"] = $account->email;
                header("Location: /mon_portfolio/admin/index.php");
                exit();

            } 
            else {
                return[
                    "success" =>false,
                    "message" =>"Mot de passe invalide"
                ];
            }
        }
        else{
            return [
                "success" => false,
                "message" =>"Email incorrect"
            ];
        }
        

    }

    public function isLogged(){
        //permet de vérifier qu'un utilisateur soit connecté afin d'accéder à l'interface d'admin
        if(isset($_SESSION["email"])){
            //la personne est connectée
            return true;
        }else{
            //la personne n'est pas connectée
            header("Location: mon_portfolion/admin/connexion.php");
        }
    }

}


?>