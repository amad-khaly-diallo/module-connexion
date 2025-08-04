<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./stylesheet/style.css">
  <title>Document</title>
</head>

<body>
  <header>
    <nav class="nav-bar">
      <span class="logo">PHP</span>
      <ul class="nav-links">
        <li class="link active"><a href="index.php">Home</a></li>
        <li class="link"><a href="connexion.php">Login</a></li>
        <li class="link"><a href="inscription.php">signup</a></li>
      </ul>
    </nav>
  </header>

  <main class="main">
    <section class="hero-section">
      <span class="hero-text">
        Bienvenue sur <br> notre module de onnexion <br>
        <span class="language"> <br> PHP & MySQL</span>
      </span>
    </section>
    <section class="des-section">
        <div class="container">
            <h1> Module de Connexion </h1>

           <p>Ce site vous permet de créer un compte personnel, de vous connecter de manière sécurisée et de gérer vos informations à tout moment. Il est simple d'utilisation et adapté à tous : utilisateurs comme administrateurs. Toutes vos données sont enregistrées dans une base de données fiable, pour une expérience fluide et sécurisée.
            </p>


            <h2>Fonctionnalités du site</h2>
            <ul>
                <li><strong>Création de compte</strong> : inscrivez-vous en fournissant un identifiant, votre prénom, votre nom et un mot de passe.</li>
                <li><strong>Connexion sécurisée</strong> : accédez à votre compte en entrant votre identifiant et votre mot de passe.</li>
                <li><strong>Modification du profil</strong> : mettez à jour vos informations personnelles à tout moment après vous être connecté.</li>
                <li><strong>Accès administrateur</strong> : pour les administrateurs, une page dédiée permet de gérer les utilisateurs inscrits, de consulter et de modifier leurs informations.</li>
            </ul>


            <div class="btns">
                <a class="btn" href="connexion.php"> Login</a>
                <a class="btn" href="inscription.php"> Signup</a>
            </div>
        </div>
    </section>
  </main>

</body>

</html>