<?php

  require_once("./src/services/OportunidadesService.php");

  class OportunidadesController {

    private OportunidadesService $Service;

    function __construct()
    {
      $this->Service = new OportunidadesService();
    }

    function processRequest(string $method, ?string $identifier) {

      try {

        if ($identifier) {

          switch($method) {
  
            case "GET":
              $data = $this->Service->getById($identifier);
              if($data) {
                http_response_code(200);
                echo json_encode($data); 
              } else {
                http_response_code(404);
                echo json_encode(["mensagem"=>"Oportunidade não encontrada!"]);
              }
            break;
  
            case "PUT";
              $oppFinded = $this->Service->update($identifier);
              if($oppFinded) {
                  http_response_code(200);
                  echo json_encode(["mensagem"=>"Atualizado com sucesso!"]);
              }
              else {
                http_response_code(404);
                echo json_encode(["mensagem"=>"Oportunidade não encontrada!"]);
              }
            break;
  
            case "DELETE";
              $oppFinded = $this->Service->delete($identifier);
              if($oppFinded) {
                http_response_code(200);
                echo json_encode(["mensagem"=>"Deletado com Sucesso!"]);
              }
              else {
                http_response_code(404);
                echo json_encode(["mensagem"=>"Oportunidade não encontrada!"]);
              }
              break;  
  
            default:
              http_response_code(405);
              echo json_encode(["mensagem"=>"Método não permitido!"]);
          } 
  
        } else {
  
          switch($method) {
  
            case "GET":
              $data = $this->Service->getMany();
              if($data) {
                http_response_code(200);
                echo json_encode($data); 
              } else {
                http_response_code(404);
                echo json_encode(["mensagem"=>"Oportunidade não encontrada!"]);
              }
            break;
  
            case "POST";
              $createdOpp = $this->Service->create();
              http_response_code(201);
              echo json_encode($createdOpp);
            break;
  
            default:
              http_response_code(405);
              echo json_encode(["mensagem"=>"Método não permitido!"]);
          } 
  
        }

      } catch (InvalidArgumentException $e) {

        // erros disparados pelo Service (validação e regras de negócio) caem aqui.
        http_response_code(400);
        echo json_encode(['mensagem' => $e->getMessage()]);
        
      } catch (Exception $e) {

        //erros internos inesperados?? (500)
        http_response_code(500);
        echo json_encode(['mensagem' => 'An internal server error occurred.']);

      }

    }

  }
  
?>