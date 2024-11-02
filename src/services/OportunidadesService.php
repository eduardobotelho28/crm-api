<?php

  require_once("./src/repositories/OportunidadesRepository.php");

  class OportunidadesService {

    private OportunidadesRepository $Repository;

    function __construct()
    {
      $this->Repository = new OportunidadesRepository();
    }

    function getMany() {
      return !empty($_GET['titulo']) ? $this->Repository->getByTitle($_GET['titulo']) : $this->Repository->getAll();
    }

    function getById(string $id) {
      return $this->Repository->getById($id);
    }

    function create() {    
      $body = json_decode(file_get_contents("php://input"), true);
      
      if (empty($body['titulo'])) {
        throw new InvalidArgumentException('Título é requerido');
      }
      if (empty($body['valor'])) {
        throw new InvalidArgumentException('Valor é requerido');
      }
      if (empty($body['data_fechamento'])) {
        throw new InvalidArgumentException('Data de Fechamento é requerido');
      }
      if (empty($body['estagio'])) {
        throw new InvalidArgumentException('Estagio é requerido');
      }

      if($this->isDateRetroative($body['data_fechamento'])) {
        throw new InvalidArgumentException('Data de fechamento tem que ser maior que hoje');
      }

      $data = [
        "titulo"          => $body['titulo']                ,
        "valor"           => $body['valor']                 ,
        "data_fechamento" => $body['data_fechamento']       ,
        "estagio"         => $body['estagio']               ,
      ];
      
      if($this->Repository->create($data))  {
        return $data;
      }

    }

    function update(string $id) {
      $opp = $this->Repository->getById($id);
      if ($opp) {

        $body   = json_decode(file_get_contents("php://input"), true);
      
        if (empty($body['titulo'])) {
            throw new InvalidArgumentException('Título é requerido');
        }
        if (empty($body['valor'])) {
        throw new InvalidArgumentException('Valor é requerido');
        }
        if (empty($body['data_fechamento'])) {
        throw new InvalidArgumentException('Data de Fechamento é requerido');
        }
        if (empty($body['estagio'])) {
        throw new InvalidArgumentException('Estagio é requerido');
        }

        if($this->isDateRetroative($body['data_fechamento'])) {
        throw new InvalidArgumentException('Data tem que ser maior que hoje');
        }
  
          $data = [
            "id"              => $id                            ,
            "titulo"          => $body['titulo']                ,
            "valor"           => $body['valor']                 ,
            "data_fechamento" => $body['data_fechamento']       ,
            "estagio"         => $body['estagio']               ,
          ];
        
        return $this->Repository->update($data)     ;       
  
      } else {
        return false;
      }
    }

    function delete(string $id) {
      $opp = $this->Repository->getById($id);
      if ($opp) {
        return $this->Repository->delete($id);       
      } else {
       return false;
      }
    }

    function isDateRetroative (string $date) : bool {
        return strtotime(date('Y-m-d')) > strtotime($date);  
    }

  }
  
?>