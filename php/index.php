<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/favicon-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <title>Bem Vindo Pweb TCGcards</title>
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
    <main>
        <section class="hero-section">
            <h1 class="hero-title">Bem-vindo à Pweb TCGcards</h1>
            <p class="hero-subtitle">Sua loja especializada em Trading Card Games</p>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <p style="text-align: center; margin-top: 20px; color: #28a745;">
                    Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>! Você está logado.
                </p>
            <?php endif; ?>
        </section>

        <section class="actions-section">
            <div id="catalogos">
                <h3>Catálogo</h3>
                <p class="section-description">Explore nossa coleção completa de cards</p>
                <button class="aba-filtro" data-navigate="catalogo.php">Acessar Catálogo</button>
            </div>
            
            <div class="contact-section">
                <h3>Entre em contato</h3>
                <p class="section-description">Tire suas dúvidas ou faça seu pedido</p>
                <button class="button-intection" data-navigate="form.php">Fale Conosco</button>
            </div>
            
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <div class="contact-section">
                    <h3>Gerenciar Cartas</h3>
                    <p class="section-description">Acesse o painel de administração</p>
                    <button class="button-intection" data-navigate="gerenciar_cartas.php">Gerenciar</button>
                </div>
            <?php endif; ?>
        </section>
    </main>
    <footer id="footer">
        <div class="footer-content">
            <div id="informações">
                <h4>Contato</h4>
                <p><strong>Telefone:</strong> (41) 9 9999-9999</p>
                <p><strong>Email:</strong> pwegtcgcards.comercial@gmail.com</p>
                <p><strong>Endereço:</strong> Rua Pitangas, 123 - Centro, Curitiba - PR</p>
            </div>
        </div>
        <p id="texto_footer">Todos os direitos exclusivos do Pweb TCGcards™</p>
    </footer>
    <script src="../js/main.js" defer></script>
</body>
</html>

