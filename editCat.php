<?php
require_once '../config/Database.php';
include_once '../models/Categories.php';

$db = new Database();
$connexion = $db->getConnection();

$AllCategory = new Categories($db);
$categorie = $AllCategory->getCategoryById($_GET['idCategorie']);

if (isset($_POST['click'])) {
    $nom = $_POST['nom'];
    $description = $_POST['description'];

    // Vérifiez si tous les champs obligatoires sont définis
    if (!empty($nom) && !empty($description)) {
        $result = $AllCategory->updateCategory($categorie['id'], $nom, $description);

        if ($result) {
            header("location:listCat.php");
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
    <h2>Modifier Categorie</h2>
    <form action="editCat.php?idCategorie=<?= $categorie['id'] ?>" method="POST" class="row g-3 boutiquierform" enctype="multipart/form-data">
        <div class="col-md-12">
            <label for="nom" class="form-label">Nom</label>
            <input name="nom" value="<?= $categorie['nom'] ?>" type="text" class="form-control" id="nom">
        </div>
        <div class="col-md-12">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="description" rows="4"><?= $categorie['description'] ?></textarea>
        </div>
        <div class="col-12">
        <button name="click" type="submit" class="btn btn-primary">Modifier</button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
