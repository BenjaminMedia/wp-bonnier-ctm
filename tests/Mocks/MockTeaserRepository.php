<?php

namespace Tests\Bonnier\WP\CTM\Mocks;

use Bonnier\WP\CTM\Contracts\TeaserRepositoryContract;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class MockTeaserRepository implements TeaserRepositoryContract
{
    private $client;
    private $locale;
    private $brandCode;
    private $returnCollection;

    public function __construct(Client $client, string $locale, string $brandCode)
    {
        $this->client = $client;
        $this->locale = $locale;
        $this->brandCode = $brandCode;
    }

    public function setLocale(string $locale): TeaserRepositoryContract
    {
        $this->locale = $locale;
        
        return $this;
    }

    public function setBrandCode(string $brandCode): TeaserRepositoryContract
    {
        $this->brandCode = $brandCode;

        return $this;
    }

    public function getTeasers(): ?Collection
    {
        return $this->returnCollection;
    }

    public function getTeasersByCategory(string $category): ?Collection
    {
        return $this->returnCollection;
    }

    public function getTeasersByTags(Collection $tags): ?Collection
    {
        return $this->returnCollection;
    }

    public function getTeasersByCategoryAndTags(string $category, Collection $tags): ?Collection
    {
        return $this->returnCollection;
    }

    public function setReturnCollection(?Collection $collecton = null)
    {
        $this->returnCollection = $collecton;
    }
}
