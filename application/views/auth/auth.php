<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <title><?= $this->config->item('site_name') ?> | <?= $this->lang->line('m47'); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="<?= str_replace('site_name',$this->config->item('site_name'),$this->lang->line('m3')); ?>" />
        <meta name="keywords" content="<?= $this->lang->line('m4') ?>" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:site_name" content="<?= $this->config->item('site_name') ?>" />
        <meta property="og:url" content="<?= base_url(); ?>" />
        <meta property="og:image" content="<?= base_url(); ?>assets/img/demo.png" />
        <meta property="og:description" content="<?= str_replace('site_name',$this->config->item('site_name'),$this->lang->line('m6')); ?>" />
        <meta property="og:locale" content="en_US" />
        <meta name="twitter:title" content="<?= $this->config->item('site_name') ?>">
        <meta name="twitter:description" content="<?= str_replace('site_name',$this->config->item('site_name'),$this->lang->line('m6')); ?>">
        <meta name="twitter:image" content="<?= base_url(); ?>assets/img/demo.png">
        <link rel="shortcut icon" href="<?php
        $favicon = get_option('favicon');
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
    <body<?php get_browser_class(); ?>>
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
                        <?php if ($signup): ?>
                        <p><?= $this->lang->line('m20'); ?> <a href="<?= site_url('auth/plans') ?>"><?= $this->lang->line('m8') ?></a></p>
                        <?php endif; ?>
                        <h1>
                            <?= $this->lang->line('m47'); ?>
                        </h1>
                        <?= form_open('login', ['class' => 'signin']) ?>
                            <div class="form-group">
                                <div class='full-input'>
                                    <label for="username"><?= $this->lang->line('m15'); ?></label>
                                    <input type="text" name="username" class="username" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class='full-input'>
                                    <label for="password"><?= $this->lang->line('m17'); ?></label>
                                    <input type="password" name="password" class="password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="remember">
                                    <span>
                                        <input type="checkbox" id="remember">
                                    </span>
                                    <span>
                                        <?= $this->lang->line('m19'); ?>
                                    </span>
                                    <a href="<?= site_url('reset') ?>" class="reset-password"><?= $this->lang->line('m46'); ?></a>
                                </p>
                            </div>                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-sign">
                                    <?= $this->lang->line('m7') ?>
                                </button>
                            </div>
                            <?php
                            if (count($data) > 0) {
                                foreach ($data as $dat):
                                    echo $dat;
                                endforeach;
                            }
                            ?>                     
                        <?= form_close() ?>
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
        <?php
        $get_code =  get_option('analytics-code');

        if ( $get_code ) {

            echo html_entity_decode( $get_code );

        }
        ?>
    </body>
</html>
