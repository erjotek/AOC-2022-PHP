<?php

function input($input)
{
    $input = array_column(array_map(fn($l) => explode(': ', $l), explode("\n", $input)), 1, 0);

    return $input;
}

function value($monkey, $name)
{
    if (is_numeric($monkey[$name])) {
        return (int)$monkey[$name];
    }

    $l = value($monkey, substr($monkey[$name], 0, 4));
    $r = value($monkey, substr($monkey[$name], 7));

    $result = match ($monkey[$name][5]) {
        '=' => $l - $r, // powinno być ==
        '+' => $l + $r,
        '-' => $l - $r,
        '*' => $l * $r,
        '/' => $l / $r,
    };

    return $result;
}


function part1($monkey)
{
    return value($monkey, 'root'); //80326079210554
}

function part2($monkey)
{
    $monkey['root'][5] = '=';

    $max = 0;
    $last = 0;
    while (true) {
        for ($e = 0; $e < 16; $e++) {
            for ($i = 1; $i <= 9; $i++) {
                $v = $i * 10 ** $e + $max;
                $monkey['humn'] = $v;
                $r = value($monkey, 'root');
                if ($r === 0) {
                    break 3;
                }

                if ($r < 0) {
                    $max = $last;
                    break 2;
                }

                $last = $v;
            }
        }
    }

    return $v; //3617613952378
}

include __DIR__ . '/template.php';
