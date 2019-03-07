<section>
    <div class="container-fluid settings">
        <div class="row">
            <div class="col-lg-12"> 
                <div class="col-lg-12">
                    <div class="row">
                        <div class="panel-heading">
                            <h2><i class="fa fa-database"></i> <?= $this->lang->line('ma222') ?></h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="widget-box">
                                <div class="widget-header">
                                    <div class="widget-toolbar">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a data-toggle="tab" href="#home-page" aria-expanded="true"><?= $this->lang->line('ma223') ?></a></li>
                                            <li><a data-toggle="tab" href="#plans" aria-expanded="false"><?= $this->lang->line('ma17') ?></a></li>
                                            <li><a data-toggle="tab" href="#guides" aria-expanded="false"><?= $this->lang->line('ma248') ?></a></li>
                                            <li><a data-toggle="tab" href="#about-us" aria-expanded="false"><?= $this->lang->line('ma254') ?></a></li>
                                            <li><a data-toggle="tab" href="#contact-us" aria-expanded="false"><?= $this->lang->line('ma267') ?></a></li>
                                            <li><a data-toggle="tab" href="#footer" aria-expanded="false"><?= $this->lang->line('ma241') ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="tab-content">
                                            <div id="home-page" class="tab-pane active">
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma224') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="website-title" placeholder="<?= $this->lang->line('ma225') ?>"><?= @$options['website-title']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma226') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="website-meta-description"><?= @$options['website-meta-description']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma227') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="website-meta-keywords"><?= @$options['website-meta-keywords']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma228') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="home-page-header-title"><?= @$options['home-page-header-title']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>  
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma229') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="home-page-header-description"><?= @$options['home-page-header-description']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma230') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="home-page-header-button"><?= @$options['home-page-header-button']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma231') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="home-page-header-money-back"><?= @$options['home-page-header-money-back']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>   
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma232') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="home-page-plans-title"><?= @$options['home-page-plans-title']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma233') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="home-page-plans-description"><?= @$options['home-page-plans-description']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma234') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="home-page-plans-advantages-title"><?= @$options['home-page-plans-advantages-title']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma235') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="home-page-plans-advantages" placeholder="<?= $this->lang->line('ma236') ?>"><?= @$options['home-page-plans-advantages']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma237') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="home-page-contact-us-title"><?= @$options['home-page-contact-us-title']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma238') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="home-page-contact-us-description"><?= @$options['home-page-contact-us-description']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma239') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="home-page-contact-us-button"><?= @$options['home-page-contact-us-button']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="plans" class="tab-pane">
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma224') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="plans-title" placeholder="<?= $this->lang->line('ma225') ?>"><?= @$options['plans-title']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma226') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="plans-meta-description"><?= @$options['plans-meta-description']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma227') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="plans-meta-keywords"><?= @$options['plans-meta-keywords']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>  
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma240') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="plans-header-title"><?= @$options['plans-header-title']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>
                                            <div id="guides" class="tab-pane">
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma266'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="enable-guides" name="enable-guides" class="setopt" <?php if (isset($options['enable-guides'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="enable-guides"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma224') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="guides-title" placeholder="<?= $this->lang->line('ma225') ?>"><?= @$options['guides-title']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma226') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="guides-meta-description"><?= @$options['guides-meta-description']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma227') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="guides-meta-keywords"><?= @$options['guides-meta-keywords']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>  
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma253') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="guides-header-title"><?= @$options['guides-header-title']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div> 
                                            <div id="about-us" class="tab-pane">
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma265'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="enable-about-us" name="enable-about-us" class="setopt" <?php if (isset($options['enable-about-us'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="enable-about-us"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma224') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="about-us-title" placeholder="<?= $this->lang->line('ma225') ?>"><?= @$options['about-us-title']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma226') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="about-us-meta-description"><?= @$options['about-us-meta-description']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma227') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="about-us-meta-keywords"><?= @$options['about-us-meta-keywords']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>  
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma255') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="about-us-header-title"><?= @$options['about-us-header-title']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-6 col-sm-6 col-xs-6"><div><?= $this->lang->line('ma256') ?></div></div>
                                                    <div class="col-lg-6 col-sm-6 col-xs-6 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" style="height: 400px;" id="about-us-body"><?= @$options['about-us-body']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="setrow" id="about-us-photo">
                                                    <div class="image-head-title"><h3><?= $this->lang->line('ma264'); ?></h3></div>
                                                    <p class="preview"><?php if (isset($options['about-us-photo'])) echo '<img src="' . $options['about-us-photo'] . '" class="thumbnail" />'; ?></p>
                                                    <p><a class="btn btn-default about-us-photo" href="#"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <?= $this->lang->line('ma58'); ?></a></p>
                                                    <div class="error-upload"></div>
                                                    <hr>
                                                </div>
                                            </div>
                                            <div id="contact-us" class="tab-pane">
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma268'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="enable-contact-us" name="enable-contact-us" class="setopt" <?php if (isset($options['enable-contact-us'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="enable-contact-us"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma269'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="enable-contact-form" name="enable-contact-form" class="setopt" <?php if (isset($options['enable-contact-form'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="enable-contact-form"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma270'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="enable-contact-map" name="enable-contact-map" class="setopt" <?php if (isset($options['enable-contact-map'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="enable-contact-map"></label>
                                                        </div>
                                                    </div>
                                                </div>                                               
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma224') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="contact-us-title" placeholder="<?= $this->lang->line('ma225') ?>"><?= @$options['contact-us-title']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma226') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="contact-us-meta-description"><?= @$options['contact-us-meta-description']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma227') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="contact-us-meta-keywords"><?= @$options['contact-us-meta-keywords']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>  
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma272') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="contact-us-header-title"><?= @$options['contact-us-header-title']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-6 col-sm-6 col-xs-6"><div><?= $this->lang->line('ma273') ?></div></div>
                                                    <div class="col-lg-6 col-sm-6 col-xs-6 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" style="height: 400px;" id="contact-us-body"><?= @$options['contact-us-body']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma271'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="google-maps-api-key"><?= @$options['google-maps-api-key']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma274'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="google-latitude"><?= @$options['google-latitude']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma275'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="google-longitude"><?= @$options['google-longitude']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma276'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="captcha-site-key"><?= @$options['captcha-site-key']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma283'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="captcha-secret-key"><?= @$options['captcha-secret-key']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                            <div id="footer" class="tab-pane">
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma242') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="footer-description"><?= @$options['footer-description']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div>Facebook url</div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="social-facebook-url"><?= @$options['social-facebook-url']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div>Twitter url</div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="social-twitter-url"><?= @$options['social-twitter-url']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div>Instagram url</div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="social-instagram-url"><?= @$options['social-instagram-url']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma279') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="analytics-code"><?= @$options['analytics-code']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow row row-eq-height clean">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div><?= $this->lang->line('ma282') ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <textarea class="optionvalue" id="privacy-cookie-url"><?= @$options['privacy-cookie-url']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
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