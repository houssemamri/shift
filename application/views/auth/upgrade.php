<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= $this->lang->line('m69'); ?></title>
        
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="ROBOTS" content="NOINDEX" />
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
        
    </head>
    <body class="single-page">
        <?php
            $this->load->view('auth/layout/header');
        ?>

        <main role="main">

            <section class="gateways bg-white" data-price="<?= $plann[0]->plan_price ?>">
                <div class="container">
                    <div class="row">
                        <div class="gateway-body col-lg-6 offset-lg-3">
                            <div class="row">
                                <div class="col-lg-12 the-price">
                                    <h3>
                                        <?= $this->lang->line('m70'); ?>
                                        <span class="plan-price"><?= $plann[0]->plan_price ?></span>
                                        <span><?= $plann[0]->currency_sign ?> </span>
                                        <span class="discount-price"></span>
                                    </h3>
                                </div>
                            </div>
                            <?= form_open('user/upgrade/' . $plan, ['class' => 'verify-coupon-code', 'data-id' => $plan]) ?>
                            <div class="row coupon-code">
                                <div class="col-lg-8 col-8">
                                    <input type="text" class="code" placeholder="<?= $this->lang->line('m72'); ?>" required>
                                </div>
                                <div class="col-lg-4 col-4">
                                    <button type="submit" class="btn btn-primary verify-coupon-code"><?= $this->lang->line('m71'); ?></button>
                                </div>                
                            </div>
                            <?= form_close() ?>
                            <div class="row">
                                <div class="col-lg-12 clean">
                                    <?php
                                    // Verify if payments class are available
                                    if ( $payments) {

                                        echo '<ul>';

                                        // List all enabled payments
                                        foreach ( $payments as $payment ) {

                                            echo '<li>
                                                    <div class="row">
                                                        <div class="col-lg-2 col-2 clean text-center">
                                                            <img src="' . $payment['icon'] . '" alt="PayPal">
                                                        </div>
                                                        <div class="col-lg-7 col-7 clean">
                                                            <h3>' . $payment['name'] . '</h3>
                                                        </div>
                                                        <div class="col-lg-3 col-3 clean text-center">
                                                            <a href="' . site_url( 'user/upgrade/' . $plan . '/' . $payment['slug'] ) . '" class="pay-now">' . $this->lang->line('m73') . '</a>
                                                        </div>                                
                                                    </div>
                                                </li>';

                                        }

                                        echo '</ul>';

                                    } else {

                                        echo '<br><p>' . $this->lang->line('m74') . '</p>';

                                    }
                                    ?>
                                </div>
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
