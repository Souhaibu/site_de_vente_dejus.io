<?php
class Database {
    // Spécifiez les informations de votre base de données
    private $host = "localhost";
    private $db_name = "xelima_jus";
    private $username = "root";
    private $password = "";
    public $connexion;

    // Méthode pour obtenir la connexion à la base de données
        public function getConnection() {
            $this->connexion = null;
    
            try {
                $this->connexion = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo "Erreur de connexion : " . $e->getMessage();
            }
    
            return $this->connexion;
        }
    
        public function prepare($sql) {
            return $this->connexion->prepare($sql);
        }
    
    public function inscription($nom, $prenom, $adresse, $tel, $email, $pwd, $profil) {
        try {
            $query = "INSERT INTO User (nom, prenom, adresse, tel, email, pwd,profil) VALUES (?, ?, ?, ?, ?, ?,?)";
            $stmt = $this->connexion->prepare($query);
    
            // Liaison des valeurs et exécution de la requête préparée
            $default_value = '0'; // Valeur par défaut 
            $stmt->bindParam(1, $nom);
            $stmt->bindParam(2, $prenom);
            $stmt->bindParam(3, $adresse);
            $stmt->bindParam(4, $tel);
            $stmt->bindParam(5, $email);
            $stmt->bindParam(6, $pwd);
            $stmt->bindParam(7, $profil);
    
            // Exécution de la requête
            $stmt->execute();
    
            return 1; // Succès de l'insertion
        } catch (\PDOException $th) {
            // Gestion des erreurs
            die($th->getMessage()); // Afficher l'erreur pour le débogage
            return 0; // Échec de l'insertion
        }
    }
    

    public function connexion($email, $pwd){
        try {
            // Préparez la requête de sélection
            $query = "SELECT * FROM `User` WHERE email=?";
            $selection = $this->connexion->prepare($query);
    
            // Exécutez la requête en passant l'email
            $selection->execute([$email]);
            $result = $selection->fetch(PDO::FETCH_ASSOC);
    
            // Vérifiez si l'utilisateur a été trouvé et si le mot de passe correspond
            if ($result && password_verify($pwd, $result['pwd'])) {
                // Retournez les résultats de la requête
                return $result;
            } else {
                // Aucun utilisateur correspondant ou mot de passe incorrect
                return NULL;
            }
        } catch (PDOException $exception) {
            // En cas d'erreur lors de la sélection dans la base de données, retournez NULL ou gérez l'erreur selon votre logique
            return NULL;
        }
    }
    
}       
?>

