<?php

namespace TextBuilder;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

use TextBuilder\Helpers\Request;
use TextBuilder\Helpers\Str;

class AjaxController
{
    public function __construct()
    {
        add_action('wp_ajax_tb-admin-ajax', [$this, 'listenAjax']);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function listenAjax()
    {
        $requestHelper = new Request();
        if ($requestHelper->exists('tb-admin-ajax')) {
            $rawResponse = $this->parseRequest();
            $output = $this->renderResponse($rawResponse);
            $this->output($output, $rawResponse);
        }
    }

    /**
     * Url to whole plugin folder.
     *
     * @param $query
     *
     * @return string
     */
    public function adminAjax($query = [])
    {
        $ajax = ['tb-admin-ajax' => 1];
        $query = $ajax + $query;
        $query['action'] = 'tb-admin-ajax';

        $url = set_url_scheme(admin_url('admin-ajax.php'));

        if (strpos($url, '?') !== false) {
            $url .= '?';
        }

        return $this->query($url, $query);
    }

    /**
     * Returns queried request to url
     *
     * @param $url
     * @param $query
     *
     * @return array|mixed|string|string[]
     */
    protected function query($url, $query = [])
    {
        if (empty($query)) {
            return $url;
        }
        $q = '?';

        $trim = true;
        if (strpos($url, '?') !== false) {
            $q = '&';
            $trim = false;
        }

        if ($trim) {
            $url = rtrim($url, '/\\');
        }

        $result = $url . $q . http_build_query($query, '', '&');
        $result = str_replace('?&', '?', $result);

        return $result;
    }

    /**
     * @return false|mixed|null
     */
    protected function parseRequest()
    {
        $requestHelper = new Request();
        if (!$requestHelper->exists('tb-action')) {
            return false;
        }

        $requestAction = $requestHelper->input('tb-action');
        $validateNonce = $this->validateNonce($requestAction);
        if ($validateNonce) {
            return apply_filters('tb-ajax-' . $requestAction, '');
        }

        return false;
    }

    /**
     * Validate nonce
     *
     * @param $requestAction
     *
     * @return bool
     */
    protected function validateNonce($requestAction)
    {
        $requestHelper = new Request();
        $strHelper = new Str();

        if ($strHelper->endsWith(strtolower($requestAction), 'nonce') && !$requestHelper->exists('tb-nonce')) {
            return false;
        }

        $result = true;
        if ($strHelper->contains($requestAction, '-adminNonce')) {
            $result = $this->verifyAdmin($requestHelper->input('tb-nonce'));
        }

        return $result;
    }

    /**
     * @param $response
     * @param $rawResponse
     *
     * @return void
     * @throws \Exception
     */
    protected function output($response, $rawResponse)
    {
        if (vcIsBadResponse($rawResponse)) {
            echo wp_json_encode(
                [
                    'status' => false,
                    'response' => $rawResponse,
                ]
            );
            vcvdie();
        }

        vcvdie($response);
    }

    /**
     * @param $response
     *
     * @return false|string
     */
    protected function renderResponse($response)
    {
        if (is_string($response)) {
            return $response;
        } elseif ($response === false) {
            return wp_json_encode(['status' => false]);
        }

        return wp_json_encode($response);
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return wp_create_nonce('tb-once');
    }


    /**
     * @return mixed
     */
    public function admin()
    {
        return current_user_can('edit_posts') ? wp_create_nonce('tb-nonce-admin') : false;
    }

    /**
     * @param $nonce
     *
     * @return bool
     */
    public function verifyUser($nonce)
    {
        return !empty($nonce) && wp_verify_nonce($nonce, 'tb-nonce');
    }

    /**
     * @param $nonce
     *
     * @return bool
     */
    public function verifyAdmin($nonce)
    {
        return !empty($nonce) && current_user_can('edit_posts')
            && wp_verify_nonce(
                $nonce,
                'tb-nonce-admin'
            );
    }
}
