<section>
    <div class="container-fluid terms-policies">
        <div class="row">
            <div class="col-lg-12"> 
                <div class="col-lg-12">
                    <div class="row">
                        <div class="panel-heading">
                            <h2><i class="fa fa-balance-scale"></i> <?= $this->lang->line('ma243') ?></h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="widget-box">
                                <div class="widget-header">
                                    <div class="widget-toolbar">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a data-toggle="tab" href="#terms-and-conditions" aria-expanded="true"><?= $this->lang->line('ma244') ?></a></li>
                                            <li><a data-toggle="tab" href="#privacy-policy" aria-expanded="false"><?= $this->lang->line('ma245') ?></a></li>
                                            <li><a data-toggle="tab" href="#cookies" aria-expanded="false"><?= $this->lang->line('ma246') ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="tab-content">
                                            <div id="terms-and-conditions" class="tab-pane active">
                                                <div class="setrow row">
                                                    <div class="col-lg-12">
                                                        <?= form_open('admin/terms-and-policies', ['class' => 'save-terms']) ?>
                                                            <div class="col-lg-12 clean">
                                                                <input type="text" class="form-control input-form msg-title" required="required" value="<?= get_option('terms_page_title') ?>" placeholder="<?= $this->lang->line('ma247'); ?>" />
                                                            </div>
                                                            <div class="col-lg-12 clean editor">
                                                                <div class="summernote"></div>
                                                                <textarea class="msg-body hidden"><?= get_option('terms_page_body') ?></textarea>
                                                                <input type="hidden" class="term-key" value="terms">
                                                            </div>
                                                            <div class="col-lg-12 clean buttons">
                                                                <button type="submit" class="btn btn-edit send-msg pull-right"><?= $this->lang->line('ma33'); ?></button>
                                                                <img src="<?= base_url() . 'assets/img/load-prev.gif'; ?>" vspace="15" hspace="10" class="display-none pull-right" />
                                                            </div>
                                                        <?= form_close() ?> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="privacy-policy" class="tab-pane">
                                                <div class="setrow row">
                                                    <div class="col-lg-12">
                                                        <?= form_open('admin/terms-and-policies', ['class' => 'save-terms']) ?>
                                                        <div class="col-lg-12 clean">
                                                            <input type="text" class="form-control input-form msg-title" required="required" value="<?= get_option('policy_page_title') ?>" placeholder="<?= $this->lang->line('ma247'); ?>" />
                                                        </div>
                                                        <div class="col-lg-12 clean editor">
                                                            <div class="summernote"></div>
                                                            <textarea class="msg-body hidden"><?= get_option('policy_page_body') ?></textarea>
                                                            <input type="hidden" class="term-key" value="policy">
                                                        </div>
                                                        <div class="col-lg-12 clean buttons">
                                                            <button type="submit" class="btn btn-edit send-msg pull-right"><?= $this->lang->line('ma33'); ?></button>
                                                            <img src="<?= base_url() . 'assets/img/load-prev.gif'; ?>" vspace="15" hspace="10" class="display-none pull-right" />
                                                        </div>
                                                        <?= form_close() ?> 
                                                    </div>
                                                </div>                                                
                                            </div>   
                                            <div id="cookies" class="tab-pane">
                                                <div class="setrow row">
                                                    <div class="col-lg-12">
                                                        <?= form_open('admin/terms-and-policies', ['class' => 'save-terms']) ?>
                                                        <div class="col-lg-12 clean">
                                                            <input type="text" class="form-control input-form msg-title" required="required" value="<?= get_option('cookies_page_title') ?>" placeholder="<?= $this->lang->line('ma247'); ?>" />
                                                        </div>
                                                        <div class="col-lg-12 clean editor">
                                                            <div class="summernote"></div>
                                                            <textarea class="msg-body hidden"><?= get_option('cookies_page_body') ?></textarea>
                                                            <input type="hidden" class="term-key" value="cookies">
                                                        </div>
                                                        <div class="col-lg-12 clean buttons">
                                                            <button type="submit" class="btn btn-edit send-msg pull-right"><?= $this->lang->line('ma33'); ?></button>
                                                            <img src="<?= base_url() . 'assets/img/load-prev.gif'; ?>" vspace="15" hspace="10" class="display-none pull-right" />
                                                        </div>
                                                        <?= form_close() ?> 
                                                    </div>
                                                </div>                                                
                                            </div>
                                            <div class="col-lg-12 clean alert-msg display-none"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>