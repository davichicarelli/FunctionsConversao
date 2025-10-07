<?php
$valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$valor = floatval(str_replace(',', '.', $valor));
$moeda = filter_input(INPUT_POST, 'moeda', FILTER_VALIDATE_INT);

if (!is_numeric($valor) || $valor <= 0) {
    echo "<h1>Erro: Valor inválido.</h1>";
    exit;
}

if (!is_numeric($moeda) || !in_array($moeda, [1, 2, 3])) {
    echo "<h1>Erro: Moeda inválida.</h1>";
    exit;
}

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
    echo "<h1>Erro: Moeda não suportada.</h1>";
    exit;
}

$resultado = $valor * $taxas[$moeda];

echo "<h1>Conversão realizada com sucesso!</h1>";
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
<p>
    <?=
        "R$ " . number_format($valor, 2, ',', '.') .
        " equivalem a " .
        number_format($resultado, 6, ',', '.') .
        " " . $nomesMoedas[$moeda];
    ?>
</p>

<a href="./../index.html">Voltar</a>
</body>
</html>
