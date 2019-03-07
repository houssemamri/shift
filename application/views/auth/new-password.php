<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= $this->lang->line('m31'); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="shortcut icon" href="<?php
        $favicon = get_option("favicon");
        if ($favicon): echo $favicon;
        else: echo base_url() . 'assets/img/favicon.png';
        endif;
        ?>" />
        <?php
        $css = get_option('frontend-css');
        if ( $css ) {
            echo '<style>' . $css . '</style>';
        }
        ?>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">

        <!-- Frontend Midrub Styles -->
        <link rel="stylesheet" id="midrub-styles-css"  href="<?= base_url(); ?>assets/auth/css/style.css?ver=<?= MD_VER; ?>" type="text/css" media="all" />

        <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.1.0/css/all.css" type="text/css" media="all" >
        
    </head>
    <body>
        <main role="main" class="bg-white">

            <section class="member-access-page">
                
                <?php
                $img = get_option('login-bg');
                ?>
                <div class="left-side"<?php if ($img) { echo ' style="background-image:url(' . $img . ')"'; } ?>>
                </div>
                <div class="row right-side">
                    <div class="col-md-12">
                        <h3>
                            <a href="<?= base_url(); ?>" class="logourl"><img src="<?php
                                $login_logo = get_option("login-logo");
                                if ($login_logo): echo $login_logo;
                                else: echo base_url() . 'assets/auth/img/big-logo.png';
                                endif;
                                ?>" alt="<?= $this->config->item('site_name') ?>"></a>
                        </h3>
                        <p><?= $this->lang->line('m28'); ?> <a href="<?= site_url('auth/members') ?>"><?= $this->lang->line('m29'); ?></a></p>
                        <h1>
                            <?= $this->lang->line('m30'); ?>
                        </h1>
                        <form action="" method="post">
                            <div class="form-group">
                                <div class='full-input'>
                                    <label for="password"><?= $this->lang->line('m33'); ?></label>
                                    <input type="password" name="password" required>
                                </div>
                            </div>  
                            <div class="form-group">
                                <div class='full-input'>
                                    <label for="password2"><?= $this->lang->line('m34'); ?></label>
                                    <input type="password" name="password2" required>
                                </div>
                            </div>                         
                            <div class="form-group">
                                <button type="submit" class="btn btn-all btn-recover">
                                    <?= $this->lang->line('m32'); ?>
                                </button>
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                            </div>   
                            <div class="form-group">
                                <?= $msg; ?>
                            </div>  
                        </form>
                    </div>
                </div>
            </section>       

        </main>
        
        <?php
        $privacy_url = get_option('privacy-cookie-url');
        if ( $privacy_url ) {
        ?>
        <div class="cookie-window">
            <p>
                <?= $this->lang->line('m75'); ?>
                <a href="<?= $privacy_url; ?>" target="_blank"><?= $this->lang->line('m76'); ?></a>
            </p>
            <p>
                <a class="cookie-button" href="#"><?= $this->lang->line('m77'); ?></a>
            </p>            
        </div>
        <?php
        }
        ?>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="//code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/bootstrap.js"></script>
        <script src="<?= base_url(); ?>assets/auth/js/main.js?ver=<?= MD_VER; ?>"></script>
        <script src="<?= base_url(); ?>assets/auth/js/auth.js?ver=<?= MD_VER; ?>"></script>
    </body>
</html>
