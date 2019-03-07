<?php
function temp($val){
    $CI =& get_instance();
    return '
            <nav class="list-details" data-id="'.$val.'">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#nav-show-emails" role="tab" aria-controls="nav-show-emails" aria-selected="true">' . $CI->lang->line('mu120') . '</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#nav-unactive-emails" role="tab" aria-controls="nav-unactive-emails" aria-selected="false">' . $CI->lang->line('mu176') . '</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#nav-settings" role="tab" aria-controls="nav-settings" aria-selected="false">' . $CI->lang->line('mu7') . '</a>    
                </div>
            </nav>
        
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-show-emails" role="tabpanel" aria-labelledby="nav-show-emails">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="col-xl-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading" id="accordion">
                                        <h3>'
                                            . '<a href="' . site_url('user/emails/upload') . '?list=' . $val . '">' . $CI->lang->line('mu177') . '</a>  
                                        </h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover">
                                                <tbody class="list-emails">                
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col col-lg-12">
                                              <ul class="pagination"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-unactive-emails" role="tabpanel" aria-labelledby="nav-lists">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="col-xl-12">
                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover">
                                                <tbody class="list-emails"></tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col col-lg-12">
                                              <ul class="pagination"></ul>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-settings" role="tabpanel" aria-labelledby="nav-settings">
                    <div class="row">
                        <div class="col-xl-12">
                            <ul class="email-list-settings">
                                <li>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <button type="button" class="btn btn-danger pull-left del-list" data-id="'.$val.'"><i class="icon-trash"></i> ' . $CI->lang->line('mu178') . '</button>
                                            <p class="pull-left confirm">'.$CI->lang->line('mu68').' <a href="#" class="delete-list yes">'.$CI->lang->line('mu69').'</a><a href="#" class="no">'.$CI->lang->line('mu70').'</a></p>
                                        </div>
                                    </div>
                                </li>
                            </ul>                                   
                        </div>
                    </div>
                </div>
            </div>';
}