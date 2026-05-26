<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HealthReadinessTest extends TestCase
{
    use RefreshDatabase;

    public function test_readiness_endpoint_checks_dependencies(): void
    {
        $this->getJson('/health/ready')
            ->assertOk()
            ->assertJsonPath('ready', true)
            ->assertJsonPath('checks.database', true)
            ->assertJsonPath('checks.cache', true);
    }
}
