<?php
// CONFIGURAÇÕES INICIAIS PARA RODAR
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Exibir erros para depuração
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Para requisições OPTIONS (pré-flight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

    // Database connection
    $host = '127.0.0.1';
    $userdb = 'root';
    $pass = '16052006';
    $db = 'apivuedb';

    // TENTATIVA DE CONEXÃO COM O BANCO DE DADOS
    try {
        // Conexão com o banco de dados usando PDO
        $conn = new PDO("mysql:host=$host;dbname=$db", $userdb, $pass);

        // MODO DE ERROS
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // SE FALHAR A CONEXÃO, RETORNA UM ERRO
        http_response_code(500);
        exit;
    }

    // RECEBE OS DADOS JSON E TRANSFORMA EM UM ARRAY PHP
    $data = json_decode(file_get_contents('php://input'), true);

    // VERIFICA SE OS DADOS FORAM RECEBIDOS CORRETAMENTE
    if (!$data) {
        error_log("Erro: JSON inválido recebido");
        http_response_code(400);
        echo json_encode(["erro" => "Dados de login ausentes ou malformados"]);
        exit;
    }

    // PEGA OS VALORES ENVIADOS DO FRONTEND E POPULA AS VARIÁVEIS
    $id = $data['id'];

    // PREPARA A CONSULTA PARA BUSCAR O USUÁRIO DE ACORDO COM O EMAIL
    $stmt = $conn->prepare("SELECT carts.id, users.nome, itens.titulo, itens.valor FROM carts INNER JOIN users ON carts.user_id = users.id INNER JOIN itens ON carts.item_id = itens.id WHERE users.id
= :id");

    // BIND PARAMS
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();

    // PEGA OS DADOS DO RESULTADO DA CONSULTA SELECT
    $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // O $result['senha'] é a senha armazenada no banco de dados
    if ($itens){
        echo json_encode(["mensagem" => "Login realizado com sucesso", "itens" => $itens]);
    } else {
        http_response_code(401);
        echo json_encode(["erro" => "Erro"]);
    }