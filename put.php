<?php
// Headers requis pour permettre les requêtes depuis n'importe quelle origine (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Vérifie si la méthode de requête est PUT
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    // Inclut les fichiers de configuration et d'accès aux données
    include_once '../config/Database.php';
    include_once '../models/Produits.php';

    // Instancie la base de données
    $database = new Database();
    $db = $database->getConnection();

    // Instancie l'objet Produits
    $produit = new Produits($db);

    // Récupère les informations envoyées
    $donnees = json_decode(file_get_contents("php://input"));
    
    // Vérifie que les données nécessaires ne sont pas vides
    if (!empty($donnees->id) && !empty($donnees->nom) && !empty($donnees->description) && !empty($donnees->prix) && !empty($donnees->categories_id)) {
        // Données reçues, on hydrate l'objet Produits
        $produit->id = $donnees->id;
        $produit->nom = $donnees->nom;
        $produit->description = $donnees->description;
        $produit->prix = $donnees->prix;
        $produit->categories_id = $donnees->categories_id;

        // Vérifie si la modification du produit a réussi
        if ($produit->modifier()) {
            // Modification réussie, envoie le code 200 OK
            http_response_code(200);
            echo json_encode(["message" => "La modification a été effectuée"]);
        } else {
            // La modification a échoué, envoie le code 503 Service Unavailable
            http_response_code(503);
            echo json_encode(["message" => "La modification n'a pas été effectuée"]);         
        }
    }
} else {
    // Gère l'erreur pour les autres méthodes de requête
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
?>
