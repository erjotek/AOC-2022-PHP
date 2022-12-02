<?php

function input($input)
{
    return array_map('array_sum', array_map(fn($n) => explode("\n", $n), explode("\n\n", $input)));
}

function part1($input)
{
    return max($input); // 67450
}

function part2($input)
{
    rsort($input);
    return array_sum(array_splice($input, 0, 3)); //199357
}

include __DIR__ . '/template.php';
