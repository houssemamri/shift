<section>
    <div class="container-fluid settings">
        <div class="row">
            <div class="col-lg-12"> 
                <div class="col-lg-12">
                    <div class="row">
                        <div class="panel-heading">
                            <h2><i class="fa fa-cog"></i> <?= $this->lang->line('ma7'); ?></h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="widget-box">
                                <div class="widget-header">
                                    <div class="widget-toolbar">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a data-toggle="tab" href="#general" aria-expanded="true"><?= $this->lang->line('ma34'); ?></a></li>
                                            <li><a data-toggle="tab" href="#advanced" aria-expanded="false"><?= $this->lang->line('ma35'); ?></a></li>
                                            <li><a data-toggle="tab" href="#users" aria-expanded="false"><?= $this->lang->line('ma36'); ?></a></li>
                                            <li><a data-toggle="tab" href="#appearance" aria-expanded="false"><?= $this->lang->line('ma215'); ?></a></li>
                                            <li><a data-toggle="tab" href="#payments" aria-expanded="false"><?= $this->lang->line('ma38'); ?></a></li>
                                            <li><a data-toggle="tab" href="#smtp" aria-expanded="false"><?= $this->lang->line('ma39'); ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="tab-content">
                                            <div id="general" class="tab-pane active">
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9">Hide Plan Usage for User</div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="hide_plan_usage" name="hide_plan_usage" class="setopt" <?php if (isset($options['hide_plan_usage'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="hide_plan_usage"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9">Hide Invoices for User</div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="hide_invoices" name="hide_invoices" class="setopt" <?php if (isset($options['hide_invoices'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="hide_invoices"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma136'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="email_marketing" name="email_marketing" class="setopt" <?php if (isset($options['email_marketing'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="email_marketing"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma151'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="disable-tickets" name="disable-tickets" class="setopt" <?php if (isset($options['disable-tickets'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="disable-tickets"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('enable_multilanguage'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="enable_multilanguage" name="enable_multilanguage" class="setopt" <?php if (isset($options['enable_multilanguage'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="enable_multilanguage"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma40'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="enable-scheduled-notifications" class="setopt" <?php if (isset($options['enable-scheduled-notifications'])) echo 'checked="checked"'; ?> name="enable-scheduled-notifications" type="checkbox">
                                                            <label for="enable-scheduled-notifications"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma44'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="enable-notifications-email" name="enable-notifications-email" class="setopt" <?php if (isset($options['enable-notifications-email'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="enable-notifications-email"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma45'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="report-bug" class="setopt" <?php if (isset($options['report-bug'])) echo 'checked="checked"'; ?> name="report-bug" type="checkbox">
                                                            <label for="report-bug"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->config->item('site_name') ?> <?= $this->lang->line('ma47'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="shortener" name="shortener" class="setopt" <?php if (isset($options['shortener'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="shortener"></label>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>
                                            <div id="advanced" class="tab-pane">
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma48'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="input-group spinner pull-right">
                                                            <input type="text" class="form-control optionvalue" id="upload_limit" value="<?php
                                                            if (isset($options['upload_limit'])): echo $options['upload_limit'];
                                                            else: echo 6;
                                                            endif;
                                                            ?>">
                                                            <div class="input-group-btn-vertical">
                                                                <button class="btn btn-default" data-id="upload_limit" type="button"><i class="fa fa-caret-up"></i></button>
                                                                <button class="btn btn-default" data-id="upload_limit" type="button"><i class="fa fa-caret-down"></i></button>
                                                            </div>
                                                        </div>
                                                        <span class="pull-right">MB</span>
                                                    </div>
                                                </div>
                                                <?php if (isset($options['tool_monitoris'])): ?>
                                                    <div class="setrow">
                                                        <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma49'); ?> </div>
                                                        <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                            <div class="input-group spinner pull-right">
                                                                <input type="text" class="form-control optionvalue" id="monitoris_limit" value="<?php
                                                                if (isset($options['monitoris_limit'])): echo $options['monitoris_limit'];
                                                                else: echo 1;
                                                                endif;
                                                                ?>">
                                                                <div class="input-group-btn-vertical">
                                                                    <button class="btn btn-default" data-id="monitoris_limit" type="button"><i class="fa fa-caret-up"></i></button>
                                                                    <button class="btn btn-default" data-id="monitoris_limit" type="button"><i class="fa fa-caret-down"></i></button>
                                                                </div>
                                                            </div>
                                                            <span class="pull-right"><?= $this->lang->line('ma50'); ?></span>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (isset($options['tool_posts-planner'])): ?>
                                                    <div class="setrow">
                                                        <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma143'); ?> </div>
                                                        <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                            <div class="input-group spinner pull-right">
                                                                <input type="text" class="form-control optionvalue" id="posts_planner_limit" value="<?php
                                                                if (isset($options['posts_planner_limit'])): echo $options['posts_planner_limit'];
                                                                else: echo 1;
                                                                endif;
                                                                ?>">
                                                                <div class="input-group-btn-vertical">
                                                                    <button class="btn btn-default" data-id="posts_planner_limit" type="button"><i class="fa fa-caret-up"></i></button>
                                                                    <button class="btn btn-default" data-id="posts_planner_limit" type="button"><i class="fa fa-caret-down"></i></button>
                                                                </div>
                                                            </div>
                                                            <span class="pull-right"><?= $this->lang->line('ma144'); ?></span>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma150'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="input-group spinner pull-right">
                                                            <input type="text" class="form-control optionvalue" id="tickets_limit" value="<?php
                                                            if (isset($options['tickets_limit'])): echo $options['tickets_limit'];
                                                            else: echo 24;
                                                            endif;
                                                            ?>">
                                                            <div class="input-group-btn-vertical">
                                                                <button class="btn btn-default" data-id="tickets_limit" type="button"><i class="fa fa-caret-up"></i></button>
                                                                <button class="btn btn-default" data-id="tickets_limit" type="button"><i class="fa fa-caret-down"></i></button>
                                                            </div>
                                                        </div>
                                                        <span class="pull-right"><?= $this->lang->line('mm107'); ?></span>
                                                    </div>
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma183'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="input-group spinner pull-right">
                                                            <input type="text" class="form-control optionvalue" id="rss_process_limit" value="<?php
                                                            if (isset($options['rss_process_limit'])): echo $options['rss_process_limit'];
                                                            else: echo 1;
                                                            endif;
                                                            ?>">
                                                            <div class="input-group-btn-vertical">
                                                                <button class="btn btn-default" data-id="rss_process_limit" type="button"><i class="fa fa-caret-up"></i></button>
                                                                <button class="btn btn-default" data-id="rss_process_limit" type="button"><i class="fa fa-caret-down"></i></button>
                                                            </div>
                                                        </div>
                                                        <span class="pull-right"><?= $this->lang->line('ma46'); ?></span>
                                                    </div>
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma285'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="input-group spinner pull-right">
                                                            <input type="text" class="form-control optionvalue" id="schedule_interval_limit" value="<?php
                                                            if (isset($options['schedule_interval_limit'])):
                                                                echo $options['schedule_interval_limit'];
                                                            else:
                                                                echo 5;
                                                            endif;
                                                            ?>">
                                                            <div class="input-group-btn-vertical">
                                                                <button class="btn btn-default" data-id="schedule_interval_limit" type="button"><i class="fa fa-caret-up"></i></button>
                                                                <button class="btn btn-default" data-id="schedule_interval_limit" type="button"><i class="fa fa-caret-down"></i></button>
                                                            </div>
                                                        </div>
                                                        <span class="pull-right"><?= $this->lang->line('ma286'); ?></span>
                                                    </div>
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma152'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="user_smtp" name="user_smtp" class="setopt" <?php if (isset($options['user_smtp'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="user_smtp"></label>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma166'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="enable-old-scheduling" name="enable-old-scheduling" class="setopt" <?php if (isset($options['enable-old-scheduling'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="enable-old-scheduling"></label>
                                                        </div>
                                                    </div>
                                                </div>  
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma284'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="disabled-frontend" name="disabled-frontend" class="setopt" <?php if (isset($options['disabled-frontend'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="disabled-frontend"></label>
                                                        </div>
                                                    </div>
                                                </div>  
                                            </div>                                     
                                            <div id="users" class="tab-pane">
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma51'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="enable-registration" name="enable-registration" class="setopt" <?php if (isset($options['enable-registration'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="enable-registration"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma52'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="social-signup" name="social-signup" class="setopt" <?php if (isset($options['social-signup'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="social-signup"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma53'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="enable-new-user-notification" name="enable-new-user-notification" class="setopt" <?php if (isset($options['enable-new-user-notification'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="enable-new-user-notification"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma54'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="signup_confirm" name="signup_confirm" class="setopt" <?php if (isset($options['signup_confirm'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="signup_confirm"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma55'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="signup_limit" name="signup_limit" class="setopt" <?php if (isset($options['signup_limit'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="signup_limit"></label>
                                                        </div>
                                                    </div>
                                                </div>                                     
                                            </div>                  
                                            <div id="appearance" class="tab-pane networks">
                                                <ul>
                                                    <li>
                                                        <div class="col-md-10 col-sm-8 col-xs-6 clean">
                                                            <h3><?= $this->lang->line('ma37'); ?></h3>
                                                            <span style="background-color: #a1a3a8;"><?= $this->lang->line('ma221') ?></span>
                                                        </div>
                                                        <div class="col-md-2 col-sm-4 col-xs-6 clean text-right">
                                                            <a href="<?= base_url() . 'admin/appearance'; ?>" class="btn btn-default"><i class="fa fa-cogs" aria-hidden="true"></i> <?= $this->lang->line('ma216') ?></a>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="col-md-10 col-sm-8 col-xs-6 clean">
                                                            <h3><?= $this->lang->line('ma222') ?></h3>
                                                            <span style="background-color: #a1a3a8;">frontend</span>
                                                        </div>
                                                        <div class="col-md-2 col-sm-4 col-xs-6 clean text-right">
                                                            <a href="<?= base_url() . 'admin/contents'; ?>" class="btn btn-default"><i class="fa fa-cogs" aria-hidden="true"></i> <?= $this->lang->line('ma216') ?></a>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="col-md-10 col-sm-8 col-xs-6 clean">
                                                            <h3><?= $this->lang->line('ma243') ?></h3>
                                                            <span style="background-color: #a1a3a8;">privacy</span>
                                                        </div>
                                                        <div class="col-md-2 col-sm-4 col-xs-6 clean text-right">
                                                            <a href="<?= base_url() . 'admin/terms-and-policies'; ?>" class="btn btn-default"><i class="fa fa-cogs" aria-hidden="true"></i> <?= $this->lang->line('ma216') ?></a>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="col-md-10 col-sm-8 col-xs-6 clean">
                                                            <h3><?= $this->lang->line('ma248') ?></h3>
                                                            <span style="background-color: #a1a3a8;">frontend guides</span>
                                                        </div>
                                                        <div class="col-md-2 col-sm-4 col-xs-6 clean text-right">
                                                            <a href="<?= base_url() . 'admin/guides'; ?>" class="btn btn-default"><i class="fa fa-cogs" aria-hidden="true"></i> <?= $this->lang->line('ma216') ?></a>
                                                        </div>
                                                    </li>
                                                </ul> 
                                            </div>
                                            <div id="payments" class="tab-pane networks">
                                                <ul>
                                                    <?php 
                                                    // Verify if payment gateway exists
                                                    if ( $payments ) {
                                                        
                                                        foreach ( $payments as $payment ) {
                                                            
                                                            echo '<li>
                                                                    <div class="col-md-10 col-sm-8 col-xs-6 clean">
                                                                        <h3>' . $payment['name'] . '</h3>
                                                                        <span style="background-color: ' . $payment['color'] . '">enabled</span>
                                                                    </div>
                                                                    <div class="col-md-2 col-sm-4 col-xs-6 clean text-right">
                                                                        <a href="' . base_url() . 'admin/payment/' . $payment['slug'] . '" class="btn btn-default"><i class="fa fa-cogs" aria-hidden="true"></i> ' . $this->lang->line('ma216') . '</a>
                                                                    </div>
                                                                </li>';
                                                            
                                                        }
                                                        
                                                    } else {
                                                        
                                                        echo '<li><div class="setrow">' . $this->lang->line('ma220') . '</div></li>';
                                                        
                                                    }
                                                    ?>
                                                </ul>                                    
                                            </div>
                                            <div id="smtp" class="tab-pane">
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><?= $this->lang->line('ma77'); ?></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="smtp-enable" name="smtp-enable" class="setopt" <?php if (isset($options['smtp-enable'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="smtp-enable"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div class="image-head-title"><?= $this->lang->line('ma167'); ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input type="text" class="optionvalue" id="smtp-protocol" value="<?= @$options['smtp-protocol']; ?>" placeholder="<?= $this->lang->line('ma168'); ?>" />
                                                        </div>
                                                    </div>                                        
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div class="image-head-title"><?= $this->lang->line('ma78'); ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input type="text" class="optionvalue" id="smtp-host" value="<?= @$options['smtp-host']; ?>" placeholder="<?= $this->lang->line('ma79'); ?>" />
                                                        </div>
                                                    </div>                                        
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div class="image-head-title"><?= $this->lang->line('ma80'); ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input type="text" class="optionvalue" id="smtp-port" value="<?= @$options['smtp-port']; ?>" placeholder="<?= $this->lang->line('ma81'); ?>" />
                                                        </div>
                                                    </div>                                        
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div class="image-head-title"><?= $this->lang->line('ma82'); ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input type="text" class="optionvalue" id="smtp-username" value="<?= @$options['smtp-username']; ?>" placeholder="<?= $this->lang->line('ma83'); ?>" />
                                                        </div>
                                                    </div>                                        
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div class="image-head-title"><?= $this->lang->line('ma84'); ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input type="text" class="optionvalue" id="smtp-password" value="<?= @$options['smtp-password']; ?>" placeholder="<?= $this->lang->line('ma85'); ?>" />
                                                        </div>
                                                    </div>                                        
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div class="image-head-title"><?= $this->lang->line('ma86'); ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="smtp-ssl" name="smtp-ssl" class="setopt" <?php if (isset($options['smtp-ssl'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="smtp-ssl"></label>
                                                        </div>
                                                    </div>                                      
                                                </div>
                                                <div class="setrow">
                                                    <div class="col-lg-10 col-sm-9 col-xs-9"><div class="image-head-title"><?= $this->lang->line('ma87'); ?></div></div>
                                                    <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                        <div class="enablus pull-right">
                                                            <input id="smtp-tls" name="smtp-tsl" class="setopt" <?php if (isset($options['smtp-tls'])) echo 'checked="checked"'; ?> type="checkbox">
                                                            <label for="smtp-tls"></label>
                                                        </div>
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