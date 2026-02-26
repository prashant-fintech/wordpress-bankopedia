<?php

namespace TextBuilder;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

class FrontPage
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        //add_action('wp_enqueue_scripts', [$this, 'enqueueStyles']);
    }

    /**
     * Enqueue view page js scripts
     *
     * @return void
     */
    public function enqueueScripts()
    {
        $options = get_option('tssSettings');
        wp_enqueue_script("jquery");
        wp_enqueue_script(
            'textbuilder',
            plugins_url('public/dist/main.bundle.js', TEXTBUILDER_ROOT),
            [],
            TEXTBUILDER_VERSION,
            true
        );
    }

    /**
     * Enqueue view page styles
     *
     * @return void
     */
    public function enqueueStyles()
    {
        wp_enqueue_style(
            'textbuilder',
            plugins_url('public/dist/style.bundle.css', TEXTBUILDER_ROOT),
            [],
            TEXTBUILDER_VERSION,
        );
    }


}
