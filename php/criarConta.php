<?php
require_once 'config.php';
redirecionarSeLogado();

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $usuario = trim($_POST['usuario'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmarSenha = $_POST['confirmarSenha'] ?? '';
    
    if (empty($nome) || empty($email) || empty($usuario) || empty($senha) || empty($confirmarSenha)) {
        $erro = 'Por favor, preencha todos os campos.';
    } elseif ($senha !== $confirmarSenha) {
        $erro = 'As senhas não coincidem.';
    } elseif (strlen($senha) < 6) {
        $erro = 'A senha deve ter pelo menos 6 caracteres.';
    } else {
        $conn = conectarDB();
        
        // Verificar se o usuário já existe
        $stmt = $conn->prepare("SELECT id_login FROM login WHERE usuario = ? OR email = ?");
        $stmt->bind_param("ss", $usuario, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $erro = 'Usuário ou email já cadastrado.';
        } else {
            // Criptografar senha
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            
            // Inserir novo usuário
            $insertStmt = $conn->prepare("INSERT INTO login (nome, usuario, senha, email) VALUES (?, ?, ?, ?)");
            $insertStmt->bind_param("ssss", $nome, $usuario, $senhaHash, $email);
            
            if ($insertStmt->execute()) {
                $sucesso = 'Conta criada com sucesso! Você pode fazer login agora.';
                // Limpar campos após sucesso
                $nome = $email = $usuario = '';
            } else {
                $erro = 'Erro ao criar conta. Tente novamente.';
            }
            
            $insertStmt->close();
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
    <title>Criar Conta</title>
    <link rel="shortcut icon" href="../img/favicon-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/criarConta.css">
</head>
<body>
    <header id="header">
        <img src="../img/logo.png" alt="logo" id="logo">
        <nav id="top-nav">
            <ul>
                <li><a href="index.php">Início</a></li>
                <li><a href="../about.html">Sobre</a></li>
                <li><a href="../catalogo.html">Catálogos</a></li>
                <li><a href="../form.html">Contato</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>
    <main class="container">
        <section class="form-section">
            <div class="form-container">
                <h2 class="form-title">Criar Conta</h2>
                
                <?php if ($erro): ?>
                    <div style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                        <?php echo htmlspecialchars($erro); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($sucesso): ?>
                    <div style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                        <?php echo htmlspecialchars($sucesso); ?>
                    </div>
                <?php endif; ?>
                
                <form class="form" action="criarConta.php" method="POST">
                    <div class="form-group">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input 
                            type="text" 
                            id="nome" 
                            name="nome" 
                            class="form-input"
                            placeholder="Digite seu nome completo"
                            required
                            value="<?php echo htmlspecialchars($nome ?? ''); ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input"
                            placeholder="Digite seu email"
                            required
                            value="<?php echo htmlspecialchars($email ?? ''); ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="usuario" class="form-label">Usuário</label>
                        <input 
                            type="text" 
                            id="usuario" 
                            name="usuario" 
                            class="form-input"
                            placeholder="Escolha um usuário"
                            required
                            value="<?php echo htmlspecialchars($usuario ?? ''); ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="senha" class="form-label">Senha</label>
                        <input 
                            type="password" 
                            id="senha" 
                            name="senha" 
                            class="form-input"
                            placeholder="Crie uma senha"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="confirmarSenha" class="form-label">Confirmar Senha</label>
                        <input 
                            type="password" 
                            id="confirmarSenha" 
                            name="confirmarSenha" 
                            class="form-input"
                            placeholder="Confirme sua senha"
                            required
                        >
                    </div>

                    <div class="form-checkbox-group">
                        <label class="form-checkbox">
                            <input type="checkbox" name="termos" required>
                            <span>Concordo com os <a href="#" class="form-link">Termos de Serviço</a></span>
                        </label>
                    </div>

                    <button type="submit" class="form-button">Criar Conta</button>
                </form>

                <div class="form-footer">
                    <p>Já tem conta? <a href="login.php" class="form-link">Fazer login</a></p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>

