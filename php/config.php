<?php
// Configuração de conexão com o banco de dados
define('DB_HOST', 'localhost');
define('DB_USER', 'user');
define('DB_PASS', 'U&c56xLW%m');
define('DB_NAME', 'somativa_web');

// Iniciar sessão se ainda não foi iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Função para conectar ao banco de dados
function conectarDB() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8");
    return $conn;
}

// Função para verificar se o usuário está autenticado
function verificarAutenticacao() {
    if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['usuario_nome'])) {
        header('Location: login.php');
        exit();
    }
}

// Função para redirecionar se já estiver logado
function redirecionarSeLogado() {
    if (isset($_SESSION['usuario_id'])) {
        header('Location: index.php');
        exit();
    }
}
?>

