<?php
require_once 'config.php';
verificarAutenticacao();

$mensagem = '';
$tipoMensagem = '';

// Processar ações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = conectarDB();
    
    if (isset($_POST['acao'])) {
        switch ($_POST['acao']) {
            case 'criar':
                $nome = trim($_POST['nome'] ?? '');
                $raridade = trim($_POST['raridade'] ?? '');
                $quantidade = intval($_POST['quantidade'] ?? 0);
                $valor = floatval($_POST['valor'] ?? 0);
                
                if (!empty($nome) && !empty($raridade)) {
                    $stmt = $conn->prepare("INSERT INTO cartas (nome, raridade, quantidade, valor) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssid", $nome, $raridade, $quantidade, $valor);
                    
                    if ($stmt->execute()) {
                        $mensagem = 'Carta criada com sucesso!';
                        $tipoMensagem = 'sucesso';
                    } else {
                        $mensagem = 'Erro ao criar carta.';
                        $tipoMensagem = 'erro';
                    }
                    $stmt->close();
                }
                break;
                
            case 'editar':
                $id = intval($_POST['id'] ?? 0);
                $nome = trim($_POST['nome'] ?? '');
                $raridade = trim($_POST['raridade'] ?? '');
                $quantidade = intval($_POST['quantidade'] ?? 0);
                $valor = floatval($_POST['valor'] ?? 0);
                
                if ($id > 0 && !empty($nome) && !empty($raridade)) {
                    $stmt = $conn->prepare("UPDATE cartas SET nome = ?, raridade = ?, quantidade = ?, valor = ? WHERE id_cartas = ?");
                    $stmt->bind_param("ssidi", $nome, $raridade, $quantidade, $valor, $id);
                    
                    if ($stmt->execute()) {
                        $mensagem = 'Carta atualizada com sucesso!';
                        $tipoMensagem = 'sucesso';
                    } else {
                        $mensagem = 'Erro ao atualizar carta.';
                        $tipoMensagem = 'erro';
                    }
                    $stmt->close();
                }
                break;
                
            case 'deletar':
                $id = intval($_POST['id'] ?? 0);
                
                if ($id > 0) {
                    $stmt = $conn->prepare("DELETE FROM cartas WHERE id_cartas = ?");
                    $stmt->bind_param("i", $id);
                    
                    if ($stmt->execute()) {
                        $mensagem = 'Carta deletada com sucesso!';
                        $tipoMensagem = 'sucesso';
                    } else {
                        $mensagem = 'Erro ao deletar carta.';
                        $tipoMensagem = 'erro';
                    }
                    $stmt->close();
                }
                break;
        }
    }
    
    $conn->close();
}

// Buscar todas as cartas
$conn = conectarDB();
$result = $conn->query("SELECT * FROM cartas ORDER BY id_cartas DESC");
$cartas = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();

// Buscar carta para edição (se houver)
$cartaEdicao = null;
if (isset($_GET['editar'])) {
    $idEditar = intval($_GET['editar']);
    $conn = conectarDB();
    $stmt = $conn->prepare("SELECT * FROM cartas WHERE id_cartas = ?");
    $stmt->bind_param("i", $idEditar);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $cartaEdicao = $result->fetch_assoc();
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Cartas</title>
    <link rel="shortcut icon" href="../img/favicon-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/cards.css">
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
        <h1>Gerenciar Cartas</h1>
        
        <?php if ($mensagem): ?>
            <div class="mensagem <?php echo $tipoMensagem; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>
        
        <!-- Formulário de Criar/Editar -->
        <section class="form-section">
            <h2><?php echo $cartaEdicao ? 'Editar Carta' : 'Nova Carta'; ?></h2>
            <form method="POST" action="gerenciar_cartas.php">
                <input type="hidden" name="acao" value="<?php echo $cartaEdicao ? 'editar' : 'criar'; ?>">
                <?php if ($cartaEdicao): ?>
                    <input type="hidden" name="id" value="<?php echo $cartaEdicao['id_cartas']; ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="nome">Nome da Carta:</label>
                    <input type="text" id="nome" name="nome" required 
                           value="<?php echo htmlspecialchars($cartaEdicao['nome'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="raridade">Raridade:</label>
                    <select id="raridade" name="raridade" required>
                        <option value="">Selecione...</option>
                        <option value="Comum" <?php echo ($cartaEdicao['raridade'] ?? '') === 'Comum' ? 'selected' : ''; ?>>Comum</option>
                        <option value="Incomum" <?php echo ($cartaEdicao['raridade'] ?? '') === 'Incomum' ? 'selected' : ''; ?>>Incomum</option>
                        <option value="Rara" <?php echo ($cartaEdicao['raridade'] ?? '') === 'Rara' ? 'selected' : ''; ?>>Rara</option>
                        <option value="Super Rara" <?php echo ($cartaEdicao['raridade'] ?? '') === 'Super Rara' ? 'selected' : ''; ?>>Super Rara</option>
                        <option value="Ultra Rara" <?php echo ($cartaEdicao['raridade'] ?? '') === 'Ultra Rara' ? 'selected' : ''; ?>>Ultra Rara</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="quantidade">Quantidade:</label>
                    <input type="number" id="quantidade" name="quantidade" min="0" required 
                           value="<?php echo $cartaEdicao['quantidade'] ?? 0; ?>">
                </div>
                
                <div class="form-group">
                    <label for="valor">Valor (R$):</label>
                    <input type="number" id="valor" name="valor" step="0.01" min="0" required 
                           value="<?php echo $cartaEdicao['valor'] ?? 0; ?>">
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">
                        <?php echo $cartaEdicao ? 'Atualizar' : 'Criar'; ?>
                    </button>
                    <?php if ($cartaEdicao): ?>
                        <a href="gerenciar_cartas.php" class="btn btn-secondary">Cancelar</a>
                    <?php endif; ?>
                </div>
            </form>
        </section>
        
        <!-- Lista de Cartas -->
        <section class="form-section">
            <h2>Lista de Cartas</h2>
            <?php if (empty($cartas)): ?>
                <p>Nenhuma carta cadastrada ainda.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Raridade</th>
                            <th>Quantidade</th>
                            <th>Valor (R$)</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartas as $carta): ?>
                            <tr>
                                <td><?php echo $carta['id_cartas']; ?></td>
                                <td><?php echo htmlspecialchars($carta['nome']); ?></td>
                                <td><?php echo htmlspecialchars($carta['raridade']); ?></td>
                                <td><?php echo $carta['quantidade']; ?></td>
                                <td>R$ <?php echo number_format($carta['valor'], 2, ',', '.'); ?></td>
                                <td>
                                    <div class="acoes">
                                        <a href="?editar=<?php echo $carta['id_cartas']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                        <form method="POST" action="gerenciar_cartas.php" style="display: inline;">
                                            <input type="hidden" name="acao" value="deletar">
                                            <input type="hidden" name="id" value="<?php echo $carta['id_cartas']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Tem certeza que deseja deletar esta carta?');">
                                                Deletar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>

