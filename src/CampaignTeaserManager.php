<?php

namespace Bonnier\WP\CTM;

class CampaignTeaserManager
{
    /** Text domain for translators */
    const TEXT_DOMAIN = 'bonnier-ctm';

    private static $instance;

    private $plugin_dir;
    private $plugin_url;

    public function __construct()
    {
        $this->plugin_dir = plugin_dir_path(__DIR__);
        $this->plugin_url = plugin_dir_url(__DIR__);

        load_plugin_textdomain(
            self::TEXT_DOMAIN,
            false,
            dirname(plugin_basename(__DIR__)) . '/languages'
        );
    }

    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self;

            do_action('bonnier_ctm_loaded');
        }

        return self::$instance;
    }

    public function getPluginUrl()
    {
        return $this->plugin_url;
    }

    public function getPluginDir()
    {
        return $this->plugin_dir;
    }

}
