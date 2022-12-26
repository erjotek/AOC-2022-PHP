<?php

function input($input)
{
    $input = explode("\n", $input);

    return $input;
}

function part1($input)
{
    $snafus = array_map(fn($s) => array_reverse(str_replace(['-', '='], [-1, -2], str_split($s))), $input);

    $sum = 0;
    foreach ($snafus as $l) {
        $nr = 0;
        foreach ($l as $p => $d) {
            $nr += 5 ** $p * $d;
        }
        $sum += $nr;
    }

    $digs = [[0, 0], [0, 1], [0, 2], [1, -2], [1, -1]];

    $p5 = strrev(base_convert($sum, 10, 5));
    $snafu = [0];

    for ($i = 0; $i < strlen($p5); $i++) {
        $snafu[$i] += $digs[$p5[$i]][1];
        $snafu[$i + 1] = ($snafu[$i + 1] ?? 0) + $digs[$p5[$i]][0];

        if ($snafu[$i] > 2) {
            $snafu[$i] = -2;
            $snafu[$i + 1] = ($snafu[$i + 1] ?? 0) + 1;
        }
    }

    if ($snafu[$i] === 0) {
        unset($snafu[$i]);
    }

    $snafu =  implode('', array_map(fn($s) => str_replace([-2, -1], ['=', '-'], $s), array_reverse($snafu)));

    return $snafu; //35677038780996 //2-2--02=1---1200=0-1
}

function part2($input)
{
    return;
}

include __DIR__ . '/template.php';
