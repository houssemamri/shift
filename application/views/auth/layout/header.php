<header>
    <div class="navbar navbar-dark box-shadow">
        <div class="container-fluid justify-content-between">
            <a href="<?php echo base_url(); ?>" class="navbar-brand home-page-link align-items-center">
                <?php
                $frontend_logo = get_option('frontend-logo');
                if ($frontend_logo):
                    echo '<img src="' . $frontend_logo . '" alt="' . $this->config->item('site_name') . '">';
                else:
                    echo $this->config->item('site_name');
                endif;
                ?>
            </a>
            <nav class="my-2">
                <?php
                // Check if session exist
                if ( isset($this->session->userdata['username']) ) {
                    ?>
                    <a class="dropdown-toggle" id="navbarDropdownMenuLink-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <img src="https://www.gravatar.com/avatar/<?php echo md5(get_user_email_by_id($this->user->get_user_id_by_username($this->session->userdata['username']))) ?>" class="img-fluid rounded-circle z-depth-0" width="30">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-purple" aria-labelledby="navbarDropdownMenuLink-5">
                        <a class="dropdown-item whov waves-effect waves-light" href="<?php echo site_url('user/app/dashboard') ?>">
                            <?php echo $this->lang->line('m67'); ?>
                        </a>
                        <a class="dropdown-item whov waves-effect waves-light" href="<?php echo site_url('auth/logout') ?>">
                            <?php echo $this->lang->line('m68'); ?>
                        </a>
                    </div>
                    <?php
                } else {
                    ?>
                    <a href="<?php echo site_url('members') ?>" class="login-btn">
                        <?php echo $this->lang->line('m56'); ?>
                    </a>  
                    <?php
                    if ( get_option( 'enable-registration' ) ) {
                        ?>
                            <a href="<?php echo site_url('auth/plans') ?>" class="signup-btn">
                                <?php echo $this->lang->line('m57'); ?>
                            </a>
                        <?php
                    }
                }
                ?>
            </nav>
        </div>
    </div>
</header>