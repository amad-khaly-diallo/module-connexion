<?php
// Connect DB 
include_once "./config/db.php";

// Start session
session_start();

$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pwd = $_POST['password'];
    $email = filter_var($_POST['login'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Email invalide");
    }

    $requete = "SELECT * FROM utilisateurs WHERE logn = ?";

    try {
        $stmt = $pdo->prepare($requete);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($pwd, $user['pwd'])) {
            throw new Exception("Email ou mot de passe incorrect");
        }

        // Variables de session
        $_SESSION['id'] = $user['id'];
        $_SESSION['role'] = ($user['role'] === 'admin') ? true : false;

        if ($_SESSION['role']) {
            header('Location: admin.php');
            exit;
        } else {
            header('Location: profile.php');
            exit;
        }

    } catch (PDOException $e) {
        $error = "Erreur de connexion au serveur, réessayer plutard";
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./stylesheet/formulaire.css">
</head>

<body>
  <main class="form-container">

    <?php if ($error): ?>
      <div class="error-message" style="color: red; margin-bottom: 1em;">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <h1>Connexion</h1>
    <form action="connexion.php" method="POST" class="form-box">
      <label for="login">Email</label>
      <input type="email" id="login" name="login" required>

      <label for="password">Mot de passe</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Se connecter</button>
    </form>
    <p class="redirect-text">
      Vous n’avez pas de compte ?
      <a href="inscription.php">Créez-en un</a>
    </p>
  </main>
</body>
</html>
