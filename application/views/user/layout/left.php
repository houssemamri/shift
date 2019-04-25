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

    <li style="border-bottom: 1px solid white;  border-top: 1px solid white;">
      <a href="<?php echo site_url('user/app/dashboard') ?>">
        <img src="<?php echo site_url('assets/user/img/dashboard.ico') ?>" style="height: 20px; width: 20px;"><br>
        <p style=" line-height: 15px;"><?php echo "Dashboard"; ?></p>
      </a>
    </li>
    <li style="border-bottom: 1px solid white;">
      <a href="<?php echo site_url('user/migration-settings') ?>">
        <i class="fas fa-cog"></i><br>
        <p style=" line-height: 15px;"><?php echo "Migration Settings"; ?></p>
      </a>
    </li>
    <li style="border-bottom: 1px solid white;">
      <a href="<?php echo site_url('user/common-migration-view') ?>">
        <img src="<?php echo site_url('assets/user/img/transfer.png') ?>" style="height: 20px; width: 20px; margin-top: -3px;"><br>
        <p style=" line-height: 15px; margin-top: -5px;"><?php echo "Start <br>Migration"; ?></p>
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
              ?>
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
