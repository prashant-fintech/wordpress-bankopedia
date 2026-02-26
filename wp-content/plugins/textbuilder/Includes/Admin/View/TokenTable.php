
<h2><?php esc_html_e('TextBuilder Authorized Users', 'textbuildere'); ?></h2>
<div class="application-passwords-list-table-wrapper">
    <table class="wp-list-table widefat fixed striped table-view-list application-passwords-user">
        <thead>
        <tr>
            <th scope="col" id="name" class="manage-column column-name column-primary">
                <?php esc_html_e('Name', 'textbuilder'); ?>
            </th>
            <th scope="col" id="created" class="manage-column column-created">
                <?php esc_html_e('Created', 'textbuilder'); ?>
            </th>
            <th scope="col" id="last_used" class="manage-column column-last_used">
                <?php esc_html_e('Last Used', 'textbuilder'); ?>
            </th>
            <th scope="col" id="revoke" class="manage-column column-revoke">
                <?php esc_html_e('Revoke', 'textbuilder'); ?>
            </th>
        </tr>
        </thead>

        <tbody id="the-list">
        <?php foreach ($users as $user) : ?>
            <tr data-uuid="39b7e097-128c-43bf-9a0c-e86d0c052977">
                <td class="name column-name has-row-actions column-primary"
                    data-colname="<?php esc_attr_e('Name', 'textbuilder'); ?>">
                    <?php echo esc_html($user->data->display_name); ?>
                </td>
                <td class="created column-created"
                    data-colname="<?php esc_attr_e('Created', 'textbuilder'); ?>">
                    <?php
                        echo wp_date(
                            get_option('date_format') . ', ' . get_option('time_format'),
                            strtotime(get_user_meta($user->ID, 'tb_token_created', true))
                        );
                    ?>
                </td>
                <td class="last_used column-last_used"
                    data-colname="<?php esc_attr_e('Last Used', 'textbuilder'); ?>">
                    <?php if (get_user_meta($user->ID, 'tb_token_last_used', true)) {
                        echo wp_date(
                            get_option('date_format') . ', ' . get_option('time_format'),
                            strtotime(get_user_meta($user->ID, 'tb_token_last_used', true))
                        );
                    } else {
                        esc_html_e('Not used yet!', 'textbuilder');
                    } ?>
                </td>
                <td class="revoke column-revoke"
                    data-colname="<?php esc_attr_e('Revoke', 'textbuilder'); ?>">
                    <a type="button"
                       href="<?php echo esc_url(
                           $ajaxController->adminAjax(
                               [
                                   'tb-action' => 'api-revoke-token-adminNonce',
                                   'tb-nonce' => $ajaxController->admin(),
                                   'userId' => $user->ID,
                               ]
                           )
                       ); ?>"
                       class="button delete" aria-label="<?php esc_attr_e('Revoke', 'textbuilder'); ?>">
                        <?php esc_html_e('Revoke', 'textbuilder'); ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
            <th scope="col" id="name" class="manage-column column-name column-primary">
                <?php esc_html_e('Name', 'textbuilder'); ?>
            </th>
            <th scope="col" id="created" class="manage-column column-created">
                <?php esc_html_e('Created', 'textbuilder'); ?>
            </th>
            <th scope="col" id="last_used" class="manage-column column-last_used">
                <?php esc_html_e('Last Used', 'textbuilder'); ?>
            </th>
            <th scope="col" id="revoke" class="manage-column column-revoke">
                <?php esc_html_e('Revoke', 'textbuilder'); ?>
            </th>
        </tr>
        </tfoot>

    </table>
    <?php if (current_user_can('remove_users')) : ?>
    <div class="tablenav bottom">
        <div class="alignright">
            <a type="button"
               href="<?php echo esc_url(
                   $ajaxController->adminAjax(
                       [
                           'tb-action' => 'api-revoke-all-tokens-adminNonce',
                           'tb-nonce' => $ajaxController->admin(),
                       ]
                   )
               ); ?>" class="button delete">
                <?php esc_html_e('Revoke all application passwords', 'textbuilder'); ?>
            </a>
        </div>
        <div class="alignleft actions bulkactions">
        </div>
        <br class="clear">
    </div>
    <?php endif; ?>
</div>