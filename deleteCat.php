<?php
require_once '../config/Database.php';
include_once '../models/Categories.php';

$db = new Database();
$connexion = $db->getConnection();
$categorie = new Categories($connexion);

if (isset($_GET['idCategorie'])) {
    $idCategorie = $_GET['idCategorie'];

    // Appel de la méthode delete pour supprimer le Categorie
    $result = $categorie->deleteCategorie($idCategorie);

    if ($result) {
        // Redirection après la suppression réussie
        header("Location: listCat.php");
        exit(); // Assure une fin d'exécution propre
    } else {
        // Gérer les erreurs éventuelles lors de la suppression du Categorie
        echo "Une erreur est survenue lors de la suppression du Categorie.";
    }
} else {
    echo "ID du Categorie non spécifié.";
}
?>
