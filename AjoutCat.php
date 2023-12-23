<?php
session_start();

require_once '../config/Database.php';
include_once '../models/Categories.php';

// Établissement de la connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Récupération de toutes les catégories pour affichage
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['valider'])) {
    $category = new Categories($db);
    // Nettoyage des entrées utilisateur pour prévenir les attaques XSS
    $nom = htmlspecialchars(trim($_POST['nom']));
    $description = htmlspecialchars(trim($_POST['description']));
    // Vérification de l'intégrité des données avant insertion dans la base de données
    if ($nom !== '' && $description !== '') {
        $result = $category->creer($nom, $description);

        if ($result == 1) {
            // Redirection après l'ajout réussi du produit
            header("location:../index.php");
            exit(); // Terminer le script après la redirection
        } else {
            $msg = "Erreur lors de la création du catégories.";
        }
    } else {
        $msg = "Veuillez remplir tous les champs correctement.";
    }
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
      <form action="AjoutCat.php" method="POST" class="row g-3 forMod" enctype="multipart/form-data">
          <?=$msg?>  
        <div class="col-md-12">
            <label for="nom" class="form-label">Nom</label>
            <input name="nom" type="text" class="form-control" id="nom">
          </div>
          <div class="col-md-12">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="4"></textarea>
          </div>
          <div class="col-12">
            <button name="valider" type="submit" class="btn ">Ajouter</button>
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