<?php

// base on https://orlp.net/blog/worlds-smallest-hash-table/
// https://github.com/orlp/aoc2022/blob/master/src/bin/day02_speed.rs

function input($input)
{
    return explode("\n", $input);
}

function ht($i, $shift)
{
//    slow :(
//    $h = '0x' . unpack("H*", strrev($i . "\n"))[1];
//    $u = hexdec($h);

    $u = ord("\n") * 256 * 256 * 256 + ord($i[2]) * 256 * 256 + ord(' ') * 256 + ord($i[0]);

    return (($shift >> ((($u * 1887065750) % 2 ** 32) >> 27)) & 7) + 1 + ($u === 173678658);
}


function part1($input)
{
    return array_sum(array_map(fn($i) => ht($i, 475903013), $input));
}

function part2($input)
{
    $ret = 0;
    foreach ($input as $i) {
        $u = ord("\n") * 256 * 256 * 256 + ord($i[2]) * 256 * 256 + ord(' ') * 256 + ord($i[0]);
        $p = ((224201846 >> ((($u * 1887065750) % 2 ** 32) >> 27)) & 7) + 1 + ($u === 173678658);

        $ret += $p;
    }

    return $ret;
}

include __DIR__ . '/template.php';
