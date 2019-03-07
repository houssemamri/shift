<?php
function temp(){
    $CI =& get_instance();
    return '
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#nav-campaigns" role="tab" aria-controls="nav-campaigns" aria-selected="true">' . $CI->lang->line('mu145') . '</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#nav-lists" role="tab" aria-controls="nav-lists" aria-selected="false">' . $CI->lang->line('mu146') . '</a>
                </div>
            </nav>
            
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-campaigns" role="tabpanel" aria-labelledby="nav-campaigns">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="col-xl-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading" id="accordion">
                                        <h3>
                                            <i class="fas fa-bullhorn"></i> '
                                            . $CI->lang->line('all_campaigns')
                                            . '<a href="#" data-toggle="modal" data-target="#newCampaign">' . $CI->lang->line('mu147') . '</a>  
                                        </h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xl-12">                                    
                                                <ul class="midrub-emails-campaigns">
                                                </ul>
                                            </div>
                                        </div>
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
                <div class="tab-pane fade" id="nav-lists" role="tabpanel" aria-labelledby="nav-lists">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="col-xl-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading" id="accordion">
                                        <h3>
                                            <i class="fa fa-at"></i> '
                                            . $CI->lang->line('all_lists')
                                            . '<a href="#" data-toggle="modal" data-target="#newList">' . $CI->lang->line('mu148') . '</a>  
                                        </h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xl-12">                                    
                                                <ul class="midrub-emails-lists">
                                                </ul>
                                            </div>
                                        </div>
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
            </div>';
    
}