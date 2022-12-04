<?php

function input($input)
{
    return explode("\n", $input);
}

function part1($input)
{
    $sum = 0;
    foreach ($input as $i) {
        preg_match('/(\d+)-(\d+),(\d+)-(\d+)/', $i, $z);
        if (($z[1] <= $z[3] && $z[2] >= $z[4])
            || ($z[3] <= $z[1] && $z[4] >= $z[2])
        ) {
            $sum++;
        }
    }

    return $sum; // 513
}

function part2($input)
{
    $sum = 0;
    foreach ($input as $i) {
        preg_match('/(\d+)-(\d+),(\d+)-(\d+)/', $i, $z);
        if (($z[3] >= $z[1] && $z[3] <= $z[2])
            || ($z[4] >= $z[1] && $z[4] <= $z[2])
            || ($z[2] >= $z[3] && $z[2] <= $z[4])
            || ($z[1] >= $z[3] && $z[1] <= $z[4])
        ) {
            $sum++;
        }
    }

    return $sum; // 513
}

include __DIR__ . '/template.php';
