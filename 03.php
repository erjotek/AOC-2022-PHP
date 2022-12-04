<?php

function input($input)
{
    return explode("\n", $input);
}

function part1($input)
{
    $sum = 0;
    foreach ($input as $i) {
        $c = strlen($i);
        $w = array_intersect(str_split(substr($i, 0, $c / 2)), str_split(substr($i, $c / 2)));
        $w = end($w);

        $sum += ord($w) - ($w <= 'Z' ? 38 : 96);
    }

    return $sum; // 7727
}

function part2($input)
{
    $sum = 0;
    $input = array_chunk($input, 3);
    foreach ($input as $i) {
        $w = array_intersect(str_split($i[0]), str_split($i[1]), str_split($i[2]));
        $w = end($w);
        $sum += ord($w) - ($w <= 'Z' ? 38 : 96);
    }

    return $sum; // 2609
}

include __DIR__ . '/template.php';
