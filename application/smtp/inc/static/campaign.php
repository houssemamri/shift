<?php
function show_lists(){
    $CI =& get_instance();
    $lists = $CI->ecl('Clist')->user_lists();
    $th = '';
    if($lists) {
        $th .= '<ul>';
        foreach($lists as $list) {
            $th .= '<li class="netsel" data-id="' . $list->list_id . '">
                        <div class="col-xl-12">
                            <i class="fa fa-address-book-o"></i> ' . $list->name . '
                            <div class="btn-group pull-right">
                                <button type="button" data-type="main" class="btn btn-default select-list">
                                    '.$CI->lang->line('mm123').'
                                </button>
                                <button type="button" class="btn btn-default show-advanced">
                                    <i class="fa fa-cog"></i>
                                </button>
                            </div>
                        </div>
                    </li>
                    <li class="socials" data-id="' . $list->list_id . '">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <select class="form-control first-condition">
                                    <option value="0">'.$CI->lang->line('mu172').'</option>
                                    <option value="1">'.$CI->lang->line('mu173').'</option>
                                    <option value="2">'.$CI->lang->line('mu174').'</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 non-mod-select">
                            <div class="form-group">
                                <select class="form-control second-template">
                                </select>                           
                            </div>
                        </div>
                    </li>';
        }
    } else {
        $th = '<ul style="padding: 10px;"><li class="notconnected">'.$CI->lang->line('mu287').'</li>';
    }
    return $th;
}

function show_stats($campaign_id){
    $CI =& get_instance();
    $stats = $CI->ecl('Sched')->get_stats($campaign_id);
    $sent = 0;
    $opened = 0;
    $unopened = 0;
    $unsub = 0;
    if($stats) {
        $sent = $stats[0]->sent;
        $opened = $stats[0]->readi;
        $unopened = $stats[0]->unread;
        $unsub = $stats[0]->unsub;
    }
    $th = ' <div class="col-xl-12">
              <div class="stat-list">
                <div class="stat-split">'.$sent.'</div>
                <div class="stat-text">'.$CI->lang->line('mu161').'</div>
              </div>
            </div>
            <div class="col-xl-12">
              <div class="stat-list">
                <div class="stat-split update-success">'.$opened.'</div>
                <div class="stat-text">'.$CI->lang->line('mu162').'</div>
              </div>
            </div>
            <div class="col-xl-12">
              <div class="stat-list">
                <div class="stat-split update-info">'.$unopened.'</div>
                <div class="stat-text">'.$CI->lang->line('mu163').'</div>
              </div>
            </div>
            <div class="col-xl-12">
              <div class="stat-list">
                <div class="stat-split update-danger">'.$unsub.'</div>
                <div class="stat-text">'.$CI->lang->line('mu164').'</div>
              </div>
            </div>';
    return $th;
}
function temp($val){
    $CI =& get_instance();

    if(!$CI->ecl('Campaign')->if_user_is_owner_campaign($val)) {
        return false;
    }
    
    // Get number of sent emails
    $sent_emails = $CI->scheduled->get_sents($CI->user_id, 'email');

    $smtp_options = $CI->ecl('Campaign')->get_campaign_meta($val, 'smtp_options');
    $meta_val1 = '';
    if(@$smtp_options[0]->meta_val1) {
        $meta_val1 = ' checked="checked"';
    }
    $meta_val2 = '';
    if(@$smtp_options[0]->meta_val2) {
        $meta_val2 = $smtp_options[0]->meta_val2;
    }
    $meta_val3 = '';
    if(@$smtp_options[0]->meta_val3) {
        $meta_val3 = $smtp_options[0]->meta_val3;
    }
    $meta_val4 = '';
    if(@$smtp_options[0]->meta_val4) {
        $meta_val4 = $smtp_options[0]->meta_val4;
    }
    $meta_val5 = '';
    if(@$smtp_options[0]->meta_val5) {
        $meta_val5 = $smtp_options[0]->meta_val5;
    }
    $meta_val6 = '';
    if(@$smtp_options[0]->meta_val6) {
        $meta_val6 = ' checked="checked"';
    }
    $meta_val7 = '';
    if(@$smtp_options[0]->meta_val7) {
        $meta_val7 = ' checked="checked"';
    }
    $meta_val8 = '';
    if(@$smtp_options[0]->meta_val8) {
        $meta_val8 = $smtp_options[0]->meta_val8;
    }
    $meta_val9 = '';
    if( @$smtp_options[0]->meta_val9 ) {
        $meta_val9 = $smtp_options[0]->meta_val9;
    }    
    $meta_val10 = '';
    if( @$smtp_options[0]->meta_val10 ) {
        $meta_val10 = $smtp_options[0]->meta_val10;
    }
    $meta_val11 = '';
    if( @$smtp_options[0]->meta_val11 ) {
        $meta_val11 = $smtp_options[0]->meta_val11;
    }
    
    $smtp = '';
    if(get_option('user_smtp')) {
        
        if(($meta_val1 == '') || ($meta_val2 == '') || ($meta_val3 == '') || ($meta_val4 == '') || ($meta_val5 == '')) {
            
            $smtp = '<div class="row">'
                        . '<div class="col-xl-12">'
                            . '<div class="reached-plan-limit">'
                                . '<div class="row">'
                                    . '<div class="col-xl-9">'
                                        . '<i class="icon-info"></i>'
                                            . $CI->lang->line('mu280')
                                    . '</div>'
                                    . '<div class="col-xl-3 text-right">'
                                    . '</div>'
                                . '</div>'
                            . '</div>'
                        . '</div>'
                    . '</div>';
        }
    }

    if ( $sent_emails ) {

        if ( count($sent_emails) >= plan_feature('sent_emails') ) {

            $smtp .= '<div class="row">'
                        . '<div class="col-xl-12">'
                            . '<div class="reached-plan-limit">'
                                . '<div class="row">'
                                    . '<div class="col-xl-9">'
                                        . '<i class="icon-info"></i>'
                                            . $CI->lang->line('reached_maximum_number_allowed_emails')
                                    . '</div>'
                                    . '<div class="col-xl-3 text-right">'
                                        . '<a href="' . site_url('user/plans') . '" class="btn"><i class="icon-basket"></i>' . $CI->lang->line( 'our_plans' ) . '</a>'
                                    . '</div>'
                                . '</div>'
                            . '</div>'
                        . '</div>'
                    . '</div>';        

        }
    
    }
    
    $planner = '';
    if(get_option('tool_emails-planner') && get_user_option('display_planner_form_campaign')){
        $act = (get_option('posts_planner_limit'))?get_option('posts_planner_limit'):'1';
        $planner = '<div class="col-xl-12 widget planner" data-act="' . $act . '">
            <div class="row">
                <div class="panel-heading">
                    <i class="fa fa-calendar" aria-hidden="true"></i> ' . $CI->lang->line('mu190') . '
                    <div class="btn-group pull-right"><button type="button" data-type="main" class="btn btn-default add-repeat"><i class="icon-plus"></i> ' . $CI->lang->line('mu189') . '</button></div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 post-plans">
                    <div class="list-group">
                        <p>' . $CI->lang->line('mu192') . '</p>
                    </div>
                </div>
            </div>
            <div class="row">
            </div>
        </div>';
    }

    return '<div class="row emails-composer">'
                . '<div class="col-xl-3 campaign-page" data-id="'.$val.'">
                        <div class="col-xl-12">
                            <ul class="campaign-menu">
                                <li class="active"><a href="#campaign-tab-send-mail" class="new-campaign-email"><i class="icon-note"></i> ' . $CI->lang->line('mu288') . '</a></li>
                                <li><a href="#campaign-tab-templates"><i class="icon-docs"></i> ' . $CI->lang->line('mu165') . '</a></li>
                                <li><a href="#campaign-tab-history"><i class="icon-organization"></i> ' . $CI->lang->line('mu3') . '</a></li>
                                <li><a href="#campaign-tab-statistics" class="get-campaign-statistics"><i class="icon-chart"></i> ' . $CI->lang->line('mu166') . '</a></li>
                                <li><a href="#campaign-tab-my-smtp"><i class="icon-wrench"></i> ' . $CI->lang->line('mu289') . '</a></li>
                                <li><a href="#campaign-tab-settings"><i class="icon-settings"></i> ' . $CI->lang->line('mu7') . '</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-9">
                        <div class="campaign-tabs">
                            <div id="campaign-tab-send-mail" class="active">
                                ' . $smtp . '
                                '.form_open('user/emails/campaign/'.$val, ['class' => 'schedule-campaign']).'
                                    <div class="col-xl-12 template-tools">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <ul class="nav nav-tabs">
                                                   <li class="active"><a href="#nav-general" class="new-campaign-email active" data-toggle="tab" role="tab" aria-controls="nav-general" aria-selected="true">General</a></li>
                                                   <li><a href="#advanced" data-toggle="tab">Advanced</a></li>
                                                </ul>
                                            </div>
                                            <div class="panel-body">
                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade show active" id="nav-general" role="tabpanel" aria-labelledby="nav-general">
                                                        <ul class="general-elements">
                                                            <li data-type="paragraph"><i class="fas fa-paragraph"></i> '.$CI->lang->line('mu284').'</li>
                                                            <li data-type="header"><i class="fas fa-heading"></i> '.$CI->lang->line('mu290').'</li>
                                                            <li data-type="photo"><i class="fas fa-camera"></i> '.$CI->lang->line('mu291').'</li>
                                                            <li data-type="table"><i class="fas fa-table"></i> '.$CI->lang->line('mu216').'</li>
                                                            <li data-type="list"><i class="fas fa-list-ol"></i> '.$CI->lang->line('mu217').'</li>
                                                            <li data-type="button"><i class="fas fa-hockey-puck"></i> '.$CI->lang->line('mu218').'</li>
                                                            <li data-type="space"><i class="fas fa-expand-arrows-alt"></i> '.$CI->lang->line('mu219').'</li>
                                                            <li data-type="line"><i class="fas fa-window-minimize"></i> '.$CI->lang->line('mu220').'</li>
                                                            <li data-type="html"><i class="fas fa-code"></i> '.$CI->lang->line('mu221').'</li>
                                                        </ul>
                                                    </div>
                                                    <div class="tab-pane fade" id="advanced">
                                                        <div class="row">
                                                            <ul class="advanced-elements nav nav-pills nav-stacked col-xl-2 col-md-3">
                                                              <li class="active"><a href="#temp_bac" data-toggle="pill" class="active show">'.$CI->lang->line('mu222').'</a></li>
                                                              <li><a href="#temp_header" data-toggle="pill">'.$CI->lang->line('mu290').'</a></li>
                                                              <li><a href="#temp_body" data-toggle="pill">'.$CI->lang->line('mu223').'</a></li>
                                                              <li><a href="#temp_footer" data-toggle="pill">'.$CI->lang->line('mu224').'</a></li>
                                                            </ul>
                                                            <div class="tab-content col-xl-10 col-md-9">
                                                                <div class="tab-pane active" id="temp_bac">
                                                                    <ul>
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-sm-8">
                                                                                    <h4>'
                                                                                        . $CI->lang->line('mu225')
                                                                                    . '</h4>
                                                                                </div>
                                                                                <div class="col-xl-4 col-sm-4">
                                                                                    <input type="color" class="pull-right type-color temp-bg-color" value="#FFFFFF">
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-sm-8">                                                                        
                                                                                    <h4>'
                                                                                        . $CI->lang->line('mu226')
                                                                                    . '</h4>
                                                                                </div>
                                                                                <div class="col-xl-4 col-sm-4"> 
                                                                                    <button type="button" class="pull-right" data-toggle="modal" data-target="#image_upload">
                                                                                        <i class="icon-picture"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-sm-8">                                                                              
                                                                                    <h4>'
                                                                                        . $CI->lang->line('mu227')
                                                                                    . '</h4>
                                                                                </div>
                                                                                <div class="col-xl-4 col-sm-4">
                                                                                    <div class="checkbox-option pull-right">
                                                                                        <input id="show-image-for-content-template" name="show-image-for-content-template" class="setopt" type="checkbox">
                                                                                        <label for="show-image-for-content-template"></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-sm-8">                                                                            
                                                                                    <h4>'
                                                                                        . $CI->lang->line('mu228').'(px)
                                                                                    </h4>
                                                                                </div>
                                                                                <div class="col-xl-4 col-sm-4">   
                                                                                    <input type="number" class="tab-columns pull-right fix-template-width" min="1" max="1500">
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="for-css-template">
                                                                            <div class="row">
                                                                                <div class="col-xl-12">                                                                           
                                                                                    <textarea rows="7" placeholder="'.$CI->lang->line('mu232').'"></textarea>
                                                                                </div>
                                                                            </div>                                                                                
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="tab-pane" id="temp_header">
                                                                    <ul>
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-sm-8">  
                                                                                    <h4>'
                                                                                        . $CI->lang->line('mu225')
                                                                                    . '</h4>
                                                                                </div>
                                                                                <div class="col-xl-4 col-sm-4">   
                                                                                    <input type="color" class="optionvalue pull-right type-color temp-header-bg-color" value="#FFFFFF">
                                                                                </div>
                                                                            </div>                                                                                     
                                                                        </li>
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-sm-8">  
                                                                                    <h4>'
                                                                                        . $CI->lang->line('mu226')
                                                                                    . '</h4>
                                                                                </div>
                                                                                <div class="col-xl-4 col-sm-4">   
                                                                                    <button type="button" class="pull-right" data-toggle="modal" data-target="#image_upload">
                                                                                        <i class="icon-picture"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>                                                                                         
                                                                        </li>
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-sm-8">                                                                          
                                                                                    <h4>'
                                                                                        . $CI->lang->line('mu227')
                                                                                    . ' </h4>
                                                                                </div>
                                                                                <div class="col-xl-4 col-sm-4">   
                                                                                    <div class="checkbox-option pull-right">
                                                                                        <input id="show-image-for-header-template" name="show-image-for-header-template" class="setopt" type="checkbox">
                                                                                        <label for="show-image-for-header-template"></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>                                                                                         
                                                                        </li>
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-sm-8">                                                                         
                                                                                    <h4>'
                                                                                        . $CI->lang->line('mu229')
                                                                                    . '</h4>
                                                                                </div>
                                                                                <div class="col-xl-4 col-sm-4">   
                                                                                    <div class="checkbox-option pull-right">
                                                                                        <input id="temp_disable_header" name="temp_disable_header" class="setopt" type="checkbox">
                                                                                        <label for="temp_disable_header"></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>                                                                                         
                                                                        </li>
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-sm-8">  
                                                                                    <h4>'
                                                                                        . $CI->lang->line('mu230')
                                                                                        . '(px)
                                                                                    </h4>
                                                                                </div>
                                                                                <div class="col-xl-4 col-sm-4">   
                                                                                    <input type="number" class="tab-columns header-height pull-right" min="1" max="1500">
                                                                                </div>
                                                                            </div>                                                                                    
                                                                        </li>
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-sm-8">                                                                          
                                                                                    <h4>'
                                                                                        . $CI->lang->line('mu281')
                                                                                        .'(px)
                                                                                    </h4>
                                                                                </div>
                                                                                <div class="col-xl-4 col-sm-4">   
                                                                                    <input type="number" class="tab-columns header-padding pull-right" value="15" min="1" max="1500">
                                                                                </div>
                                                                            </div>                                                                                      
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="tab-pane" id="temp_body">
                                                                    <ul>
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-sm-8">                                                                           
                                                                                    <h4>'
                                                                                        .$CI->lang->line('mu225')
                                                                                    . '</h4>
                                                                                </div>
                                                                                <div class="col-xl-4 col-sm-4">   
                                                                                    <input type="color" class="optionvalue pull-right type-color temp-body-bg-color" value="#FFFFFF">
                                                                                </div>
                                                                            </div>                                                                                          
                                                                        </li>
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-sm-8">                                                                          
                                                                                    <h4>'
                                                                                        . $CI->lang->line('mu226')
                                                                                    . '</h4>
                                                                                </div>
                                                                                <div class="col-xl-4 col-sm-4">   
                                                                                    <button type="button" class="pull-right" data-toggle="modal" data-target="#image_upload"><i class="icon-picture"></i></button>
                                                                                </div>
                                                                            </div>                                                                                         
                                                                        </li>
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-sm-8">                                                                           
                                                                                    <h4>'
                                                                                        . $CI->lang->line('mu227')
                                                                                    . '</h4>
                                                                                </div>
                                                                                <div class="col-xl-4 col-sm-4">   
                                                                                    <div class="checkbox-option pull-right">
                                                                                        <input id="show-image-for-body-template" name="show-image-for-body-template" class="setopt" type="checkbox">
                                                                                        <label for="show-image-for-body-template"></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>                                                                                         
                                                                        </li>
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-sm-8">                                                                        
                                                                                    <h4>'
                                                                                        . $CI->lang->line('mu230')
                                                                                        . '(px)
                                                                                    </h4>
                                                                                </div>
                                                                                <div class="col-xl-4 col-sm-4">   
                                                                                    <input type="number" class="tab-columns pull-right body-height" min="1" max="1500">
                                                                                </div>
                                                                            </div>                                                                                     
                                                                        </li>
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-sm-8"> 
                                                                                    <h4>'
                                                                                        . $CI->lang->line('mu281')
                                                                                        . '(px)
                                                                                    </h4>
                                                                                </div>
                                                                                <div class="col-xl-4 col-sm-4">   
                                                                                    <input type="number" class="tab-columns body-padding pull-right" value="15" min="1" max="1500">
                                                                                </div>
                                                                            </div>                                                                                     
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="tab-pane" id="temp_footer">
                                                                    <ul>
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-sm-8">                                                                         
                                                                                    <h4>'
                                                                                        . $CI->lang->line('mu225')
                                                                                    . '</h4>
                                                                                </div>
                                                                                <div class="col-xl-4 col-sm-4">   
                                                                                    <input type="color" class="optionvalue pull-right type-color temp-footer-bg-color" value="#FFFFFF">
                                                                                </div>
                                                                            </div>                                                                                        
                                                                        </li>
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-sm-8">                                                                         
                                                                                    <h4>'
                                                                                        . $CI->lang->line('mu226')
                                                                                    . '</h4>
                                                                                </div>
                                                                                <div class="col-xl-4 col-sm-4">   
                                                                                    <button type="button" class="pull-right" data-toggle="modal" data-target="#image_upload">
                                                                                        <i class="icon-picture"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>                                                                                         
                                                                        </li>
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-sm-8">                                                                          
                                                                                    <h4>'
                                                                                        . $CI->lang->line('mu227')
                                                                                    . '</h4>
                                                                                </div>
                                                                                <div class="col-xl-4 col-sm-4">   
                                                                                    <div class="checkbox-option pull-right">
                                                                                        <input id="show-image-for-footer-template" name="show-image-for-footer-template" class="setopt" type="checkbox">
                                                                                        <label for="show-image-for-footer-template"></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>                                                                                        
                                                                        </li>
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-sm-8">                                                                         
                                                                                    <h4>'
                                                                                        . $CI->lang->line('mu231')
                                                                                    . '</h4>
                                                                                </div>
                                                                                <div class="col-xl-4 col-sm-4">   
                                                                                    <div class="checkbox-option pull-right">
                                                                                        <input id="temp_disable_footer" name="temp_disable_footer" class="setopt" type="checkbox">
                                                                                        <label for="temp_disable_footer"></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>                                                                                           
                                                                        </li>
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-sm-8">                                                                          
                                                                                    <h4>'
                                                                                        . $CI->lang->line('mu230')
                                                                                        . '(px)
                                                                                    </h4>
                                                                                </div>
                                                                                <div class="col-xl-4 col-sm-4">   
                                                                                    <input type="number" class="tab-columns pull-right footer-height" min="1" max="1500">
                                                                                </div>
                                                                            </div>                                                                                    
                                                                        </li>
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-sm-8">                                                                          
                                                                                    <h4>'
                                                                                        . $CI->lang->line('mu281')
                                                                                        .'(px)
                                                                                    </h4>
                                                                                </div>
                                                                                <div class="col-xl-4 col-sm-4">   
                                                                                    <input type="number" class="tab-columns footer-padding pull-right" value="15" min="1" max="1500">
                                                                                </div>
                                                                            </div>                                                                                     
                                                                        </li>    
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 template-editor">
                                        <div class="template-builder" style="background-color: #f6f9fc;padding: 15px;">
                                            <div style="width:80%;min-height:auto;margin:30px auto 70px;">
                                                <div class="email-template-header" style="width:100%;min-height:70px;background-color:#ffffff;padding:15px;"></div>
                                                <div class="email-template-body" style="width:100%;margin:20px 0;height:350px;background-color:#ffffff;padding:15px;"></div>
                                                <div class="email-template-footer" style="width:100%;min-height:70px;background-color:#ffffff;padding:15px;"></div>
                                                <div class="only-css-here"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 emails-buttons-action">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="stat-list">
                                                    <div class="stat-split update-success">' . $CI->lang->line('mu182') . '</div>
                                                    <div class="stat-text">' . site_url('unsubscribe/' . $val . '/email-id/scheduled-id') . '</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 emails-buttons-action">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <input type="text" class="form-control post-title" placeholder="'.$CI->lang->line('mu233').'" required="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 elists">
                                            ' . show_lists() . '
                                        </ul>              
                                    </div>
                                    ' . $planner . '
                                    <div class="col-xl-12 emails-buttons-action">
                                        <div class="row">
                                            <div class="col-xl-12 text-right buttons">
                                                <input type="hidden" class="datetime">
                                                <button type="submit" class="btn btn-default draft-save"><i class="icon-support"></i> ' . $CI->lang->line('mu44') . '</button>
                                                <button type="button" class="btn btn-success open-midrub-planner"><i class="icon-paper-plane"></i> ' . $CI->lang->line('mu234') . '</button>
                                            </div>
                                        </div>
                                    </div>
                                ' . form_close() . '
                            </div>
                            <div id="campaign-tab-templates">
                                <div class="col-xl-12 template-tools">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <ul class="nav nav-tabs">
                                               <li class="active"><a href="#nav-templates" class="new-campaign-email active" data-toggle="tab" role="tab" aria-controls="nav-templates" aria-selected="true">' . $CI->lang->line('mu165') . '</a></li>
                                            </ul>
                                        </div>
                                        <div class="panel-body">
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active" id="nav-templates" role="tabpanel" aria-labelledby="nav-templates">
                                                    <div class="tab-pane show-templates-lists-here active" id="temp_bac">
                                                        <ul class="histories">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="campaign-tab-history">
                                <div class="col-xl-12 template-tools">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <ul class="nav nav-tabs">
                                               <li class="active"><a href="#nav-history" class="new-campaign-email active" data-toggle="tab" role="tab" aria-controls="nav-history" aria-selected="true">' . $CI->lang->line('mu3') . '</a></li>
                                            </ul>
                                        </div>
                                        <div class="panel-body">
                                            <div class="tab-content">
                                                <div class="tab-pane fade in active show" id="nav-history">
                                                    <div class="tab-pane active" id="temp_bac">
                                                        <ul class="histories">
                                                        </ul>
                                                        <div class="row">
                                                            <div class="col col-xl-12">
                                                                <ul class="pagination"></ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="campaign-tab-statistics">
                                <div class="col-xl-12 template-tools">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <ul class="nav nav-tabs">
                                               <li class="active"><a href="#nav-statistics" class="new-campaign-email active" data-toggle="tab" role="tab" aria-controls="nav-statistics" aria-selected="true">' . $CI->lang->line('mu166') . '</a></li>
                                            </ul>
                                        </div>
                                        <div class="panel-body">
                                            <div class="tab-content">
                                                <div class="tab-pane fade in active show" id="nav-statistics">
                                                    <div class="row">
                                                        <div class="col-xl-12 stat-head">
                                                            <div class="dropdown pull-left">
                                                                <button type="button" class="btn btn-success dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown">' . $CI->lang->line('mu236') . ' <span class="caret"></span></button>
                                                                <div class="dropdown-menu dropdown-menu-action sort-stats-by-template" aria-labelledby="dropdownMenuLink">
                                                                </div>
                                                            </div>
                                                            <div class="btn-group pull-right">
                                                                <button type="button" class="btn btn-default active select-range" data-value="30">' . $CI->lang->line('mu237') . '</button>
                                                                <button type="button" class="btn btn-default select-range" data-value="all">' . $CI->lang->line('mu238') . '</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div id="rations" class="graph"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="campaign-tab-my-smtp">
                                <div class="col-xl-12 template-tools">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <ul class="nav nav-tabs">
                                               <li class="active"><a href="#nav-smtp" class="new-campaign-email active" data-toggle="tab" role="tab" aria-controls="nav-smtp" aria-selected="true">' . $CI->lang->line('mu289') . '</a></li>
                                            </ul>
                                        </div>
                                        <div class="panel-body">
                                            <div class="tab-content">
                                                <div class="tab-pane fade in active show" id="nav-smtp">
                                                    <div class="setrow row">
                                                        <div class="col-xl-10 col-sm-9 col-xs-9">' . $CI->lang->line('mu239') . '</div>
                                                        <div class="col-xl-2 col-sm-3 col-xs-3 text-right">
                                                            <div class="checkbox-option pull-right">
                                                                <input id="smtp-enable" name="smtp-enable" class="besan" type="checkbox"' . $meta_val1 . '>
                                                                <label for="smtp-enable"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="setrow row">
                                                        <div class="col-xl-10 col-sm-9 col-xs-9"><div class="image-head-title">' . $CI->lang->line('mu300') . '</div></div>
                                                        <div class="col-xl-2 col-sm-3 col-xs-3 text-right">
                                                            <div class="checkbox-option pull-right">
                                                                <input type="text" class="pappio" id="smtp-protocol" value="' . $meta_val8 . '" placeholder="' . $CI->lang->line('mu301') . '">
                                                            </div>
                                                        </div>                                        
                                                    </div>                                     
                                                    <div class="setrow row">
                                                        <div class="col-xl-10 col-sm-9 col-xs-9"><div class="image-head-title">' . $CI->lang->line('mu240') . '</div></div>
                                                        <div class="col-xl-2 col-sm-3 col-xs-3 text-right">
                                                            <div class="checkbox-option pull-right">
                                                                <input type="text" class="pappio" id="smtp-host" value="' . $meta_val2 . '" placeholder="' . $CI->lang->line('mu241') . '">
                                                            </div>
                                                        </div>                                        
                                                    </div>
                                                    <div class="setrow row">
                                                        <div class="col-xl-10 col-sm-9 col-xs-9"><div class="image-head-title">' . $CI->lang->line('mu242') . '</div></div>
                                                        <div class="col-xl-2 col-sm-3 col-xs-3 text-right">
                                                            <div class="checkbox-option pull-right">
                                                                <input type="text" class="pappio" id="smtp-port" value="' . $meta_val3 . '" placeholder="' . $CI->lang->line('mu243') . '">
                                                            </div>
                                                        </div>                                        
                                                    </div>
                                                    <div class="setrow row">
                                                        <div class="col-xl-10 col-sm-9 col-xs-9"><div class="image-head-title">' . $CI->lang->line('mu244') . '</div></div>
                                                        <div class="col-xl-2 col-sm-3 col-xs-3 text-right">
                                                            <div class="checkbox-option pull-right">
                                                                <input type="text" class="pappio" id="smtp-username" value="' . $meta_val4 . '" placeholder="' . $CI->lang->line('mu245') . '">
                                                            </div>
                                                        </div>                                        
                                                    </div>
                                                    <div class="setrow row">
                                                        <div class="col-xl-10 col-sm-9 col-xs-9"><div class="image-head-title">' . $CI->lang->line('mu246') . '</div></div>
                                                        <div class="col-xl-2 col-sm-3 col-xs-3 text-right">
                                                            <div class="checkbox-option pull-right">
                                                                <input type="text" class="pappio" id="smtp-password" value="' . $meta_val5 . '" placeholder="' . $CI->lang->line('mu247') . '">
                                                            </div>
                                                        </div>                                        
                                                    </div>
                                                    <div class="setrow row">
                                                        <div class="col-xl-10 col-sm-9 col-xs-9"><div class="image-head-title">' . $CI->lang->line('mu248') . '</div></div>
                                                        <div class="col-xl-2 col-sm-3 col-xs-3 text-right">
                                                            <div class="checkbox-option pull-right">
                                                                <input id="smtp-ssl" name="smtp-ssl" class="besan" type="checkbox"' . $meta_val6 . '>
                                                                <label for="smtp-ssl"></label>
                                                            </div>
                                                        </div>                                      
                                                    </div>
                                                    <div class="setrow row">
                                                        <div class="col-xl-10 col-sm-9 col-xs-9"><div class="image-head-title">' . $CI->lang->line('mu249') . '</div></div>
                                                        <div class="col-xl-2 col-sm-3 col-xs-3 text-right">
                                                            <div class="checkbox-option pull-right">
                                                                <input id="smtp-tls" name="smtp-tsl" class="besan" type="checkbox"' . $meta_val7 . '>
                                                                <label for="smtp-tls"></label>
                                                            </div>
                                                        </div>                                      
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="campaign-tab-settings">
                                <div class="col-xl-12 template-tools">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <ul class="nav nav-tabs">
                                               <li class="active"><a href="#nav-settings" class="new-campaign-email active" data-toggle="tab" role="tab" aria-controls="nav-settings" aria-selected="true">' . $CI->lang->line('mu7') . '</a></li>
                                            </ul>
                                        </div>
                                        <div class="panel-body">
                                            <div class="tab-content">
                                                <div class="tab-pane fade in active show" id="nav-settings">
                                                    <div class="setrow row">
                                                        <div class="col-xl-10 col-sm-9 col-xs-9"><div class="image-head-title">' . $CI->lang->line('mu309') . '</div></div>
                                                        <div class="col-xl-2 col-sm-3 col-xs-3 text-right">
                                                            <div class="checkbox-option pull-right">
                                                                <input type="text" class="pappio" id="smtp-priority" value="' . $meta_val11 . '" placeholder="' . $CI->lang->line('mu310') . '">
                                                            </div>
                                                        </div>                                        
                                                    </div>   
                                                    <div class="setrow row">
                                                        <div class="col-xl-10 col-sm-9 col-xs-9"><div class="image-head-title">' . $CI->lang->line('mu302') . '</div></div>
                                                        <div class="col-xl-2 col-sm-3 col-xs-3 text-right">
                                                            <div class="checkbox-option pull-right">
                                                                <input type="text" class="pappio" id="smtp-sender-name" value="' . $meta_val9 . '" placeholder="' . $CI->lang->line('mu304') . '">
                                                            </div>
                                                        </div>                                        
                                                    </div>
                                                    <div class="setrow row">
                                                        <div class="col-xl-10 col-sm-9 col-xs-9"><div class="image-head-title">' . $CI->lang->line('mu303') . '</div></div>
                                                        <div class="col-xl-2 col-sm-3 col-xs-3 text-right">
                                                            <div class="checkbox-option pull-right">
                                                                <input type="text" class="pappio" id="smtp-sender-email" value="' . $meta_val10 . '" placeholder="' . $CI->lang->line('mu305') . '">
                                                            </div>
                                                        </div>                                        
                                                    </div> 
                                                    <div class="setrow row">
                                                        <div class="col-xl-12 col-sm-12 col-xs-12">
                                                            <button type="button" class="btn btn-danger pull-left delete-campaign" data-id="' . $val . '">' . $CI->lang->line('mu168') . '</button>
                                                            <p class="pull-left confirm">' . $CI->lang->line('mu68') . ' <a href="#" class="delete-cam yes">' . $CI->lang->line('mu69') . '</a><a href="#" class="no">' . $CI->lang->line('mu70') . '</a></p>
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
        <div id="dialog-form" title="' . $CI->lang->line('mu273') . '">
            <input type="text" id="tem-url-field" placeholder="http://" class="text ui-widget-content ui-corner-all">
            <button class="btn btn-default add-tem-link" type="button">' . $CI->lang->line('mu274') . '</button>
            <input type="color" class="pull-right type-color change-tem-link-color" value="#333333">
        </div>'
        . form_open_multipart('user/emails', array('class' => 'upim d-none', 'id' => 'upim', 'method' => 'post', 'data-csrf' => $CI->security->get_csrf_token_name()))
            . '<input type="hidden" name="type" id="type" value="video"><input type="file" name="file[]" id="file" accept=".gif,.jpg,.jpeg,.png,.mp4,.avi" multiple>'
        . form_close();
}