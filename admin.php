<?php
session_start();

// Restriction admin
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}

include_once './config/db.php';

// Suppression d'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['delete'])) {
    $id = intval($_POST['id']);
    $delete = $pdo->prepare("DELETE FROM utilisateurs WHERE id = ?");
    $delete->execute([$id]);
}

try {
    $stmt = $pdo->query("SELECT * FROM utilisateurs WHERE role != 'admin' ORDER BY prenom DESC");
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
            <div class="admin-info">
                <strong> Admin </strong>
                <div class="admin-image">
                    <img src="https://images.pexels.com/photos/189528/pexels-photo-189528.jpeg" alt="">
                </div>
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
                        <img src="<?= htmlspecialchars($user['profil']) ?>" alt="Photo de profil">
                        <div class="user-info">
                            <h2><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></h2>
                            <p><?= htmlspecialchars($user['logn']) ?></p>
                            <span class="date">Inscrit le <?= htmlspecialchars($user['created_at']) ?></span>
                        </div>
                        <form action="admin.php" method="post" style="display:inline; margin-top:2rem" onsubmit="return confirm('Supprimer cet utilisateur ?');">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                            <input type="submit" class="btn delete" name="delete" value="Supprimer">
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>