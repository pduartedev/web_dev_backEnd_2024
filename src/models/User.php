<?php
require_once '../../config/database.php';

class User {
    private $conn;
    private $table_name = "usuarios";

    public $id_usuario;
    public $nome_usuario;
    public $email;
    public $senha;
    public $permissao;
    public $status;
    public $dt_cadastro;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Criar um novo usuário
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nome_usuario=:nome_usuario, email=:email, senha=:senha, permissao=:permissao, status=:status, dt_cadastro=:dt_cadastro";
        $stmt = $this->conn->prepare($query);

        // Sanitizar
        $this->nome_usuario = htmlspecialchars(strip_tags($this->nome_usuario));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->senha = htmlspecialchars(strip_tags($this->senha));
        $this->permissao = htmlspecialchars(strip_tags($this->permissao));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->dt_cadastro = htmlspecialchars(strip_tags($this->dt_cadastro));

        // Bind
        $stmt->bindParam(":nome_usuario", $this->nome_usuario);
        $stmt->bindParam(":email", $this->email);
        $hashed_password = password_hash($this->senha, PASSWORD_BCRYPT);
        $stmt->bindParam(":senha", $hashed_password);
        $stmt->bindParam(":permissao", $this->permissao, PDO::PARAM_INT);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":dt_cadastro", $this->dt_cadastro);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Encontrar um usuário pelo nome_usuario
    public function findByUsername() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE nome_usuario = :nome_usuario LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        // Bind
        $stmt->bindParam(":nome_usuario", $this->nome_usuario);

        $stmt->execute();

        return $stmt;
    }
}
?>