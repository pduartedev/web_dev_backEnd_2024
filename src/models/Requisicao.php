<?php

class Requisicao {
    public $id_requisicao;
    public $produto_id_produto;
    public $quantidade;
    public $data_requisicao;

    public function __construct($id_requisicao, $produto_id_produto, $quantidade, $data_requisicao) {
        $this->id_requisicao = $id_requisicao;
        $this->produto_id_produto = $produto_id_produto;
        $this->quantidade = $quantidade;
        $this->data_requisicao = $data_requisicao;
    }

    // ...métodos adicionais...
}
?>
