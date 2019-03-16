<section>
    <div class="container-fluid users" style="padding-left:15px;">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-6 fl">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="panel-heading"  style="width:100%;">
                                <h2 style="margin-top:20px;"><i class="fa fa-cog"></i> All Migration Setting List <a href="<?php echo site_url('user/new-migration-setting') ?>" class="pull-right">New Migration Setting</a></h2>
                            </div>
                        </div>
                        
                        <div class="row settings-item">      
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="pagination"></ul>
                                <img src="<?= base_url(); ?>assets/img/load-prev.gif" class="pull-right pageload">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 fr user-details display-none">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="panel-heading details">
                                <h2><i class="fa fa-inbox"></i> <?= $this->lang->line('ma100'); ?><span></span></h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <?= form_open('admin/users', ['class' => 'update-form']) ?>
                                <div class="form-group">
                                    <input class="new-message form-control first_name" type="text" placeholder="<?= $this->lang->line('ma277'); ?>" required>
                                </div>
                                <div class="form-group">
                                    <input class="new-message form-control last_name" type="text" placeholder="<?= $this->lang->line('ma278'); ?>" required>
                                </div>
                                <div class="form-group">
                                    <input class="new-message form-control dusername" type="text" placeholder="<?= $this->lang->line('ma101'); ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <input class="new-message form-control demail" type="text" placeholder="<?= $this->lang->line('ma102'); ?>" required>
                                </div>
                                <div class="form-group">
                                    <input class="new-message form-control dpassword" type="password" placeholder="<?= $this->lang->line('ma103'); ?>">
                                </div>
                                <div class="form-group">
                                    <input class="new-message form-control dproxy" type="text" placeholder="<?= $this->lang->line('ma140'); ?>">
                                </div>                        
                                <?php
                                if ($plans) {
                                    echo '<div class="form-group">'
                                    . '<select class="form-control dplan">';
                                    foreach ($plans as $plan) {
                                        ?>
                                        <option value="<?= $plan->plan_id ?>"><?= $plan->plan_name ?></option>
                                        <?php
                                    }
                                    echo '</select>
                                        </div>';
                                }
                                ?>
                                <div class="form-group">
                                    <select class="form-control drole">
                                        <option value="0"><?= $this->lang->line('ma104'); ?></option>
                                        <option value="1"><?= $this->lang->line('ma105'); ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control dstatus">
                                        <option value="0"><?= $this->lang->line('ma106'); ?></option>
                                        <option value="1"><?= $this->lang->line('ma107'); ?></option>
                                        <option value="2"><?= $this->lang->line('ma108'); ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-labeled btn-danger pull-left delete-account"><?= $this->lang->line('ma109'); ?></button> <p class="pull-left confirm"><?= $this->lang->line('ma30'); ?> <a href="#" class="yes"><?= $this->lang->line('ma31'); ?></a><a href="#" class="no"><?= $this->lang->line('ma32'); ?></a></p>
                                    <button type="submit" class="btn btn-labeled btn-primary pull-right"><?= $this->lang->line('ma110'); ?></button>
                                </div>
                                <div class="form-group alert-msg"></div>
                                <?= form_close() ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="panel-footer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</section>