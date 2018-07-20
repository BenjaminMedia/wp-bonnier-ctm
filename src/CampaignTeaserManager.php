<?php

namespace Bonnier\WP\CTM;

use Bonnier\WP\CTM\Contracts\TeaserRepositoryContract;
use Bonnier\WP\CTM\Repositories\CampaignTeaserManagerRepository;
use Bonnier\WP\CTM\Services\TeaserService;
use GuzzleHttp\Client;

class CampaignTeaserManager
{
    private static $instance;
    
    private $teaserRepository;
    private $teaserService;

    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self;

            self::$instance->setTeaserRepository();
            self::$instance->setTeaserService();

            do_action('bonnier_ctm_loaded');
        }

        return self::$instance;
    }

    public function setTeaserRepository(?TeaserRepositoryContract $repo = null)
    {
        if (!$repo) {
            $client = new Client([
                'base_uri' => env('CAMPAIGN_TEASER_MANAGER_HOST', null),
            ]);
            $lang = 'da';
            if (function_exists('pll_current_language')) {
                $lang = pll_current_language();
            }
            $repo = new CampaignTeaserManagerRepository(
                $client,
                $lang,
                env('BRANDCODE', '')
            );
        }

        $this->teaserRepository = $repo;
    }

    public function getTeaserRepository(): TeaserRepositoryContract
    {
        return $this->teaserRepository;
    }

    public function setTeaserService()
    {
        $this->teaserService = new TeaserService($this->teaserRepository);
    }

    public function getTeaserService(): TeaserService
    {
        return $this->teaserService;
    }
}
