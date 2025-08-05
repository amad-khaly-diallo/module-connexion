<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}

include_once "./config/db.php";

$error = false;
$errorUpload = false;

try {
    $id = $_SESSION['id'];

    // getuser info
    $requete = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
    $requete->execute([$id]);
    $userInfo = $requete->fetch(PDO::FETCH_ASSOC);

    if (!$userInfo) {
        header('Location: connexion.php');
        session_destroy();
        exit;
    }

    // Traitement du formulaire
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change-profile'])) {

        // Check Old-password
        if (empty($_POST['old-password']) || !password_verify($_POST['old-password'], $userInfo['pwd'])) {
            throw new Exception("Ancien mot de passe incorrect.");
        }

        // cehck mail format
        $email = filter_var($_POST['login'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Adresse e-mail invalide.");
        }

        //check if email already exists
        $checkEmail = $pdo->prepare("SELECT * FROM utilisateurs WHERE logn = ?");
        $checkEmail->execute([$email]);
        $existingUser = $checkEmail->fetch(PDO::FETCH_ASSOC);

        if ($existingUser && $existingUser['id'] !== $id) {
            throw new Exception("L'adresse e-mail est déjà utilisée par un autre compte.");
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

    // Upload image de profil
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload-photo']) && isset($_FILES['photo'])) {
        $image = $_FILES['photo'];

        if ($image['error'] === 0) {
            $allowed = ['image/jpeg', 'image/png', 'image/webp'];
            if (!in_array($image['type'], $allowed)) {
                throw new Exception("Format de fichier non autorisé.");
            }

            if ($image['size'] > 3 * 1024 * 1024) {
                throw new Exception("Fichier trop volumineux (3 Mo max).");
            }

            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $new_name = uniqid() . '-' . basename($image['name']);
            $destination = $upload_dir . $new_name;

            // Supprimer l'ancienne photo si elle existe
            if (!empty($userInfo['profil']) && file_exists($userInfo['profil'])) {
                unlink($userInfo['profil']);
            }

            if (move_uploaded_file($image['tmp_name'], $destination)) {
                $stmt = $pdo->prepare("UPDATE utilisateurs SET profil = ? WHERE id = ?");
                $stmt->execute([$destination, $id]);

                // Recharger les infos utilisateur
                $requete = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
                $requete->execute([$id]);
                $userInfo = $requete->fetch(PDO::FETCH_ASSOC);

                $success = "Photo de profil mise à jour.";
            } else {
                $errorUpload = "Erreur lors du téléchargement de l'image.";
                throw new Exception("Erreur lors de l'enregistrement de la photo.");
            }
        } else {
            $errorUpload = "Erreur lors du téléchargement de l'image.";
        }
    }

    // Handle user delete
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
        // Delete user from database
        $delete = $pdo->prepare("DELETE FROM utilisateurs WHERE id = ?");
        $delete->execute([$id]);
        session_destroy();
        header('Location: index.php');
        exit;
    }
    // logout
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
        session_destroy();
        header('Location: index.php');
        exit;
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

        <a href="index.php" class="home-link"> <- Accueil</a>

        <div class="profil-card">
            <img src="<?= htmlspecialchars($userInfo['profil'] ?? 'https://images.pexels.com/photos/11035390/pexels-photo-11035390.jpeg') ?>" alt="Photo de profil">
            <?php if ($errorUpload): ?>
                <p style="color: red;"><?= htmlspecialchars($errorUpload) ?></p>
            <?php endif; ?>
            <form action="profile.php" method="POST" enctype="multipart/form-data" class="photo-form">
                <input type="hidden" name="profil" value="profil">
                <input type="file" name="photo" accept="image/*" id="photo" required>
                <button type="submit" name="upload-photo">Changer la photo</button>
            </form>
            <h2><?= htmlspecialchars($userInfo['prenom'] . ' ' . $userInfo['nom']) ?></h2>
            <p><?= htmlspecialchars($userInfo['logn']) ?></p>
            <span style="color: #555;" class="date">Inscrit le <?= htmlspecialchars($userInfo['created_at']) ?></span>
            <form action="profile.php" method="post" class="bottom-text">
                <input type="hidden" name="logout" value="logout">
                <button type="submit">Se déconnecter</button>
                <button type="submit" name="delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?');">Supprimer</button>
            </form>
        </div>
        <div class="form-container">
            <h1>Mon Profil</h1>

            <?php if (isset($error)) : ?>
                <p style="color:red; text-align:center;"><?= htmlspecialchars($error) ?></p>
            <?php elseif (isset($success)) : ?>
                <p style="color:green; text-align:center;"><?= htmlspecialchars($success) ?></p>
            <?php endif; ?>

            <form action="profile.php" method="POST" class="form-box">
                <input type="hidden" name="change-profile" value="change-profile">

                <label for="login">Login</label>
                <input type="email" name="login" id="login" value="<?= htmlspecialchars($userInfo['logn']) ?>" required />

                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($userInfo['prenom']) ?>" required />

                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($userInfo['nom']) ?>" required />

                <label for="old-password">Ancien mot de passe</label>
                <input type="password" name="old-password" id="old-password" required />

                <label for="new-password">Nouveau mot de passe</label>
                <input type="password" name="new-password" id="new-password" />

                <button type="submit">Mettre à jour</button>
            </form>

        </div>
    </main>

</body>

</html>
