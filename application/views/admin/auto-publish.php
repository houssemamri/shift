<section>
    <div class="container-fluid scheduled">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-6 col-lg-offset-3">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="panel-heading details">
                                <h2><i class="fa fa-calendar-check-o" aria-hidden="true"></i> <?= $this->lang->line('ma111'); ?></h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <?= form_open('admin/auto-publish', ['class' => 'auto-publish']) ?>
                                <div class="form-group">
                                    <ul class="list-group">
                                        <li class="list-group-item"><i class="fa fa-clock-o" aria-hidden="true"></i> <?= $this->lang->line('ma112'); ?> <span class="pull-right unpub"><?= $scheduled ?></span></li>
                                        <li class="list-group-item"><i class="fa fa-calendar-times-o" aria-hidden="true"></i> <?= $this->lang->line('ma113'); ?> <span class="pull-right"><?= (is_numeric($first_unpublished)) ? calculate_time($first_unpublished, time()) : ' ' ?></span></li>
                                        <li class="list-group-item"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i> <?= $this->lang->line('ma114'); ?> <span class="pull-right"><?= (is_numeric($last_scheduled)) ? strip_tags(calculate_time($last_scheduled, time())) : ' ' ?></span></li>
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <img src="<?= base_url(); ?>assets/img/load-prev.gif" class="publishing-run display-none">
                                    <button type="button" class="btn btn-labeled all-publish btn-success pull-right"><?= $this->lang->line('ma115'); ?></button>
                                    <button type="button" class="btn btn-labeled only-unpublished btn-info pull-right"><?= $this->lang->line('ma116'); ?></button>
                                </div>
                                <div class="form-group alert-msg"></div>
                                <?= form_close() ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="panel-footer"><i class="fa fa-history" aria-hidden="true"></i> <span class="expir"><?= $unpublished ?></span> <?= $this->lang->line('ma117'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>