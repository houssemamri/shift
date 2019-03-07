<section>
    <div class="container-fluid tools">
        <div class="row">
            <div class="col-lg-12">    
                <div class="col-lg-12">
                    <div class="row">
                        <div class="panel-heading">
                            <h2><i class="fa fa-cogs"></i> <?= $this->lang->line('ma4'); ?></h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="widget-box">
                                <div class="widget-header">
                                    <div class="widget-toolbar">
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
                                                        if($tools) {
                                                            foreach($tools as $tool) {
                                                                ?>
                                                                <li>
                                                                    <?php
                                                                    if(property_exists($tool,'logo')) {
                                                                        ?>
                                                                        <?= $tool->logo; ?> 
                                                                        <?php
                                                                    }
                                                                    if(property_exists($tool,'name')) {
                                                                        ?>
                                                                        <span class="netaccount"><?= $tool->name; ?></span>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <div class="enablus pull-right">
                                                                        <input id="tool_<?= $tool->slug ?>" class="setopt" <?php if (isset($options['tool_'.$tool->slug])) echo 'checked="checked"'; ?> name="tool_<?= $tool->slug ?>" type="checkbox">
                                                                        <label for="tool_<?= $tool->slug ?>"></label>
                                                                    </div>
                                                                </li>
                                                                <?php
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
                                                            <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma89'); ?></div>
                                                            <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                                <div class="enablus pull-right">
                                                                    <input id="enable_tools_page" class="setopt" <?php if (isset($options['enable_tools_page'])) echo 'checked="checked"'; ?> name="enable_tools_page" type="checkbox">
                                                                    <label for="enable_tools_page"></label>
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
