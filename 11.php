<?php

function input($input)
{
    $input = explode("\n", $input);

    $monkey = [];

    foreach ($input as $i) {
        if (str_starts_with($i, 'Monkey')) {
            $m = $i[7];
        }

        if (str_starts_with($i, '  Starting')) {
            $monkey[$m]['items'] = explode(', ', substr($i, 18));
        }

        if (str_starts_with($i, '  Operation:')) {
            $monkey[$m]['op'] = explode(' ', substr($i, 23));
        }

        if (str_starts_with($i, '  Test:')) {
            $monkey[$m]['test'] = substr($i, 21);
        }

        if (str_starts_with($i, '    If true:')) {
            $monkey[$m]['t'] = substr($i, 29);
        }

        if (str_starts_with($i, '    If false:')) {
            $monkey[$m]['f'] = substr($i, 30);
        }
    }

    return $monkey;
}

function turns($monkey, $part2 = false)
{
    $inspected = [];

    if ($part2) {
        $mod = array_product(array_column($monkey, 'test'));
        $turns = 10_000;
    } else {
        $turns = 20;
    }

    for ($turn = 1; $turn <= $turns; $turn++) {
        foreach ($monkey as $mid => &$m) {
            while ($item = array_shift($m['items'])) {
                $inspected[$mid] = ($inspected[$mid] ?? 0) + 1;

                if ($m['op'][0] === '*') {
                    $item *= $m['op'][1] === 'old' ? $item : $m['op'][1];
                }

                if ($m['op'][0] === '+') {
                    $item += $m['op'][1];
                }

                if ($part2) {
                    $item %= $mod;
                } else {
                    $item = floor($item / 3);
                }

                $monkey[$m[!($item % $m['test']) ? 't' : 'f']]['items'][] = $item;
            }
        }
    }
    unset($m);

    rsort($inspected);

    return $inspected[0] * $inspected[1];
}

function part1($monkey)
{
    return turns($monkey, false); //72884
}

function part2($monkey)
{
    return turns($monkey, true); //15310845153
}

include __DIR__ . '/template.php';
