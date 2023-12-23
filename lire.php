<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/Produits.php';

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Instanciation de la classe Produits
$produits = new Produits($db);

// Route pour récupérer tous les produits (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Appel de la méthode lire() pour obtenir tous les produits
    $result = $produits->lire();

    if ($result->rowCount() > 0) {
        $produits_arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            // Création d'un tableau associatif pour chaque produit
            $produit_item = array(
                "id" => $id,
                "nom" => $nom,
                "description" => $description,
                "prix" => $prix,
                "image" => $image,
                "category_nom" => $category_nom,
                "id_boutiquier" => $id_boutiquier,
                "created_at" => $created_at,
                
            );

            array_push($produits_arr, $produit_item);
        }

        http_response_code(200);
        echo json_encode($produits_arr);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "Aucun produit trouvé."));
    }
}