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
    <title>Historia Pweb</title>
</head>
<body>
    <header id="header">
        <img src="../img/logo.png" alt="logo" id="logo">
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
    <section id="quem_somos_contatos">
        <div id="quem_somos">
            <h1>Quem Somos</h1>
            <p>
            <br>A Pweb TCGcards nasceu de uma paixão que compartilhamos com você: a estratégia, a coleção e a emoção de cada booster aberto. Somos mais do que apenas uma loja; somos jogadores, colecionadores e entusiastas dedicados ao universo dos Trading Card Games.<br>
            <br>
            Nossa missão é ser o ponto de encontro definitivo para a comunidade TCG. Oferecemos uma seleção criteriosa dos seus jogos favoritos, desde os últimos lançamentos até cards raros e acessórios essenciais para proteger seu deck.<br>
            <br>
            Entendemos a importância de um ambiente confiável e justo. Por isso, cada produto em nosso catálogo é tratado com o máximo cuidado, garantindo autenticidade e qualidade. Na Pweb TCGcards, você não é apenas um cliente, mas parte de uma comunidade crescente que celebra a cultura TCG.<br>
            <br>
            Seja você um duelista competitivo buscando a carta que falta para o seu meta, ou um colecionador em busca daquela peça especial, estamos aqui para ajudar sua jornada no hobby.<br>
            <br>
            </p>
        </div>
    </section>
</main>
<script src="../js/main.js" defer></script>
</body>
</html>