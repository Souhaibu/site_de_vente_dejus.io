<?php
require_once '../config/Database.php';
include_once '../models/Produits.php';

$db = new Database();
$connexion = $db->getConnection();

$produit = new Produits($connexion); // Assurez-vous d'instancier correctement la classe Produits avec la connexion

if (isset($_GET['idProduit'])) {
    $idProduit = $_GET['idProduit'];

    // Appel de la méthode delete pour supprimer le produit
    $result = $produit->deleteProduit($idProduit);
    
    if ($result) {
        // Redirection après la suppression réussie
        header("Location: listprod.php");
        exit(); // Assure une fin d'exécution propre
    } else {
        // Gérer les erreurs éventuelles lors de la suppression du produit
        echo "Une erreur est survenue lors de la suppression du produit.";
    }
} else {
    echo "ID du produit non spécifié.";
}
?>
