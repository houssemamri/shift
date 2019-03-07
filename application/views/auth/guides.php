<!doctype html>
<html lang="en">
    <head>
        
        <title><?= get_option('guides-title') ?></title>
        
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="<?= get_option('guides-meta-description') ?>" />
        <meta name="keywords" content="<?= get_option('guides-meta-keywords') ?>" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:site_name" content="<?= get_option('guides-title') ?>" />
        <meta property="og:url" content="<?= base_url(); ?>" />
        <meta property="og:image" content="<?= base_url(); ?>assets/img/demo.png" />
        <meta property="og:description" content="<?= get_option('guides-meta-description') ?>" />
        <meta property="og:locale" content="en_US" />
        <meta name="twitter:title" content="<?= get_option('guides-title') ?>">
        <meta name="twitter:description" content="<?= get_option('guides-meta-description') ?>">
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
    <body class="single-page">
        <?php
            $this->load->view('auth/layout/header');
        ?>
        
        <main role="main">

            <section class="jumbotron header-single-pages text-center">
                <div class="container">
                    <h1 class="jumbotron-heading"><?= get_option('guides-header-title') ?></h1>
                </div>
            </section>

            <section class="guides-list-gallery bg-white">
                <div class="container">
                    <div class="row">
                        
                        <?php
                        if ( $guides ) {
                            
                            foreach ( $guides as $guide ) {
                                
                            ?>

                            <div class="col-lg-4 guide-area">
                                <div class="col-lg-12">
                                    <?php
                                    if ( $guide->cover ) {
                                        
                                        echo '<a href="' . site_url('guides/' . $guide->guide_id ) . '"><img src="' . $guide->cover . '"></a>';
                                        
                                    }
                                    ?>
                                    <h3>
                                        <a href="<?= site_url('guides/' . $guide->guide_id ) ?>">
                                            <?php
                                            echo $guide->title;
                                            ?>
                                        </a>
                                    </h3>
                                </div>
                            </div>

                            <?php

                            }
                            
                        } else {
                            
                            ?>
                            <div class="col-lg-12 text-center">
                                <?= $this->lang->line('ma249'); ?>
                            </div>                        
                            <?php
                            
                        }
                        
                        ?>                        
                        
                    </div>
                </div>
            </section>           

        </main>

        <?php
            $this->load->view('auth/layout/footer');
        ?>
        
    </body>
</html>