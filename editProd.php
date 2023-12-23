<?php
require_once '../config/Database.php';
include_once '../models/Produits.php';

$db = new Database();
$connexion = $db->getConnection();

$Allproduit = new Produits($db);
$produit = $Allproduit->getProduitById($_GET['idProduit']);

if (isset($_POST['click'])) {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];

    $image = $produit['image']; // Par défaut, utilisez l'image existante

    // Vérifie si une nouvelle image a été téléchargée
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTemp = $_FILES['image']['tmp_name'];
        $image = basename($_FILES['image']['name']);
        $imagePath = "../assets/images/" . $image;
        move_uploaded_file($imageTemp, $imagePath);
    }

    // Vérifiez si tous les champs obligatoires sont définis
    if (!empty($nom) && !empty($description) && !empty($prix)) {
        $result = $Allproduit->updateProduit($produit['id'], $nom, $description, $prix, $image);

        if ($result) {
            header("location:listprod.php");
        } else {
            echo "Erreur lors de la mise à jour du produit.";
        }
    } else {
        echo "Veuillez remplir tous les champs obligatoires.";
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Produit</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/styles/accueil.css">
</head>
<body>


<div class="container">
    <h2>Modifier Produit</h2>
    <form action="editProd.php?idProduit=<?= $produit['id'] ?>" method="POST" class="row g-3 boutiquierform" enctype="multipart/form-data">
        <div class="col-md-12">
            <label for="nom" class="form-label">Nom</label>
            <input name="nom" value="<?= $produit['nom'] ?>" type="text" class="form-control" id="nom">
        </div>
        <div class="col-md-12">
            <label for="prix"  class="form-label">Prix unitaire</label>
            <input name="prix" value="<?= $produit['prix'] ?>" type="number" class="form-control" id="prix">
        </div>
        <div class="col-md-12">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="description" rows="4"><?= $produit['description'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Ajouter une image</label>
            <input name="image" class="form-control" type="file" id="formFile">
        </div>
        <div class="col-12">
        <button name="click" type="submit" class="btn btn-primary">Modifier</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
