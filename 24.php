<?php

/*
I also used my usual trick for managing 2D data in Go (and bash...), which lacks multidimensional arrays. For a 2D grid of width W and height H, I use a single array of size W*H, and convert a position p in this array to (x, y) coordinates by the simple rules:

p = x + y*W

x = p % W

y = p / W

This simplifies immensely working with data on a 2D map of a fixed size. For instance a direction can then just be a number that you add to a position to move in this direction: up is -W, down is +W, right is +1, left is -1.
*/

$min = 10000;
$maxx = 0;
$maxy = 0;
$end = [];
$boards = [];

function boards($blizzards)
{
    global $boards;
    global $maxx;
    global $maxy;
    $minute = 0;

    while (true) {
        $board = board($blizzards);

        $boards[$minute] = $board;
        if ($minute > 0 && $board === $boards[0]) {
            unset($boards[$minute]);
            break;
        }
        $minute++;

        foreach ($blizzards as &$b) {
            $b[0] += $b[2][0];
            $b[1] += $b[2][1];

            if ($b[0] > $maxy) {
                $b[0] = 1;
            }
            if ($b[0] < 1) {
                $b[0] = $maxy;
            }

            if ($b[1] > $maxx) {
                $b[1] = 1;
            }
            if ($b[1] < 1) {
                $b[1] = $maxx;
            }
        }
        unset($b);
    }

}

function input($input)
{
    $input = explode("\n", $input);

    $moves = ['<' => [0, -1], '>' => [0, 1], '^' => [-1, 0], 'v' => [1, 0]];

    global $end;
    global $maxx;
    global $maxy;

    $end = [count($input) - 1, strpos($input[count($input) - 1], '.')];
    $maxy = count($input) - 2;
    $maxx = strlen($input[0]) - 2;

    $blizzards = [];
    foreach ($input as $y => $row) {
        for ($x = 1; $x < strlen($row) - 1; $x++) {
            if (isset($moves[$input[$y][$x]])) {
                $blizzards[] = [$y, $x, $moves[$row[$x]], $row[$x]];
            }
        }
    }

    boards($blizzards);
}

function board($blizzards)
{
    $board = [];
    foreach ($blizzards as $b) {
        $board[$b[0]][$b[1]] = $b[3];
    }

    return $board;
}

function moves($sminute, $spos, $end)
{
    global $maxx;
    global $maxy;
    global $boards;

    $memory = [];

    $min = 1000;
    $moves = [[0, 1], [1, 0], [0, 0], [0, -1], [-1, 0]];

    $queue = new SplMinHeap();
    $queue->insert([$sminute, $spos]);
    $countb = count($boards);

    while (!$queue->isEmpty()) {
        [$minute, $pos] = $queue->extract();
        ++$minute;

        foreach ($moves as $m) {
            $npos = [$pos[0] + $m[0], $pos[1] + $m[1]];

            if (isset($memory[$minute % $countb][$npos[0]][$npos[1]])) {
                continue;
            }

            if ($npos === $end) {
                $min = $minute;
                break;
            }

            if ($minute >= $min) {
                break;
            }

            if (($npos[0] < 1 || $npos[0] > $maxy || $npos[1] < 1 || $npos[1] > $maxx) && $m != [0, 0]) {
                continue;
            }

            if (isset($boards[$minute % $countb][$npos[0]][$npos[1]])) {
                continue;
            }

            if ($minute + abs($pos[0] - $end[0]) + abs($pos[1] - $end[1]) > $min) {
                continue;
            }

            $memory[$minute % $countb][$npos[0]][$npos[1]] = true;

            $queue->insert([$minute, $npos]);
        }
    }

    return $min;
}

function part1($input)
{
    global $end;

    return moves(0, [0, 1], $end); // 332
}

function part2($input)
{
    global $end;

    $goal = moves(0, [0, 1], $end);
    $back = moves($goal, $end, [0, 1]);
    $next = moves($back, [0, 1], $end);

    return $next; // 942
}

include __DIR__ . '/template.php';
