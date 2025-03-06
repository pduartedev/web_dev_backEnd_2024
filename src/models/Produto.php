<?php

class Produto {
    public $id_estoque;
    public $fornecedor_id_fornecedor;

    public function __construct($id_estoque, $fornecedor_id_fornecedor) {
        $this->id_estoque = $id_estoque;
        $this->fornecedor_id_fornecedor = $fornecedor_id_fornecedor;
    }

    // ...métodos adicionais...
}
?>
