<?php

function input($input)
{
    return $input;
}

function rocks($input, $limit)
{

    $rocks = [];
    $rocks[0][0] = 0b000111100;

    $rocks[1][2] = 0b000010000;
    $rocks[1][1] = 0b000111000;
    $rocks[1][0] = 0b000010000;

    $rocks[2][2] = 0b000001000;
    $rocks[2][1] = 0b000001000;
    $rocks[2][0] = 0b000111000;

    $rocks[3][3] = 0b000100000;
    $rocks[3][2] = 0b000100000;
    $rocks[3][1] = 0b000100000;
    $rocks[3][0] = 0b000100000;

    $rocks[4][1] = 0b000110000;
    $rocks[4][0] = 0b000110000;


    $cave = [];
    $cave[0] = 0b111111111;

    $cache = [];

    $count = 0;
    $nextRock = 0;
    $gas = 0;
    $rock = $rocks[$nextRock];
    $top = 0;
    $rockPos = $top + 4;

    while (true) {
        $possible = true;
        $newRock = $rock;

        for ($r = 0, $rMax = count($rock); $r < $rMax; $r++) {
            if ($input[$gas] === '>') {
                $newRock[$r] = $rock[$r] >> 1;
            } else {
                $newRock[$r] = $rock[$r] << 1;
            }

            $cave[$rockPos + $r] ??= 0b100000001;
            $cave[$rockPos + $r - 1] ??= 0b100000001;

            if ($cave[$rockPos + $r] & $newRock[$r]) {
                $possible = false;
                break;
            }
        }

        if ($possible) {
            $rock = $newRock;
        }

        $stop = false;
        for ($r = 0, $rMax = count($rock); $r < $rMax; $r++) {
            if ($cave[$rockPos - 1 + $r] & $rock[$r]) {
                $stop = true;
                break;
            }
        }

        if ($stop) {
            for ($r = 0, $rMax = count($rock); $r < $rMax; $r++) {
                $cave[$rockPos + $r] |= $rock[$r];
            }

            $key = "$nextRock $gas {$rock[0]}";

            $cache[$key][] = [$count, $top];

            if (count($cache[$key]) >= 2 && ($limit - $cache[$key][0][0]) % ($cache[$key][1][0] - $cache[$key][0][0]) === 0) {
                return $cache[$key][0][1] + ($cache[$key][1][1] - $cache[$key][0][1]) * ($limit - $cache[$key][0][0]) / ($cache[$key][1][0] - $cache[$key][0][0]) - 1;
            }


            $top = max($top, $rockPos + count($rock));
            $nextRock = ($nextRock + 1) % 5;
            $rock = $rocks[$nextRock];
            $rockPos = $top + 3;
            $count++;

            if ($count === $limit) {
                break;
            }
        } else {
            $rockPos--;
        }

        $gas = (++$gas) % strlen($input);
    }


    return $top - 1;
}

function part1($input)
{
    return rocks($input, 2022); //3217
}

function part2($input)
{
    return rocks($input, 1000000000000); //1585673352422
}


include __DIR__ . '/template.php';
