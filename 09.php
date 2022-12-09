<?php

function input($input)
{
    $input = explode("\n", $input);
    $input = array_map(fn($e) => explode(" ", $e), $input);

    return $input;
}

function tailPos($H, $T)
{
    $d = [$H[0] - $T[0], $H[1] - $T[1]];

    $d[0] = $H[0] - $T[0];
    $d[1] = $H[1] - $T[1];

    if (abs($d[0]) === 2 && abs($d[1]) === 2) {
//        $T[0] = ($H[0] + $T[0]) / 2;
        $T[0] += ($H[0] <=> $T[0]);
//        $T[1] = ($H[1] + $T[1]) / 2;
        $T[1] += ($H[1] <=> $T[1]);

        return $T;
    }

    if (abs($d[1]) === 2) {
        $T[0] += $d[0];
//        $T[1] = ($H[1] + $T[1]) / 2;
        $T[1] += ($H[1] <=> $T[1]);

        return $T;
    }

    if (abs($d[0]) === 2) {
//        $T[0] = ($H[0] + $T[0]) / 2;
        $T[0] += ($H[0] <=> $T[0]);
        $T[1] += $d[1];

        return $T;
    }

    return $T;
}

function walk($H, $T, $input)
{
    $vis = [];

    $dirs = ['R' => [0, 1], 'L' => [0, -1], 'U' => [-1, 0], 'D' => [1, 0]];

    foreach ($input as [$dirn, $moves]) {
        $dir = $dirs[$dirn];

        for ($m = 0; $m < $moves; $m++) {
            $H[0] += $dir[0];
            $H[1] += $dir[1];
            $last = $H;
            foreach ($T as $k => $t) {
                $T[$k] = tailPos($last, $t);
                $last = $T[$k];
            }

            $vis[implode('-', $last)] = true;
        }
    }

//    display($H, $T, $vis);
    return count($vis);
}

function part1($input)
{
    $H = [0, 0];
    $T[0] = [0, 0];

    return walk($H, $T, $input); //5874

}

function part2($input)
{
    $H = [0, 0];
    $T = array_fill(1, 9, [0, 0]);

    return walk($H, $T, $input); //2467
}

include __DIR__ . '/template.php';


function display($H, $T, $vis)
{
    $l = -180;
    $r = 100;
    $t = -60;
    $b = 500;

    foreach (range($t, $b) as $row) {
        foreach (range($l, $r) as $col) {
            if ($H[0] == $row && $H[1] == $col) {
                echo 'H';
                continue;
            }

            foreach ($T as $k => $t) {
                if ($t[0] == $row && $t[1] == $col) {
                    echo $k;
                    continue 2;
                }
            }

            if (isset($vis["$row-$col"])) {
                echo 'v';
                continue;
            }


            echo '.';
        }

        echo "\n";
    }

    echo "\n\n";
}
