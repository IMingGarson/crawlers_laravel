<?php

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerService
{
    private $crawler = null;
    private $client = null;
    
    public function __construct(string $url = '')
    {
        $this->client = app(Client::class);
        $content = $this->client->get($url)->getBody()->getContents();
        $this->crawler = new Crawler();
        $this->crawler->addHtmlContent($content);
    }

    public function getCrawler(): Null | Crawler
    {
        return $this->crawler;
    }

    public function getDescription(): string
    {
        return $this->crawler->filterXpath("//meta[@name='description']")->extract(['content']);
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