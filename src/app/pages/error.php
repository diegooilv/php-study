<?php
$code = $_GET['code'] ?? 500;
$msg = $_GET['msg'] ?? 'Erro interno';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro <?= $code ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <main class="container">
        <h1><?= $code ?></h1>
        <p><?= htmlspecialchars($msg) ?></p>
        <a href="/">Voltar ao início</a>
    </main>
</body>

</html>