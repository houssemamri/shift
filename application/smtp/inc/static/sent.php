<?php
function temp($val,$type) {
    $CI =& get_instance();
    
    return '
            <div class="container-fluid template-upload sent-info" data-id="'.$val.'" data-type="'.$type.'">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="col-xl-12">
                            <div class="widget-box">
                                <div class="widget-header">
                                    <div class="widget-toolbar">
                                        <a href="#" class="btn btn-success get-csv-sent pull-right">'.$CI->lang->line('mu188').'</a>
                                        <ul class="nav nav-tabs" style="border: 0;">
                                            <li class="active"> <a data-toggle="tab" href="#sent-emails" aria-expanded="true">'.$CI->lang->line('mu120').'</a> </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="tab-content">
                                            <div id="sent-emails" class="tab-pane active">
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
                    </div>
                </div>
            </div>';
}