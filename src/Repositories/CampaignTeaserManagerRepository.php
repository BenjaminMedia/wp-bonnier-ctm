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

    /**
     * CampaignTeaserManagerRepository constructor.
     * @param Client $client
     * @param string $locale
     * @param string $brandCode
     */
    public function __construct(Client $client, string $locale, string $brandCode)
    {
        $this->client = $client;
        $this->locale = $locale;
        $this->brandCode = $brandCode;
    }

    /**
     * @param string $locale
     * @return TeaserRepositoryContract
     */
    public function setLocale(string $locale): TeaserRepositoryContract
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @param string $brandCode
     * @return TeaserRepositoryContract
     */
    public function setBrandCode(string $brandCode): TeaserRepositoryContract
    {
        $this->brandCode = $brandCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @return string
     */
    public function getBrandCode(): string
    {
        return $this->brandCode;
    }

    /**
     * @return Collection|null
     */
    public function getTeasers(): ?Collection
    {
        if ($response = $this->get('api/teasers')) {
            return new Collection($response->data);
        }
        return null;
    }

    /**
     * @param string $category Category Contenthub ID
     * @return Collection|null
     */
    public function getTeasersByCategory(string $category): ?Collection
    {
        if ($response = $this->get('api/teasers', ['category' => $category])) {
            return new Collection($response->data);
        }
        return null;
    }

    /**
     * @param Collection $tags Collection of tag Contenthub IDs
     * @return Collection|null
     */
    public function getTeasersByTags(Collection $tags): ?Collection
    {
        if ($response = $this->get('api/teasers', ['tags' => $tags])) {
            return new Collection($response->data);
        }
        return null;
    }

    /**
     * @param string $category Category Contenthub ID
     * @param Collection $tags Collection of tag Contenthub IDs
     * @return Collection|null
     */
    public function getTeasersByCategoryAndTags(string $category, Collection $tags): ?Collection
    {
        if ($response = $this->get('api/teasers', [
            'category' => $category,
            'tags' => $tags
        ])) {
            return new Collection($response->data);
        }
        return null;
    }

    /**
     * @param string $url
     * @param array $query
     * @return array|mixed|null|object
     */
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
            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return null;
        }
    }
}
