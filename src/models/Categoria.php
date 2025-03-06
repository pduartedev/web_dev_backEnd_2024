<?php

class Categoria {
    public $id_categoria;
    public $nome;
    public $status;

    public function __construct($id_categoria, $nome, $status) {
        $this->id_categoria = $id_categoria;
        $this->nome = $nome;
        $this->status = $status;
    }

    // ...métodos adicionais...
}
?>
