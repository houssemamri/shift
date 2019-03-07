<!doctype html>
<html lang="en">
    <head>
        
        <title><?= get_option('plans-title') ?></title>
        
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="<?= get_option('plans-meta-description') ?>" />
        <meta name="keywords" content="<?= get_option('plans-meta-keywords') ?>" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:site_name" content="<?= get_option('plans-title') ?>" />
        <meta property="og:url" content="<?= base_url(); ?>" />
        <meta property="og:image" content="<?= base_url(); ?>assets/img/demo.png" />
        <meta property="og:description" content="<?= get_option('plans-meta-description') ?>" />
        <meta property="og:locale" content="en_US" />
        <meta name="twitter:title" content="<?= get_option('plans-title') ?>">
        <meta name="twitter:description" content="<?= get_option('plans-meta-description') ?>">
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
        if ( !get_option('disabled-frontend') ) {
            $this->load->view('auth/layout/header');
        }
        ?>
        
        <main role="main">
            <section class="jumbotron header-single-pages text-center">
                <div class="container">
                    <h1 class="jumbotron-heading"><?= get_option('plans-header-title') ?></h1>
                </div>
            </section>

            <section class="plans bg-white">
                <div class="container">
                    <div class="card-deck mb-3 text-center">
                        <?php
                        if ( $plans ) {
                            
                            foreach ( $plans as $plan ) {
                                
                                $features = $plan->features;
                                
                                $featur = preg_split('/\r\n|\r|\n/', $features);
                                
                                if ( $featur ) {
                                    
                                    $features = '';
                                    
                                    foreach ( $featur as $feature ) {
                                        
                                        $features .= '<li>' . $feature . '</li>';
                                        
                                    }
                                    
                                } else {
                                    
                                    $features = '<li>' . $features . '</li>';
                                    
                                }
                                
                                $popular = '';
                                
                                if ( $plan->popular ) {
                                    
                                    $popular = ' most-popular';
                                    
                                }
                                
                                $interval = $this->lang->line('m48');

                                if ( $plan->period > 300 ) {
                                    $interval = $this->lang->line('m49');
                                }
                                
                                $btn_txt = $this->lang->line('m55');
                                
                                if ( $plan->trial > 0 ) {
                                    $btn_txt = $this->lang->line('m54');
                                } 
                                
                                echo '<div class="card mb-4 box-shadow' . $popular . '">
                                        <div class="card-header">
                                            <h4 class="my-0">' . $plan->plan_name . '</h4>
                                            <p>' . $plan->header . '</p>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title pricing-card-title">' . $plan->currency_sign . ' ' . $plan->plan_price . ' <small class="text-muted">/ ' . $interval . '</small></h1>
                                            <ul class="list-unstyled mt-3 mb-4">
                                                ' . $features . '
                                            </ul>
                                            <a href="' . site_url( 'auth/signup/' . $plan->plan_id ) . '" class="btn btn-lg btn-block btn-primary">' . $btn_txt . '</a>
                                        </div>
                                    </div>';
                                
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