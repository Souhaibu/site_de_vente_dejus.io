<?php
session_start();
require_once '../config/Database.php';

$db = new Database();
$connexion = $db->getConnection();
$msg = "";

if(isset($_POST['valider'])){
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    // Utilisation d'une requête préparée pour récupérer l'utilisateur correspondant à l'e-mail
    $stmt = $connexion->prepare("SELECT * FROM User WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification du mot de passe avec password_verify
    if ($user && password_verify($pwd, $user['pwd'])) {
        $_SESSION['User'] = $user;
        if (isset($_GET['page'])) {
            header('location:'.$_GET['page'].'.php');
        } else {
            header("location:../index.php");
        }
    } else {
        $msg = "Informations invalides";
    }
}
?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Connexion</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
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
      <div class="container-fluid">
          <form action="connexion.php" method="POST" class="col-10 row forMod" >
              <?=$msg?>
              <h2>Connexion</h2>
              <div class="input-group mb-3">
                  <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                  <div class="form-floating">
                      <input type="email" name="email" class="form-control" id="floatingInputGroup1" placeholder="Votre Mail">
                      <label for="floatingInputGroup1">E-mail</label>
                  </div>
              </div>
              <div class="input-group mb-3">
                  <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                  <div class="form-floating">
                      <input type="password" name="pwd" class="form-control" id="floatingInputGroup1" placeholder="Mots de pass">
                      <label for="floatingInputGroup1">Mots de pass</label>
                  </div>
              </div>
              <div class="col-4">
                 <button name="valider" type="submit" class="btn2">Se connecter</button>
              </div>
              <div class="col-4">
                 <button name="valider" type="submit" class="btn2"><a href="inscription.php">S'inscrire</a></button>
              </div>
          </form> 
      </div>
  
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
  </html>