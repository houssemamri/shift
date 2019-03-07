<section>
    <div class="container-fluid notifications">
        <div class="col-lg-4">
            <div class="col-lg-12">
                <div class="widget-box">
                    <div class="widget-header">
                        <div class="widget-toolbar">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a data-toggle="tab" href="#guides" aria-expanded="true"><?= $this->lang->line('ma248'); ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="tab-content">
                                <div id="guides" class="tab-pane active">
                                    <ul class="list-group">
                                        <?php
                                        if ( $guides ) {
                                            
                                            foreach ( $guides as $guide ) {
                                                
                                                echo '<li class="list-group-item" data-id="' . $guide->guide_id . '"><i class="fa fa-file" aria-hidden="true"></i> ' . $guide->title . ' <span class="pull-right">' . calculate_time($guide->created, time()) . '</span></li>';
                                                
                                            }
                                            
                                        } else {
                                            
                                            echo '<li class="list-group-item">'.$this->lang->line('ma249').'</li>';
                                            
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="col-lg-12 msg-body">
                <?= form_open('admin/guides', ['class' => 'save-new-guide']) ?>
                <div class="col-lg-12 clean">
                    <input type="text" class="form-control input-form msg-title" required="required" placeholder="<?= $this->lang->line('ma247'); ?>" />
                </div>
                <div class="col-lg-12 clean">
                    <input type="text" class="form-control input-form msg-short" required="required" placeholder="<?= $this->lang->line('ma257'); ?>" />
                </div>
                <div class="col-lg-12 clean editor">
                    <div id="summernote"></div>
                    <textarea class="msg-body hidden"></textarea>
                </div>
                <div class="setrow" id="guide-cover">
                    <div class="image-head-title"><h3><?= $this->lang->line('ma252'); ?></h3></div>
                    <p class="preview"></p>
                    <p><a class="btn btn-default guide-cover" href="#"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <?= $this->lang->line('ma58'); ?></a></p>
                    <div class="error-upload"></div>
                    <hr>
                </div>
                <div class="col-lg-12 clean buttons">
                    <input type="hidden" class="guide" />
                    <button type="button" class="btn btn-danger display-none delete-guide pull-left" data-id=""><?= $this->lang->line('ma12'); ?></button>
                    <button type="submit" class="btn btn-edit send-msg pull-right"><?= $this->lang->line('ma33'); ?></button>
                    <img src="<?= base_url() . 'assets/img/load-prev.gif'; ?>" vspace="15" hspace="10" class="display-none pull-right" />
                </div>
                <div class="col-lg-12 clean alert-msg display-none"></div>
                <?= form_close() ?> 
                <!--upload media form !-->
                <div class="hidden">
                    <?php
                    $attributes = array('class' => 'upmedia', 'method' => 'post');
                    echo form_open_multipart('admin/settings', $attributes);
                    ?>
                    <input type="file" name="file" id="file">
                    <input type="text" name="media-name" id="media-name">
                    <?php
                    echo form_close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
