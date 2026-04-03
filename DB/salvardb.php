<?php
// salvar.php
header('Content-Type: application/json');
require_once 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    try {
        $sql = "INSERT INTO armas (nome, modelo, calibre, numero_serie, situacao) 
                VALUES (:nome, :modelo, :calibre, :serial, :situacao)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome'     => $data['tipo'], // Mapeando 'tipo' do HTML para 'nome' no Banco
            ':modelo'   => $data['modelo'],
            ':calibre'  => $data['calibre'],
            ':serial'   => $data['serial'],
            ':situacao' => $data['status']
        ]);

        echo json_encode(['success' => true, 'message' => 'Armamento registrado com sucesso!']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar: ' . $e->getMessage()]);
    }
}
?>