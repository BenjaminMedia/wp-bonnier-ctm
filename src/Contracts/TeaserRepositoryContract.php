<?php

namespace Bonnier\WP\CTM\Contracts;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;

interface TeaserRepositoryContract
{
    public function __construct(Client $client, string $locale, string $brandCode);

    public function setLocale(string $locale): TeaserRepositoryContract;

    public function setBrandCode(string $brandCode): TeaserRepositoryContract;

    public function getLocale(): string;

    public function getBrandCode(): string;

    public function getTeasers(): ?Collection;

    public function getTeasersByCategory(string $category): ?Collection;

    public function getTeasersByTags(Collection $tags): ?Collection;

    public function getTeasersByCategoryAndTags(string $category, Collection $tags): ?Collection;
}
