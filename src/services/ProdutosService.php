<?php

  require_once("./src/repositories/ProdutosRepository.php");

  class ProdutosService {

    private ProdutosRepository $Repository;

    function __construct()
    {
      $this->Repository = new ProdutosRepository();
    }

    function getMany() {
      return !empty($_GET['codigo']) ? $this->Repository->getBycode($_GET['codigo']) : $this->Repository->getAll();
    }

    function getById(string $id) {
      return $this->Repository->getById($id);
    }

    function create() {    
      $body = json_decode(file_get_contents("php://input"), true);
      
      if (empty($body['nome'])) {
        throw new InvalidArgumentException('Nome é requerido');
      }
      if (empty($body['preco'])) {
        throw new InvalidArgumentException('Preco é requerido');
      }
      if (empty($body['codigo'])) {
        throw new InvalidArgumentException('Código é requerido');
      }

      if($this->isCodeDuplicated($body['codigo'])) {
        throw new InvalidArgumentException('O codigo já esta sendo utilizado');
      }

      $data = [
        "nome"          => $body['nome']                 ,
        "descricao"     => $body['descricao']  ?? null   ,
        "codigo"        => $body['codigo']               ,
        "preco"         => $body['preco']                ,
        "data_criacao"  => $body['data_criacao'] ?? null ,
      ];
      
      if($this->Repository->create($data))  {
        return $data;
      }

    }

    function update(string $id) {
      $product = $this->Repository->getById($id);
      if ($product) {

        $body   = json_decode(file_get_contents("php://input"), true);

        if (empty($body['nome'])) {
            throw new InvalidArgumentException('Nome é requerido');
          }
        if (empty($body['preco'])) {
            throw new InvalidArgumentException('Preco é requerido');
        }
        if (empty($body['codigo'])) {
            throw new InvalidArgumentException('Código é requerido');
        }
      
        $data = [
            "id"            => $id                           ,
            "nome"          => $body['nome']                 ,
            "descricao"     => $body['descricao'] ?? null    ,
            "codigo"        => $body['codigo']               ,
            "preco"         => $body['preco']                ,
            "data_criacao"  => $body['data_criacao'] ?? null ,
        ]; 
    
        return $this->Repository->update($data)     ;       
  
      } else {
        return false;
      }
    }

    function delete(string $id) {
      $product = $this->Repository->getById($id);
      if ($product) {
        return $this->Repository->delete($id);       
      } else {
       return false;
      }
    }

    function isCodeDuplicated (string $code) : bool {
        return $this->Repository->isCodeDuplicated($code); 
      }

  }
  
?>