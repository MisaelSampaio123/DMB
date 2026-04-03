<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;

include "conexao.php";

$dompdf = new Dompdf();

$html = '<h2>Relatório de Armamentos</h2>';
$html .= '<table border="1" width="100%" cellspacing="0" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Modelo</th>
    <th>Calibre</th>
    <th>Nº Série</th>
    <th>Situação</th>
</tr>';

$sql = "SELECT * FROM armas";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $html .= "<tr>
        <td>{$row['id']}</td>
        <td>{$row['nome']}</td>
        <td>{$row['modelo']}</td>
        <td>{$row['calibre']}</td>
        <td>{$row['numero_serie']}</td>
        <td>{$row['situacao']}</td>
    </tr>";
}

$html .= "</table>";

$dompdf->loadHtml($html);

// tamanho do papel
$dompdf->setPaper('A4', 'portrait');

// renderizar
$dompdf->render();

// baixar automaticamente
$dompdf->stream("relatorio_armas.pdf", ["Attachment" => true]);
?>