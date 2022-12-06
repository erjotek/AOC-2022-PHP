<?php

function input($input)
{
    return $input;
}

function uniq($input, $uniq) {
    $c = strlen($input);

    for ($i = 0; $i < $c - $uniq; $i++) {
        if (strlen(count_chars(substr($input, $i, $uniq), 3)) === $uniq) {
            return $i + $uniq;
        }
    }

    return -1;
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
