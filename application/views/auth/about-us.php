<!doctype html>
<html lang="en">
    <head>
        <?php
        $page_title = get_option('about-us-title');
        $page_description = get_option('about-us-meta-description');
        $photo = get_option('about-us-photo');
        ?>        
        <title><?= $page_title; ?></title>

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="<?= $page_description; ?>" />
        <meta name="keywords" content="<?= get_option('about-us-meta-keywords'); ?>" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:site_name" content="<?= $page_title; ?>" />
        <meta property="og:url" content="<?= base_url(); ?>" />
        <?php if ( $photo ): ?>
        <meta property="og:image" content="<?= $photo; ?>" />
        <?php endif; ?>
        <meta property="og:description" content="<?= $page_description; ?>" />
        <meta property="og:locale" content="en_US" />
        <meta name="twitter:title" content="<?= $page_title; ?>">
        <meta name="twitter:description" content="<?= $page_description; ?>">
        <?php if ( $photo ): ?>
        <meta name="twitter:image" content="<?= $photo; ?>">
        <?php endif; ?>
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
                    <h1 class="jumbotron-heading"><?= get_option('about-us-header-title') ?></h1>
                </div>
            </section>

            <section class="our-mission bg-white">
                <div class="container">
                    <div class="row">
                        <?php
                        $body = get_option('about-us-body');
                        $photo = get_option('about-us-photo');
                        if ( $photo ) {
                        ?>
                        <div class="col-lg-5">
                            <?php
                                if ( $body ) {
                                    
                                    echo html_entity_decode($body);
                                    
                                }
                            ?>
                        </div>
                        <div class="col-lg-7">
                            <img src="<?= $photo ?>" alt="<?= get_option('about-us-header-title'); ?>">
                        </div>      
                        <?php
                        } else {
                            
                            if ( $body ) {

                                echo '<div class="col-lg-12">' . html_entity_decode($body) . '</div>';

                            }                            
                            
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