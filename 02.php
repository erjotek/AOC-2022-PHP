<?php

function input($input)
{
    return explode("\n", $input);
}

function part1($input)
{
    $pks['X'] = 1;
    $pks['Y'] = 2;
    $pks['Z'] = 3;

    $win['AX'] = 3;
    $win['AY'] = 6;
    $win['AZ'] = 0;

    $win['BX'] = 0;
    $win['BY'] = 3;
    $win['BZ'] = 6;

    $win['CX'] = 6;
    $win['CY'] = 0;
    $win['CZ'] = 3;

    $sum = 0;
    foreach ($input as $r) {
        $sum += $pks[$r[2]];
        $sum += $win[$r[0].$r[2]];
    }

    return $sum; //12276
}

function part2($input)
{
    $sco['X'] = 0;
    $sco['Y'] = 3;
    $sco['Z'] = 6;

    $pks['X'] = 1;
    $pks['Y'] = 2;
    $pks['Z'] = 3;

    $win['AX'] = 'Z';
    $win['AY'] = 'X';
    $win['AZ'] = 'Y';

    $win['BX'] = 'X';
    $win['BY'] = 'Y';
    $win['BZ'] = 'Z';

    $win['CX'] = 'Y';
    $win['CY'] = 'Z';
    $win['CZ'] = 'X';

    $sum = 0;
    foreach ($input as $r) {
        $sum += $sco[$r[2]];
        $sum += $pks[$win[$r[0].$r[2]]];
    }
    return $sum; // 9975
}

include __DIR__ . '/template.php';
