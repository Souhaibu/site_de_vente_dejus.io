<?php
require_once '../config/Database.php';

$db = new Database();
$connexion = $db->getConnection();
$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["adresse"]) && !empty($_POST["tel"]) && !empty($_POST["email"]) && !empty($_POST["pwd"])) {
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $adresse = htmlspecialchars($_POST['adresse']);
        $tel = htmlspecialchars($_POST['tel']);
        $email = htmlspecialchars($_POST['email']);
        $pwd = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
        $profile;

        if (strlen($_POST['pwd']) < 7) {
            $msg = "Votre mot de passe est trop court.";
        } else{
            try {
                $insertion = $connexion->prepare("INSERT INTO User(nom, prenom, adresse, tel, email, pwd,profile) VALUES(?, ?, ?, ?, ?, ?,?)");
                $insertion->execute(array($nom, $prenom, $adresse, $tel, $email, $pwd,"CLIENT"));
                $msg = "Votre compte a bien été créé.";

                // Redirection vers la page de connexion
                header("Location: connexion.php");
                exit(); // Assure que le script s'arrête ici après la redirection
            } catch (PDOException $exception) {
                // En cas d'erreur lors de l'insertion dans la base de données
                $msg = "Erreur lors de la création du compte : " . $exception->getMessage();
            }
        }
    } else {
        $msg = "Tous les champs doivent être remplis.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        <form action="inscription.php" method="POST" class="col-10 row  forMod" >
            <?=$msg?> 
            <h2>INSCRIPTION</h2>
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                <div class="form-floating">
                    <input type="text" name="nom" class="form-control" id="floatingInputGroup1" placeholder="Nom">
                    <label for="floatingInputGroup1">Nom</label>
                </div>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                <div class="form-floating">
                    <input type="text" name="prenom" class="form-control" id="floatingInputGroup1" placeholder="Prenom">
                    <label for="floatingInputGroup1">Prenom</label>
                </div>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                <div class="form-floating">
                    <input type="text" name="adresse" class="form-control" id="floatingInputGroup1" placeholder="Adresse">
                    <label for="floatingInputGroup1">Adresse</label>
                </div>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                <div class="form-floating">
                    <input type="email" name="email" class="form-control" id="floatingInputGroup1" placeholder="Votre Mail">
                    <label for="floatingInputGroup1">E-mail</label>
                </div>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                <div class="form-floating">
                    <input type="number" name="tel" class="form-control" id="floatingInputGroup1" placeholder="Téléphone">
                    <label for="floatingInputGroup1">Téléphone</label>
                </div>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <div class="form-floating">
                    <input type="password" name="pwd" class="form-control" id="floatingInputGroup1" placeholder="Mots de pass">
                    <label for="floatingInputGroup1">Mots de pass</label>
                </div>
            </div>
            <?php $message ?>
            <div class="col-4 ">
               <button name="valider" type="submit" class="btn2">Inscrire</button>
            </div>
           
        </form> 
    </div>

    <div class="container-fluid mt-5" style="background-color:green;" >
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