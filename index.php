<?php
   include_once 'config/Database.php';
   include_once 'models/Produits.php';
   
   // Connexion à la base de données
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/styles/accueil.css">
    <style>
        /* Style pour le div de connexion et d'inscription */
        .header-container {
            background: url('./assets/images/collage.jpg') no-repeat center center fixed;
            background-size: 150%; /* Agrandit l'image de fond */
            text-align: center;
            margin-bottom: 60px;
            padding: 80px;
            border-radius: 10px;
        }

            .btn-primary, .btn-success {
                margin: 10px;
                padding: 10px 20px;
                font-size: 1.2em;
                text-decoration: none;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .btn-primary {
                background-color: #004d00;
            }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg">
      <div class="container-fluid ">
        <a class="navbar-brand colort" href="index.php">Xelima jus</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link colort" aria-current="page" href="index.php">Accueil</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle colort" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Produit
              </a>
              <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="./pages/AjoutProd.php">Ajout</a></li>
                <li><a class="dropdown-item" href="./pages/listProd.php">Liste</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle colort" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Catégorie
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="./pages/AjoutCat.php">Ajout</a></li>
                <li><a class="dropdown-item" href="./pages/listCat.php">Liste</a></li>
              </ul>
            </li>
          </ul>
          <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success colort" type="submit">Search</button>
          </form>
          <ul class="navbar-nav" >
           <li class="nav-item">
              <a class="nav-link colort" href="./pages/connexion.php">Connexion</i></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="./assets/images/orange.png" class="d-block w-100 img-fl" alt="...">
        </div>
        <div class="carousel-item">
          <img src="./assets/images/pommes.png" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="./assets/images/bananeA.png" class="d-block w-100" alt="...">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    <h1 style="text-align:center;margin-top:10px;font-size:4em;color:orange;">Nos Produits</h1>
   <div class="container prodAcc">
      <?php 
      foreach ($allproduct as $key => $produit) { ?>
      <div  class="card cart-hove" style="width: 18rem;">
          <img src="./assets/images/<?=$produit['image']?>" class="card-img-top " alt="...">
          <div class="card-body">
          <h5 class="card-title"><?=$produit['nom']?></h5>
          <h6 class="card-text">Prix: <?=number_format( $produit['prix'])?> Fcfa</h6>
          <p class="card-text">categorie: <?=$produit['category_nom']?></p>  
      </div>
         <a name="click" class="btn btn-outline-warning" href="#"><i class="bi bi-cart-plus-fill"></i>Ajouter au panier</a>        
      </div>
      <?php } ?>

   </div>
   <div style="text-align: center; margin-bottom: 20px; background-color: rgba(255, 255, 255, 0.8); padding: 0 20px 0 20px; border-radius: 10px;">
        <div class="header-container">
            <h1  style="text-align:center;margin-top:10px;font-size:3em;color:orange;">XELIMA JUS</h1>
            <h6 style="text-align:center;margin-top:10px;font-size:1.2em;color:green;">
              Découvrez l'essence même du soleil du Sénégal capturée dans chaque bouteille <br> de Xélima Jus. Notre engagement envers l'excellence et la fraîcheur commence dès la source :<br> tous nos fruits sont méticuleusement récoltés au cœur des terres fertiles du Sénégal,<br> berceau de saveurs authentiques.
           </h6>
            <a href="connexion.html" class="btn btn-primary">VOIR PLUS</a>
        </div>
    </div>
  <div class="container z text-center mb-3 ">
    <h1 style="text-align:center;margin-top:10px;font-size:3em;color:Orange;">DECOUVRIR PLUS</h1>
    <div class="row">
      <div class="col">
        <img style="height: 330px; width: 550px; object-fit: cover;" src="./assets/images/image_G.jpg" alt="">
      </div>
      <div class="col textt">
        <p style="text-align:left;margin-top:10px;font-size:1.2em;color:Green;">
          À notre usine, ces trésors naturels sont transformés avec précision et 
          expertise, préservant chaque note de leur goût unique et de leur fraîcheur.
          Nos maîtres artisans mettent en œuvre tout leur savoir-faire pour extraire 
          le meilleur des fruits, créant ainsi une gamme diversifiée de jus Xélima aux
          saveurs envoûtantes.<br>Explorez notre gamme de jus Xélima et laissez-vous transporter
          par la magie du soleil, capturée dans chaque gorgée. Xélima Jus, l'essence même
          du Sénégal à déguster sans modération.<br>
          <button type="button" class="btn btn-outline-warning">Voir plus</button>
        </p>
        
      </div>
    </div>
  </div>
  <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d15435.840469292876!2d-17.4913492!3d14.714846950000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sfr!2ssn!4v1703259599402!5m2!1sfr!2ssn" width="1348" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
  </iframe>
        <!--Footer-->
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