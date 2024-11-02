<?php

    require_once("conn.php");

    $conn = new Database();

    $sql = "DROP TABLE IF EXISTS leads";
    $conn->exec($sql);
    
    $sql = "CREATE TABLE leads (
        id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
        nome VARCHAR(200)                         , 
        email VARCHAR(200)                        ,
        telefone INT                              ,
        origem VARCHAR(200)                       
    )";
    $conn->exec($sql);

    $stmt = $conn->prepare("INSERT INTO leads (nome, email, telefone, origem) 
                            VALUES (:nome, :email, :telefone, :origem)")    ;
    
    $leads = [
        ["nome" => "Eduardo Botelho",    "email" => "eduardo@email.com",  "telefone" => 51999999999, "origem" => "redes sociais"],
        ["nome" => "Henrique Guimarães", "email" => "henrique@email.com", "telefone" => 51988888888, "origem" => "redes sociais"],
        ["nome" => "Fulano",             "email" => "fulano@email.com",   "telefone" => 51900000000, "origem" => "indicação"]    ,
        ["nome" => "Ciclano",            "email" => "ciclano@email.com",  "telefone" => 51911111111, "origem" => "indicação"]    ,
    ];
    
    foreach ($leads as $lead) {
        $stmt->execute($lead);
    }

    // ----------------------------------------------------------------------------------------------------- //

    $sql = "DROP TABLE IF EXISTS oportunidades";
    $conn->exec($sql);
    
    $sql = "CREATE TABLE oportunidades (
        id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
        titulo VARCHAR(50)                        , 
        valor DECIMAL (10,2)                      ,
        data_fechamento DATE                      ,
        estagio VARCHAR(50)                       
    )";
    $conn->exec($sql);

    $stmt = $conn->prepare("INSERT INTO oportunidades (titulo, valor, data_fechamento, estagio) 
                            VALUES (:titulo, :valor, :data_fechamento, :estagio)")    ;
    
    $opportunities = [
        ["titulo" => "Teste", "valor" => 10.20,  "data_fechamento" => '2024-10-09', "estagio" => "fechado e ganho"],
        ["titulo" => "Teste", "valor" => 20.00,  "data_fechamento" => '2024-10-19', "estagio" => "fechado e ganho"],
        ["titulo" => "Teste", "valor" => 30.00,  "data_fechamento" => '2024-10-11', "estagio" => "fechado e ganho"],
        ["titulo" => "Teste", "valor" => 40.00,  "data_fechamento" => '2024-10-12', "estagio" => "fechado e ganho"],
    ];

    foreach ($opportunities as $opp) {
        $stmt->execute($opp);
    }

    echo json_encode(["mensagem"=>"Dados criados com sucesso!"]);
  
    // ----------------------------------------------------------------------------------------------------- //

    $sql = "DROP TABLE IF EXISTS produtos";
    $conn->exec($sql);
    
    $sql = "CREATE TABLE produtos (
        id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
        nome VARCHAR(50)                          , 
        descricao VARCHAR (200)                   ,
        codigo INT                                ,
        preco DECIMAL (10,2)                      ,
        data_criacao DATE                                       
    )";
    $conn->exec($sql);

    $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, codigo, preco, data_criacao) 
                            VALUES (:nome, :descricao, :codigo, :preco, :data_criacao)")      ;
    
    $products = [
        ["nome" => "PRODUTO 1", "descricao" => "um produto de mega qualidade",  "codigo" => '12345', "preco" => 299.99, "data_criacao" => "2024-10-11"],
        ["nome" => "PRODUTO 2", "descricao" => "um outro produto",              "codigo" => '12346', "preco" => 299.99, "data_criacao" => "2024-10-11"],
        ["nome" => "PRODUTO 3", "descricao" => "produto top",                   "codigo" => '12347', "preco" => 299.99, "data_criacao" => "2024-10-11"],
        ["nome" => "PRODUTO 4", "descricao" => "melhor produto",                "codigo" => '12348', "preco" => 299.99, "data_criacao" => "2024-10-11"],
    ];

    foreach ($products as $product) {
        $stmt->execute($product);
    }

    echo json_encode(["mensagem"=>"Dados criados com sucesso!"]);
    
?>