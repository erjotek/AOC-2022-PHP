<?php

function input($input)
{
    $input = explode("\n", $input);
    $cave = [];

    foreach ($input as $line) {
        $line = explode(' -> ', $line);
        $start = explode(',', array_shift($line));
        while ($end = array_shift($line)) {
            $end = explode(',', $end);

            for ($cr = min($start[1], $end[1]); $cr <= max($start[1], $end[1]); $cr++) {
                for ($cc = min($start[0], $end[0]); $cc <= max($start[0], $end[0]); $cc++) {
                    $cave[$cr][$cc] = '#';
                }
            }
            $start = $end;
        }
    }

    return $cave;
}

function display($cave)
{
    $bottom = max(array_keys($cave)) + 1;
    $ml = min(array_map('min', array_map('array_keys', $cave))) - 1;
    $mr = max(array_map('max', array_map('array_keys', $cave))) + 1;

    for ($row = 0; $row <= $bottom; $row++) {
        for ($col = $ml; $col <= $mr; $col++) {
            echo $cave[$row][$col] ?? '.';
        }
        echo "\n";
    }
    echo "\n";
}

function sands($cave, $part2 = false)
{
    $bottom = max(array_keys($cave)) + 2;

    $sands = 0;
    while (true) {
        [$sr, $sc] = [0, 500];
        $sands++;

        if (isset($cave[$sr][$sc])) {
            break;
        }

        while (true) {
            $sr++;

            if ($sr === $bottom) {
                if ($part2) {
                    $cave[$sr - 1][$sc] = 'o';
                    break;
                }

                break 2;
            }

            if (!isset($cave[$sr][$sc])) {
                continue;
            }

            if (!isset($cave[$sr][$sc - 1])) {
                $sc--;
                continue;
            }

            if (!isset($cave[$sr][$sc + 1])) {
                $sc++;
                continue;
            }

            $cave[$sr - 1][$sc] = 'o';
            break;
        }
    }

//    display($cave);
    return $sands - 1;
}

function part1($cave)
{
    return sands($cave, false); //979
}

function part2($cave)
{
    return sands($cave, true); //29044
}

include __DIR__ . '/template.php';
