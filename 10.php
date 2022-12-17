<?php

$cycles = [];

function input($input)
{
    $input = explode("\n", $input);

    return $input;
}

function part1($input)
{
    $X = 1;
    global $cycles;

    $cycles[] = $X;

    foreach ($input as $i) {
        $cycles[] = $X; //noop, begin of addx

        if (str_starts_with($i, 'addx ')) {
            $X += (int)substr($i, 5);
            $cycles[] = $X;
        }
    }

    $info = [20, 60, 100, 140, 180, 220];

    $sum = array_reduce($info, fn($c, $p) => $c + $p * $cycles[$p-1]);

    return $sum; //12880
}

function part2($input)
{
    global $cycles;

    for ($c = 0; $c < 240; $c++) {
        $rc = $c % 40;

        echo in_array($rc, [$cycles[$c] - 1, $cycles[$c], $cycles[$c] + 1], true) ? "\u{2588}" : "\u{2591}";

        if ($rc === 39) {
            echo "\n";
        }
    }

    return; //FCJAPJRE
}

include __DIR__ . '/template.php';
