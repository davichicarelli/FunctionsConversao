<?php
function validarValor($valor) {
    return is_numeric($valor) && $valor > 0;
}
function validarMoeda($moeda) {
    return is_numeric($moeda) && in_array($moeda, [1, 2, 3]);
}

function converterMoeda($valor, $moeda) {
    $taxas = [
        1 => 0.18,
        2 => 0.16,
        3 => 0.000003
    ];

    $nomesMoedas = [
        1 => 'dólar(es)',
        2 => 'euro(s)',
        3 => 'bitcoin(s)'
    ];

    if (!isset($taxas[$moeda])) {
        return "Erro: Moeda não suportada.";
    }

    $resultado = $valor * $taxas[$moeda];

    return "R$ " . number_format($valor, 2, ',', '.') . " equivalem a " . 
           number_format($resultado, 6, ',', '.') . " " . $nomesMoedas[$moeda];
}
function exibirMensagem($mensagem) {
    echo $mensagem;
}

$valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$valor = floatval(str_replace(',', '.', $valor));
$moeda = filter_input(INPUT_POST, 'moeda', FILTER_VALIDATE_INT);
$resultado = converterMoeda($valor, $moeda);
    exibirMensagem("<h1>Conversão realizada com sucesso!</h1>");

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Moedas</title>
    <link rel="stylesheet" href="./../css/style.css">
</head>
<body>

<h2>Valor em Real (BRL):</h2>
<p>R$ <?= number_format($valor, 2, ',', '.'); ?></p>

<h2>Resultado da Conversão:</h2>
<?php echo $resultado; ?>

<a href="./../index.html">Voltar</a>
</body>
</html>