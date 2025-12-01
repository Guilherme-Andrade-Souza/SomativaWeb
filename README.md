# Pweb TCGcards - Aplicação Full-Stack

Aplicação web full-stack desenvolvida para avaliação somativa, utilizando HTML, CSS, JavaScript, PHP e MySQL.

## 📋 Requisitos Atendidos

### 1. Área de Negócio
- **Domínio**: Loja de Trading Card Games (TCG)
- **Descrição**: Sistema de gerenciamento de cartas para uma loja especializada em jogos de cartas colecionáveis (Pokémon, Yu-Gi-Oh, Magic: The Gathering)

### 2. Base de Dados MySQL
- **Banco de dados**: `somativa_web`
- **Tabelas com relacionamento 1xN**:
  - `login` → `contato` (1 usuário pode ter N contatos)
  - `login` → `pedidos` (1 usuário pode ter N pedidos)
  - `pedidos` → `pedidos_cartas` (1 pedido pode ter N cartas)
  - `cartas` → `pedidos_cartas` (1 carta pode estar em N pedidos)

### 3. Sistema de Autenticação
- Tabela `login` com senhas criptografadas usando `password_hash()` do PHP
- Cadastro de novos usuários com validação
- Sistema de login com sessões

### 4. Tratamento de Login
- Acesso restrito apenas para usuários autenticados
- Proteção de rotas usando sessões PHP
- Redirecionamento automático para login quando não autenticado

### 5. Interface Padronizada (Front-end)
- HTML5 semântico
- CSS customizado
- JavaScript para interatividade
- Design responsivo
- CRUD acessível apenas para usuários autenticados

### 6. Back-end PHP com CRUD Completo
- **CREATE**: Criar novas cartas
- **READ**: Listar todas as cartas
- **UPDATE**: Editar cartas existentes
- **DELETE**: Deletar cartas
- Todas as operações protegidas por autenticação

## 🚀 Instalação e Configuração

### Pré-requisitos
- Servidor web (Apache/Nginx)
- PHP 7.4 ou superior
- MySQL 5.7 ou superior

### Passos para Instalação

1. **Clone ou copie o projeto** para o diretório do servidor web

2. **Configure o banco de dados**:
   ```sql
   -- Execute os scripts na ordem:
   -- 1. SQL/db.sql (criação do banco e tabelas)
   -- 2. SQL/update_db.sql (atualização para senhas criptografadas)
   -- 3. SQL/users.sql (criação de usuários do banco)
   -- 4. SQL/dados_iniciais.sql (dados de exemplo - opcional)
   ```

3. **Configure as credenciais** no arquivo `php/config.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'user');
   define('DB_PASS', 'U&c56xLW%m');
   define('DB_NAME', 'somativa_web');
   ```

4. **Acesse a aplicação**:
   - URL: `http://localhost/SomativaWeb/php/index.php`


Ou criar uma nova conta através da interface web.

## 🎯 Funcionalidades

### Públicas (sem autenticação)
- Visualizar página inicial
- Visualizar catálogo de cartas
- Visualizar página "Sobre"
- Enviar formulário de contato
- Criar nova conta

### Protegidas (requer autenticação)
- Gerenciar cartas (CRUD completo)
  - Criar novas cartas
  - Listar todas as cartas
  - Editar cartas existentes
  - Deletar cartas

## 🛠️ Tecnologias Utilizadas

- **Front-end**: HTML5, CSS3, JavaScript (ES6+)
- **Back-end**: PHP 7.4+
- **Banco de Dados**: MySQL 5.7+
- **Segurança**: password_hash(), prepared statements, sessões PHP

## 📝 Notas Importantes

- As senhas são criptografadas usando `password_hash()` do PHP
- Todas as consultas SQL usam prepared statements para prevenir SQL injection
- As rotas protegidas verificam autenticação antes de permitir acesso
- O sistema suporta migração de senhas MD5 antigas para password_hash

## 👨‍💻 Desenvolvido para

Atividade Somativa 2 - Desenvolvimento Web Full-Stack

