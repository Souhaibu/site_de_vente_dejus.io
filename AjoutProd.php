<?php
session_start();

// recupéré l'id du boutiquier
$id_admin = 1;

require_once '../config/Database.php';
include_once '../models/Produits.php';
include_once '../models/Categories.php';

// Établissement de la connexion à la base de données
$database = new Database();
$db = $database->getConnection();

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['valider'])) {
    $produits = new Produits($db);

    // Nettoyage des entrées utilisateur pour prévenir les attaques XSS
    $nom = htmlspecialchars(trim($_POST['nom']));
    $description = htmlspecialchars(trim($_POST['description']));
    $prix = ($_POST['prix']);
    $image = telechargeImage($_FILES['image']);
    $category_id = intval($_POST['category_id']);

    // Vérification de l'intégrité des données avant insertion dans la base de données
    if ($nom !== '' && $description !== '' && $prix > 0 && $image !== '' && $category_id > 0 && $id_admin > 0 ) {
        $result = $produits->creer($nom, $description, $prix, $image, $category_id, $id_admin);

        if ($result == 1) {
            // Redirection après l'ajout réussi du produit
            header("location:../index.php");
            exit(); // Terminer le script après la redirection
        } else {
            $msg = "Erreur lors de la création du produit.";
        }
    } else {
        $msg = "Veuillez remplir tous les champs correctement.";
    }
}

// Récupération de toutes les catégories pour affichage
$category = new Categories($db);
$allcategory = $category->lire();

// Fonction pour télécharger l'image dans le répertoire spécifié
function telechargeImage($imageInfos){
    $nomImage = $imageInfos['name'];
    $imagePath = $imageInfos['tmp_name'];
    if (move_uploaded_file($imagePath, "../assets/images/" . $nomImage)) {
        return $nomImage;
    }
    return "";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/styles/inscript.css">
  <link rel="stylesheet" href="../assets/styles/accueil.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg">
      <div class="container-fluid ">
        <a class="navbar-brand colort" href="../index.php">Xelima jus</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link colort" aria-current="page" href="../index.php">Accueil</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle colort" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Produit
              </a>
              <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="./AjoutProd.php">Ajout</a></li>
                <li><a class="dropdown-item" href="./listProd.php">Liste</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle colort" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Catégorie
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="./AjoutCat.php">Ajout</a></li>
                <li><a class="dropdown-item" href="./listCat.php">Liste</a></li>
              </ul>
            </li>
          </ul>
          <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success colort" type="submit">Search</button>
          </form>
          <ul class="navbar-nav" >
           <li class="nav-item">
              <a class="nav-link colort" href="./connexion.php">Connexion</i></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  <div class="container">
      <form action="AjoutProd.php" method="POST" class="row g-3 forMod" enctype="multipart/form-data">
          <?=$msg?>  
        <div class="col-md-12">
            <label for="nom" class="form-label">Nom</label>
            <input name="nom" type="text" class="form-control" id="nom">
          </div>
          <div class="col-md-12">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="4"></textarea>
          </div>
          <div class="col-md-12">
            <label for="prix" class="form-label">Prix unitaire</label>
            <input name="prix" type="number" class="form-control" id="telephone">
          </div>
          <div class="mb-5">
            <label for="formFile" class="form-label">Ajouter un image</label>
            <input name="image" class="form-control img" type="file" id="formFile">
          </div>
          <select name="category_id" class="form-select" aria-label="Default select example">
              <option selected>Choisissez une catégorie</option>
              <?php foreach ($allcategory as $key => $category) { ?>
                  <option value="<?=$category['id']?>"><?=$category['nom']?></option>
              <?php } ?>
          </select>
          <div class="col-12">
            <button name="valider" type="submit" class="btn">Ajouter</button>
          </div>
      </form>
  </div>

  <div class="container-fluid" style="background-color:green;" >
    <div class="row">
      <div class="col" style="text-align:left;margin:20px; color: white;" >
        <h4>Nos pages  <br><hr  style="width: 50px; color: white"></h4>
        <p>accueil <br> Produits <br> Categories </p>
      </div>
      <div class="col" style="text-align:left;margin:20px; color: white;" >
        <h4>Listes categories  <br><hr  style="width: 50px; color: white"></h4>
        <p>Orange <br> Pommes <br> Banane</p>
      </div>
      <div class="col" style="text-align:left;margin:20px; color: white;" >
        <h4>A propos de nous  <br><hr  style="width: 50px; color: white"></h4>
        <p>Bloc <br> Nutrition <br> Vitamine</p>
      </div>
      <div class="col" style="text-align:left;margin:20px; color: white;" >
        <h4>Contactez nous  <br><hr  style="width: 50px; color: white"></h4>
        <p>Nos réseaux <br> <i style="margin-right:10px" class="bi bi-facebook"></i><i style="margin-right:10px" class="bi bi-instagram"></i><i style="margin-right:10px" class="bi bi-tiktok"></i><i style="margin-right:10px" class="bi bi-youtube"></i></p>
      </div>
    </div>
  </div>
<div class="container-fluid text-center" style="background-color:black;" >
    <p style="color: white;paddind:0;margin:0; opacity:60%;">@Copyright : Creer Par Xélima , 2023</p>
</div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>