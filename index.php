<?php
 
header("Content-type: application/json")                      ;

$url        = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$urlParts   = explode("/", $url)                              ;

$resource   = $urlParts[2] ?? null                            ;
$identifier = $urlParts[3] ?? null                            ;

//no caso de não vir nenhum recurso, cairá na rota de "apresentação".
if(empty($resource)) {
    http_response_code(200)                     ;
    die(file_get_contents('apresentation.json'));
}

switch($resource) {
    case "leads":
        require_once("./src/controllers/LeadsController.php")                      ;
        $leadsController = new LeadsController()                                   ;
        $leadsController->processRequest($_SERVER['REQUEST_METHOD'], $identifier)  ;
    break;
    case "oportunidades":
        require_once("./src/controllers/OportunidadesController.php")                      ;
        $oportunidadesController = new OportunidadesController()                           ;
        $oportunidadesController->processRequest($_SERVER['REQUEST_METHOD'], $identifier)  ;
    break;
    case "produtos":
        require_once("./src/controllers/ProdutosController.php");
    break; 
    case "db":
        require_once("./src/database/example_data.php");
    break;
    default:
        http_response_code(404);
        echo json_encode(["mensagem"=>"Recurso não encontrado!"]);
}