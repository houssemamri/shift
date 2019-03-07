<?php
/**
 * Functions
 *
 * PHP Version 5.6
 *
 * In this file is used to process the ajax requests
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
/**
 * Get Posts
 */
if (get_instance()->input->get('action', TRUE) == 'results') {
    // Load Second Helper
    get_instance()->load->helper('second_helper');
    $page = get_instance()->input->get('page', TRUE);
    $by = get_instance()->input->get('by', TRUE);
    if((is_numeric($page) == TRUE) && (is_numeric($by) == TRUE)) {
        planner_emails_by($page,$by);
    }
}
/**
 * Add new network account to a post
 */
if (get_instance()->input->get('action', TRUE) == 'update-selected-accounts') {
    // Load Second Helper
    get_instance()->load->helper('second_helper');
    $page = get_instance()->input->get('res', TRUE);
    $net = get_instance()->input->get('net', TRUE);
    if((is_numeric($net) == TRUE) || (is_numeric($page) == TRUE)) {
        if(is_numeric(add_account_to_post($page,$net))) {
            echo json_encode(2);
            exit();
        }
    }    
    if(is_numeric($page) == TRUE) {
        get_sel_accounts_per_post($page);
    }
}
/**
 * Delete post's meta by id
 */
if (get_instance()->input->get('action', TRUE) == 'delete-meta-post') {
    // Load Second Helper
    get_instance()->load->helper('second_helper');
    $page = get_instance()->input->get('res', TRUE);
    $net = get_instance()->input->get('net', TRUE);
    if((is_numeric($net) == TRUE) || (is_numeric($page) == TRUE)) {
        delete_post_meta_by($page,$net);
    }    
    if(is_numeric($page) == TRUE) {
        get_sel_accounts_per_post($page);
    }
}
/**
 * Update a resend meta
 */
if (get_instance()->input->get('action', TRUE) == 'edit-meta') {
    // Load Second Helper
    get_instance()->load->helper('second_helper');
    $page = get_instance()->input->get('res', TRUE);
    $net = get_instance()->input->get('met', TRUE);
    if(get_instance()->input->get('rule1', TRUE)) {
        if((get_instance()->input->get('rule1', TRUE) > 0) && (get_instance()->input->get('rule1', TRUE) < 8)) {
            edit_resend_meta_by($page,$net,get_instance()->input->get('rule1', TRUE),'rule1');
        }
    } else if(get_instance()->input->get('rule2', TRUE)) {
        if(hour_minute(get_instance()->input->get('rule2', TRUE))) {
            edit_resend_meta_by($page,$net,get_instance()->input->get('rule2', TRUE),'rule2');
        }
    } else if((get_instance()->input->get('rule3', TRUE) > 0) && (get_instance()->input->get('rule3', TRUE) < 5)) {
        edit_resend_meta_by($page,$net,get_instance()->input->get('rule3', TRUE),'rule3');
    } else if((get_instance()->input->get('rule4', TRUE) > 0) && (get_instance()->input->get('rule4', TRUE) < 31)) {
        edit_resend_meta_by($page,$net,get_instance()->input->get('rule4', TRUE),'rule4');
    }
}
/**
 * Delete resend's meta by id
 */
if (get_instance()->input->get('action', TRUE) == 'delete-meta') {
    // Load Second Helper
    get_instance()->load->helper('second_helper');
    $page = get_instance()->input->get('res', TRUE);
    $net = get_instance()->input->get('met', TRUE);
    if((is_numeric($net) == TRUE) || (is_numeric($page) == TRUE)) {
        delete_meta_by_temp($page,$net);
    }
}
/**
 * Add template's list
 */
if (get_instance()->input->get('action', TRUE) == 'add-template-list') {
    $template = get_instance()->input->get('template', TRUE);
    $list = get_instance()->input->get('list', TRUE);
    if((is_numeric($template) == TRUE) || (is_numeric($list) == TRUE)) {
        if(get_instance()->ecl('Instance')->mod('lists', 'if_user_has_list', [get_instance()->ecl('Instance')->user(),$list,'email'])) {
            if(get_instance()->ecl('Instance')->mod('templates', 'set_list', [$template,$list,get_instance()->ecl('Instance')->user()])) {
                echo json_encode(1);
            } else {
                echo json_encode(1);
            }
        }
    }
}
/**
 * Add a new planner's action
 */
if (get_instance()->input->get('action', TRUE) == 'add-new-planner') {
    // Load Second Helper
    get_instance()->load->helper('second_helper');
    $page = get_instance()->input->get('net', TRUE);
    $time = get_instance()->input->get('time', TRUE);
    $time = strtotime($time);
    if((is_numeric($page) == TRUE) && (is_numeric($time) == TRUE)) {
        $act = (get_option('posts_planner_limit'))?get_option('posts_planner_limit'):'1';
        // Load User Model
        get_instance()->load->model('resend');
        // Load User Model
        get_instance()->load->model('user');
        $user_id = get_instance()->ecl('Instance')->user();
        $resend_id = get_instance()->resend->get_template_resend_id($user_id,$page);
        if($resend_id) {
            $metas = get_instance()->resend->get_metas($user_id, $resend_id);
            if($metas) {
                if(count($metas) >= $act) {
                    exit();
                }
            }          
        }
        $response = add_new_planner_template($page,$time);
        if($response){
            echo json_encode($response);
        }
    }
}
/**
 * Get Selected Accounts
 */
if (get_instance()->input->get('action', TRUE) == 'get-selected') {
    // Load Second Helper
    get_instance()->load->helper('second_helper');
    // Load Lists Model
    get_instance()->load->model('lists');
    $page = get_instance()->input->get('res', TRUE);
    $user_id = get_instance()->ecl('Instance')->user();
    if(is_numeric($page) == TRUE) {
        $gt = 0;
        if(get_option('tool_groups-accounts') && get_user_option('display_groups_form')) {
            $gt++;
        }
        $get = gets_post_group($page);
        if(is_numeric($get[0]->category)) {
            $vk = get_instance()->lists->get_lists($user_id, 0, 'social', 1000);
            if($vk) {
                echo json_encode(['category' => $get[0]->category, 'res' => $vk]);
            }
        } else if(($gt > 0) && (!get_post_details($user_id, $page))) {
            $vk = get_instance()->lists->get_lists($user_id, 0, 'social', 1000);
            if($vk) {
                echo json_encode(['category' => 0, 'res' => $vk]);
            }      
        } else {
            get_sel_accounts_per_post($page);
        }
    }
}
/**
 * Cancel Planner Schedule
 */
if (get_instance()->input->get('action', TRUE) == 'cancel-planner-sched') {
    // Load Second Helper
    get_instance()->load->helper('second_helper');
    $page = get_instance()->input->get('res', TRUE);
    $id = get_instance()->input->get('id', TRUE);
    if(is_numeric($page) == TRUE) {
        $rules = cancel_planner_sched($page,$id);
        if($rules) {
            echo json_encode($rules);
        }
    }    
}
/**
 * Get Schedules
 */
if (get_instance()->input->get('action', TRUE) == 'get-schedules') {
    // Load Second Helper
    get_instance()->load->helper('second_helper');
    $page = get_instance()->input->get('res', TRUE);
    if(is_numeric($page) == TRUE) {
        $rules = get_rules_for_temp($page);
        if($rules) {
            echo json_encode($rules);
        }
    }    
}
/**
 * Search Social Accounts
 */
if (get_instance()->input->get('action', TRUE) == 'search-accounts') {
    // Load Second Helper
    get_instance()->load->helper('second_helper');
    $net = get_instance()->input->get('net', TRUE);
    $keys = get_instance()->input->get('keys', TRUE);
    if ($this->input->post()) {
        $this->form_validation->set_rules('keys', 'Keys', 'trim|required');
        $this->form_validation->set_rules('net', 'Net', 'trim|required');
        // Get data
        $keys = $this->input->post('keys');
        $net = $this->input->post('net');
        if ($this->form_validation->run()) {
            get_accounts_by_search($net,$keys);
        }
    }
}

/**
 * Get Resend Data
 */
if (get_instance()->input->get('action', TRUE) == 'getplanns') {
    // Load Second Helper
    get_instance()->load->helper('second_helper');
    $page = get_instance()->input->get('res', TRUE);
    if(is_numeric($page) == TRUE) {
        planner_childs($page);
    }
}

/**
 * Save Post's Groups
 */
if (get_instance()->input->get('action', TRUE) == 'save-post-groups') {
    // Load Second Helper
    get_instance()->load->helper('second_helper');
    $res = get_instance()->input->get('res', TRUE);
    $page = get_instance()->input->get('page', TRUE);
    if((is_numeric($page) == TRUE) && (is_numeric($res) == TRUE)) {
        // Load Second Helper
        get_instance()->load->helper('second_helper');
        // Load Lists Model
        get_instance()->load->model('lists');
        $user_id = get_instance()->ecl('Instance')->user();
        $add_or_remove = add_or_remove_post_group($user_id,$page,$res);
        if($add_or_remove == 2) {
            echo json_encode(2);
            exit();
        } else if($add_or_remove == 3) {
            $res = 0;
        }
        $vk = get_instance()->lists->get_lists($user_id, 0, 'social', 1000);
        if($vk) {
            echo json_encode(['category' => $res, 'res' => $vk]);
        }
    }
}

/**
 * Planner Actions
 */
if (get_instance()->input->get('action', TRUE) == 'do-planner') {
    // Load Templates Model
    get_instance()->load->model('Templates');        
    // Load Resend Model
    get_instance()->load->model('resend');
    // Load Second Helper
    get_instance()->load->helper('second_helper');
    $resends = get_instance()->resend->get_active_resend();
    if($resends){
        foreach ($resends as $resend){
            $type = get_instance()->ecl('Instance')->mod('resend', 'get_resend_type', [$resend->resend_id]);
            if($type != 2) {
                continue;
            }
            $time = get_plan_time($resend);
            $resend_metas = metaget($resend->user_id,$resend->resend_id);
            $df = 0; $o = 0;
            if($resend_metas){
                foreach ($resend_metas as $resend_meta){
                    $rul = get_instance()->resend->get_rule_by_id($resend_meta->meta_id);
                    $tr = 0;
                    if($rul) {
                        if($resend_meta->rule3 == 1) {
                            $tr++;
                        } elseif (($resend_meta->rule3 == 2) && ($rul[0]->totime < time()-604800)) {
                            $tr++;
                        } elseif (($resend_meta->rule3 == 3) && ($rul[0]->totime < time()-2073600)) {
                            $tr++;
                        } elseif (($resend_meta->rule3 == 4) && ($rul[0]->totime < time()-31104000)) {
                            $tr++;
                        }
                    } else {
                        if ($resend_meta->rule3 == 2) {
                            if($resend->updated < time()-604800) {
                                $tr++;
                            }
                        } elseif ($resend_meta->rule3 == 3) {
                            if($resend->updated < time()-2073600) {
                                $tr++;
                            }
                        } elseif ($resend_meta->rule3 == 4) {
                            if($resend->updated < time()-31104000) {
                                $tr++;
                            }
                        } else {
                            $tr++;
                        }
                    }
                    if($tr > 0) {
                        fofime($resend->resend_id,$resend_meta->meta_id,plafame($resend_meta->rule2,day_by_time($time,$resend_meta->rule1)),$resend_meta->rule4,$resend->user_id,($resend->time - $resend->created));
                    }
                    $rules = get_instance()->resend->get_rules_by_id($resend_meta->meta_id);
                    if($rules){
                        if((count($rules)) >= $resend_meta->rule4){
                            $df++;
                        } else {
                            $df--;
                        }
                    }
                    $o++;
                }
                if($df >= $o) {
                    planner_done($resend->resend_id, $resend->user_id);
                }                
            } else {
                planner_done($resend->resend_id, $resend->user_id);
            }
        }
    }
    $rules = get_instance()->resend->get_active_rules();
    if($rules){
        foreach ($rules as $rule) {          
            $type = get_instance()->ecl('Instance')->mod('resend', 'get_resend_type', [$rule->resend_id]);
            if($type != 2) {
                continue;
            }
            $template = get_instance()->resend->get_template_by_resend_id($rule->resend_id);
            if($template) {
                // Load User Model
                get_instance()->load->model('user');
                // Load Scheduled Model
                get_instance()->load->model('scheduled');
                $user_id = $template[0]->user_id;
                $send_limit = plan_feature('sent_emails');
                $sent_emails = get_instance()->scheduled->get_sents($user_id, 'email');
                if(!$sent_emails) {
                    $sent_emails = 0;
                } else {
                    $sent_emails = count($sent_emails);
                }
                if($send_limit <= $sent_emails) {
                    get_instance()->resend->cancel_planner_sched($rule->resend_id,$rule->rule_id);
                } else {
                    $template_id = get_instance()->ecl('Instance')->mod('scheduled', 'schedule_template', [$user_id,'email',$template[0]->campaign_id,$template[0]->list_id,$template[0]->template_id,0,0,$rule->totime]);
                    if($template_id) {
                        get_instance()->resend->done_planner_sched($rule->resend_id,$rule->rule_id);
                    } else {
                        get_instance()->resend->cancel_planner_sched($rule->resend_id,$rule->rule_id);
                    }
                }
            } else {
                get_instance()->resend->cancel_planner_sched($rule->resend_id,$rule->rule_id);
            }
        }
    }
}