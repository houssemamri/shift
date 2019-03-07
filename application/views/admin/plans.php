<section>
    <div class="container-fluid plans">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 apps-header">
                            <h3>
                                <i class="fas fa-hand-holding-usd"></i> <?php echo $this->lang->line('ma17'); ?>
                                <a href="#" data-toggle="modal" data-target="#new-plan"><?php echo $this->lang->line('ma18'); ?></a>
                            </h3>
                        </div>
                        <div class="col-lg-12 plans-list">
                        <?php

                        // Verify if plans exists
                        if ( $plans ) {

                            echo '<ul>';

                            foreach ( $plans as $plan ) {

                                echo '<li>'
                                        . '<div class="row">'
                                            . '<div class="col-lg-10">'
                                                . '<p>'
                                                    . '<i class="fas fa-dollar-sign"></i>'
                                                    . $plan->plan_name
                                                . '</p>'
                                            . '</div>'
                                            . '<div class="col-lg-2">'
                                                . '<a href="' . site_url( 'admin/plans/' . $plan->plan_id ) . '" class="btn btn-default"><i class="fas fa-sign-in-alt"></i> ' . $this->lang->line('ma134') . '</a>'
                                            . '</div>'
                                        . '</div>'
                                    . '</li>';

                            }

                            echo '</ul>';

                        } else {
                            
                            echo '<p class="no-results-found">' . $this->lang->line('no_apps_found') . '</p>';

                        }

                        ?>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="new-plan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <?php
        echo form_open('admin/plans', array('class' => 'create-plan', 'method' => 'post', 'data-csrf' => $this->security->get_csrf_token_name()));
        ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('ma18'); ?></h4>
            </div>
            <div class="modal-body">
                <input type="text" class="plan_name" placeholder="<?php echo $this->lang->line('ma19'); ?>" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info"><?php echo $this->lang->line('ma33'); ?></button>
            </div>
        <?php
        echo form_close();
        ?>
    </div>
  </div>
</div>