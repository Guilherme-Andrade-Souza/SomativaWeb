<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon-32x32.png" type="image/x-icon">
	<link rel="stylesheet" href="../css/style.css">    
    <title>Catalogo</title>
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
    <section>
        <div id="catalogos">
            <h2>Veja nosso catalogo a venda</h2>
            
            <!-- Abas de filtro -->
            <div id="filtros-abas">
                <button class="aba-filtro active" data-filtro="todos">Todos</button>
                <button class="aba-filtro" data-filtro="pokemon">Pokémon</button>
                <button class="aba-filtro" data-filtro="yugioh">Yu-Gi-Oh</button>
                <button class="aba-filtro" data-filtro="magic">Magic</button>
            </div>
            
            <div id="display_pokemon" class="categoria-cartas" data-categoria="pokemon">
                <img class="pokemon_card" src="../img/pokemon-cards/1.jpeg" alt="" >
                <img class="pokemon_card" src="../img/pokemon-cards/2.jpeg" alt="" >
                <img class="pokemon_card" src="../img/pokemon-cards/3.jpeg" alt="" >
                <img class="pokemon_card" src="../img/pokemon-cards/4.jpeg" alt="" >
                <img class="pokemon_card" src="../img/pokemon-cards/6.jpg" alt="" >
                <img class="pokemon_card" src="../img/pokemon-cards/7.jpg" alt="" >
                <img class="pokemon_card" src="../img/pokemon-cards/8.jpg" alt="" >
                <img class="pokemon_card" src="../img/pokemon-cards/9.jpg" alt="" >
                <img class="pokemon_card" src="../img/pokemon-cards/10.jpg" alt="" >
            </div>
            <div id="display_yugioh" class="categoria-cartas" data-categoria="yugioh">
                <img class="yugioh_card" src="../img/yugioh-cards/1.jpeg" alt="">
                <img class="yugioh_card" src="../img/yugioh-cards/2.jpeg" alt="">
                <img class="yugioh_card" src="../img/yugioh-cards/3.jpeg" alt="">
                <img class="yugioh_card" src="../img/yugioh-cards/4.jpeg" alt="">
                <img class="yugioh_card" src="../img/yugioh-cards/5.jpeg" alt="">
                <img class="yugioh_card" src="../img/yugioh-cards/6.jpeg" alt="">
                <img class="yugioh_card" src="../img/yugioh-cards/7.jpg" alt="">
                <img class="yugioh_card" src="../img/yugioh-cards/8.jpg" alt="">
                <img class="yugioh_card" src="../img/yugioh-cards/9.jpg" alt="">
                <img class="yugioh_card" src="../img/yugioh-cards/10.jpg" alt="">
                <img class="yugioh_card" src="../img/yugioh-cards/11.jpg" alt="">
            </div>
            <div id="display_magic" class="categoria-cartas" data-categoria="magic">
    
            </div>
        </div>       
    </section>

    <script src="../js/main.js" defer></script>
</body>
</html>