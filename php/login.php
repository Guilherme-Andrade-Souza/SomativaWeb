<?php
require_once 'config.php';
redirecionarSeLogado();

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $senha = $_POST['senha'] ?? '';
    
    if (empty($usuario) || empty($senha)) {
        $erro = 'Por favor, preencha todos os campos.';
    } else {
        $conn = conectarDB();
        
        $stmt = $conn->prepare("SELECT id_login, nome, usuario, senha FROM login WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verificar senha (suporta tanto MD5 antigo quanto password_hash)
            if (password_verify($senha, $user['senha']) || md5($senha) === $user['senha']) {
                $_SESSION['usuario_id'] = $user['id_login'];
                $_SESSION['usuario_nome'] = $user['nome'];
                $_SESSION['usuario'] = $user['usuario'];
                
                // Se a senha estava em MD5, atualizar para password_hash
                if (md5($senha) === $user['senha']) {
                    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
                    $updateStmt = $conn->prepare("UPDATE login SET senha = ? WHERE id_login = ?");
                    $updateStmt->bind_param("si", $senhaHash, $user['id_login']);
                    $updateStmt->execute();
                }
                
                header('Location: index.php');
                exit();
            } else {
                $erro = 'Usuário ou senha incorretos.';
            }
        } else {
            $erro = 'Usuário ou senha incorretos.';
        }
        
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="../img/favicon-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">
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
        <section class="form-section">
            <div class="form-container">
                <h2 class="form-title">Login</h2>
                
                <?php if ($erro): ?>
                    <div style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                        <?php echo htmlspecialchars($erro); ?>
                    </div>
                <?php endif; ?>
                
                <form class="form" action="login.php" method="POST">
                    <div class="form-group">
                        <label for="usuario" class="form-label">Usuário</label>
                        <input 
                            type="text" 
                            id="usuario" 
                            name="usuario" 
                            class="form-input"
                            placeholder="Digite seu usuário"
                            required
                            value="<?php echo htmlspecialchars($_POST['usuario'] ?? ''); ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="senha" class="form-label">Senha</label>
                        <input 
                            type="password" 
                            id="senha" 
                            name="senha" 
                            class="form-input"
                            placeholder="Digite sua senha"
                            required
                        >
                    </div>

                    <div class="form-options">
                        <label class="form-checkbox">
                            <input type="checkbox" name="lembrar">
                            <span>Lembrar-me</span>
                        </label>
                        <a href="#" class="form-link">Esqueceu a senha?</a>
                    </div>

                    <button type="submit" class="form-button">Entrar</button>
                </form>

                <div class="form-footer">
                    <p>Não tem conta? <a href="criarConta.php" class="form-link">Criar conta</a></p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>

