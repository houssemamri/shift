<section class="gateways-page">
    <div class="container-fluid" data-price="<?= $plann[0]->plan_price ?>">
        <div class="row">
            <div class="col-xl-4 offset-xl-4">
                <div class="col-xl-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3><?= $this->lang->line('mu380'); ?> <span class="pull-right plan-price"><?= $plann[0]->plan_price ?></span><span class="pull-right"><?= $plann[0]->currency_sign ?> </span><span class="pull-right discount-price"></span></h3>
                        </div>
                        <div class="panel-body">
                            <?= form_open('user/upgrade/' . $plan, ['class' => 'verify-coupon-code', 'data-id' => $plan]) ?>
                            <div class="row coupon-code">
                                <div class="col-xl-8 col-sm-8 col-xs-8 col-8">
                                    <input type="text" class="code" placeholder="<?= $this->lang->line('mu382'); ?>" required>
                                </div>
                                <div class="col-xl-4 col-sm-4 col-xs-4 col-4">
                                    <button type="submit" class="btn btn-primary verify-coupon-code"><?= $this->lang->line('mu381'); ?></button>
                                </div>                
                            </div>
                            <?= form_close() ?>
                            <?php
                            // Verify if payments class are available
                            if ( $payments) {

                                echo '<ul>';

                                // List all enabled payments
                                foreach ( $payments as $payment ) {

                                    echo '<li>
                                            <div class="row">
                                                <div class="col-lg-2 col-sm-2 col-xs-2 col-2 clean text-center">
                                                    <img src="' . $payment['icon'] . '" alt="PayPal">
                                                </div>
                                                <div class="col-lg-7 col-sm-7 col-xs-7 col-7 clean">
                                                    <h3>' . $payment['name'] . '</h3>
                                                </div>
                                                <div class="col-lg-3 col-sm-3 col-xs-3 col-3 clean text-center">
                                                    <a href="' . site_url( 'user/upgrade/' . $plan . '/' . $payment['slug'] ) . '" class="pay-now">' . $this->lang->line('mu383') . '</a>
                                                </div>                                
                                            </div>
                                        </li>';

                                }

                                echo '</ul>';

                            } else {

                                echo '<br><p class="no-payments-found">' . $this->lang->line('mu384') . '</p>';

                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>