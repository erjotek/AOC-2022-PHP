<?php

$air = [];

function input($input)
{
    $input = explode("\n", $input);

    return $input;
}


function part1($input)
{
    global $air;

    $cubes = array_flip($input);

    $neighbors = [[1, 0, 0], [-1, 0, 0], [0, 1, 0], [0, -1, 0], [0, 0, 1], [0, 0, -1]];

    foreach ($cubes as $c => $v) {
        $c = explode(',', $c);
        foreach ($neighbors as $n) {
            $key = implode(',', [$c[0] + $n[0], $c[1] + $n[1], $c[2] + $n[2]]);

            if (!isset($cubes[$key])) {
                $air[$key] = ($air[$key] ?? 0) + 1;
            }
        }
    }

    return array_sum($air); // 4300
}

function part2($input)
{
    global $air;

    $cubes = array_flip($input);

    $minx = 1000;
    $maxx = 0;
    $miny = 1000;
    $maxy = 0;
    $minz = 1000;
    $maxz = 0;

    foreach (array_keys($air) as $id) {
        $id = explode(",", $id);
        $minx = min($minx, $id[0]);
        $maxx = max($maxx, $id[0]);
        $miny = min($miny, $id[1]);
        $maxy = max($maxy, $id[1]);
        $minz = min($minz, $id[2]);
        $maxz = max($maxz, $id[2]);
    }

    $queue = new SplQueue();

    $queue->enqueue([$minx, $miny, $minz]);

    $dirs = [[-1, 0, 0], [1, 0, 0], [0, -1, 0], [0, 1, 0], [0, 0, 1], [0, 0, -1]];

    $visited = [];

    while (!$queue->isEmpty()) {
        $p = $queue->dequeue();
        foreach ($dirs as $d) {
            $npx = $p[0] + $d[0];
            $npy = $p[1] + $d[1];
            $npz = $p[2] + $d[2];
            $np = "$npx,$npy,$npz";

            if (isset($visited[$np])
                || isset($cubes[$np])
                || $npx < $minx
                || $npx > $maxx
                || $npy < $miny
                || $npy > $maxy
                || $npz < $minz
                || $npz > $maxz
            ) {
                continue;
            }


            $visited[$np] = $air[$np] ?? 0;
            $queue->enqueue([$npx, $npy, $npz]);
        }
    }

    return array_sum($visited); // 2490
}

include __DIR__ . '/template.php';
