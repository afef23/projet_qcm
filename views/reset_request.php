<?php
session_start();

// Récupérer les messages d'erreur et de succès
$errorMessage = $_SESSION['error_message'] ?? null;
$successMessage = $_SESSION['success_message'] ?? null;
unset($_SESSION['error_message'], $_SESSION['success_message']);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <link rel="icon" type="image/png" href="../Image/logo_violet.svg">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function openMenu() {
            document.getElementById("sidebar").classList.remove("-translate-x-full");
        }

        function closeMenu() {
            document.getElementById("sidebar").classList.add("-translate-x-full");
        }
    </script>
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
</head>

<body>
    <?php include 'menu.php'; ?>

    <!-- Navbar -->
    <nav class="bg-violet-700 p-4 flex justify-between items-center w-full">
        <button onclick="openMenu()" class="text-white text-2xl">&#9776;</button>
        <div>
            <a href="register.php" class="bg-white text-violet-700 px-4 py-2 rounded mr-2">S'inscrire</a>
            <a href="login.php" class="bg-gray-900 text-white px-4 py-2 rounded">Se connecter</a>
        </div>
    </nav>

    <!-- Formulaire de demande de réinitialisation -->
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-8 rounded-lg shadow-md w-96">
            <h2 class="text-2xl font-semibold text-center mb-6">Mot de passe oublié</h2>

            <!-- Messages d'erreur / succès -->
            <?php if ($errorMessage): ?>
                <p class="text-red-500 text-center mb-4"><?= htmlspecialchars($errorMessage); ?></p>
            <?php endif; ?>
            <?php if ($successMessage): ?>
                <p class="text-green-500 text-center mb-4"><?= htmlspecialchars($successMessage); ?></p>
            <?php endif; ?>

            <form action="../controllers/reset_request_process.php" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700">Entrez votre email :</label>
                    <input type="email" name="email" class="w-full p-2 border rounded mt-1" required>
                </div>
                <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Envoyer</button>
            </form>
        </div>
    </div>

</body>

</html>