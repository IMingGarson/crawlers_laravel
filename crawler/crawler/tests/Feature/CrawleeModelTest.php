<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Crawlees;

class CrawleeModelTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create_crawlee_data(): void
    {
        $crawlee = Crawlees::factory()->make();
        $this->assertNotNull($crawlee);
        $this->assertArrayHasKey('url', $crawlee);
        $this->assertArrayHasKey('screenshot_path', $crawlee);
        $this->assertArrayHasKey('contents', $crawlee);
    }
}
