<?php
$mensagem = "";

function validarValor($valor) {
    return is_numeric($valor) && $valor > 0;
}

function validarMoeda($moeda) {
    return in_array($moeda, ['USD', 'EUR', 'BTC']);
}

function cotacaoAPI($moeda) {
    global $mensagem;
    $url = "https://economia.awesomeapi.com.br/json/last/{$moeda}-BRL";

    $response = @file_get_contents($url);

    if ($response === false) {
        $mensagem = "<h1>Erro ao acessar a API!</h1>";
        return null;
    }

    $data = json_decode($response, true);
    $chave = "{$moeda}BRL";

    if (isset($data[$chave])) {
        return (float)$data[$chave]['bid'];
    } else {
        $mensagem = "<p>Cotação não encontrada.</p>";
        return null;
    }
}

function converterMoeda($valor, $moeda) {
    $nomesMoedas = [
        'USD' => 'dólar(es)',
        'EUR' => 'euro(s)',
        'BTC' => 'bitcoin(s)'
    ];

    $cotacao = cotacaoAPI($moeda);

    if (!$cotacao) {
        return "Erro: não foi possível obter a cotação da moeda.";
    }

    $resultado = $valor / $cotacao;

    return "R$ " . number_format($valor, 2, ',', '.') . " equivalem a " .
        number_format($resultado, 2, ',', '.') . " " . $nomesMoedas[$moeda] .
        " (cotação: R$ " . number_format($cotacao, 2, ',', '.') . ")";
}

$valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$valor = floatval(str_replace(',', '.', $valor));
$moeda = filter_input(INPUT_POST, 'moeda', FILTER_SANITIZE_STRING);

if (validarValor($valor) && validarMoeda($moeda)) {
    $resultado = converterMoeda($valor, $moeda);
    $mensagem = "<h1>Conversão realizada com sucesso!</h1>";
} else {
    $resultado = "Entrada inválida! Digite um valor válido e selecione uma moeda disponível.";
    $mensagem = "<h1>Erro na conversão</h1>";
}
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
    <?= $mensagem ?>
    <h2>Valor em Real (BRL):</h2>
    <p>R$ <?= number_format($valor, 2, ',', '.'); ?></p>

    <h2>Resultado da Conversão:</h2>
    <p><?= $resultado; ?></p>

    <a href="./../index.html">Voltar</a>
</body>
</html>