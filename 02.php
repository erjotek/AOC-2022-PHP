<?php

function input($input)
{
    return explode("\n", $input);
}

function part1($input)
{
    $win['A X'] = 3 + 1;
    $win['A Y'] = 6 + 2;
    $win['A Z'] = 0 + 3;

    $win['B X'] = 0 + 1;
    $win['B Y'] = 3 + 2;
    $win['B Z'] = 6 + 3;

    $win['C X'] = 6 + 1;
    $win['C Y'] = 0 + 2;
    $win['C Z'] = 3 + 3;

    return array_reduce($input, fn($c, $w) => $c + $win[$w]); //12276
}

function part2($input)
{
    $win['A X'] = 3 + 0;
    $win['A Y'] = 1 + 3;
    $win['A Z'] = 2 + 6;

    $win['B X'] = 1 + 0;
    $win['B Y'] = 2 + 3;
    $win['B Z'] = 3 + 6;

    $win['C X'] = 2 + 0;
    $win['C Y'] = 3 + 3;
    $win['C Z'] = 1 + 6;

    return array_reduce($input, fn($c, $w) => $c + $win[$w]); // 9975
}

include __DIR__ . '/template.php';
