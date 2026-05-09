<?php

require_once __DIR__ . '/require.php';

$user = PagesController::verifyLogin();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <main class="container">
        <h1>Perfil</h1>

        <label class="dashboard-label">Nome</label>
        <p class="dashboard-card"><?= htmlspecialchars($user['name']) ?></p>

        <label class="dashboard-label">Email</label>
        <p class="dashboard-card"><?= htmlspecialchars($user['email']) ?></p>

        <label class="dashboard-label">Telefone</label>
        <p class="dashboard-card"><?= htmlspecialchars($user['phone'] ?? '-') ?></p>

        <label class="dashboard-label">Bio</label>
        <p class="dashboard-card"><?= htmlspecialchars($user['bio'] ?? '-') ?></p>

        <label class="dashboard-label">Cargo</label>
        <p class="dashboard-card"><?= htmlspecialchars(ucfirst($user['role']) ?? '-') ?></p>

        <a href="/logout">Sair</a>
    </main>
</body>

</html>