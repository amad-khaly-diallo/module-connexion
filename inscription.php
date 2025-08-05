<?php 
include_once "./config/db.php";
$error = false;

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $name = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['login'];

    try {

      // Vérification que l'utilisateur n'existe pas déjà
        $checkStmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE logn = ?");
        $checkStmt->execute([$email]);

        if ($checkStmt->fetch()) {
            throw new Exception("Un compte avec cet email existe déjà.");
        }


        // Vérification des mots de passe
        if ($_POST['password'] !== $_POST['password2']) {
            throw new Exception("Les mots de passe ne sont pas identiques.");
        }

        //hash password
        $pwd = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Requête corrigée (login et VALUES au pluriel)
        $requet = "INSERT INTO utilisateurs (logn, prenom, nom, pwd) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($requet);
        $stmt->execute([$email, $prenom, $name, $pwd]);

        // Redirection après succès
        header("Location: connexion.php");
        exit;

    } catch (Exception $th) {
        $error = $th->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Inscription</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./stylesheet/formulaire.css">
</head>

<body>
  <main class="form-container">
    <h1>Inscription</h1>

    <?php if ($error): ?>
      <div class="error-message" style="color: red; margin-bottom: 1em;">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form action="inscription.php" method="POST" class="form-box">
        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" required>

        <label for="login">Login</label>
        <input type="email" id="login" name="login" required placeholder="exemple@gmail.com">

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required>

        <label for="password2">Confirmer le mot de passe</label>
        <input type="password" id="password2" name="password2" required>

        <button type="submit">S’inscrire</button>
    </form>

    <p class="redirect-text">Vous avez déjà un compte ? <a href="connexion.php">Connectez-vous</a></p>
  </main>
</body>

</html>
