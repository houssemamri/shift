<section>
    <div class="container-fluid networks payments">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="panel-heading">
                            <h2><i class="fa fa-check-square-o" aria-hidden="true"></i> <?= ucwords(str_replace('_', ' ', $gateway)) ?></h2>
                        </div>
                    </div>          
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="setrow">
                                <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma124'); ?></div>
                                <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                    <div class="enablus pull-right">
                                        <input id="<?= $gateway ?>" name="<?= $gateway ?>" class="setopt"<?php if (get_option($gateway)) echo ' checked="checked"' ?> type="checkbox">
                                        <label for="<?= $gateway ?>"></label>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            $settings = @$class['settings'];

                            if ( $settings ) {

                                foreach ($settings as $setting) {
                                    
                                    $value = '';

                                    if ( get_option( $gateway . '-' . $setting['class'] ) ) {

                                        $value = get_option( $gateway . '-' . $setting['class'] );

                                    }
                                    
                                    if ( $setting['type'] == 'text' ) {
                                        
                                        $option = '<div class="enablus pull-right">
                                                        <input type="text" class="optionvalue" id="' . $gateway . '-' . $setting['class'] . '" value="' . $value . '">
                                                    </div>';
                                        
                                    } else if ( $setting['type'] == 'option' ) {
                                        
                                        $checked = '';
                                        
                                        if ( get_option( $gateway . '-' . $setting['class'] ) ) {
                                            
                                            $checked = ' checked="checked"';
                                            
                                        }
                                        
                                        $option = '<div class="enablus pull-right">
                                                    <input id="' . $gateway . '-' . $setting['class'] . '" name="' . $gateway . '-' . $setting['class'] . '" class="setopt"' . $checked . ' type="checkbox">
                                                    <label for="' . $gateway . '-' . $setting['class'] . '"></label>
                                                </div>';                                        
                                        
                                    }
                                    
                                    ?>
                                    <div class="setrow">
                                        <div class="col-lg-10 col-sm-9 col-xs-9"><?= $setting['label']; ?></div>
                                        <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                            <?= $option ?>
                                        </div>
                                    </div>
                                    <?php
                                    
                                }
                                
                            }
                            ?>
                            <div class="alert-default">
                                <?= $this->lang->line('ma188'); ?>
                                <a href="<?= base_url( 'admin/coupon-codes' ); ?>" class="pull-right"><?= $this->lang->line('ma189'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
