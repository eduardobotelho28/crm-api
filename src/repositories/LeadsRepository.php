<?php

  require_once ("./src/database/conn.php");

  class LeadsRepository {

    private $conn;

    function __construct()
    {
      $this->conn = new Database();
    }

    function getAll(): array {
      $stmt = $this->conn->prepare("SELECT * FROM leads");
      $stmt->execute();      
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getByName (string $name): array {
      $stmt = $this->conn->prepare("SELECT * FROM leads WHERE nome LIKE :nome");
      $name = "%{$name}%";
      $stmt->execute(["nome" => $name]);   
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getById (string $id): array {
      $stmt = $this->conn->prepare("SELECT * FROM leads WHERE id = :id");
      $stmt->execute(["id" => $id])                                     ;   
      $temp = $stmt->fetch(PDO::FETCH_ASSOC)                            ;
      return $temp ? $temp : []                                         ;
    }

    function create(array $data): bool {
      $stmt = $this->conn->prepare("INSERT INTO leads (nome, email, telefone, origem) 
                                    VALUES (:nome, :email, :telefone, :origem)");
     return $stmt->execute($data);
    }

    function update(array $lead): bool {
      $stmt = $this->conn->prepare("UPDATE leads SET 
                          nome = :nome, email = :email, telefone = :telefone, origem = :origem
                          WHERE id = :id");
     return $stmt->execute($lead);
    }

    function delete(string $id): bool {
      $stmt = $this->conn->prepare("DELETE FROM leads  
                                    WHERE id = :id");
      $stmt->bindParam("id", $id);
     return $stmt->execute();
    }

    function isEmailDuplicated (string $email) : bool {
      $stmt = $this->conn->prepare("SELECT COUNT(*) FROM leads WHERE email = :email");
      $stmt->execute(["email" => $email]);
      return (int) $stmt->fetchColumn() > 0;
    }

  }

?>