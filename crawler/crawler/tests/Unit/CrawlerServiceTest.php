<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\CrawlerService;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    private $mockCrawlerService = null;
    public function setUp(): void
    {
        parent::setUp();
        $url = 'https://laravel.com/docs/10.x/providers';
        $this->mockCrawlerService = new CrawlerService($url);
    }

    public function test_crawler_is_setup(): void
    {
        $crawler = $this->mockCrawlerService->getCrawler();
        $this->assertNotNull($crawler);
        $this->assertType('[string]', $crawler->getDescription());
        $this->assertType('[string]', $crawler->getTitle());
        $this->assertType('[string]', $crawler->getBody());
    }
}
