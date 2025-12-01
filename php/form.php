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
	<link rel="stylesheet" href="../css/styleForm.css">
	<title>Contato - Pweb TCGcards</title>
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
		<section class="form-wrap" aria-labelledby="form-title">
			<h1 id="form-title">Fale conosco</h1>
			<p class="muted">Preencha o formulário abaixo e responderemos o mais breve possível.</p>

			<form id="contactForm" action="formAction.php" method="get" >
				<div class="row">
					<div class="form-control">
						<label for="name">Nome completo</label>
						<input id="name" name="name" type="text" required placeholder="Seu nome completo" />
					</div>
					<div class="form-control">
						<label for="email">Email</label>
						<input id="email" name="email" type="email" required placeholder="seu@email.com" />
					</div>
				</div>

				<div class="row">
					<div class="form-control">
						<label for="phone">Telefone</label>
						<input id="phone" name="phone" type="tel" placeholder="(41) 9 9999-9999" />
					</div>
					<div class="form-control">
						<label for="subject">Assunto</label>
						<select id="subject" name="subject" required>
							<option value="">Selecione...</option>
							<option value="produto">Informações sobre produto</option>
							<option value="pedido">Dúvida sobre pedido</option>
							<option value="suporte">Suporte / Garantia</option>
							<option value="outros">Outros</option>
						</select>
					</div>
				</div>

				<div class="form-control">
					<label for="message">Mensagem</label>
					<textarea id="message" name="message" required placeholder="Descreva sua mensagem"></textarea>
				</div>

				<div class="form-actions" style="margin-top:12px;">
					<button class="btn-submit" type="submit">Enviar mensagem</button>
					<button class="btn" type="button" id="resetBtn">Limpar</button>
				</div>

				<p id="formFeedback" role="status" aria-live="polite" class="muted" style="margin-top:10px;"></p>
			</form>
		</section>
	</main>

	<footer id="footer">
		<p id="texto_footer">Todos os direitos exclusivos do Pweb TCGcards™</p>
	</footer>

	<script src="../js/main.js" defer></script>
</body>
</html>