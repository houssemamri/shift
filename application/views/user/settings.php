<?php
use MidrubApps\Classes as MidrubAppsClasses;
?>
<section class="settings-page">
    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <h1 class="settings-title">
                <?php echo $this->lang->line('mu7'); ?>
                <button class="btn btn-primary settings-save-changes">
                    <i class="far fa-save"></i>
                    <?php echo $this->lang->line('save_changes'); ?>
                </button>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-2 offset-xl-2">
            <div class="settings-menu-group">
                <ul class="nav nav-tabs">
                    <li>
                        <h3 class="settings-menu-header">
                            <?php echo $this->lang->line('general'); ?>
                        </h3>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active show" data-toggle="tab" href="#main-settings">
                            <?php echo $this->lang->line('main'); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#advanced">
                            <?php echo $this->lang->line('advanced'); ?>
                        </a>
                    </li>
                    <?php
                    if ( !get_option('hide_plan_usage') ) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#plan-usage">
                            <?php echo $this->lang->line('plan_usage'); ?>
                        </a>
                    </li>
                    <?php
                    }
                    if ( !get_option('hide_invoices') ) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#invoices">
                            <?php echo $this->lang->line('invoices'); ?>
                        </a>
                    </li>
                    <?php
                    }
                    ?>
                    <li>
                        <h3 class="settings-menu-header">
                            <?php echo $this->lang->line('additional'); ?>
                        </h3>
                    </li>
                    <?php

                    // List all apps
                    foreach (glob(APPPATH . 'apps/collection/*', GLOB_ONLYDIR) as $dir) {

                        $app_dir = trim(basename($dir).PHP_EOL);

                        if ( !get_option('app_' . $app_dir . '_enable') || !plan_feature('app_' . $app_dir) ) {
                            continue;
                        }

                        // Create an array
                        $array = array(
                            'MidrubApps',
                            'Collection',
                            ucfirst($app_dir),
                            'Main'
                        );

                        // Implode the array above
                        $cl = implode('\\',$array);

                        // Get User's settings
                        $user_options = (new $cl())->user_options();

                        if ( !$user_options ) {
                            continue;
                        }

                        // Get app info
                        $app_info = (new $cl())->app_info();

                        echo '<li class="nav-item">'
                                . '<a class="nav-link" data-toggle="tab" href="#app-' . $app_info['app_slug'] . '">'
                                    . $app_info['display_app_name']
                                . '</a>'
                            . '</li>';

                    }

                    ?>
                </ul>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="settings-list">
                <div class="tab-content">
                    <div class="tab-pane container fade active show" id="main-settings">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="icon-settings"></i>
                                <?php echo $this->lang->line('main_settings'); ?>
                            </div>
                            <div class="panel-body">
                                <ul class="settings-list-options">
                                <?php

                                echo (new MidrubAppsClasses\Settings)->process((new MidrubAppsClasses\User_main_options)->get_options());

                                if ( get_option('enable_multilanguage') ) {
                                ?>
                                <li>
                                    <div class="row">
                                        <div class="col-xl-10 col-md-10 col-8">
                                            <h4><?php echo $this->lang->line('language'); ?></h4>
                                            <p><?php echo $this->lang->line('select_language_description'); ?></p>
                                        </div>
                                        <div class="col-xl-2 col-md-2 col-4">
                                            <div class="select-option pull-right">
                                                <?php
                                                $languages = glob(APPPATH . 'language' . '/*' , GLOB_ONLYDIR);
                                                ?>
                                                <select id="user_language">
                                                    <?php
                                                    if ( $languages ) {

                                                        foreach ( $languages as $language ) {

                                                            $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                                                            $select = '';

                                                            if ( $this->config->item('language') === $only_dir ) {
                                                                $select = ' selected';
                                                            }

                                                            echo '<option value="' . $only_dir . '"' . $select . '>' . ucfirst($only_dir) . '</option>';

                                                        }

                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php
                                }

                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="advanced">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="icon-settings"></i>
                                <?php echo $this->lang->line('advanced_settings'); ?>
                            </div>
                            <div class="panel-body">
                                <ul class="settings-list-options">
                                    <?php
                                    echo (new MidrubAppsClasses\Settings)->process((new MidrubAppsClasses\User_advanced_options)->get_options());
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ( !get_option('hide_plan_usage') ) {
                    ?>
                    <div class="tab-pane container fade" id="plan-usage">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="icon-basket-loaded"></i>
                                <?php echo $this->lang->line('plan_usage'); ?>
                            </div>
                            <div class="panel-body">
                                <ul class="settings-list-plan-usage">
                                    <li>
                                        <?php

                                        // Get the user's plan
                                        $user_plan = get_user_option( 'plan', $this->user_id );

                                        // Get plan end
                                        $plan_end = get_user_option( 'plan_end', $this->user_id );

                                        // Get plan data
                                        $plan_data = $this->plans->get_plan( $user_plan );

                                        // Calculate remaining time
                                        $time = strip_tags( calculate_time(strtotime($plan_end), time()) );

                                        $period = (strtotime($plan_end) - (strtotime($plan_end) - ($plan_data[0]['period'] * 86400)));

                                        $time_taken = ( strtotime($plan_end) - time() );

                                        $time_left = ( ( $period - $time_taken ) / $period ) * 100;

                                        // Get processbar color
                                        if ( $time_left < 90 ) {

                                            $color = ' bg-success';

                                        } else {

                                            $color = ' bg-danger';

                                        }

                                        ?>
                                        <div class="row">
                                            <div class="col-xl-9 col-sm-8 col-6">
                                                <?php
                                                echo $plan_data[0]['plan_name'];
                                                ?>
                                            </div>
                                            <div class="col-xl-3 col-sm-4 col-6 text-right">
                                                <i class="icon-hourglass"></i> <?php echo $time; ?>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar<?php echo $color; ?>" role="progressbar" style="width: <?php echo $time_left; ?>%" aria-valuenow="<?php echo $time_left; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <?php

                                        // Get user storage
                                        $user_storage = get_user_option( 'user_storage', $this->user_id );

                                        if ( !$user_storage ) {
                                            $user_storage = 0;
                                        }

                                        $plan_storage = 0;

                                        $plan_st = plan_feature('storage');

                                        if ( $plan_st ) {

                                            $plan_storage = $plan_st;

                                        }

                                        // Get percentage
                                        $free_space = number_format((100 - ( ( $plan_storage - $user_storage ) / $plan_storage ) * 100));

                                        // Get processbar color
                                        if ( $free_space < 90 ) {

                                            $color = ' bg-success';

                                        } else {

                                            $color = ' bg-danger';

                                        }

                                        ?>
                                        <div class="row">
                                            <div class="col-xl-9 col-sm-8 col-6">
                                                <?php
                                                echo $this->lang->line('storage');
                                                ?>
                                            </div>
                                            <div class="col-xl-3 col-sm-4 col-6 text-right">
                                                <?php

                                                if ( $user_storage > 0 ) {
                                                    $user_storage = calculate_size($user_storage);
                                                }

                                                echo $user_storage . '/' . calculate_size($plan_storage);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar<?php echo $color; ?>" role="progressbar" style="width: <?php echo $free_space; ?>%" aria-valuenow="<?php echo $free_space; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </li>
                                    <?php
                                    $team_limits = plan_feature('teams');
                                    if ( $team_limits > 0 ) {
                                    ?>
                                    <li>
                                        <?php

                                        // Get team members
                                        $members = $this->team->get_members( $this->user_id );

                                        if ( !$members ) {
                                            $members = 0;
                                        }

                                        // Get percentage
                                        $members_left = number_format(( 100 - ( ( $team_limits - $members ) / $team_limits ) * 100 ));

                                        // Get processbar color
                                        if ( $members_left < 90 ) {

                                            $color = ' bg-success';

                                        } else {

                                            $color = ' bg-danger';

                                        }

                                        ?>
                                        <div class="row">
                                            <div class="col-xl-9 col-sm-8 col-6">
                                                <?php
                                                echo $this->lang->line('teams');
                                                ?>
                                            </div>
                                            <div class="col-xl-3 col-sm-4 col-6 text-right">
                                                <?php
                                                echo $members . '/' . $team_limits
                                                ?>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar<?php echo $color; ?>" role="progressbar" style="width: <?php echo $members_left; ?>%" aria-valuenow="<?php echo $members_left; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </li>
                                    <?php
                                    }
                                    ?>
                                <?php

                                // List all apps
                                foreach (glob(APPPATH . 'apps/collection/*', GLOB_ONLYDIR) as $dir) {

                                    $app_dir = trim(basename($dir) . PHP_EOL);

                                    if ( !get_option('app_' . $app_dir . '_enable') || !plan_feature('app_' . $app_dir) ) {
                                        continue;
                                    }

                                    // Create an array
                                    $array = array(
                                        'MidrubApps',
                                        'Collection',
                                        ucfirst($app_dir),
                                        'Main'
                                    );

                                    // Implode the array above
                                    $class = implode('\\', $array);

                                    // Get app info
                                    $app_info = (new $class())->app_info();

                                    // Get plan's limits
                                    (new $class())->plan_limits($app_dir);

                                    // Create an array
                                    $array = array(
                                        'MidrubApps',
                                        'Collection',
                                        ucfirst($app_dir),
                                        'Helpers',
                                        'Plans_limits'
                                    );

                                    // Implode the array above
                                    $cl = implode('\\', $array);

                                    // Get app limits
                                    $app_limits = (new $cl())->get_limits();

                                    if ( $app_limits ) {

                                        foreach ( $app_limits as $app_limit ) {

                                            if ( $app_limit['type'] === 'text' ) {

                                                $total = plan_feature($app_limit['name']);

                                                if ( !$total ) {
                                                    continue;
                                                }

                                                $usage_limit = (new $cl())->get_usage($app_limit['name']);

                                                $left = (100 - ( ( $total - $usage_limit ) / $total ) * 100);

                                                // Get processbar color
                                                if ( $left < 90 ) {

                                                    $color = ' bg-success';

                                                } else {

                                                    $color = ' bg-danger';

                                                }

                                                echo '<li>'
                                                        . '<div class="row">'
                                                            . '<div class="col-xl-9 col-sm-8 col-6">'
                                                                . $app_info['app_icon'] . ' ' . $app_limit['title']
                                                            . '</div>'
                                                            . '<div class="col-xl-3 col-sm-4 col-6 text-right">'
                                                                . $usage_limit . ' / ' . $total
                                                            . '</div>'
                                                        . '</div>'
                                                        . '<div class="progress">'
                                                            . '<div class="progress-bar ' . $color . '" role="progressbar" style="width: ' . $left . '%" aria-valuenow="' . $left . '" aria-valuemin="0" aria-valuemax="100"></div>'
                                                        . '</div>'
                                                    . '</li>';

                                            }

                                        }

                                    }

                                }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    if ( !get_option('hide_invoices') ) {
                    ?>
                    <div class="tab-pane container fade" id="invoices">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <?php echo $this->lang->line('invoices'); ?>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <ul class="settings-list-invoices">
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <ul class="pagination" data-type="settings-invoices">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }

                    // List all apps
                    foreach (glob(APPPATH . 'apps/collection/*', GLOB_ONLYDIR) as $dir) {

                        $app_dir = trim(basename($dir).PHP_EOL);

                        if ( !get_option('app_' . $app_dir . '_enable') || !plan_feature('app_' . $app_dir) ) {
                            continue;
                        }

                        // Create an array
                        $array = array(
                            'MidrubApps',
                            'Collection',
                            ucfirst($app_dir),
                            'Main'
                        );

                        // Implode the array above
                        $cl = implode('\\',$array);

                        // Get User's settings
                        $user_options = (new $cl())->user_options();

                        if ( !$user_options ) {
                            continue;
                        }

                        // Get app info
                        $app_info = (new $cl())->app_info();

                        echo '<div class="tab-pane container fade" id="app-' . $app_info['app_slug'] . '">'
                                . '<div class="panel panel-default">'
                                    . '<div class="panel-heading">'
                                        . $app_info['app_icon']
                                        . $app_info['display_app_name']
                                    . '</div>'
                                    . '<div class="panel-body">'
                                        . '<ul class="settings-list-options">'
                                        . (new MidrubAppsClasses\Settings)->process($user_options)
                                        . '</ul>'
                                    . '</div>'
                                . '</div>'
                            . '</div>';

                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="change-password" tabindex="-1" role="dialog" aria-labelledby="change-password-tab" aria-hidden="true">
    <?php echo form_open('user/settings', ['class' => 'form-settings-save-changes', 'data-csrf' => $this->security->get_csrf_token_name()]) ?>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <?php
                        echo $this->lang->line('change_password');
                        ?>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="password" class="form-control current-password" id="current-password" maxlength="50" placeholder="<?php echo $this->lang->line('enter_current_password'); ?>" name="current-password" autocomplete="off" required="required">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control new-password" id="new-password" maxlength="50" placeholder="<?php echo $this->lang->line('enter_new_password'); ?>" name="new-password" autocomplete="off" required="required">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control repeat-password" id="repeat-password" maxlength="50" placeholder="<?php echo $this->lang->line('repeat_password'); ?>" name="repeat-password" autocomplete="off" required="required">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" data-type="main" class="btn btn-primary pull-right"><?php echo $this->lang->line('change'); ?></button>
                </div>
            </div>
        </div>
    <?php echo form_close() ?>
</div>

<!-- Modal -->
<div class="modal fade" id="delete-account" tabindex="-1" role="dialog" aria-labelledby="delete-account-tab" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <?php
                    echo $this->lang->line('mu68');
                    ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group text-center">
                    <button type="button" data-type="main" class="btn btn-danger delete-user-account"><?php echo $this->lang->line('yes_delete_my_account'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
