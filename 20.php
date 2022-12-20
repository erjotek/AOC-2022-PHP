<?php

function input($input)
{
    $input = explode("\n", $input);

    return $input;
}

function mix($input, $rounds = 1)
{
    $buff = $input;
    $c = count($buff) - 1;

    for ($round = 1; $round <= $rounds; $round++) {
        foreach ($input as $i) {
            if (!$i) {
                continue;
            }
            $pos = (int)array_search($i, $buff, true);
            $newpos = ($c + ($pos + (int)$i) % $c) % $c;
            unset($buff[$pos]);

            if ($newpos) {
                $pre = array_slice($buff, 0, $newpos);
                $post = array_slice($buff, $newpos);
                $buff = [...$pre, $i, ...$post];
            } else {
                $buff[] = $i;
            }
            $buff = array_values($buff);
        }
    }

    $z = array_search('0', $buff, true);
    $c++;

    $wyn = [
        (int)$buff[($z + 1000) % $c],
        (int)$buff[($z + 2000) % $c],
        (int)$buff[($z + 3000) % $c],
    ];

    return array_sum($wyn); //11123

}

function part1($input)
{
    array_walk($input, function (&$l, $k) {
        if ($l) {
            $l = "$l#$k";
        }
    });

    return mix($input); //11123
}

function part2($input)
{
    array_walk($input, function (&$l, $k) {
        if ($l) {
            $l = ($l * 811589153) . "#$k";
        }
    });

    return mix($input, 10); //4248669215955
}

include __DIR__ . '/template.php';
