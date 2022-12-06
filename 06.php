<?php

function input($input)
{
    return str_split($input);
}

function uniq($input, $uniq) {
    $c = count($input);

    for ($i = 0; $i < $c - $uniq; $i++) {
        if (count(array_unique(array_slice($input, $i, $uniq))) === $uniq) {
            return $i + $uniq;
        }
    }
}

function part1($input)
{
    return uniq($input, 4); // 1794
}

function part2($input)
{
    return uniq($input, 14); // 2851
}

include __DIR__ . '/template.php';
