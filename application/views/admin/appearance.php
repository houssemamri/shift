<section>
    <div class="container-fluid settings">
        <div class="row">
            <div class="col-lg-12"> 
                <div class="col-lg-12">
                    <div class="row">
                        <div class="panel-heading">
                            <h2><i class="fa fa-paint-brush"></i> <?= $this->lang->line('ma37'); ?></h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="tab-content">                
                                            <div id="appearance" class="tab-pane active">
                                                <div class="setrow" id="frontend-logo">
                                                    <div class="image-head-title"><h3><?= $this->lang->line('ma262'); ?></h3></div>
                                                    <p class="preview"><?php if (isset($options['frontend-logo'])) echo '<img src="' . $options['frontend-logo'] . '" class="thumbnail" />'; ?></p>
                                                    <p><a class="btn btn-default frontend-logo" href="#"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <?= $this->lang->line('ma58'); ?></a></p>
                                                    <div class="error-upload"></div>
                                                    <hr>
                                                </div>
                                                <div class="setrow" id="home-bg">
                                                    <div class="image-head-title"><h3><?= $this->lang->line('ma60'); ?></h3></div>
                                                    <p class="preview"><?php if (isset($options['home-bg'])) echo '<img src="' . $options['home-bg'] . '" class="thumbnail" />'; ?></p>
                                                    <p><a class="btn btn-default home-bg" href="#"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <?= $this->lang->line('ma58'); ?></a></p>
                                                    <div class="error-upload"></div>
                                                    <hr>
                                                </div>  
                                                <div class="setrow" id="login-bg">
                                                    <div class="image-head-title"><h3><?= $this->lang->line('ma263'); ?></h3></div>
                                                    <p class="preview"><?php if (isset($options['login-bg'])) echo '<img src="' . $options['login-bg'] . '" class="thumbnail" />'; ?></p>
                                                    <p><a class="btn btn-default login-bg" href="#"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <?= $this->lang->line('ma58'); ?></a></p>
                                                    <div class="error-upload"></div>
                                                    <hr>
                                                </div> 
                                                <div class="setrow" id="login-logo">
                                                    <div class="image-head-title"><h3><?= $this->lang->line('ma56'); ?></h3></div>
                                                    <p class="preview"><?php if (isset($options['login-logo'])) echo '<img src="' . $options['login-logo'] . '" class="thumbnail" />'; ?></p>
                                                    <p><a class="btn btn-default login-logo" href="#"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <?= $this->lang->line('ma58'); ?></a></p>
                                                    <div class="error-upload"></div>
                                                    <hr>
                                                </div>
                                                <div class="setrow" id="main-logo">
                                                    <div class="image-head-title"><h3><?= $this->lang->line('ma57'); ?></h3></div>
                                                    <p class="preview"><?php if (isset($options['main-logo'])) echo '<img src="' . $options['main-logo'] . '" class="thumbnail" />'; ?></p>
                                                    <p><a class="btn btn-default main-logo" href="#"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <?= $this->lang->line('ma58'); ?></a></p>
                                                    <div class="error-upload"></div>
                                                    <hr>
                                                </div>
                                                <div class="setrow" id="favicon">
                                                    <div class="image-head-title"><h3><?= $this->lang->line('ma59'); ?></h3></div>
                                                    <p class="preview"><?php if (isset($options['favicon'])) echo '<img src="' . $options['favicon'] . '" class="thumbnail" />'; ?></p>
                                                    <p><a class="btn btn-default favicon" href="#"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <?= $this->lang->line('ma58'); ?></a></p>
                                                    <div class="error-upload"></div>
                                                    <hr>
                                                </div>
                                                <div class="setrow">
                                                    <div class="image-head-title"><h3><?= $this->lang->line('ma63'); ?></h3></div>      
                                                    <div class="enablus">
                                                        <input type="color" class="optionvalue" id="home-bg-color" value="<?= @$options['home-bg-color'] ? $options['home-bg-color'] : '#0D9AC0'; ?>"  />
                                                    </div>
                                                    <hr>
                                                </div>
                                                <div class="setrow">
                                                    <div class="image-head-title"><h3><?= $this->lang->line('ma64'); ?></h3></div>      
                                                    <div class="enablus">
                                                        <input type="color" class="optionvalue" id="home-header-text-color" value="<?= @$options['home-header-text-color'] ? $options['home-header-text-color'] : '#FFFFFF'; ?>"  />
                                                    </div>
                                                    <hr>
                                                </div>
                                                <div class="setrow">
                                                    <div class="image-head-title"><h3><?= $this->lang->line('ma66'); ?></h3></div>      
                                                    <div class="enablus">
                                                        <input type="color" class="optionvalue" id="main-menu-color" value="<?= @$options['main-menu-color'] ? $options['main-menu-color'] : '#000000'; ?>"  />
                                                    </div>
                                                    <hr>
                                                </div>
                                                <div class="setrow">
                                                    <div class="image-head-title"><h3><?= $this->lang->line('ma67'); ?></h3></div>      
                                                    <div class="enablus">
                                                        <input type="color" class="optionvalue" id="main-menu-text-color" value="<?= @$options['main-menu-text-color'] ? $options['main-menu-text-color'] : '#000000'; ?>"  />
                                                    </div>
                                                    <hr>
                                                </div>
                                                <div class="setrow">
                                                    <div class="image-head-title"><h3><?= $this->lang->line('ma68'); ?></h3></div>      
                                                    <div class="enablus">
                                                        <input type="color" class="optionvalue" id="panel-heading-color" value="<?= @$options['panel-heading-color'] ? $options['panel-heading-color'] : '#000000'; ?>"  />
                                                    </div>
                                                    <hr>
                                                </div>
                                                <div class="setrow">
                                                    <div class="image-head-title"><h3><?= $this->lang->line('ma69'); ?></h3></div>      
                                                    <div class="enablus">
                                                        <input type="color" class="optionvalue" id="panel-heading-text-color" value="<?= @$options['panel-heading-text-color'] ? $options['panel-heading-text-color'] : '#000000'; ?>"  />
                                                    </div>
                                                    <hr>
                                                </div>
                                                <div class="setrow">
                                                    <div class="image-head-title"><h3><?= $this->lang->line('ma280'); ?></h3></div>      
                                                    <div class="enablus">
                                                        <textarea class="optionvalue" style="height: 400px;" placeholder="<?= $this->lang->line('ma281'); ?>" id="frontend-css"><?= @$options['frontend-css']; ?></textarea>
                                                    </div>
                                                    <hr>
                                                </div>
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