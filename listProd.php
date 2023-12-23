<?php

require_once '../config/Database.php';
include_once '../models/Produits.php';

$database = new Database();
$db = $database->getConnection();
// Instanciation de la classe Produits
$produits = new Produits($db);   
$allproduct = $produits->lire();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Produits</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
              <a class="nav-link colort" href=".connexion.php">Connexion</i></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
<div class="container prodAcc">
 <?php 
  foreach ($allproduct as $key => $produit) { ?>
   <div class="card" style="width: 18rem;">
      <img src="../assets/images/<?=$produit['image']?>" class="card-img-top " alt="...">
      <div class="card-body">
         <h5 class="card-title"><?=$produit['nom']?></h5>
         <p class="card-text"><?=$produit['description']?></p>
         <p class="card-text"><?=$produit['prix']?> Fcfa</p>
         <div class="col-md-8 ">
            <a class="btn btn-outline-success" href="editProd.php?idProduit=<?=$produit['id']?>"><i class="bi bi-pencil-square"></i></a>
            <a class="btn btn-outline-danger" href="deleteProd.php?idProduit=<?=$produit['id']?>"><i class="bi bi-trash"></i></a>
         </div>
      </div>
   </div>
   <?php } ?>
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