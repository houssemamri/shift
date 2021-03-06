<section class="plans-page">
    <div class="container-fluid">
        <?php
        if($upgrade) {
        ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="reached-plan-limit">
                    <div class="row">
                        <div class="col-xl-9">
                            <i class="icon-info"></i>
                            <?php echo html_entity_decode($upgrade); ?> 
                        </div>
                        <div class="col-xl-3 text-right">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="row">
            <?php
            if ($plans) {
                $col = 12 / count($plans);
                foreach ($plans as $plan) {
                    ?>
                    <div class="col-xl-<?php echo $col; ?> col-xs-12">
                        <div class="col-xl-12">
                            <div class="panel panel-success <?php echo str_replace(' ', '-', strtolower($plan->plan_name)) ?>">
                                <div class="panel-heading">
                                    <h3><?php echo $plan->plan_name ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="the-price">
                                        <h1><?php echo $plan->currency_sign ?> <?php echo $plan->plan_price ?></h1>
                                    </div>
                                    <table class="table">
                                        <?php
                                        if ($plan->features) {
                                            $features = explode("\n", $plan->features);
                                            foreach ($features as $feature) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $feature ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </table>
                                </div>
                                <div class="panel-footer">
                                    <?php
                                    $cplan = 1;
                                    $plan_end = time() + 86400;
                                    if ($user_plan) {
                                        foreach ($user_plan as $up) {
                                            if (@$up->meta_name == 'plan') {
                                                $cplan = $up->meta_value;
                                            }
                                            if (@$up->meta_name == 'plan_end') {
                                                $plan_end = strtotime($up->meta_value);
                                            }
                                        }
                                    }
                                    if (($cplan != $plan->plan_id) || ($plan_end < time())):
                                        ?>
                                        <a href="<?php echo site_url(['user/upgrade', $plan->plan_id]) ?>" class="btn btn-success <?php echo str_replace(' ', '-', strtolower($plan->plan_name)) ?>" role="button"><?php echo $this->lang->line('order_now'); ?></a>
                                    <?php elseif ($expires_soon): ?>
                                        <a href="<?php echo site_url(['user/upgrade', $plan->plan_id]) ?>" class="btn btn-default" role="button"><?php echo $this->lang->line('renew_current_plan'); ?></a>                        
                                    <?php else: ?>
                                        <a href="#" class="btn btn-default" role="button"><?php echo $this->lang->line('current_plan'); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>
