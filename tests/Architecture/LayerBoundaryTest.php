<?php

declare(strict_types=1);

namespace Tests\Architecture;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class LayerBoundaryTest extends TestCase
{
    private static function projectRoot(): string
    {
        return dirname(__DIR__, 2);
    }

    /**
     * @return iterable<string, array{0: string}>
     */
    public static function presentationFiles(): iterable
    {
        foreach (['app/Http', 'app/Filament'] as $directory) {
            $root = self::projectRoot().'/'.$directory;

            if (! is_dir($root)) {
                continue;
            }

            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root));

            foreach ($files as $file) {
                if (! $file instanceof SplFileInfo || $file->getExtension() !== 'php') {
                    continue;
                }

                yield str_replace(self::projectRoot().'/', '', $file->getPathname()) => [$file->getPathname()];
            }
        }
    }

    #[DataProvider('presentationFiles')]
    public function test_presentation_layer_does_not_depend_on_catalog_infrastructure(string $path): void
    {
        $contents = (string) file_get_contents($path);

        $this->assertStringNotContainsString(
            'App\\Catalog\\Infrastructure',
            $contents,
            sprintf('%s should depend on application contracts instead of catalog infrastructure classes.', $path),
        );
    }
}
