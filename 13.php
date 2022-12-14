<?php

function input($input)
{
    $input = explode("\n\n", $input);
    $input = array_map(fn($n) => explode("\n", $n), $input);

    return $input;
}

function comp($first, $second)
{
    while (true) {
        $f = array_shift($first);

        if ($f === null) {
            if (!empty($second)) {
                return true;
            }

            return;
        }

        $s = array_shift($second);
        if ($s === null) {
            return false;
        }

        if (is_numeric($f) && is_numeric($s)) {
            if ($f < $s) {
                return true;
            }

            if ($f > $s) {
                return false;
            }

            continue;
        }

        if (!is_array($f)) {
            $f = [$f];
        }

        if (!is_array($s)) {
            $s = [$s];
        }

        $ret = comp($f, $s);

        if (is_bool($ret)) {
            return $ret;
        }
    }

    return;
}

function part1($input)
{
    $ok = [];

    foreach ($input as $k => $pair) {
        $first = json_decode($pair[0], true);
        $second = json_decode($pair[1], true);
        $wyn = comp($first, $second);
        if ($wyn) {
            $ok[] = $k + 1;
        }
    }

    return array_sum($ok); //4821
}

function part2($input)
{
    $input = array_merge(['[[2]]', '[[6]]'], ...$input);

    usort($input, fn($a, $b) => comp(json_decode($a, true), json_decode($b, true)) ? -1 : 1);

    $pos = (array_search('[[2]]', $input, true) + 1) * (array_search('[[6]]', $input, true) + 1);

    return $pos; //21890
}

include __DIR__ . '/template.php';
