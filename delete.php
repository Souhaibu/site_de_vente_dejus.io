<?php
// Headers requis pour permettre les requêtes depuis n'importe quelle origine (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Vérifie si la méthode de requête est DELETE
if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    // Inclut les fichiers de configuration et d'accès aux données
    include_once '../config/Database.php';
    include_once '../models/Produits.php';

    // Instancie la base de données
    $database = new Database();
    $db = $database->getConnection();

    // Instancie l'objet Produits
    $produit = new Produits($db);

    // Récupère l'ID du produit à supprimer
    $donnees = json_decode(file_get_contents("php://input"));

    if(!empty($donnees->id)){
        $produit->id = $donnees->id;

        // Vérifie si la suppression du produit a réussi
        if($produit->supprimer()){
            // Suppression réussie, envoie le code 200 OK
            http_response_code(200);
            echo json_encode(["message" => "La suppression a été effectuée"]);
        }else{
            // La suppression a échoué, envoie le code 503 Service Unavailable
            http_response_code(503);
            echo json_encode(["message" => "La suppression n'a pas été effectuée"]);         
        }
    }
}else{
    // Gère l'erreur pour les autres méthodes de requête
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
?>
