<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebendo e limpando os dados
    $nome   = htmlspecialchars($_POST['nome']);
    $idade  = htmlspecialchars($_POST['idade']);
    $cpf    = htmlspecialchars($_POST['cpf']);
    $cargo  = htmlspecialchars($_POST['cargo']);
    $orgao  = htmlspecialchars($_POST['orgao']);
    $modelo = $_POST['modelo'];

    // Configuração do PDF
    $options = new Options();
    $options->set('defaultFont', 'Helvetica');
    $dompdf = new Dompdf($options);

    // Definindo cores e títulos baseados no modelo selecionado
    $corPrincipal = ($modelo == 'modelo1') ? '#2c3e50' : '#27ae60';
    $tituloDoc    = ($modelo == 'modelo1') ? 'CREDENCIAL DE ACESSO' : 'CARTEIRA PROFISSIONAL';

    // Estrutura HTML que será convertida em PDF
    $html = "
    <style>
        .card { 
            width: 400px; 
            border: 2px solid $corPrincipal; 
            padding: 20px; 
            border-radius: 15px; 
            font-family: Arial, sans-serif;
        }
        .header { 
            text-align: center; 
            background-color: $corPrincipal; 
            color: white; 
            padding: 10px; 
            margin: -20px -20px 20px -20px;
            border-radius: 12px 12px 0 0;
            font-weight: bold;
        }
        .field { margin-bottom: 10px; border-bottom: 1px dashed #eee; padding-bottom: 5px; }
        .label { font-size: 10px; color: #666; text-transform: uppercase; display: block; }
        .value { font-size: 16px; font-weight: bold; color: #333; }
    </style>

    <div class='card'>
        <div class='header'>$tituloDoc</div>
        
        <div class='field'>
            <span class='label'>Nome do Portador</span>
            <span class='value'>$nome</span>
        </div>

        <div class='field'>
            <span class='label'>Documento CPF</span>
            <span class='value'>$cpf</span>
        </div>

        <div class='field'>
            <span class='label'>Cargo / Função</span>
            <span class='value'>$cargo</span>
        </div>

        <div class='field'>
            <span class='label'>Instituição</span>
            <span class='value'>$orgao</span>
        </div>
    </div>";

    // Gerando o arquivo
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Envia o PDF para o navegador
    $dompdf->stream("documento_" . trim($nome) . ".pdf", ["Attachment" => false]);
} else {
    header("Location: index.html");
    exit;
}