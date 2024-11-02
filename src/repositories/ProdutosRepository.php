<?php

  require_once ("./src/database/conn.php");

  class ProdutosRepository {

    private $conn;

    function __construct()
    {
      $this->conn = new Database();
    }

    function getAll(): array {
      $stmt = $this->conn->prepare("SELECT * FROM produtos");
      $stmt->execute();      
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getByCode (string $code): array {
      $stmt = $this->conn->prepare("SELECT * FROM produtos WHERE codigo LIKE :codigo");
      $code = "%{$code}%";
      $stmt->execute(["codigo" => $code]);   
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getById (string $id): array {
      $stmt = $this->conn->prepare("SELECT * FROM produtos WHERE id = :id");
      $stmt->execute(["id" => $id])                                             ;   
      $temp = $stmt->fetch(PDO::FETCH_ASSOC)                                    ;
      return $temp ? $temp : []                                                 ;
    }

    function create(array $data): bool {
      $stmt = $this->conn->prepare("INSERT INTO produtos (nome, descricao, codigo, preco, data_criacao) 
                                    VALUES (:nome, :descricao, :codigo, :preco, :data_criacao)");
     return $stmt->execute($data);
    }

    function update(array $data): bool {
      $stmt = $this->conn->prepare("UPDATE produtos SET 
                          nome = :nome, descricao = :descricao, codigo = :codigo, preco = :preco, data_criacao = :data_criacao
                          WHERE id = :id");
     return $stmt->execute($data);
    }

    function delete(string $id): bool {
      $stmt = $this->conn->prepare("DELETE FROM produtos  
                                    WHERE id = :id");
      $stmt->bindParam("id", $id);
     return $stmt->execute();
    }

    function isCodeDuplicated (string $email) : bool {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM produtos WHERE codigo = :codigo");
        $stmt->execute(["codigo" => $email]);
        return (int) $stmt->fetchColumn() > 0;
      }

  }

?>