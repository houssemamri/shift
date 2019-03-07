<section>
    <div class="container-fluid update">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-6 col-lg-offset-3">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="panel-heading details">
                                <h2><i class="fa fa-cloud-download"></i> <?= $this->lang->line('ma91'); ?></h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group update-buttons">
                                    <?php if ($new_update == true): ?>
                                        <?php if (($code == 1)): ?>
                                            <a href="<?php echo site_url('admin/upnow') ?>"><button type="button" class="btn btn-labeled all-publish btn-success pull-right"><?= $this->lang->line('ma91'); ?></button></a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?= $this->lang->line('ma92'); ?>
                                    <?php endif; ?>
                                    <?php if (@$restore): ?>
                                        <a href="<?php echo site_url('admin/upnow/1') ?>"><button type="button" class="btn btn-labeled only-unpublished btn-danger pull-right"><?= $this->lang->line('ma93'); ?></button></a>
                                    <?php endif; ?>
                                </div>
                                <?php if ($new_update): ?>
                                    <div class="form-group history-update">
                                        <p><?= @$new_update["version"] ?></p>
                                        <?php if (@$new_update["changelogs"]): ?>
                                            <?= $new_update["changelogs"] ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if ((($code == 0) || ($code == 2) || ($code == 3) || ($code == 4)) && ($new_update == true)): ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <?= form_open('admin/update') ?>
                                    <div class="input-group">
                                        <input id="btn-input" name="code" type="text" class="form-control input-sm" placeholder="<?= $this->lang->line('ma94'); ?>" required />
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary btn-sm" type="submit">
                                                <?= $this->lang->line('ma95'); ?>
                                            </button>
                                            <a href="http://access-codes.midrub.com/" class="btn btn-default btn-sm" target="_blank">
                                                <?= $this->lang->line('ma96'); ?>
                                            </a>	                            
                                        </span>
                                    </div>
                                    <?= form_close() ?>
                                </div>
                            </div>
                            <?php if ($code == 2): ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p><?= display_mess(103); ?></p>
                                    </div>
                                </div>                    
                            <?php endif; ?>
                            <?php if ($code == 3): ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p><?= display_mess(102); ?></p>
                                    </div>
                                </div>                    
                            <?php endif; ?> 
                            <?php if ($code == 4): ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p><?= display_mess(101); ?></p>
                                    </div>
                                </div>                    
                            <?php endif; ?>                
                        <?php endif; ?>   
                        <div class="row">
                            <div class="panel-footer"><?php if ($msg): ?><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?php
                                    echo $msg;
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>