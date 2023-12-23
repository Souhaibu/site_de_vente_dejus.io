<?php
class Produits {
    private $connexion; // Stocke la connexion à la base de données
    private $table = "produits"; // Nom de la table "produits" dans la base de données

    public $idProduit;
    public $nom;
    public $description;
    public $prix;
    public $category_id;
    public $categories_nom;
    public $created_at;

    public function __construct($db){
        $this->connexion = $db; // Initialise la connexion à la base de données
    }

    // Récupère tous les produits de la base de données avec leurs catégories
    public function lire(){
        // Requête pour sélectionner tous les produits avec le nom de leur catégorie, triés par date de création décroissante
        $sql = "SELECT p.id, p.nom, p.description, p.prix, p.image, c.nom AS category_nom, p.id_admin, p.created_at
                FROM produits p
                LEFT JOIN categories c ON p.category_id = c.id
                ORDER BY p.created_at DESC";
        return $this->connexion->query($sql); // Exécute la requête et retourne les résultats
    }
    

    public function creer($nom,$description, $prix, $image, $category_id, $id_admin){
        // Vérifiez si les champs obligatoires sont définis
        if (!empty($nom) && !empty($description)&& !empty($prix) && !empty($image) && !empty($category_id)) {
            // Requête pour insérer un nouveau produit dans la table
            $sql = "INSERT INTO {$this->table} (nom, description, prix, image, category_id, id_admin) VALUES (?, ?, ?, ?, ?, ?)";
            $query = $this->connexion->prepare($sql); // Prépare la requête SQL
    
            // Exécute la requête avec les valeurs fournies
            $result = $query->execute([$nom,$description, $prix, $image, $category_id, $id_admin]);
    
            if ($result) {
                return 1; // Succès de l'insertion
            } else {
                // En cas d'échec, affichez un message d'erreur pour le débogage
                $errorInfo = $query->errorInfo();
                error_log("Erreur lors de l'insertion du produit : " . $errorInfo[2]);
                return 0; // Échec de l'insertion
            }
        } else {
            return 0; // Si des champs obligatoires sont manquants, ne pas exécuter l'insertion
        }
    }
    // Récupère un produit spécifique de la base de données par son ID
    public function lireUn(){
        // Requête pour sélectionner un produit spécifique avec le nom de sa catégorie
        $sql = "SELECT c.nom as categories_nom, p.id, p.nom, p.description, p.prix, p.category_id, p.created_at FROM {$this->table} p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ? LIMIT 0,1";
        $query = $this->connexion->prepare($sql); // Prépare la requête SQL
        $query->execute([$this->id]); // Exécute la requête en spécifiant l'ID du produit
        $row = $query->fetch(PDO::FETCH_ASSOC); // Récupère la première ligne de résultat sous forme de tableau associatif
        $this->remplirDonnees($row); // Remplit les données de l'objet avec les résultats obtenus
    }

    // Supprime un produit de la base de données par son ID
    public function deleteProduit($idProduit){
        // Vérifiez si l'ID du produit à supprimer est défini
        if (!empty($idProduit)) {
            // Requête pour supprimer un produit de la table
            $sql = "DELETE FROM {$this->table} WHERE id = ?";
            $query = $this->connexion->prepare($sql); // Prépare la requête SQL
    
            // Exécute la requête avec l'ID du produit à supprimer
            $result = $query->execute([$idProduit]);
    
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
    
    public function getProduitById($idProduit) {
        try {
            $stmt = $this->connexion->prepare("SELECT * FROM `Produits` WHERE id = ?");
            $stmt->bindParam(1, $idProduit); // Utilisation correcte de bindParam
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        return null;
    }
    

    // Autres méthodes de la classe Produits...

    // Met à jour un produit dans la base de données
// Met à jour un produit dans la base de données
public function updateProduit($idProduit, $nom, $description, $prix, $image){
    // Vérifiez si les champs obligatoires sont définis
    if (!empty($idProduit) && !empty($nom) && !empty($description) && !empty($prix) && !empty($image)){
        // Requête pour mettre à jour les données du produit dans la table
        $sql = "UPDATE {$this->table} SET nom = ?, description = ?, prix = ?, image = ? WHERE id = ?";
        $query = $this->connexion->prepare($sql); // Prépare la requête SQL

        // Exécute la requête avec les valeurs fournies
        $result = $query->execute([$nom, $description, $prix, $image, $idProduit]); // Placer l'ID à la fin

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

    // Nettoie les entrées pour éviter les injections SQL
    private function nettoyerEntrees(){
        $this->nom = isset($this->nom) ? htmlspecialchars(strip_tags($this->nom)) : null;
        $this->prix = isset($this->prix) ? htmlspecialchars(strip_tags($this->prix)) : null;
        $this->description = isset($this->description) ? htmlspecialchars(strip_tags($this->description)) : null;
        $this->categories_id = isset($this->category_id) ? htmlspecialchars(strip_tags($this->category_id)) : null;
        $this->created_at = isset($this->created_at) ? htmlspecialchars(strip_tags($this->created_at)) : null;
    }
    

    // Remplit les données de l'objet avec celles d'une ligne de la base de données
    private function remplirDonnees($row){
        $this->nom = $row['nom'];
        $this->prix = $row['prix'];
        $this->description = $row['description'];
        $this->categories_id = $row['category_id'];
        $this->categories_nom = $row['categories_nom'];
    }
}
