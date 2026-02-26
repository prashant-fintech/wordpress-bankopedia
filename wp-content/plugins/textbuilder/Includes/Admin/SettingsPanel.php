<?php

namespace TextBuilder\Admin;

use TextBuilder\AjaxController;
use TextBuilder\Api\AuthorizationController;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

class SettingsPanel
{
    public function __construct()
    {
        if (isset($_GET['page']) && $_GET['page'] === 'textbuilder') {
            add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);
            add_action('admin_enqueue_scripts', [$this, 'enqueueStyles']);
        }
        add_action('admin_menu', [$this, 'createSection']);
        add_action('admin_init', [$this, 'registerSettings']);
        add_action('plugin_action_links_textbuilder/textBuilder.php', [$this, 'pluginSettingsLink'], 10, 1);
        add_action('activated_plugin', [$this, 'activationRedirect']);

        add_action('tb-unset-user-data', [$this, 'unsetData']);
    }

    /**
     * Enqueue view admin js scripts
     *
     * @return void
     */
    public function enqueueScripts()
    {
        wp_enqueue_script(
            'textbuilder',
            plugins_url('public/dist/adminMain.bundle.js', TEXTBUILDER_ROOT),
            [],
            TEXTBUILDER_VERSION,
            true
        );
    }

    /**
     * Enqueue admin page styles
     *
     * @return void
     */
    public function enqueueStyles()
    {
        wp_enqueue_style(
            'textbuilder',
            plugins_url('public/dist/adminMain.bundle.css', TEXTBUILDER_ROOT),
            [],
            TEXTBUILDER_VERSION,
        );
    }

    /**
     * Add section in wp-admin
     *
     * @return void
     */
    public function createSection()
    {
        $cap = 'edit_posts';

        add_menu_page(
            __('TextBuilder', 'textbuilder'),
            __('TextBuilder', 'textbuilder'),
            $cap,
            'textbuilder',
            [$this, 'content'],
            plugins_url(TEXTBUILDER_ROOT_DIRNAME . '/public/img/tb-logo.png'),
            80
        );
    }

    /**
     * Render content
     *
     * @return void
     */
    public function content()
    {
        //BC - Remove already authorised users
        if ($this->isAuthorize() && $this->isApache() && !$this->isHtaccessValid()) {
            $authorizationController = new AuthorizationController();
            $authorizationController->revokeAllTokens(true);
        }

        $ajaxController = new AjaxController(); ?>
        <div class="textbuilder-settings">
        <?php
        if ($this->isAuthorize() || current_user_can('remove_users')) {
            if (current_user_can('remove_users')) {
                $users = get_users(['meta_key' => 'tb_token',]);
            } elseif (!current_user_can('remove_users')) {
                $user = wp_get_current_user();
                $users = get_users(['meta_key' => 'tb_token', 'include' => [$user->ID],]);
            }
            if (!empty($users)) {
                require_once 'View/TokenTable.php';
            }
        }

        if (!$this->isAuthorize()) {
            $authorizeUrl = $ajaxController->adminAjax(
                ['tb-action' => 'api-authorize-token-adminNonce', 'tb-nonce' => $ajaxController->admin()]
            );
        }
        ?>
            <div class="tb-authorize-wrapper">
                <img src="<?php echo esc_url(plugins_url(TEXTBUILDER_ROOT_DIRNAME . '/public/img/intro-menu-logo.png')); ?>">
                <div class="tb-content-wrapper">
                    <?php if (wp_is_site_protected_by_basic_auth('front')) : ?>
                        <p>
                            <?php esc_html_e(
                                'Your website appears to use Basic Authentication, which is not currently compatible with Application Passwords.',
                                'textbuilder'
                            ); ?>
                        </p>
                    <?php elseif ($this->isApache() && !$this->isHtaccessValid()) : ?>
                    <p>
                        <?php printf(
                            esc_html__(
                                'It appears that your website is hosted on an Apache web server. To ensure proper functionality of the plugin, it is essential to have the %sauthorization header%s detected. Currently, we were unable to detect this header.',
                                'textbuilder'
                            ),
                            '<strong>',
                            '</strong>'
                        ); ?>
                    </p>
                    <p>
                        <?php printf(
                            esc_html__(
                                'To resolve this, please make adjustments to your %s.htaccess%s file before proceeding with the authorization process. We recommend reaching out to your hosting provider\'s support team for assistance in implementing the necessary changes.',
                                'textbuilder'
                            ),
                            '<strong>',
                            '</strong>'
                        ); ?>
                    </p>
                    <p>
                        <?php printf(
                            esc_html__(
                                'The required modifications involve adding the following lines to your %s.htaccess%s file:',
                                'textbuilder'
                            ),
                            '<strong>',
                            '</strong>'
                        ); ?>
                    </p>
                    <pre>
                        RewriteEngine On
	                    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
                    </pre>
                </div>
                <?php elseif (!$this->isAuthorize()) : ?>
                <a href="<?php echo esc_url($authorizeUrl); ?>" class="tb-authorize-button">
                    <?php esc_html_e('Connect to TextBuilder', 'textbuilder'); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    /**
     * Register/add settings fields
     *
     * @return void
     */
    public function registerSettings()
    {
        register_setting(
            'tbSettings',
            'tbSettings',
            'tss_settings_args'
        );

        add_settings_section(
            'tbSettings',
            null,
            null,
            'tbSettingsFields'
        );
    }

    /**
     * Get admin url
     *
     * @return string
     */
    protected function getAdminUrl()
    {
        return esc_url(
            add_query_arg(
                'page',
                'textbuilder',
                get_admin_url() . 'admin.php'
            )
        );
    }

    /**
     * Add settings link to plugins page
     *
     * @param $links
     *
     * @return mixed
     */
    public function pluginSettingsLink($links)
    {
        return array_merge(
            [
                sprintf(
                    '<a href="%s">%s</a>',
                    esc_url($this->getAdminUrl()),
                    esc_html__('Settings', 'textbuilder')
                ),
            ],
            $links
        );
    }

    /**
     * Redirect to settings after plugin activation
     *
     * @param $plugin
     *
     * @return void
     */
    public function activationRedirect($plugin)
    {
        if ($plugin == plugin_basename(TEXTBUILDER_ROOT)) {
            exit(wp_redirect(esc_url($this->getAdminUrl())));
        }
    }

    /**
     * Check if user is authorized
     *
     * @return string
     */
    public function isAuthorize()
    {
        $currentUser = wp_get_current_user();
        $userId = $currentUser->ID;

        if (!empty(get_user_meta($userId, 'tb_token', true))) {
            return true;
        }

        return false;
    }

    /**
     * Unset added data
     *
     * @param $id
     *
     * @return void
     */
    public function unsetData($id)
    {
        delete_user_meta($id, 'tb_token');
        delete_user_meta($id, 'tb_token_created');
    }

    /**
     * Check if .htaccess file contais HTTP_AUTHORIZATION.
     *
     * @return false
     */
    public function isHtaccessValid()
    {
        $found = false;

        if (is_file(ABSPATH . '.htaccess')) {
            $htaccessContent = file(ABSPATH . '.htaccess', FILE_IGNORE_NEW_LINES);

            foreach ($htaccessContent as $line) {
                if (strpos($line, 'HTTP_AUTHORIZATION') !== false && strpos($line, '#') !== 0) {
                    $found = true;
                    break;
                }
            }
        }

        return $found;
    }

    /**
     * Check if Apache is used
     *
     * @return bool
     */
    public function isApache()
    {
        if ((isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'apache') !== false)
            || (function_exists('php_sapi_name') && strpos(php_sapi_name(), 'apache') !== false)) {
            return true;
        }

        return false;
    }
}
