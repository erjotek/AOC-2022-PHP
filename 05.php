<?php

function input($input)
{
    [$stack, $moves] = explode("\n\n", $input);
    $stack = str_replace(['[', ']'], ' ', $stack);
    $stack = array_reverse(explode("\n", $stack));
    unset($stack[0]);
    $stacks = [];

    foreach ($stack as $ss) {
        $ss = array_filter(str_split($ss), 'trim');
        foreach ($ss as $k => $s) {
            $stacks[(int)(($k-1)/4)+1][] = $s;
        }
    }

    $moves = explode("\n", $moves);

    return [$stacks, $moves];
}

function part1($input)
{
    [$stacks, $moves] = $input;

    foreach ($moves as $mo) {
        preg_match('/move (?<c>\d+) from (?<f>\d+) to (?<t>\d+)/', $mo, $m);
        for ($i = 0; $i < $m['c']; $i++) {
            $stacks[$m['t']][] = array_pop($stacks[$m['f']]);
        }
    }

    $res = '';
    foreach ($stacks as $s) {
        $res .= end($s);
    }

    return $res; //PSNRGBTFT
}

function part2($input)
{
    [$stacks, $moves] = $input;

    foreach ($moves as $mo) {
        preg_match('/move (?<c>\d+) from (?<f>\d+) to (?<t>\d+)/', $mo, $m);
        $stacks[$m['t']] = [...$stacks[$m['t']], ...array_splice($stacks[$m['f']], -$m['c'])];
    }

    $res = '';
    foreach ($stacks as $s) {
        $res .= end($s);
    }

    return $res; // BNTZFPMMW
}

include __DIR__ . '/template.php';
