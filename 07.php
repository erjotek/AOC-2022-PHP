<?php

function input($input)
{
    $input = explode('$ ', $input);
    $input = array_filter($input, 'strlen');

    $files = [];
    $path = [];
    $sizes = [];
    foreach ($input as $ii) {
        $ii = trim($ii);

        if (str_contains($ii, 'cd ..')) {
            array_pop($path);
            continue;
        }

        if (str_contains($ii, 'cd /')) {
            $path = [];
            continue;
        }

        if (str_contains($ii, 'cd ')) {
            $path[] = substr($ii, 3);
            continue;
        }

        if (str_starts_with($ii, 'ls')) {
            $ii = explode("\n", $ii);
            foreach ($ii as $i) {
                if (preg_match('/(\d+) (\S+)/', $i, $f)) {
                    $files[implode('/', $path)][$f[2]] = $f[1];
                }
            }

            $size = array_sum($files[implode('/', $path)] ?? []);
            $sizes[implode('/', $path)] = $size;

            $pp = $path;
            while (array_pop($pp)) {
                $sizes[implode('/', $pp)] += $size;
            }
        }
    }

    return $sizes;
}

function part1($sizes)
{
    return array_sum(array_filter($sizes, fn($s) => $s < 100000)); //1182909
}

function part2($sizes)
{
    asort($sizes);

    $need = 30000000 - (70000000 - $sizes['']);

    foreach ($sizes as $r) {
        if ($r >= $need) {
            break;
        }
    }

    return $r; //2832508
}

include __DIR__ . '/template.php';
