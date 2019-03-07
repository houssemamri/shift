<section>
    <div class="container-fluid tools">
        <div class="row">
            <div class="col-lg-12">  
                <div class="col-lg-12">
                    <div class="row">
                        <div class="panel-heading">
                            <h2><i class="fas fa-thumbtack"></i> <?= $this->lang->line('ma159'); ?></h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="widget-box">
                                <div class="widget-header">
                                    <div class="widget-botbar">
                                        <ul class="nav nav-tabs">
                                            <li class="active"> <a data-toggle="tab" href="#all" aria-expanded="true"><?= $this->lang->line('ma88'); ?></a> </li>
                                            <li class=""> <a data-toggle="tab" href="#settings" aria-expanded="false"><?= $this->lang->line('ma7'); ?></a> </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="tab-content">
                                            <div id="all" class="tab-pane active">
                                                <div class="col-lg-12">
                                                    <ul>
                                                        <?php 
                                                        if($bots) {
                                                            foreach($bots as $bot) {
                                                                echo $bot;
                                                            }
                                                        }
                                                        else {
                                                            echo '<li>'.$this->lang->line('ma90').'</li>';
                                                        }
                                                        ?>                                                
                                                    </ul>          
                                                </div>
                                            </div>
                                            <div id="settings" class="tab-pane">
                                                <div class="col-lg-12">
                                                    <div id="general" class="tab-pane active">
                                                        <div class="setrow">
                                                            <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma160'); ?></div>
                                                            <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                                <div class="enablus bots-checker pull-right">
                                                                    <input id="enable_bots_page" class="setopt" <?php if (isset($options['enable_bots_page'])) echo 'checked="checked"'; ?> name="enable_bots_page" type="checkbox">
                                                                    <label for="enable_bots_page"></label>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
