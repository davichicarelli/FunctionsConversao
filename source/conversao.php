<?php
function validarValor($valor) {
    return is_numeric($valor) && $valor > 0;
}
function validarMoeda($moeda) {
    return is_numeric($moeda) && in_array($moeda, [1, 2, 3]);
}