<?php

// essa funcao tem como objetivo formatar o preço que vem em string e devolve em forma de int formatado
function formatPriceAsInt(string $price): int
{
    return (int) (round((float) $price * 100));
}
