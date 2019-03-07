<?php
function temp($val){
    $CI =& get_instance();
    $response = '';
    if(defined('response')){
        $response = response;
    }
    return '
            <div class="container-fluid template-upload">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="col-xl-12">
                            ' . form_open_multipart('user/emails/upload?list=' . $CI->input->get('list', TRUE)) . '
                                <div class="row">
                                    <div class="col-xl-6">
                                        <textarea placeholder="' . $CI->lang->line('mu183') . '" name="emails-upload"></textarea>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="mm-upload">
                                            <h2><a href="#" class="select-csv"><img src="'.site_url('assets/img/upload.png').'"><br><span>' . $CI->lang->line('mu184') . '</span></a></h2>
                                            <input type="file" class="load-csv d-none" name="csv-file" accept=".csv">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <button type="submit">' . $CI->lang->line('mu185') . '</button>
                                        &nbsp;&nbsp;<a href="' . site_url('user/emails/lists/' . $CI->input->get('list', TRUE)) . '">' . $CI->lang->line('mu186') . '</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 alert-msg">
                                        ' . $response . '
                                    </div>
                                </div>
                            ' . form_close() . '
                        </div>
                    </div>
                </div>
            </div>';
}