<?php

namespace Tests\Feature;

use App\Support\Runtime\IntentionalMemoryLeakProbe;
use App\Support\Runtime\RequestStateLeakProbe;
use App\Support\Runtime\WorkerMemoryCounter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RuntimeReferenceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        WorkerMemoryCounter::reset();
        RequestStateLeakProbe::reset();
        IntentionalMemoryLeakProbe::reset();
    }

    public function test_runtime_light_route_returns_process_context(): void
    {
        $this->getJson('/dev/runtime/light')
            ->assertOk()
            ->assertJsonPath('ok', true)
            ->assertJsonStructure(['pid', 'timestamp']);
    }

    public function test_worker_counter_keeps_process_memory_inside_same_runtime(): void
    {
        $this->getJson('/dev/runtime/worker-counter?label=first')
            ->assertOk()
            ->assertJsonPath('requests_seen_by_this_php_process', 1);

        $this->getJson('/dev/runtime/worker-counter?label=second')
            ->assertOk()
            ->assertJsonPath('requests_seen_by_this_php_process', 2);
    }

    public function test_static_leak_demo_has_unsafe_and_safe_paths(): void
    {
        $this->getJson('/dev/runtime/static-leak/unsafe/first')
            ->assertOk()
            ->assertJsonPath('after', 'first');

        $this->getJson('/dev/runtime/static-leak/unsafe')
            ->assertOk()
            ->assertJsonPath('before', 'first');

        $this->getJson('/dev/runtime/static-leak/safe')
            ->assertOk()
            ->assertJsonPath('before', null);
    }

    public function test_request_context_returns_request_identifier(): void
    {
        $this->getJson('/dev/runtime/request-context')
            ->assertOk()
            ->assertJsonStructure(['request_id', 'pid']);
    }

    public function test_temporary_stream_closes_on_success_path(): void
    {
        $this->getJson('/dev/runtime/temporary-stream')
            ->assertOk()
            ->assertJsonPath('closed_in_finally', true);
    }

    public function test_memory_probe_is_resettable(): void
    {
        $this->getJson('/dev/runtime/memory-leak?kb=1')
            ->assertOk()
            ->assertJsonPath('items_retained', 1);

        $this->postJson('/dev/runtime/memory-leak/reset')->assertOk();

        $this->getJson('/dev/runtime/memory-leak?kb=1')
            ->assertOk()
            ->assertJsonPath('items_retained', 1);
    }
}
