<?php

function input($input)
{
    $input = explode("\n", $input);
    $input = array_map('str_split', $input);

    return $input;
}

function route($input, $start, $end) {

    $pq = new SplPriorityQueue();
    $visited = [];

    $input[$start[0]][$start[1]] = 'a';
    $input[$end[0]][$end[1]] = 'z';

    $pq->insert([$start[0], $start[1]], 0);

    foreach ($input as $row => $line) {
        foreach ($line as $col => $val) {
            $pq->insert([$row, $col], PHP_INT_MIN);
            $visited[$row][$col] = PHP_INT_MAX;
        }
    }

    $dirs = [[0, 1], [0, -1], [1, 0], [-1, 0]];
    $visited[$start[0]][$start[1]] = 0;

    while (!$pq->isEmpty()) {
        [$row, $col] = $pq->extract();

        foreach ($dirs as [$dr, $dc]) {
            $drow = $row + $dr;
            $dcol = $col + $dc;

            if (!isset($input[$drow][$dcol])) {
                continue;
            }

            if (ord($input[$drow][$dcol]) - ord($input[$row][$col]) > 1) {
                continue;
            }

            if ($visited[$drow][$dcol] <= $visited[$row][$col] + 1) {
                continue;
            }

            $visited[$drow][$dcol] = $visited[$row][$col] + 1;
            $pq->insert([$drow, $dcol], -$visited[$drow][$dcol]);
        }
    }

     return $visited[$end[0]][$end[1]];

}

function part1($input)
{
    foreach ($input as $row => $line) {
        foreach ($line as $col => $val) {
            if ($val === 'S') {
                $start = [$row, $col];
                continue;
            }

            if ($val === 'E') {
                $end = [$row, $col];
            }
        }
    }

    return route($input, $start, $end); //528
}

function part2($input)
{
    $short = PHP_INT_MAX;

    foreach ($input as $row => $line) {
        foreach ($line as $col => $val) {
            if ($val === 'E') {
                $end = [$row, $col];
            }
        }
    }

    $rows = count($input);
    for ($s = 0; $s < $rows; $s++) {
        $start = [$s, 0];
        $short = min($short, route($input, $start, $end));
    }

    return $short; //522
}

include __DIR__ . '/template.php';
