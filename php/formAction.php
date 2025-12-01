<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon-32x32.png" type="image/x-icon">
	<link rel="stylesheet" href="../css/style.css">
    <title>Mensagem enviada com sucesso!</title>
</head>
<body>
    <header id="header">
        <img src="img/logo.png" alt="logo" id="logo">
        <nav id="top-nav">
            <ul>
                <li><a href="index.php">Início</a></li>
                <li><a href="about.php">Sobre</a></li>
                <li><a href="catalogo.php">Catálogos</a></li>
                <li><a href="form.php">Contato</a></li>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                <li><a href="gerenciar_cartas.php">Gerenciar Cartas</a></li>
                <li><a href="logout.php">Sair (<?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>)</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
	<main class="container">
		<section class="form-result">
			<h1>Dados enviados</h1>
			<p class="muted" id="statusMsg"></p>
            <p id="dadosfornecidos"><strong>Dados:</strong></p>
			<div id="result"></div>
			<p style="margin-top:12px;"><a class="btn-return" href="form.html">Voltar ao formulário</a></p>
		</section>
	</main>

	<script src="../js/main.js" defer></script>
</body>
</html>