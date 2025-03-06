<?php

class Fornecedor {
    public $id_fornecedor;
    public $nome;
    public $email;
    public $cnpj;
    public $telefone;
    public $status;

    public function __construct($id_fornecedor, $nome, $email, $cnpj, $telefone, $status) {
        $this->id_fornecedor = $id_fornecedor;
        $this->nome = $nome;
        $this->email = $email;
        $this->cnpj = $cnpj;
        $this->telefone = $telefone;
        $this->status = $status;
    }

    // ...métodos adicionais...
}
?>
