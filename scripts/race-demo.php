<?php

$file = sys_get_temp_dir().'/octane-race-demo-counter.txt';
file_put_contents($file, '0');

$children = 20;

for ($i = 0; $i < $children; $i++) {
    $pid = pcntl_fork();

    if ($pid === -1) {
        fwrite(STDERR, "Unable to fork process\n");
        exit(1);
    }

    if ($pid === 0) {
        $current = (int) file_get_contents($file);
        usleep(20000);
        file_put_contents($file, (string) ($current + 1));
        exit(0);
    }
}

while (pcntl_wait($status) > 0) {
}

$actual = (int) file_get_contents($file);
echo "expected={$children} actual={$actual}\n";

if ($actual >= $children) {
    echo "The race did not reproduce on this run. Increase children or delay.\n";
}
