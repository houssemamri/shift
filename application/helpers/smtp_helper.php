<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Name: Smtp Helper
 * Author: Scrisoft
 * Created: 10/05/2016
 * Here you will find the following functions:
 * get_list_by_id - gets a list by ID
 * get_template_by_id - gets a template by ID
 * send_smtp - sends templates to email's lists
 * parse_ip - gets data by ip address
 * */
if (!function_exists('get_list_by_id')) {
    function get_list_by_id($list_id,$scheduled) {
        if(is_numeric($list_id))
        {
            $CI = get_instance();
            // Load Lists Model
            $CI->load->model('lists');
            return $CI->lists->get_list_childs($list_id,$scheduled);
        } else {
            return false;
        }
        
    }
}
if (!function_exists('get_template_by_id')) {
    function get_template_by_id($template_id) {
        if(is_numeric($template_id))
        {
            $CI = get_instance();
            // Load Templates Model
            $CI->load->model('templates');
            return $CI->templates->get_template($template_id);
        } else {
            return false;
        }
        
    }
}
if (!function_exists('send_smtp')) {
    function send_smtp($template,$list,$scheduled) {
        $CI = get_instance();
        // Load Scheduled Model
        $CI->load->model('scheduled');
        $CI->load->model('plans');
        $title = $template[0]->title;
        $body = str_replace('syle>','style>',$template[0]->body);
        // Load SMTP
        $config = smtp();
        $sent_emails = $CI->scheduled->get_sents($scheduled[0]->user_id,'email');
        if($sent_emails) {
            $sent_emails = count($sent_emails)-1;
        } else {
            $sent_emails = 0;
        }
        
        $plan_id = get_user_option('plan', $scheduled[0]->user_id);

        $sent_limit = plan_feature('sent_emails', $plan_id);
        if($sent_emails >= $sent_limit){
            exit();
        }
        // Verify if user must use its smtp
        $smtp_options = get_instance()->ecl('Campaign')->get_campaign_meta($scheduled[0]->campaign_id, 'smtp_options');
        if ( get_option('user_smtp') ) {
            if ( ( @$smtp_options[0]->meta_val1 == '' ) || ( @$smtp_options[0]->meta_val2 == '' ) || ( @$smtp_options[0]->meta_val3 == '' ) || ( @$smtp_options[0]->meta_val4 == '' ) || ( @$smtp_options[0]->meta_val5 == '' ) ) {
                exit();
            }
        }
        // If user have added his smtp
        if ( ( @$smtp_options[0]->meta_val1 != '' ) || ( @$smtp_options[0]->meta_val2 != '' ) || ( @$smtp_options[0]->meta_val3 != '' ) || ( @$smtp_options[0]->meta_val4 != '' ) || ( @$smtp_options[0]->meta_val5 != '' ) ) {
            $protocol = 'sendmail';
            if ( $smtp_options[0]->meta_val8 ) {
                $protocol = $smtp_options[0]->meta_val8;
            }
            $config = ['mailtype' => 'html', 'charset' => 'utf-8', 'smtpauth' => true, 'priority' => '1', 'newline' => "\r\n", 'protocol' => $smtp_options[0]->meta_val8, 'smtp_host' => $smtp_options[0]->meta_val2, 'smtp_port' => $smtp_options[0]->meta_val3, 'smtp_user' => $smtp_options[0]->meta_val4, 'smtp_pass' => $smtp_options[0]->meta_val5];
            if ( $smtp_options[0]->meta_val6 ) {
                $config['smtp_crypto'] = 'ssl';
            } elseif ( $smtp_options[0]->meta_val7 ) {
                $config['smtp_crypto'] = 'tls';
            }
        }
        $send_email = $CI->config->item('contact_mail');
        if ( @$smtp_options[0]->meta_val10 ) {
            $send_email = $smtp_options[0]->meta_val10;
        }
        $send_name = $CI->config->item('site_name');
        if ( @$smtp_options[0]->meta_val9 ) {
            $send_name = $smtp_options[0]->meta_val9;
        }
        $priority = 3;
        if ( @$smtp_options[0]->meta_val11 ) {
            $priority = $smtp_options[0]->meta_val11;
        }
        $config['priority'] = $priority;
        // Load Sending Email Class
        $CI->load->library('email', $config);
        // Load User Model
        $CI->load->model('user');
        if($list) {
            foreach($list as $meta) {
                if($sent_emails >= $sent_limit){
                    break;
                }
                $title2 = $title;
                $body2 = $body;
                if($CI->user->get_user_option($scheduled[0]->user_id, 'use_spintax_emails') == 1) {
                    $body2 = get_instance()->ecl('Deco')->lsd($body2, $scheduled[0]->user_id);
                    if($title2) {
                        $title2 = get_instance()->ecl('Deco')->lsd($title2, $scheduled[0]->user_id);
                    }
                }
                $body = str_replace(['/scheduled-id','/email-id'],['/'.$scheduled[0]->scheduled_id,'/'.$meta->meta_id],$body);
                $CI->email->from($send_email, $send_name);
                $CI->email->to($meta->body);
                $CI->email->subject($title2);
                $CI->email->message($body2.'<img src="'.site_url('seen/'.$scheduled[0]->scheduled_id.'/'.$meta->meta_id).'" height="1" width="1">');
                if ($CI->email->send()) {
                    $CI->scheduled->save_stats($scheduled[0]->scheduled_id, $scheduled[0]->campaign_id, $scheduled[0]->list_id, $template[0]->template_id, $meta->body);
                }
                $sent_emails++;
            }
        }
    }
}
if (!function_exists('parse_ip')) {
    function parse_ip($ip) {
        if($ip){
            $data = get('http://ip-api.com/json/'.$ip);
            if($data){
                $data = json_decode($data);
                return [@$data->city,@$data->country];
            }
        }
    }
}