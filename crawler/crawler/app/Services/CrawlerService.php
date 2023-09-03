<?php

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Log;

class CrawlerService
{
    private $crawler = null;
    private $client = null;
    
    public function __construct(string $url = '')
    {
        try {
            $this->client = app(Client::class);
            $content = $this->client->get($url)->getBody()->getContents();
            $this->crawler = new Crawler();
            $this->crawler->addHtmlContent($content);
        } catch (\Exception $e) {
            log::error('CrawlerService Error.', ['message' => $e->getMessage()]);
        }
    }

    public function getCrawler(): Null | Crawler
    {
        return $this->crawler;
    }

    public function getDescription(): string
    {
        $webDescription = $this->crawler->filterXpath("//meta[@name='description']")->extract(['content']);
        return $webDescription ? $webDescription[0] : '';
    }

    public function getTitle(): string
    {
        return $this->crawler->filterXpath("//title")->text();
    }

    public function getBody(): string
    {
        return $this->crawler->filterXpath("//body")->text();
    }
}