<?php

function input($input)
{
    $input = explode("\n", $input);
    $input = array_map('str_split', $input);

    return $input;
}

function visible($pos, $dir, &$input)
{
    $val = $input[$pos[0]][$pos[1]];
    while (true) {
        $pos[0] += $dir[0];
        $pos[1] += $dir[1];

        if (!isset($input[$pos[0]][$pos[1]])) {
            return true;
        }

        if ($input[$pos[0]][$pos[1]] >= $val) {
            return false;
        }
    }
}

function countTrees($pos, $dir, &$input)
{
    $val = $input[$pos[0]][$pos[1]];
    $see = 0;
    while (true) {
        $pos[0] += $dir[0];
        $pos[1] += $dir[1];

        if (!isset($input[$pos[0]][$pos[1]])) {
            return $see;
        }

        $see++;

        if ($input[$pos[0]][$pos[1]] >= $val) {
            return $see;
        }
    }
}

function part1($input)
{
    $rows = count($input);
    $cols = count($input[0]);

    $vis = 0;

    for ($row = 1; $row < $rows - 1; $row++) {
        for ($col = 1; $col < $cols - 1; $col++) {
            foreach ([[0, 1], [0, -1], [-1, 0], [1, 0]] as $dir) {
                if (visible([$row, $col], $dir, $input)) {
                    $vis++;
                    continue 2;
                }
            }
        }
    }

    return $vis + $rows * 2 + $cols * 2 - 4; //1713
}

function part2($input)
{
    $rows = count($input);
    $cols = count($input[0]);

    $cts = 0;

    for ($row = 1; $row < $rows - 1; $row++) {
        for ($col = 1; $col < $cols - 1; $col++) {
            $ct = [];
            foreach ([[0, 1], [0, -1], [-1, 0], [1, 0]] as $dir) {
                $ct[] = countTrees([$row, $col], $dir, $input);
            }
            $cts = max($cts, array_product($ct));
        }
    }

    return $cts; //268464
}

include __DIR__ . '/template.php';
