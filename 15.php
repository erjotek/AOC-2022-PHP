<?php

function input($input)
{
    $input = explode("\n", $input);
    $sensors = array_map(function ($l) {
        preg_match('~Sensor at x=(-?\d+), y=(-?\d+)~', $l, $r);

        return [$r[1], $r[2]];
    }, $input);

    $beacons = array_map(function ($l) {
        preg_match('~beacon is at x=(-?\d+), y=(-?\d+)~', $l, $r);

        return [$r[1], $r[2]];
    }, $input);

    return [$sensors, $beacons];
}


function part1($info)
{
    [$sensors, $beacons] = $info;

    $line = 2000000;

    $y = [];
    foreach ($sensors as $id => $s) {
        $b = $beacons[$id];
        $d = [$b[0] - $s[0], $b[1] - $s[1]];

        $size = abs($d[0]) + abs($d[1]);

        $dy = abs($line - $s[1]);

        if ($dy >= $size) {
            continue;
        }

        for ($i = $s[0] - ($size - $dy); $i <= $s[0] + ($size - $dy); $i++) {
            $y[$i] = true;
        }
    }

    foreach ($beacons as $b) {
        if ($b[1] === $line) {
            unset($y[$b[0]]);
        }
    }

    return count($y); //5256611
}

function part2($info)
{
    [$sensors, $beacons] = $info;

    $max = 4000000;

    $xy = [];
    foreach ($sensors as $id => $s) {
        $b = $beacons[$id];
        $d = [$b[0] - $s[0], $b[1] - $s[1]];
        $size = abs($d[0]) + abs($d[1]);

        for ($y = max(0, $s[1] - $size); $y <= min($max, $s[1] + $size); $y++) {
            $delta = $size - abs($y - $s[1]);
            $xy[$y][] = max(0, $s[0] - $delta) . "," . min($max, $s[0] + $delta);
        }
    }

    for ($y = 0; $y <= $max; $y++) {
        natsort($xy[$y]);
        $ml = 0;
        $mr = 0;
        foreach ($xy[$y] as $n) {
            [$l, $r] = explode(',', $n);
            if ($l > $mr + 1) {
                return ($mr + 1) * 4000000 + $y;
            }
            $ml = min($ml, $l);
            $mr = max($mr, $r);
        }
    }

    return; //13337919186981
}

include __DIR__ . '/template.php';
