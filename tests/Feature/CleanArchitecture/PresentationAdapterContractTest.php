<?php

declare(strict_types=1);

namespace Tests\Feature\CleanArchitecture;

use App\Presentation\Console\Commands\ImportNomenclatureCommand;
use Tests\TestCase;

final class PresentationAdapterContractTest extends TestCase
{
    public function test_console_adapter_exists_at_presentation_boundary(): void
    {
        self::assertTrue(class_exists(ImportNomenclatureCommand::class));
    }
}
