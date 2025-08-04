<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}

include_once "./config/db.php";

$error = false;

try {
    $id = $_SESSION['id'];

    // getuser info
    $requete = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
    $requete->execute([$id]);
    $userInfo = $requete->fetch(PDO::FETCH_ASSOC);

    if (!$userInfo) {
        throw new Exception("Utilisateur introuvable.");
    }

    // Traitement du formulaire
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Check Old-password
        if (empty($_POST['old-password']) ||!password_verify($_POST['old-password'], $userInfo['pwd'])) {
            throw new Exception("Ancien mot de passe incorrect.");
        }

        // cehck mail format
        $email = filter_var($_POST['login'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Adresse e-mail invalide.");
        }

        // change password if new password is provided
        $new_password = !empty($_POST['new-password'])
            ? password_hash($_POST['new-password'], PASSWORD_DEFAULT)
            : $userInfo['pwd'];

        //update user info in database
        $update = $pdo->prepare("UPDATE utilisateurs SET prenom = ?, nom = ?, logn = ?, pwd = ? WHERE id = ?");
        $update->execute([
            $_POST['prenom'],
            $_POST['nom'],
            $email,
            $new_password,
            $id
        ]);

        // update user info in brawser
        $requete = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
        $requete->execute([$id]);
        $userInfo = $requete->fetch(PDO::FETCH_ASSOC);

        $success = "Profil mis à jour avec succès.";
    }
} catch (PDOException $e) {
    $error = "Erreur de connexion au serveur, réessayer plutard";
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($userInfo['prenom']) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./stylesheet/profil.css" />
</head>

<body>
    <main class="profil-wrapper">

        <div class="profil-card">
            <img src="https://images.pexels.com/photos/33265474/pexels-photo-33265474.jpeg" alt="Photo de profil">
            <form action="profile.php" method="POST" enctype="multipart/form-data" class="photo-form">
                <input type="hidden" name="profil" value="profil">
                <input type="file" name="photo" accept="image/*" id="photo" required>
                <button type="submit" name="upload-photo">Changer la photo</button>
            </form>
            <h2><?= htmlspecialchars($userInfo['prenom'] . ' ' . $userInfo['nom']) ?></h2>
            <p><?= htmlspecialchars($userInfo['logn']) ?></p>

            <div class="bottom-text">
                <a href="logout.php">Se déconnecter</a>
            </div>
        </div>
        <div class="form-container">
            <h1>Mon Profil</h1>

            <?php if (isset($error)) : ?>
                <p style="color:red; text-align:center;"><?= htmlspecialchars($error) ?></p>
            <?php elseif (isset($success)) : ?>
                <p style="color:green; text-align:center;"><?= htmlspecialchars($success) ?></p>
            <?php endif; ?>

            <form action="profile.php" method="POST" class="form-box">
                <input type="hidden" name="form" value="form">

                <label for="login">Email</label>
                <input type="text" name="login" id="login" value="<?= htmlspecialchars($userInfo['logn']) ?>" required />

                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($userInfo['prenom']) ?>" required />

                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($userInfo['nom']) ?>" required />

                <label for="old-password">Ancien mot de passe</label>
                <input type="password" name="old-password" id="old-password" required />

                <label for="new-password">Nouveau mot de passe</label>
                <input type="password" name="new-password" id="new-password"/>

                <button type="submit">Mettre à jour</button>
            </form>
        </div>
    </main>


</body>

</html>