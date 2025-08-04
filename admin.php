<?php
session_start();

// Restriction admin
if (!isset($_SESSION['id']) || $_SESSION['role'] !== true) {
    header('Location: connexion.php');
    exit;
}

include_once './config/db.php';

try {
    $stmt = $pdo->query("SELECT id, prenom, nom, logn FROM utilisateurs ORDER BY prenom DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Erreur lors de la récupération des utilisateurs.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="stylesheet/admin.css">
</head>
<body>
    <main class="admin-container">
        <div class="top-bar">
            <h1>Dashboard Administrateur</h1>
            <div>
                <span>Connecté en tant que <strong> Admin </strong></span>
                <a href="logout.php" class="logout-btn">Déconnexion</a>
            </div>
        </div>

        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php elseif (empty($users)): ?>
            <p class="info">Aucun utilisateur trouvé.</p>
        <?php else: ?>
            <div class="user-grid">
                <?php foreach ($users as $user): ?>
                    <div class="user-card">
                        <img src="https://images.pexels.com/photos/33265474/pexels-photo-33265474.jpeg" alt="Photo de profil">
                        <div class="user-info">
                            <h2><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></h2>
                            <p><?= htmlspecialchars($user['logn']) ?></p>
                            <span class="date">Inscrit le </span>
                        </div>
                        <div class="user-actions">
                            <a href="modifier_utilisateur.php?id=<?= $user['id'] ?>" class="btn edit">Modifier</a>
                            <a href="supprimer_utilisateur.php?id=<?= $user['id'] ?>" class="btn delete" onclick="return confirm('Supprimer cet utilisateur ?');">Supprimer</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
