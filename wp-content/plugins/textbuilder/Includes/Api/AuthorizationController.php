<?php
namespace TextBuilder\Api;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

use TextBuilder\Helpers\Request;

class AuthorizationController
{
    protected $requestHelper = false;

    public function __construct()
    {
        $this->requestHelper = new Request();
        add_action('admin_init', [$this, 'handleToken']);
        add_filter('tb-ajax-api-authorize-token-adminNonce', [$this, 'authorizeToken']);
        add_filter('tb-ajax-api-revoke-token-adminNonce', [$this, 'revokeToken']);
        add_filter('tb-ajax-api-revoke-all-tokens-adminNonce', [$this, 'revokeAllTokens']);
    }

    /**
     * Parse token
     *
     * @return void
     */
    public function handleToken()
    {
        $currentUser = wp_get_current_user();
        if (isset($_GET['token'], $_GET['page']) && $_GET['page'] === 'textbuilder') {
            // Verify the nonce to prevent CSRF attacks
            if (!wp_verify_nonce($_GET['nonce'], 'tb_authorize_token_' . $currentUser->ID)) {
                wp_die('Failed to verify nonce. Please try again.');
            }

            update_user_meta($currentUser->ID, 'tb_token', sanitize_key($_GET['token']));
            update_user_meta($currentUser->ID, 'tb_token_created', current_time('mysql'));
            wp_redirect(esc_url_raw(strtok($this->settingsUrl(), '&')));
        }
    }

    /**
     * Revoke token
     *
     * @return void
     */
    public function revokeToken()
    {
        $response = false;
        $currentUser = wp_get_current_user();
        $requestId = $this->requestHelper->input('userId');

        //get the token
        if ($currentUser->ID === (int)$requestId) {
            $token = get_user_meta($currentUser->ID, 'tb_token', true);
        } elseif (current_user_can('remove_users')) {
            $token = get_user_meta($requestId, 'tb_token', true);
        }

        //delete token in tb
        if (!empty($token)) {
            $url = TEXTBUILDER_API_URL . 'token/';
            $response = wp_remote_request($url, [
                'method' => 'DELETE',
                'timeout' => 30,
                'body' => ['token' => $token,],
            ]);
        }

        $redirectUrl = $this->settingsUrl();
        if ($this->requestHelper->isValidResponse($response)) {
            //delete all user data
            if ($currentUser->ID === (int)$requestId) {
                do_action('tb-unset-user-data', $currentUser->ID);
            } elseif (current_user_can('remove_users')) {
                do_action('tb-unset-user-data', (int)$requestId);
            }
        } else {
            $body = json_decode(wp_remote_retrieve_body($response), true);
            if (isset($body['status'], $body['code']) && $body['status'] === 'error' && $body['code'] === '#1002') {
                //remove the invalid token
                do_action('tb-unset-user-data', (int)$requestId);
            } else {
                $redirectUrl = add_query_arg(['tb-error' => 'invalid-response'], $redirectUrl);
            }
        }

        wp_redirect(esc_url_raw($redirectUrl));
        exit;
    }

    /**
     * Revoke all tokens
     *
     * @return void
     */
    public function revokeAllTokens($background = false)
    {
        $response = false;
        $users = get_users(['meta_key' => 'tb_token',]);

        if (current_user_can('remove_users') && !empty($users)) {
            $token = get_user_meta($users[0]->ID, 'tb_token', true);
            $tokens = [];
            foreach ($users as $user) {
                $tokens[] = get_user_meta($user->ID, 'tb_token', true);
            }

            //delete tokens in tb
            if (!empty($tokens)) {
                $url = TEXTBUILDER_API_URL . 'tokens/';
                $response = wp_remote_request($url, [
                    'method' => 'DELETE',
                    'timeout' => 30,
                    'body' => ['token' => $token, 'tokens' => $tokens],
                ]);
            }
        }

        $redirectUrl = $this->settingsUrl();
        if ($this->requestHelper->isValidResponse($response)) {
            //delete all user data
            $responseBody = json_decode(wp_remote_retrieve_body($response), true);
            $responseBodyData = $responseBody['data'];
            foreach ($responseBodyData as $key => $responseBody) {
                if ($this->requestHelper->isValidResponse(['body' => $responseBody])) {
                    do_action('tb-unset-user-data', $users[ $key ]->ID);
                }
            }
        } else {
            if (!$background) {
                $redirectUrl = add_query_arg(['tb-error' => 'invalid-response'], $redirectUrl);
            }
        }

        if (!$background) {
            wp_redirect(esc_url_raw($redirectUrl));
            exit;
        }
    }

    /**
     * Authorize token
     *
     * @return void
     */
    public function authorizeToken()
    {
        $currentUser = wp_get_current_user();
        $userId = $currentUser->ID;

        // Create a nonce for this specific user and action
        $nonce = wp_create_nonce('tb_authorize_token_' . $userId);

        $url = add_query_arg(
            [
                'app' => 'textbuilder',
                'domain' => urlencode_deep(get_site_url()),
                'redirect_url' => urlencode_deep($this->settingsUrl() . '&nonce=' . $nonce),
                'user' => urlencode_deep($currentUser->data->user_login),
                'user_id' => urlencode_deep($userId),
                'textbuilder_version' => urlencode_deep(TEXTBUILDER_VERSION),
            ],
            'https://app.textbuilder.ai/authorize/'
        );

        wp_redirect($url);
        exit;
    }

    /**
     * Get current URL
     *
     * @return string
     */
    protected function settingsUrl()
    {
        return set_url_scheme(admin_url('admin.php?page=textbuilder'));
    }
}
