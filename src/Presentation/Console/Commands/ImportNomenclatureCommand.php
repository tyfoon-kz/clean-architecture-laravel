<?php

declare(strict_types=1);

namespace App\Presentation\Console\Commands;

use Illuminate\Console\Command;

final class ImportNomenclatureCommand extends Command
{
    protected $signature = 'nomenclature:import {path}';

    protected $description = 'Import nomenclature through an explicit presentation adapter.';

    public function handle(): int
    {
        $this->info('Import scenario is delegated to Application in the next iteration.');

        return self::SUCCESS;
    }
}
