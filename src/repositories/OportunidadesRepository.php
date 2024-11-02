<?php

  require_once ("./src/database/conn.php");

  class OportunidadesRepository {

    private $conn;

    function __construct()
    {
      $this->conn = new Database();
    }

    function getAll(): array {
      $stmt = $this->conn->prepare("SELECT * FROM oportunidades");
      $stmt->execute();      
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getByTitle (string $title): array {
      $stmt = $this->conn->prepare("SELECT * FROM oportunidades WHERE titulo LIKE :titulo");
      $title = "%{$title}%";
      $stmt->execute(["titulo" => $title]);   
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getById (string $id): array {
      $stmt = $this->conn->prepare("SELECT * FROM oportunidades WHERE id = :id");
      $stmt->execute(["id" => $id])                                             ;   
      $temp = $stmt->fetch(PDO::FETCH_ASSOC)                                    ;
      return $temp ? $temp : []                                                 ;
    }

    function create(array $data): bool {
      $stmt = $this->conn->prepare("INSERT INTO oportunidades (titulo, valor, data_fechamento, estagio) 
                                    VALUES (:titulo, :valor, :data_fechamento, :estagio)");
     return $stmt->execute($data);
    }

    function update(array $data): bool {
      $stmt = $this->conn->prepare("UPDATE oportunidades SET 
                          titulo = :titulo, valor = :valor, data_fechamento = :data_fechamento, estagio = :estagio
                          WHERE id = :id");
     return $stmt->execute($data);
    }

    function delete(string $id): bool {
      $stmt = $this->conn->prepare("DELETE FROM oportunidades  
                                    WHERE id = :id");
      $stmt->bindParam("id", $id);
     return $stmt->execute();
    }

  }

?>