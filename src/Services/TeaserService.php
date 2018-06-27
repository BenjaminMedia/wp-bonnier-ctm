<?php

namespace Bonnier\WP\CTM\Services;

use Bonnier\WP\CTM\Contracts\TeaserRepositoryContract;
use Bonnier\WP\CTM\Models\Teaser;
use Illuminate\Support\Collection;
use WP_Post;
use WP_Term;

class TeaserService
{
    /** @var TeaserRepositoryContract */
    protected $teaserRepository;

    /**
     * TeaserService constructor.
     * @param TeaserRepositoryContract $teaserRepository
     */
    public function __construct(TeaserRepositoryContract $teaserRepository)
    {
        $this->teaserRepository = $teaserRepository;
    }

    /**
     * @param WP_Post $post
     * @return Collection
     */
    public function getTeasers(WP_Post $post): Collection
    {
        if (function_exists('pll_get_post_language') && $locale = pll_get_post_language($post->ID)) {
            $this->teaserRepository->setLocale($locale);
        }

        $category = $this->getCategory($post);
        $tags = $this->getTags($post);

        if ($category && $tags->isNotEmpty()) {
            $response = $this->teaserRepository->getTeasersByCategoryAndTags($category, $tags);
        } elseif ($category) {
            $response = $this->teaserRepository->getTeasersByCategory($category);
        } elseif ($tags->isNotEmpty()) {
            $response = $this->teaserRepository->getTeasersByTags($tags);
        } else {
            $response = $this->teaserRepository->getTeasers();
        }

        if ($response) {
            return $response->map(function (\stdClass $teaser) {
                return new Teaser($teaser);
            });
        }

        return new Collection();
    }

    /**
     * @param WP_Post $post
     * @return null
     */
    private function getCategory(WP_Post $post)
    {
        if (($term = get_category($post->post_category[0] ?? null)) && $term instanceof WP_Term) {
            return $this->getContenthubID($term);
        }

        return null;
    }

    /**
     * @param WP_Post $post
     * @return Collection
     */
    private function getTags(WP_Post $post)
    {
        if (($tags = new Collection(wp_get_post_tags($post->ID))) && $tags->isNotEmpty()) {
            return $tags->map(function (WP_Term $tag) {
                return $this->getContenthubID($tag);
            })->reject(function ($tag) {
                return is_null($tag);
            });
        }

        return new Collection();
    }

    /**
     * @param WP_Term $term
     * @return null
     */
    private function getContenthubID(WP_Term $term)
    {
        return get_term_meta($term->term_id, 'content_hub_id', $single = true) ?: null;
    }
}
