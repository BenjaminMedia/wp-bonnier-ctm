<?php

namespace Bonnier\WP\CTM\Repositories;

use Bonnier\WP\CTM\Contracts\TeaserRepositoryContract;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Collection;

class CampaignTeaserManagerRepository implements TeaserRepositoryContract
{
    /** @var Client */
    protected $client;
    protected $locale;
    protected $brandCode;

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

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getBrandCode(): string
    {
        return $this->brandCode;
    }

    public function getTeasers(): ?Collection
    {
        if ($response = $this->get('api/teasers')) {
            return new Collection($response['data']);
        }
        return null;
    }

    public function getTeasersByCategory(string $category): ?Collection
    {
        if ($response = $this->get('api/teasers', ['category' => $category])) {
            return new Collection($response['data']);
        }
        return null;
    }

    public function getTeasersByTags(Collection $tags): ?Collection
    {
        if ($response = $this->get('api/teasers', ['tags' => $tags])) {
            return new Collection($response['data']);
        }
        return null;
    }

    public function getTeasersByCategoryAndTags(string $category, Collection $tags): ?Collection
    {
        if ($response = $this->get('api/teasers', [
            'category' => $category,
            'tags' => $tags
        ])) {
            return new Collection($response['data']);
        }
        return null;
    }

    protected function get(string $url, array $query = [])
    {
        $query['locale'] = $this->locale;
        $query['brandCode'] = $this->brandCode;

        try {
            $response = $this->client->get($url, [
                'query' => $query,
                'headers' => [
                    'Accept' => 'application/json'
                ],
            ]);
            return json_decode($response->getBody()->getContents(), JSON_OBJECT_AS_ARRAY);
        } catch (RequestException $e) {
            return null;
        }
    }
}
