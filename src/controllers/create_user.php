<?php
require_once '../../config/database.php';
require_once '../models/User.php';

// Obter conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();

// Criar instância do usuário
$user = new User($db);
$user->nome_usuario = 'admin';
$user->email = 'admin@example.com';
$user->senha = 'admin';
$user->permissao = 1; // Permissão deve ser um inteiro
$user->status = 'ativo';
$user->dt_cadastro = date('Y-m-d H:i:s');

// Criar usuário
if ($user->create()) {
    echo "Usuário criado com sucesso.";
} else {
    echo "Erro ao criar usuário.";
}
?>