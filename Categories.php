<?php
class Categories {
    private $connexion;
    private $table = "categories";

    public $id;
    public $nom;
    public $description;

    // Constructeur prenant en paramètre la connexion à la base de données
    public function __construct($db){
        $this->connexion = $db;
    }

    // Méthode pour lire toutes les catégories depuis la base de données
    public function lire(){
        $sql = "SELECT id, nom, description FROM {$this->table}";
        return $this->connexion->query($sql);
    }

    // Méthode pour lire une catégorie spécifique par son ID
    public function lireUneCategorie(){
        $sql = "SELECT id, nom, description FROM {$this->table} WHERE id = ?";
        $query = $this->connexion->prepare($sql);
        $query->execute([$this->id]);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $this->remplirDonnees($row);
    }

    // Méthode pour créer une nouvelle catégorie dans la base de données
    public function creer($nom,$description){
        // Vérifiez si les champs obligatoires sont définis
        if (!empty($nom) && !empty($description)) {
            // Requête pour insérer un nouveau catégorie dans la table
            $sql = "INSERT INTO {$this->table} (nom, description) VALUES (?, ?)";
            $query = $this->connexion->prepare($sql); // Prépare la requête SQL
    
            // Exécute la requête avec les valeurs fournies
            $result = $query->execute([$nom,$description]);
    
            if ($result) {
                return 1; // Succès de l'insertion
            } else {
                // En cas d'échec, affichez un message d'erreur pour le débogage
                $errorInfo = $query->errorInfo();
                error_log("Erreur lors de l'insertion du categorie : " . $errorInfo[2]);
                return 0; // Échec de l'insertion
            }
        } else {
            return 0; // Si des champs obligatoires sont manquants, ne pas exécuter l'insertion
        }
    }

    public function getCategoryById($idCategorie) {
        try {
            $stmt = $this->connexion->prepare("SELECT * FROM `Categories` WHERE id = ?");
            $stmt->bindParam(1, $idCategorie); // Utilisation correcte de bindParam
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        return null;
    }

    public function updateCategory($idCategorie, $nom, $description){
        // Vérifiez si les champs obligatoires sont définis
        if (!empty($idCategorie) && !empty($nom) && !empty($description)){
            // Requête pour mettre à jour les données du produit dans la table
            $sql = "UPDATE {$this->table} SET nom = ?, description = ? WHERE id = ?";
            $query = $this->connexion->prepare($sql); // Prépare la requête SQL
    
            // Exécute la requête avec les valeurs fournies
            $result = $query->execute([$nom, $description, $idCategorie]); // Placer l'ID à la fin
    
            if ($result) {
                return 1; // Succès de la mise à jour
            } else {
                // En cas d'échec, affichez un message d'erreur pour le débogage
                $errorInfo = $query->errorInfo();
                error_log("Erreur lors de la mise à jour du produit : " . $errorInfo[2]);
                return 0; // Échec de la mise à jour
            }
        } else {
            return 0; // Si des champs obligatoires sont manquants, ne pas exécuter la mise à jour
        }
    }
    public function deleteCategorie($idCategorie){
        // Vérifiez si l'ID du produit à supprimer est défini
        if (!empty($idCategorie)) {
            // Requête pour supprimer un produit de la table
            $sql = "DELETE FROM {$this->table} WHERE id = ?";
            $query = $this->connexion->prepare($sql); // Prépare la requête SQL
    
            // Exécute la requête avec l'ID du produit à supprimer
            $result = $query->execute([$idCategorie]);
    
            if ($result) {
                return 1; // Succès de la suppression
            } else {
                // En cas d'échec, affichez un message d'erreur pour le débogage
                $errorInfo = $query->errorInfo();
                error_log("Erreur lors de la suppression du produit : " . $errorInfo[2]);
                return 0; // Échec de la suppression
            }
        } else {
            return 0; // Si l'ID du produit est manquant, ne pas exécuter la suppression
        }
    }

    // Méthode pour nettoyer les entrées afin d'éviter les injections SQL
    private function nettoyerEntrees(){
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->description = htmlspecialchars(strip_tags($this->description));
    }

    // Méthode privée pour remplir les données de l'objet avec celles récupérées depuis la base de données
    private function remplirDonnees($row){
        $this->nom = $row['nom'];
        $this->description = $row['description'];
    }
}
