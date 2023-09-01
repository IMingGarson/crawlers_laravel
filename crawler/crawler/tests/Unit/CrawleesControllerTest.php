<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use App\Http\Controllers\CrawleesController;
use App\Models\Crawlees;

class CrawleesControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    private $createCrawleeDataPath = 'api.crawlee.store';
    private $url = 'https://laravel.com/docs/10.x/providers';

    public function test_create_crawlee_data(): void
    {
    }
}
