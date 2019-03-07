<?php
class Cpost{
    protected $CI;
    public function __construct(){
        $this->CI = get_instance();
        if($this->CI->input->post('campaign')) {
            $this->new_campaign();
        } else if($this->CI->input->post('list')) {
            $this->new_list();
        } else if($this->CI->input->post('first_template')) {
            $this->schedule_template();
        } else if($this->CI->input->post('smtp_option')) {
            $this->smtp_option();
        } else if($this->CI->input->post('campaign_statistics')) {
            $this->show_stats();
        }       
    }
    public function emails_upload() {
        // Create a new List
        $this->CI->form_validation->set_rules('emails-upload', 'Emails Upload', 'trim');
        if ($this->CI->form_validation->run()) {
            $emails_upload = $this->CI->input->post('emails-upload');
            $csv_file = $this->CI->input->post('csv-file');
            if($emails_upload)
            {
                return $this->CI->ecl('Clist')->upload($this->CI->input->get('list', TRUE),$emails_upload);
            } else if(@$_FILES['csv-file']['tmp_name']){
                $expected = ['text/csv','text/plain','application/csv','text/comma-separated-values','application/excel','application/vnd.ms-excel','application/vnd.msexcel','text/anytext','application/octet-stream','application/txt'];
                if(in_array($_FILES['csv-file']['type'], $expected))
                {
                    return $this->CI->ecl('Clist')->extract_upload($this->CI->input->get('list', TRUE),$_FILES['csv-file']['tmp_name']);
                } else {
                    return display_mess(120);
                }
            }
        }
        else{
            return display_mess(120);
        }
    }
    public function new_list() {
        // Create a new List
        $this->CI->form_validation->set_rules('list', 'List', 'trim|required');
        $this->CI->form_validation->set_rules('description', 'Description', 'trim');
        if ($this->CI->form_validation->run()) {
            $l = $this->CI->input->post('list');
            $d = $this->CI->input->post('description');
            $this->CI->ecl('Clist')->create($l,$d);
        }
        else{
            display_mess(18);
        }
    }
    public function schedule_template() {
        // Schedule a template
        $this->CI->form_validation->set_rules('publish', 'Publish', 'trim|integer');
        $this->CI->form_validation->set_rules('template_title', 'Template Title', 'trim|required');
        $this->CI->form_validation->set_rules('campaign_id', 'Campaign ID', 'trim|required');
        $this->CI->form_validation->set_rules('first_template', 'First Template', 'trim|required');
        $this->CI->form_validation->set_rules('first_list', 'List 1', 'trim|integer');
        $this->CI->form_validation->set_rules('first_condition', 'Condition', 'trim|integer');
        $this->CI->form_validation->set_rules('second_template', 'Template 2', 'trim|integer');
        $this->CI->form_validation->set_rules('datetime', 'Time', 'trim');
        $this->CI->form_validation->set_rules('date', 'Date', 'trim');
        $this->CI->form_validation->set_rules('all_planns', 'All Plans', 'trim');
        if ($this->CI->form_validation->run()) {
            $publish = $this->CI->input->post('publish');
            $template_title = $this->CI->input->post('template_title');
            $campaign_id = $this->CI->input->post('campaign_id');
            $first_template = $this->CI->input->post('first_template', FALSE);
            $first_list = $this->CI->input->post('first_list');
            $first_condition = $this->CI->input->post('first_condition');
            $second_template = $this->CI->input->post('second_template');
            $datetime = $this->CI->input->post('datetime');
            $date = $this->CI->input->post('date');
            $all_planns = $this->CI->input->post('all_planns');
            $date = (is_numeric(strtotime($date))) ? strtotime($date) : time();
            $datetime = (is_numeric(strtotime($datetime))) ? strtotime($datetime) : time();
            $datetime2 = $datetime;
            $datetime = $date - $datetime + time();
            $msg_tem = $this->CI->ecl('Template')->create($template_title,$first_template,$campaign_id,$publish);
            if($publish < 1) {
                echo $msg_tem;
                exit();
            }
            // Verify if the template was created successfully
            if(!$msg_tem) {
                display_mess(134);
                exit();
            } else {
                $first_template = $msg_tem;
            }
            // Check if the user has the list
            if(!$this->CI->ecl('Clist')->get_user_list($first_list)) {
                display_mess(123);
                exit();
            }
            // Save resend if exists
            if($all_planns){
                // Load Second Helper
                $this->CI->load->helper('second_helper');
                resend_temp($first_template,$all_planns,$first_list,$datetime2);
            }
            // Check if the user has the template
            if(!$this->CI->ecl('Template')->get_template_title($first_template)) {
                display_mess(123);
                exit();
            }
            if(($first_condition != 1) && ($first_condition != 2)) {
                $first_condition = 0;
                $second_template = 0;
            } else{
                if(is_numeric($second_template)){
                    // Check if the user has the template
                    if(!$this->CI->ecl('Template')->get_template_title($second_template)) {
                        $first_condition = 0;
                        $second_template = 0;
                    }
                } else {
                    $first_condition = 0;
                    $second_template = 0;
                }
            }
            $this->CI->ecl('Sched')->schedule_template($campaign_id,$first_template,$first_list,$first_condition,$second_template,$datetime);
        }
        else{
            display_mess(123);
        }
    }
    public function new_campaign() {
        // Create a new Campaign
        $this->CI->form_validation->set_rules('campaign', 'Campaign', 'trim|required');
        $this->CI->form_validation->set_rules('description', 'Description', 'trim');
        if ($this->CI->form_validation->run()) {
            $c = $this->CI->input->post('campaign');
            $d = $this->CI->input->post('description');
            $this->CI->ecl('Campaign')->create($c,$d);
        }
        else {
            display_mess(18);
        }
    }
    public function smtp_option() {
        // Save smtp options
        $this->CI->form_validation->set_rules('campaign_id', 'Campaign ID', 'integer|trim|required');
        $this->CI->form_validation->set_rules('smtp_option', 'Smtp Options', 'trim|required');
        $this->CI->form_validation->set_rules('field', 'Field', 'trim|required');
        $this->CI->form_validation->set_rules('value', 'Value', 'trim');
        if ($this->CI->form_validation->run()) {
            $smtp_option = $this->CI->input->post('smtp_option');
            $field = $this->CI->input->post('field');
            $value = $this->CI->input->post('value');
            $campaign_id = $this->CI->input->post('campaign_id');
            if($this->CI->ecl('Campaign')->create_meta($campaign_id,$smtp_option,$field,$value)) {
                echo json_encode(1);
            }
        }
    }
    
    public function show_stats() {
        // Get scheduled stats
        $this->CI->form_validation->set_rules('campaign_statistics', 'Campaign Statistics', 'integer|trim|required');
        $this->CI->form_validation->set_rules('template_id', 'Template ID', 'trim|integer');
        $this->CI->form_validation->set_rules('time', 'Time', 'trim');
        if ($this->CI->form_validation->run()) {
            $campaign_id = $this->CI->input->post('campaign_statistics');
            $template_id = $this->CI->input->post('template_id');
            $time = $this->CI->input->post('time');
            if($time == 'all') {
                $time = 3650;
            }
            $stats = $this->CI->ecl('Scheduled')->get_sent_schedules($campaign_id,$template_id,$time);
            if($stats) {
                echo json_encode($stats);
            }
        }
    }
}