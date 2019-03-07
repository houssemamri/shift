<!doctype html>
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
        <?= lheads(); ?>
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
    <?php
    $img = get_option('home-bg');
    ?>
    <body<?php get_browser_class(); if ($img) { echo ' style="background-image:url(' . $img . ')"'; } ?>>
        <?php
            $this->load->view('auth/layout/header');
        ?>

        <main role="main">

            <section class="jumbotron welcome-text text-center">
                <div class="container">
                    <h1 class="jumbotron-heading"><?= get_option('home-page-header-title'); ?></h1>
                    <p class="after-heading"><?= get_option('home-page-header-description'); ?></p>
                    <?php
                    if ( get_option( 'enable-registration' ) ) {
                        ?>
                        <p>
                            <?php
                            $button = get_option('home-page-header-button');
                            if ( $button ) {
                            ?>
                            <a href="<?= site_url('auth/plans') ?>" class="get_started_now">
                                <?= $button; ?>
                            </a>
                            <?php
                            }
                            ?>                        
                        </p>
                        <p class="reminder">
                            <?= get_option('home-page-header-money-back'); ?>
                        </p>
                        <?php
                    }
                    ?>
                </div>
            </section>

            <?php
            $plans_title = get_option('home-page-plans-title');
            if ( $plans_title ) {
                ?>
                <section class="signup-features bg-white">
                    <div class="container">
                        <div class="row">
                            <div class="signup-features-header col-lg-12 text-center">
                                <h2><?= $plans_title; ?></h2>
                                <p><?= get_option('home-page-plans-description'); ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-lg-4 col-md-12 col-sm-12">
                                <div class="col-lg-12 content-area">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h3><?= get_option('home-page-plans-advantages-title'); ?></h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">   
                                            <ul>
                                                <?php
                                                $advantages = get_option('home-page-plans-advantages');

                                                if ( $advantages ) {

                                                    $keys = preg_split('/\r\n|\r|\n/', $advantages);

                                                    foreach ( $keys as $key ) {

                                                        echo '<li> ' . $key . '</li>';

                                                    }

                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>                                        
                                </div>
                            </div>
                            <?php
                            if ( $plans ) {

                                foreach ( $plans as $plan ) {

                                    if ( !$plan->featured ) {
                                        continue;
                                    }

                                    @list($price, $decimal) = explode('.', $plan->plan_price);

                                    if ( $decimal ) {

                                        $decimals = '<span class="decimals">.' . $decimal . '</span>';

                                    }

                                    $interval = $this->lang->line('m48');

                                    if ( $plan->period > 300 ) {
                                        $interval = $this->lang->line('m49');
                                    }

                                    $btn_txt = $this->lang->line('m55');

                                    if ( $plan->trial > 0 ) {
                                        $btn_txt = $this->lang->line('m54');
                                    }                                

                                    echo '<div class="col-xl-3 col-lg-4 col-md-12 col-sm-12">
                                            <div class="col-lg-12 content-area">
                                                <div class="row">
                                                    <div class="col-lg-12 text-center">
                                                        <h3>' . $plan->plan_name . '</h3>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 text-center">
                                                        <h1>
                                                            <span class="currency">' . $plan->currency_sign . '</span>
                                                            ' . $price . '
                                                            ' . @$decimals . '
                                                        </h1>
                                                        <h2>
                                                            ' . $this->lang->line('m53') . ' ' . $interval . '
                                                        </h2>
                                                        <h4>
                                                            <a class="start-free-trial" href="' . site_url( 'auth/signup/' . $plan->plan_id ) . '">' . $btn_txt . '</a>
                                                        </h4>
                                                    </div>
                                                </div>                                
                                            </div>                            
                                        </div>';

                                }

                            }
                            ?>       
                        </div>
                    </div>
                </section>
                <?php
            }
            ?>
            
            <?php
            if ( $guides && get_option('enable-guides') ) {
                ?>
                <section class="guides-list">
                    <div class="container">
                        <div class="row">
                            <?php
                            $re = 0;
                            foreach ( $guides as $guide ) {
                                ?>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <?php
                                        if ( $guide->cover ) {
                                            ?>
                                            <div class="col-lg-12">
                                                <img src="<?= $guide->cover ?>">
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">  
                                            <h3><a href="<?= site_url('guides/' . $guide->guide_id ); ?>"><?= $guide->title ?></a></h3>
                                            <p><?= $guide->short ?></p>
                                        </div>
                                    </div>                                    
                                </div>    
                                <?php
                                $re++;
                                if ( $re > 1 ) {
                                    break;
                                }
                            }
                            ?>
                        </div>
                    </div>
                </section>
                <?php
            }
            ?>  
            
            
            <?php
            $contact_title = get_option('home-page-contact-us-title');
            if ( $contact_title ) {
                ?>
                <section class="contact-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <h2><?= $contact_title; ?></h2>
                                <p><?= get_option('home-page-contact-us-description'); ?></p>
                                <p><a href="<?= site_url('contact-us'); ?>"><?= get_option('home-page-contact-us-button'); ?></a></p>
                            </div>
                        </div>
                    </div>
                </section>            
                <?php
            }
            ?>
            
        </main>

        <?php
            $this->load->view('auth/layout/footer');
        ?>
    </body>
</html>