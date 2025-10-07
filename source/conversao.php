<?php
function validarValor($valor) {
    return is_numeric($valor) && $valor > 0;
}
function validarMoeda($moeda) {
    return is_numeric($moeda) && in_array($moeda, [1, 2, 3]);
}
function exibirMensagem($mensagem) {
    echo $mensagem;
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