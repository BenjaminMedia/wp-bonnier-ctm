<?php

namespace Bonnier\WP\CTM\Contracts;

use Illuminate\Support\Collection;

interface TeaserRepositoryContract
{
    /**
     * @param string $locale
     * @return TeaserRepositoryContract
     */
    public function setLocale(string $locale): TeaserRepositoryContract;

    /**
     * @param string $brandCode
     * @return TeaserRepositoryContract
     */
    public function setBrandCode(string $brandCode): TeaserRepositoryContract;

    /**
     * @return string
     */
    public function getLocale(): string;

    /**
     * @return string
     */
    public function getBrandCode(): string;

    /**
     * @return Collection|null
     */
    public function getTeasers(): ?Collection;

    /**
     * @param string $category
     * @return Collection|null
     */
    public function getTeasersByCategory(string $category): ?Collection;

    /**
     * @param Collection $tags
     * @return Collection|null
     */
    public function getTeasersByTags(Collection $tags): ?Collection;

    /**
     * @param string $category
     * @param Collection $tags
     * @return Collection|null
     */
    public function getTeasersByCategoryAndTags(string $category, Collection $tags): ?Collection;
}
