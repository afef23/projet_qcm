<?php
session_start();
require_once '../bdd/database.php';
require_once '../models/Quiz.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$nomUtilisateur = $_SESSION['nom'] ?? "Utilisateur";
$user_id = $_SESSION['user_id'];

$quiz = new Quiz();
$userScores = $quiz->getUserScores($user_id);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes résultats - QCM</title>
    <link rel="icon" type="image/png" href="../Image/logo_violet.svg">

    <style>
        body {
            background: linear-gradient(to bottom, rgba(195, 181, 253, 0.55), rgba(237, 233, 254, 0.5), rgba(255, 255, 255, 1));
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .content {
            width: 90%;
            max-width: 1200px;
            padding: 20px;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function openMenu() {
            document.getElementById("sidebar").classList.remove("-translate-x-full");
        }

        function closeMenu() {
            document.getElementById("sidebar").classList.add("-translate-x-full");
        }
    </script>
</head>

<body>
    <?php include 'menu.php'; ?>

    <nav class="bg-violet-700 p-4 flex justify-between items-center w-full">
        <button onclick="openMenu()" class="text-white text-2xl">&#9776;</button>
        <?php if (isset($_SESSION['nom_utilisateur'])): ?>
            <div class="flex items-center space-x-4 p-3 rounded-lg shadow-md bg-white">
                <!-- Icône utilisateur et nom -->
                <div class="flex items-center space-x-3">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['nom_utilisateur']); ?>&background=6B46C1&color=fff&size=40"
                        alt="Avatar" class="w-10 h-10 rounded-full border border-white shadow">
                    <span class="text-gray-900 font-bold text-lg"><?= htmlspecialchars($_SESSION['nom_utilisateur']); ?></span>
                </div>

                <!-- Bouton de déconnexion -->
                <a href="../controllers/logout.php" class="flex items-center bg-white text-violet-700 px-4 py-2 rounded-lg border border-violet-700 hover:bg-violet-100 transition font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-violet-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V7" />
                    </svg>
                    Déconnexion
                </a>
            </div>
        <?php endif; ?>
    </nav>

    <div class="container mx-auto mt-10">


        <div class="bg-white p-8 rounded-lg shadow-md w-3/4 mx-auto text-center mt-10">
            <h3 class="text-xl font-semibold mb-4">Historique de vos scores</h3>
            <table class="table-auto w-full border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-violet-700 text-white">
                        <th class="px-4 py-2">Quiz</th>
                        <th class="px-4 py-2">Score</th>
                        <th class="px-4 py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($userScores)) : ?>
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-gray-500">Aucun score enregistré.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($userScores as $score) : ?>
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-2"><?= htmlspecialchars($score['titre'] ?? 'Inconnu'); ?></td>
                                <td class="px-4 py-2">
                                    <?= isset($score['score'], $score['total_questions'])
                                        ? htmlspecialchars($score['score'] . '/' . $score['total_questions'])
                                        : 'N/A'; ?>
                                </td>
                                <td class="px-4 py-2">
                                    <?= isset($score['date']) && !empty($score['date'])
                                        ? date("d/m/Y H:i", strtotime($score['date']))
                                        : 'Date inconnue'; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>