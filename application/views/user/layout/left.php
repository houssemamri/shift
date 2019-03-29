<nav class="navbar navbar-expand-lg navbar-light collapse navbar-collapse" id="mainMenu">
    <a class="home-page-link" href="<?php echo base_url(); ?>">
        <img src="<?php $main_logo = get_option('main-logo');
        if ( $main_logo ) {
            echo $main_logo;
        } else {
            echo base_url('assets/img/logo.png');
        }
        ?>" alt="<?= $this->config->item('site_name') ?>">
    </a>
    <a href="#mainMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle close-main-menu toggle-btn">
        <i class="fas fa-times"></i>
    </a>
    <ul>
    <?php

        if ( !class_exists('MidrubApps\MidrubApps') ) {
            // Require the Apps class
            $this->load->file( APPPATH . '/apps/main.php' );
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

            // Get app info
            $app_info = (new $cl())->app_info();

            $active = '';

            if ( @$app === $app_dir ) {
                $active = ' class="active"';
            }

            echo '<li' . $active . '>'
                    . '<a href="' . site_url('user/app/' . str_replace('_', '-', $app_dir) ) . '">'
                        . $app_info['app_icon'] . '<br>'
                        . $app_info['display_app_name']
                    . '</a>'
                . '</li>';

        }
        ?>
		<li>
                <a href="<?php echo site_url('user/migration-settings') ?>">
                    <i class="fas fa-cog"></i><br>
                    <?php echo "Migration Settings"; ?>
                </a>
        </li>
    </ul>
</nav>

<main id="main" class="site-main main">

    <header>
        <div class="container-fluid">
            <ul class="nav navbar navbar-left">
                <li>
                    <a href="#mainMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle toggle-btn">
                        <div class="menu-line"></div>
                        <div class="menu-line"></div>
                        <div class="menu-line"></div>
                    </a>
                </li>



                <!-- START -->
                <li>
                    <a href="<?php echo site_url('user/product-migration') ?>" class="new-post-button">
                        Product Migration
                    </a>
                </li>
                <li>
                    <!-- EDIT -->
                    <a href="<?php echo site_url('user/customer-migration') ?>" class="new-post-button">
                    <!-- EDIT -->
                        Customer Migration
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('user/order-migration') ?>" class="new-post-button">
                        Order Migration
                    </a>
                </li>
                <!-- END -->



            </ul>
            <ul class="nav navbar justify-content-end">
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><i class="icon-question"></i><span class="label label-success"><?php echo $this->user_header['new_tickets']; ?></span></a>
                    <ul class="dropdown-menu show-tickets-lists">
                        <li><?php echo $this->lang->line('mu212'); ?></li>
                        <?php echo $this->user_header['tickets']; ?>
                        <li><a href="<?php echo site_url('user/faq-page') ?>"><?php echo $this->lang->line('mu213'); ?></a></li>
                    </ul>
                </li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><i class="icon-bell"></i><span class="label label-primary"><?php echo $this->user_header['new_notifications']; ?></span></a>
                    <ul class="dropdown-menu notificationss">
                        <li><?php echo $this->lang->line('mu10'); ?></li>
                        <?php echo $this->user_header['notifications']; ?>
                        <li><a href="<?php echo site_url('user/notifications') ?>"><?php echo $this->lang->line('mu11'); ?></a></li>
                    </ul>
                </li>
                <li class="dropdown profile-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="https://www.gravatar.com/avatar/<?php echo md5($this->user_header['user_profile']['email']) ?>"/>
                        <strong><?php echo $this->user_header['user_profile']['name']; ?></strong>
                        <i class="fas fa-sort-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <?php
                        if ( !$this->session->userdata( 'member' ) ) {
                       /*  ?>
                        <li>
                            <a href="<?= site_url('user/activities') ?>">
                                <i class="icon-chart"></i> <?php echo $this->lang->line('mu3'); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('user/team') ?>">
                                <i class="icon-people"></i> <?php echo $this->lang->line('mu314'); ?>
                            </a>
                        </li> */ ?>
                        <li>
                            <a href="<?= site_url('user/settings') ?>">
                                <i class="icon-settings"></i> <?php echo $this->lang->line('mu7'); ?>
                            </a>
                        </li>
                        <?php
                        } else if ( get_user_option('display_activities') ) {
                            ?>
                            <li>
                                <a href="<?= site_url('user/activities') ?>">
                                    <i class="icon-chart"></i> <?php echo $this->lang->line('mu3'); ?>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                        <li>
                            <a href="<?php echo site_url('auth/logout') ?>">
                                <i class="icon-logout"></i> <?php echo $this->lang->line('sign-out'); ?>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </header>
