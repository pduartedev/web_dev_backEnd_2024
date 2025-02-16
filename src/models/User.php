<?php

class User {
    private $id;
    private $name;
    private $email;

    public function __construct($name, $email) {
        $this->name = $name;
        $this->email = $email;
    }

    public function create() {
        // Lógica para criar um novo usuário no banco de dados
    }

    public function find($id) {
        // Lógica para encontrar um usuário pelo ID
    }

    public function delete($id) {
        // Lógica para deletar um usuário pelo ID
    }

    // Getters e Setters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
}