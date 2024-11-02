<?php

  require_once("./src/repositories/LeadsRepository.php");

  class LeadsService {

    private LeadsRepository $Repository;

    function __construct()
    {
      $this->Repository = new LeadsRepository();
    }

    function getMany() {
      return !empty($_GET['nome']) ? $this->Repository->getByName($_GET['nome']) : $this->Repository->getAll();
    }

    function getById(string $id) {
      return $this->Repository->getById($id);
    }

    function create() {    
      $body = json_decode(file_get_contents("php://input"), true);
      
      if (empty($body['nome'])) {
        throw new InvalidArgumentException('Nome é requerido');
      }
      if (empty($body['email'])) {
        throw new InvalidArgumentException('Email é requerido');
      }

      if(!$this->isEmailValid($body['email'])) {
        throw new InvalidArgumentException('Email inválido');
      }

      if($this->isEmailDuplicated($body['email'])) {
        throw new InvalidArgumentException('Email já esta sendo utilizado');
      }

      $data = [
        "nome"     => $body['nome']               ,
        "email"    => $body['email']              ,
        "telefone" => $body['telefone'] ?? null   , 
        "origem"   => $body['origem']   ?? null   , 
      ];

      if($this->Repository->create($data))  {
        return $data;
      }

    }

    function update(string $id) {
      $lead = $this->Repository->getById($id);
      if ($lead) {

        $body   = json_decode(file_get_contents("php://input"), true);
      
        if (empty($body['nome'])) {
          throw new InvalidArgumentException('Nome é requerido');
        }
        if (empty($body['email'])) {
          throw new InvalidArgumentException('Email é requerido');
        }
  
        if(!$this->isEmailValid($body['email'])) {
          throw new InvalidArgumentException('Email inválido');
        }
  
        // if($this->isEmailDuplicated($body['email'])) {
        //   throw new InvalidArgumentException('Email já esta sendo utilizado');
        // }
  
        $data = [
          "id"       => $id                         ,
          "nome"     => $body['nome']               ,
          "email"    => $body['email']              ,
          "telefone" => $body['telefone'] ?? null   , 
          "origem"   => $body['origem']   ?? null   , 
        ];
        return $this->Repository->update($data)     ;       
  
      } else {
        return false;
      }
    }

    function delete(string $id) {
      $lead = $this->Repository->getById($id);
      if ($lead) {
        return $this->Repository->delete($id);       
      } else {
       return false;
      }
    }

    function isEmailValid (string $email) : bool {
      return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    function isEmailDuplicated (string $email) : bool {
      return $this->Repository->isEmailDuplicated($email); 
    }

  }
  
?>