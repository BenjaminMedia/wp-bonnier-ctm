<?php

/**
 * Plugin Name: Bonnier Campaign Teaser Manager Plugin
 * Version: 1.0.3
 * Plugin URI: https://github.com/BenjaminMedia/wp-bonnier-ctm
 * Description: This plugin allows you to integrate your site with the Campaign Teaser Manager
 * Author: Bonnier
 * License: GPL v3
 */

if (!defined('ABSPATH')) {
    exit;
}

function registerBonnierCTM()
{
    return \Bonnier\WP\CTM\CampaignTeaserManager::class;
}

add_action('plugins_loaded', 'registerBonnierCTM');
