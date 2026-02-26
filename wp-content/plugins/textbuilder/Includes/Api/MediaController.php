<?php

namespace TextBuilder\Api;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

use \WP_REST_Attachments_Controller;
use \WP_REST_Server;

class MediaController extends WP_REST_Attachments_Controller
{
    public function __construct()
    {
        parent::__construct('post');
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    /**
     * Register the routes for the objects of the controller.
     */
    public function register_routes()
    {
        $version = '2';
        $namespace = 'textbuilder/v' . $version;

        register_rest_route($namespace, '/media', [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'create_item'],
                'permission_callback' => [$this, 'create_item_permissions_check'],
            ],
        ]);
    }
}
