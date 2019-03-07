<?php
use MidrubApps\Classes as MidrubAppsClasses;
?>
<section>
    <div class="container-fluid plan" data-plan-id="<?php echo $plan_id; ?>">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-xl-1 col-lg-2 col-md-2">
                    <ul class="nav nav-tabs">
                        <li class="nav-item active">
                            <a class="nav-link" id="home-tab" data-toggle="tab" href="#nav-general" role="tab" aria-controls="nav-general" aria-selected="true">
                                <i class="fas fa-home"></i><br>
                                <?php echo $this->lang->line('ma34'); ?>
                            </a>
                        </li>
                        <?php
                        
                        // Require the Apps class
                        $this->load->file(APPPATH . '/apps/main.php');

                        // List all apps
                        foreach (glob(APPPATH . 'apps/collection/*', GLOB_ONLYDIR) as $dir) {

                            $app_dir = trim(basename($dir) . PHP_EOL);
                            
                            if ( !get_option('app_' . $app_dir . '_enable') ) {
                                continue;
                            }

                            // Create an array
                            $array = array(
                                'MidrubApps',
                                'Collection',
                                ucfirst($app_dir),
                                'Main'
                            );

                            // Implode the array above
                            $cl = implode('\\', $array);

                            // Get app info
                            $app_info = (new $cl())->app_info();

                            echo '<li class="nav-item">'
                                . '<a class="nav-link" id="' . $app_info['app_slug'] . '-tab" data-toggle="tab" href="#nav-' . $app_info['app_slug'] . '" role="tab" aria-controls="nav-' . $app_info['app_slug'] . '" aria-selected="false">'
                                    . $app_info['app_icon'] . '<br>'
                                    . $app_info['display_app_name']
                                . '</a>'
                            . '</li>';
                        }
                        
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" id="networks-tab" data-toggle="tab" href="#nav-networks" role="tab" aria-controls="nav-networks" aria-selected="false">
                                <i class="far fa-share-square"></i><br>
                                <?php echo $this->lang->line('ma5'); ?>
                            </a>
                        </li>                        
                    </ul>
                </div>
                <div class="col-xl-11 col-lg-10 col-md-10">
                    <?php echo form_open('admin/plans/' . $plan_id, ['class' => 'update-plan', 'data-csrf' => $this->security->get_csrf_token_name()]) ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active in" id="nav-general" role="tabpanel" aria-labelledby="nav-general">
                                    <?php
                                    echo (new MidrubAppsClasses\Plans)->process($plan_id, (new MidrubAppsClasses\General_plans_limits)->get_limits());
                                    ?>
                                </div>
                                <?php

                                // List all apps
                                foreach (glob(APPPATH . 'apps/collection/*', GLOB_ONLYDIR) as $dir) {

                                    $app_dir = trim(basename($dir) . PHP_EOL);

                                    // Create an array
                                    $array = array(
                                        'MidrubApps',
                                        'Collection',
                                        ucfirst($app_dir),
                                        'Main'
                                    );

                                    // Implode the array above
                                    $cl = implode('\\', $array);

                                    // Get app info
                                    $app_info = (new $cl())->app_info();
                                    
                                    // Call the plan's limits
                                    $plans_limits = (new $cl())->plan_limits($app_dir);

                                    echo '<div class="tab-pane fade" id="nav-' . $app_info['app_slug'] . '" role="tabpanel" aria-labelledby="nav-' . $app_info['app_slug'] . '">' . $plans_limits['limits'] . '</div>';
                                }
                                ?>
                                <div class="tab-pane fade" id="nav-networks" role="tabpanel" aria-labelledby="nav-networks">
                                    <?php
                                    echo (new MidrubAppsClasses\Plans)->process($plan_id, (new MidrubAppsClasses\Networks_plans_limits)->get_limits());
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                            if ( $plan_id > 1 ) {    
                                ?>
                                <button type="button" class="btn pull-left btn-danger delete-plan" data-plan=""><?php echo $this->lang->line('ma29'); ?></button>
                                <p class="pull-left confirm"><?php echo $this->lang->line('ma30'); ?> <a href="#" class="yes"><?php echo $this->lang->line('ma31'); ?></a><a href="#" class="no"><?php echo $this->lang->line('ma32'); ?></a></p>
                                <?php
                            }   
                            ?>                            
                            <button type="submit" class="btn pull-right save-plan btn-info"><?php echo $this->lang->line('ma33'); ?></button>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</section>