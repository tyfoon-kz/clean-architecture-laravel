<?php

$file = sys_get_temp_dir().'/octane-lock-demo-counter.txt';
file_put_contents($file, '0');

$children = 20;

for ($i = 0; $i < $children; $i++) {
    $pid = pcntl_fork();

    if ($pid === -1) {
        fwrite(STDERR, "Unable to fork process\n");
        exit(1);
    }

    if ($pid === 0) {
        $handle = fopen($file, 'c+');

        if ($handle === false) {
            exit(1);
        }

        flock($handle, LOCK_EX);
        rewind($handle);
        $current = (int) stream_get_contents($handle);
        usleep(20000);
        ftruncate($handle, 0);
        rewind($handle);
        fwrite($handle, (string) ($current + 1));
        fflush($handle);
        flock($handle, LOCK_UN);
        fclose($handle);
        exit(0);
    }
}

while (pcntl_wait($status) > 0) {
}

echo "expected={$children} actual=".file_get_contents($file)."\n";
echo "Locking protects correctness, but the critical section reduces parallel throughput.\n";
