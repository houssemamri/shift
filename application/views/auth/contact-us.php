<!doctype html>
<html lang="en">
    <head>
        
        <title><?= get_option('contact-us-title') ?></title>
        
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="<?= get_option('contact-us-meta-description') ?>" />
        <meta name="keywords" content="<?= get_option('contact-us-meta-keywords') ?>" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:site_name" content="<?= get_option('contact-us-title') ?>" />
        <meta property="og:url" content="<?= base_url(); ?>" />
        <meta property="og:image" content="<?= base_url(); ?>assets/img/demo.png" />
        <meta property="og:description" content="<?= get_option('contact-us-meta-description') ?>" />
        <meta property="og:locale" content="en_US" />
        <meta name="twitter:title" content="<?= get_option('contact-us-title') ?>">
        <meta name="twitter:description" content="<?= get_option('contact-us-meta-description') ?>">
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
                    <h1 class="jumbotron-heading"><?= get_option('contact-us-header-title') ?></h1>
                </div>
            </section>

            <section class="contact-us bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <?php
                            if ( get_option('enable-contact-form') ) {
                                ?>
                                <script src='https://www.google.com/recaptcha/api.js'></script>
                                <?= form_open('contact-us') ?>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="firstName"><?= $this->lang->line('m59'); ?></label>
                                            <input type="text" class="form-control" name="firstName" id="firstName">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="lastName"><?= $this->lang->line('m61'); ?></label>
                                            <input type="text" class="form-control" name="lastName" id="lastName">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email"><?= $this->lang->line('m16'); ?> <span class="text-muted"><?= $this->lang->line('m65'); ?></span></label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="you@example.com" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone"><?= $this->lang->line('m62'); ?> <span class="text-muted"><?= $this->lang->line('m66'); ?></span></label>
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="202-555-0165">
                                    </div>

                                    <div class="mb-3">
                                        <label for="message"><?= $this->lang->line('m63'); ?> <span class="text-muted"><?= $this->lang->line('m65'); ?></span></label>
                                        <textarea class="form-control" name="message" rows="7" id="message" required></textarea>
                                    </div>
                            
                                    <div class="mb-3">
                                        <div class="g-recaptcha" data-sitekey="<?= get_option('captcha-site-key'); ?>"></div>
                                    </div>                            

                                    <hr class="mb-4">
                                    <div class="mb-3">
                                        <button class="btn btn-primary btn-lg btn-block" type="submit"><?= $this->lang->line('m64'); ?></button>
                                    </div>

                                    <div class="form-field report_button">
                                        <?= $msg ?>
                                    </div>                        
                                    <?= form_close() ?>
                                <?php
                            }
                            
                            if ( get_option('enable-contact-map') ) {
                            ?>
                                <style>
                                  /* Always set the map height explicitly to define the size of the div
                                   * element that contains the map. */
                                  #map {
                                    height: 400px;
                                  }
                                  /* Optional: Makes the sample page fill the window. */
                                  html, body {
                                    height: 100%;
                                    margin: 0;
                                    padding: 0;
                                  }
                                </style>
                                <div id="map"></div>
                                <script>
                                  var marker;

                                  function initMap() {
                                    var map = new google.maps.Map(document.getElementById('map'), {
                                      zoom: 13,
                                      center: {lat: <?= get_option('google-latitude'); ?>, lng: <?= get_option('google-longitude'); ?>}
                                    });

                                    marker = new google.maps.Marker({
                                      map: map,
                                      draggable: true,
                                      animation: google.maps.Animation.DROP,
                                      position: {lat: <?= get_option('google-latitude'); ?>, lng: <?= get_option('google-longitude'); ?>}
                                    });
                                    marker.addListener('click', toggleBounce);
                                  }

                                  function toggleBounce() {
                                    if (marker.getAnimation() !== null) {
                                      marker.setAnimation(null);
                                    } else {
                                      marker.setAnimation(google.maps.Animation.BOUNCE);
                                    }
                                  }
                                </script>
                                <script src="//maps.googleapis.com/maps/api/js?key=<?= get_option('google-maps-api-key'); ?>&callback=initMap"></script>
                            <?php
                            }
                            ?>
                        </div> 
                        <div class="col-lg-4">
                            <div class="bg-white rounded box-shadow">
                                <?php
                                
                                $contact_data = get_option('contact-us-body');
                                
                                if ( $contact_data ) {
                                    
                                    echo html_entity_decode($contact_data);
                                    
                                }
                                
                                ?>
                            </div>
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