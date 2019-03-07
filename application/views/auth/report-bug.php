<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= get_option('website-title') ?></title>
        
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="<?= get_option('website-meta-description') ?>" />
        <meta name="keywords" content="<?= get_option('website-meta-keywords') ?>" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:site_name" content="<?= get_option('website-title') ?>" />
        <meta property="og:url" content="<?= base_url(); ?>" />
        <meta property="og:image" content="<?= base_url(); ?>assets/img/demo.png" />
        <meta property="og:description" content="<?= get_option('website-meta-description') ?>" />
        <meta property="og:locale" content="en_US" />
        <meta name="twitter:title" content="<?= get_option('website-title') ?>">
        <meta name="twitter:description" content="<?= get_option('website-meta-description') ?>">
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
        
        <link href='https://fonts.googleapis.com/css?family=Merriweather:400,700,900' rel='stylesheet' type='text/css'>
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body class="single-page">
        <?php
            $this->load->view('auth/layout/header');
        ?>

        <main role="main">
            
            <section class="jumbotron header-single-pages text-center">
                <div class="container">
                    <h1 class="jumbotron-heading"><?= $this->lang->line('m35'); ?></h1>
                </div>
            </section>

            <section class="guides-list-gallery bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <p><?= str_replace('site_name', $this->config->item('site_name'), $this->lang->line('m36')); ?></p>
                            <?= form_open('report-bug') ?>
                            
                            <div class="mb-3">
                                <label for="request_subject"><?= $this->lang->line('m37'); ?></label>
                                <input type="text" name="subject" id="subject" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description"><?= $this->lang->line('m38'); ?></label>
                                <textarea name="description" class="form-control" id="description" required></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <div class="g-recaptcha" data-sitekey="<?= get_option('captcha-site-key'); ?>"></div>
                            </div>                            

                            <hr class="mb-4">
                            <div class="mb-3">
                                <button class="btn btn-primary btn-lg btn-block" type="submit"><?= $this->lang->line('m39'); ?></button>
                            </div>
                                    
                            <div class="form-field report_button">
                                <?= $msg ?>
                            </div>                        
                            <?= form_close() ?> 
                        </div>
                    </div>
                </div>
            </section>            

        </main>

        <?php
            $this->load->view('auth/layout/footer');
        ?>
        
    </body>
</html>
