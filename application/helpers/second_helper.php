<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Name: Second Helper
 * Author: Scrisoft
 * Created: 05/06/2017
 * Here you will find the following functions:
 * get_post_details - gets post data
 * gets_autopost - gets all autopost files
 * get_autopost_assets - gets autopost's assets
 * gets_list_meta - gets list's meta
 * delete_account_group - deletes group's accounts
 * add_account_to_group - adds account to group
 * get_group_networks - gets group's social accounts
 * cancel_planner_sched - cancel scheduling action
 * planner_done - setup planner like done
 * get_rules - gets resend's rules
 * metaget - gets resend meta
 * gets_post_group - gets post's group
 * genitime - generates the time
 * add_new_planner - adds a new planner action to a post
 * add_new_planner_template - adds a new planner action to a template
 * delete_meta_by - deletes a resend's meta
 * delete_meta_by_temp - deletes a template's resend meta
 * timea - calculate time
 * show_groups - display user's groups
 * delete_post_meta_by - deletes post meta by post id and meta id
 * edit_resend_meta_by - edit the resend's meta
 * add_account_to_post - adds new account to post
 * planner_posts_by - gets posts in the Posts Planner tool
 * planner_emails_by - gets emails in the Emails Planner tool
 * planner_childs - gets planner childs
 * get_meta_publishes - gets the number of scheduled meta
 * day_by_time - gets day from the time
 * get_sel_accounts_per_post - gets selected accounts per post id
 * hour_minute - checks if the time form is hour and minute
 * get_accounts_by_search - searches accounts by social network
 * the_time - gets updated time
 * resend_id - resends a post
 * resend_temp - resends a template
 * plafame - get time
 * get_plan_time - gets current time
 * add_or_remove_post_group - adds or removes a post's group
 * */
if (!function_exists('get_post_details')) {
    function get_post_details($a, $b) {
        $CI = get_instance();
        // Load Posts Model
        $CI->load->model('posts');
        // Then verify if the user is the post's owner
        $posto = $CI->posts->get_post($a, $b);
        if($posto) {
            $postu = $CI->posts->pmet($b);
            if($postu) {
                return true;
            }
        }
    }
}
if (!function_exists('gets_autopost')) {
    function gets_autopost(){
        $CI = & get_instance();
        // Load Options Model
        $CI->load->model('options');
        include_once APPPATH . 'interfaces/Autopost.php';
        $classes = [];
        foreach (glob(APPPATH . 'autopost/*.php') as $filename) {
            include_once $filename;
            $className = str_replace([APPPATH . 'autopost/', '.php'], '', $filename);
            // Check if the administrator has disabled the $className social network
            if ($CI->options->check_enabled(strtolower($className)) == false) {
                continue;
            }
            $get = new $className;
            $info = $get->get_info();
            $classes[] = [$info->color,$info->icon,$className];
        }
        return $classes;
    }
}
if (!function_exists('get_autopost_assets')) {
    function get_autopost_assets($netu, $nets) {
        if($nets) {
            $socios = [];
            foreach ($nets as $net){
                if(strtolower($net[2]) == $netu) {
                    return '<span class="icon pull-right" style="color:'.$net[0].';" title="' . ucwords(str_replace("_", " ", $netu)) . '">' . str_replace(' style="color:#ffffff"','',$net[1]) . '</span>';
                }
            }
        }
    }
}
if (!function_exists('gets_list_meta')) {
    function gets_list_meta($metas) {
        if($metas) {
            $nets = gets_autopost();
            $fres = '';
            foreach($metas as $meta) {
                $expires = 'never';
                if($meta->expires) {
                    $expires = substr($meta->expires, 0, 19);
                }
                $fres .= '<li>' . $meta->user_name . ' <span class="expires">' . get_instance()->lang->line('mu39') . ' <strong>' . $expires . '</strong></span>' . get_autopost_assets($meta->network_name, $nets) . '</li>';
            }
            return $fres;
        } else {
            return '<li>' . get_instance()->lang->line('mm127') . '</li>';
        }
    }
}
if (!function_exists('delete_account_group')) {
    function delete_account_group($a1,$a2,$a3) {
        $CI = get_instance();
        // Load Lists Model
        $CI->load->model('lists');
        // Delete account
        return $CI->lists->delete_meta($a1,$a3,$a2);
    }
}
if (!function_exists('add_account_to_group')) {
    function add_account_to_group($a1,$a2,$a3) {
        $CI = get_instance();
        // Load Lists Model
        $CI->load->model('lists');
        // Load Networks Model
        $CI->load->model('networks');
        // First verify if the user is the owner of the list
        $is_owner = $CI->lists->if_user_has_list($a1, $a2, 'social');
        if($is_owner) {
            // Verify if the user is the account's owner
            $is_owner = $CI->networks->get_account($a3);
            if($is_owner) {
                if($is_owner[0]->user_id == $a1) {
                    // Calculate the number of added networks per group
                    $limit = $CI->lists->gets_groups_selected_accounts($a2,$is_owner[0]->network_name);
                    if($limit) {
                        if($limit >= plan_feature('publish_accounts')) {
                            return '2';
                        }
                    }
                    // Then add account
                    return $CI->lists->upload_to_list($a1, $a2, $a3);
                }
            }
        }
    }
}
if (!function_exists('get_group_networks')) {
    function get_group_networks($a1,$a2) {
        $CI = get_instance();
        // Load Lists Model
        $CI->load->model('lists');
        // First verify if the user is the owner of the list
        $is_owner = $CI->lists->if_user_has_list($a1,$a2,'social');
        if($is_owner) {
            return $CI->lists->get_lists_meta($a1, 0, $a2, 3);
        }
    }
}
if (!function_exists('cancel_planner_sched')) {
    function cancel_planner_sched($a1,$a2) {
        $CI = get_instance();
        // Load Resend Model
        $CI->load->model('resend');
        // Get user by ID
        $user_id = get_instance()->ecl('Instance')->user();
        if($CI->resend->get_metas($user_id,$a1)) {
            $CI->resend->cancel_planner_sched($a1,$a2);
            return $CI->resend->get_rules($user_id,$CI->resend->get_resend_post($a1));
        }
    }
}
if (!function_exists('planner_done')) {
    function planner_done($a1,$b) {
        $CI = get_instance();
        return $CI->resend->finished_planner($a1,$b);
    }
}
if (!function_exists('get_rules')) {
    function get_rules($a1) {
        $CI = get_instance();
        // Load Resend Model
        $CI->load->model('resend');
        // Get user by ID
        $user_id = get_instance()->ecl('Instance')->user();
        return $CI->resend->get_rules($user_id,$a1);
    }
}
if (!function_exists('get_rules_for_temp')) {
    function get_rules_for_temp($a1) {
        $CI = get_instance();
        // Load Resend Model
        $CI->load->model('resend');
        // Get user by ID
        $user_id = get_instance()->ecl('Instance')->user();
        return $CI->resend->get_rules_for_temp($user_id,$a1);
    }
}
if (!function_exists('metaget')) {
    function metaget($a1,$a2) {
        $CI = get_instance();
        // Load Resend Model
        $CI->load->model('resend');
        $CI->resend->updatup($a2);
        return $CI->resend->get_metas($a1,$a2);
    }
}
if (!function_exists('gets_post_group')) {
    function gets_post_group($a) {
        $CI = get_instance();
        // Load Posts Model
        $CI->load->model('posts');
        return $CI->posts->gets_post_group($a);
    }
}
if (!function_exists('genitime')) {
    function genitime($time,$v,$l) {
        if(($v == 1) && ($l == 1)){
            return $time;
        } else if(($v == 1) && ($l == 2)) {
            return $time + 86400;
        } else if(($v == 1) && ($l == 3)) {
            return $time + 172800;
        } else if(($v == 1) && ($l == 4)) {
            return $time + 259200;
        } else if(($v == 1) && ($l == 5)) {
            return $time + 345600;
        } else if(($v == 1) && ($l == 6)) {
            return $time + 432000;
        } else if(($v == 1) && ($l == 7)) {
            return $time + 518400;
        } else if(($v == 2) && ($l == 2)) {
            return $time;
        } else if(($v == 2) && ($l == 3)) {
            return $time + 86400;
        } else if(($v == 2) && ($l == 4)) {
            return $time + 172800;
        } else if(($v == 2) && ($l == 5)) {
            return $time + 259200;
        } else if(($v == 2) && ($l == 6)) {
            return $time + 345600;
        } else if(($v == 2) && ($l == 7)) {
            return $time + 432000;
        } else if(($v == 3) && ($l == 3)) {
            return $time;
        } else if(($v == 3) && ($l == 4)) {
            return $time + 86400;
        } else if(($v == 3) && ($l == 5)) {
            return $time + 172800;
        } else if(($v == 3) && ($l == 6)) {
            return $time + 259200;
        } else if(($v == 3) && ($l == 7)) {
            return $time + 345600;
        } else if(($v == 4) && ($l == 4)) {
            return $time;
        } else if(($v == 4) && ($l == 5)) {
            return $time + 86400;
        } else if(($v == 4) && ($l == 6)) {
            return $time + 172800;
        } else if(($v == 4) && ($l == 4)) {
            return $time + 259200;
        } else if(($v == 5) && ($l == 5)) {
            return $time;
        } else if(($v == 5) && ($l == 6)) {
            return $time + 86400;
        } else if(($v == 5) && ($l == 7)) {
            return $time + 172800;
        } else if(($v == 6) && ($l == 6)) {
            return $time;
        } else if(($v == 6) && ($l == 7)) {
            return $time + 86400;
        } else if(($v == 7) && ($l == 1)){
            return $time + 86400;
        } else if(($v == 7) && ($l == 2)) {
            return $time + 172800;
        } else if(($v == 7) && ($l == 3)) {
            return $time + 259200;
        } else if(($v == 7) && ($l == 4)) {
            return $time + 345600;
        } else if(($v == 7) && ($l == 5)) {
            return $time + 432000;
        } else if(($v == 7) && ($l == 6)) {
            return $time + 518400;
        } else if(($v == 7) && ($l == 6)) {
            return $time + 518400;
        } else if(($v == 7) && ($l == 7)) {
            return $time + 604800;
        }
    }
}
if (!function_exists('add_new_planner')) {
    function add_new_planner($post_id, $time) {
        $CI = get_instance();
        // Load Posts Model
        $CI->load->model('posts');        
        // Load Resend Model
        $CI->load->model('resend');
        // Get user by ID
        $user_id = get_instance()->ecl('Instance')->user();
        // Check if the user is the owner of the post and get resend_id
        $resend_id = $CI->resend->get_post_resend_id($user_id,$post_id);
        if($resend_id){
            // Save resend's meta
            $meta = $CI->resend->save_meta($resend_id,'1','00:00','1','1');
            if($meta){
                return ['meta_id' => $meta, 'resend_id' => $resend_id];
            }
        } else {
            // Create a new resend
            $resend_id = $CI->resend->save_resend($user_id,$time);
            if($resend_id){
                // If Resend was created successfully will be saved the meta
                $meta = $CI->resend->save_meta($resend_id,'1','00:00','1','1');
                if($meta){
                    // If the meta was saved succesfully, will be updated the post
                    if($CI->resend->setup($post_id,$resend_id)){
                        // Now if the post was updated successfully, will return $meta
                        if($meta){
                            return ['meta_id' => $meta, 'resend_id' => $resend_id];
                        }
                    }
                }
            }
        }
    }
}
if (!function_exists('add_new_planner_template')) {
    function add_new_planner_template($template_id, $time) {
        $CI = get_instance();
        // Load Templates Model
        $CI->load->model('templates');        
        // Load Resend Model
        $CI->load->model('resend');
        // Get user by ID
        $user_id = get_instance()->ecl('Instance')->user();
        // Check if the user is the owner of the template and get resend_id
        $resend_id = $CI->resend->get_template_resend_id($user_id,$template_id);
        if($resend_id){
            // Save resend's meta
            $meta = $CI->resend->save_meta($resend_id,'1','00:00','1','1');
            if($meta){
                return ['meta_id' => $meta, 'resend_id' => $resend_id];
            }
        } else {
            // Create a new resend
            $resend_id = $CI->resend->save_resend($user_id,$time);
            if($resend_id){
                // If Resend was created successfully will be saved the meta
                $meta = $CI->resend->save_meta($resend_id,'1','00:00','1','1');
                if($meta){
                    // If the meta was saved succesfully, will be updated the template
                    if($CI->resend->setup_temp($template_id,$resend_id)){
                        // Now if the template was updated successfully, will return $meta
                        if($meta){
                            return ['meta_id' => $meta, 'resend_id' => $resend_id];
                        }
                    }
                }
            }
        }
    }
}
if (!function_exists('delete_meta_by')) {
    function delete_meta_by($resend,$meta) {
        $CI = get_instance();
        // Load Resend Model
        $CI->load->model('resend');
        // Get user by ID
        $user_id = get_instance()->ecl('Instance')->user();
        // Check if the user is the resend's author
        if($CI->resend->get_metas($user_id, $resend)){
            // Delete resend meta
            $check = $CI->resend->delete_meta_by($resend, $meta);
            if($check){
                if($CI->resend->get_metas($user_id, $resend)){
                    echo json_encode(1);
                } else if($CI->resend->delete($resend)){
                    echo json_encode(2);
                } else {
                    echo json_encode(1);
                }
            }
        }
    }
}
if (!function_exists('delete_meta_by_temp')) {
    function delete_meta_by_temp($resend,$meta) {
        $CI = get_instance();
        // Load Resend Model
        $CI->load->model('resend');
        // Get user by ID
        $user_id = get_instance()->ecl('Instance')->user();
        // Check if the user is the resend's author
        if($CI->resend->get_metas($user_id, $resend)){
            // Delete resend meta
            $check = $CI->resend->delete_meta_by($resend, $meta);
            if($check){
                if($CI->resend->get_metas($user_id, $resend)){
                    echo json_encode(1);
                } else if($CI->resend->delete($resend,1)){
                    echo json_encode(2);
                } else {
                    echo json_encode(1);
                }
            }
        }
    }
}
if (!function_exists('timea')) {
    function timea($time) {
        return strtotime(date('Y-m-d',$time));
    }
}
if (!function_exists('show_groups')) {
    function show_groups() {
        $CI = get_instance();
        // Load User Model
        $CI->load->model('lists');
        $user_id = get_instance()->ecl('Instance')->user();
        // First verify if the user has a list
        $is_owner = $CI->lists->get_lists($user_id, 0, 'social', 1000);
        if($is_owner) {
            echo '<div class="col-lg-12 social"><ul>';
            foreach ($is_owner as $group) {
                echo '<li class="netsel" data-id="' . $group->list_id . '">
                            <span class="icon pull-left" style="background-color: #5fd0b9"><i class="fa fa-users" style="color:#fff"></i></span> <span class="netaccount pull-left" style="line-height: 40px;">' . $group->name . '</span>
                            <div class="btn-group pull-right">
                                <button type="button" data-type="main" class="btn btn-default select-group">
                                    ' . get_instance()->lang->line('mm123') . '
                                </button>
                                <button type="button" class="btn btn-default show-accounts">
                                    <i class="fa fa-bars" aria-hidden="true"></i>
                                </button>
                            </div>
                        </li>
                        <li class="socials">
                           <div class="row">
                               <div class="col-lg-12"><i class="fa fa-search" aria-hidden="true"></i><input class="search-accounts-groups form-control" data-id="' . $group->list_id . '" placeholder="' . get_instance()->lang->line('mu38') . '"><button class="show-selected" type="button"><i class="fa fa-times" aria-hidden="true"></i></button></div>
                           </div>
                           <div class="row">
                               <div class="col-lg-12">
                                   <ul class="sell-accounts">
                                       ' . gets_list_meta($CI->lists->get_lists_meta($user_id, 0, $group->list_id, 3)) . '
                                   </ul>
                               </div>
                           </div>
                        </li>';
            }
            echo '</ul></div>';
        } else {
            echo '<div class="col-lg-12 social">
                    <ul style="padding:10px">
                        <li class="notconnected">' . $CI->lang->line('mu207') . '</li>
                    </ul>
                </div>';
        }
    }
}
if (!function_exists('delete_post_meta_by')) {
    function delete_post_meta_by($post,$net) {
        $CI = get_instance();
        // Load Networks Model
        $CI->load->model('networks');
        $user_id = get_instance()->ecl('Instance')->user();
        $CI->networks->delete_user_post_meta($user_id,$post,$net);
    }
}
if (!function_exists('edit_resend_meta_by')) {
    function edit_resend_meta_by($resend,$meta,$rule,$type) {
        $CI = get_instance();
        // Load Resend Model
        $CI->load->model('resend');
        // Get user by ID
        $user_id = get_instance()->ecl('Instance')->user();
        // Check if the user is the resend's author
        if($CI->resend->get_metas($user_id, $resend)){
            // Delete resend meta
            $check = $CI->resend->edit_resend_meta($resend,$meta,$rule,$type);
            if($check){
                echo json_encode(1);
            }
        }
    }
}
if (!function_exists('add_account_to_post')) {
    function add_account_to_post($post,$net) {
        $CI = get_instance();
        // Load Networks Model
        $CI->load->model('networks');
        // Load Posts Model
        $CI->load->model('posts');        
        $user_id = get_instance()->ecl('Instance')->user();
        // Gets network_name
        $network = $CI->networks->get_account($net);
        if($network) {
            $network_name = $network[0]->network_name;
            $res = $CI->posts->count_post_meta($post,$network_name);
            if($res) {
                if($res >= plan_feature('publish_accounts')) {
                    return '2';
                }
            }
        }
        $CI->networks->add_new_post_meta($user_id,$post,$net);
    }
}
if (!function_exists('planner_posts_by')) {
    function planner_posts_by($page,$by) {
        $CI = get_instance();
        // Load Resend Model
        $CI->load->model('resend');
        $limit = 10;
        $page--;
        $user_id = get_instance()->ecl('Instance')->user();
        $total = $CI->resend->get_posts($user_id,$by);
        $posts = $CI->resend->get_posts($user_id, $page * $limit, $limit, $by);
        if($posts){
            echo json_encode(['posts' => $posts, 'total' => count($total)]);
        }
    }
}
if (!function_exists('planner_emails_by')) {
    function planner_emails_by($page,$by) {
        $CI = get_instance();
        // Load Resend Model
        $CI->load->model('resend');
        $limit = 10;
        $page--;
        $user_id = get_instance()->ecl('Instance')->user();
        $total = $CI->resend->get_templates($user_id,$by);
        $templates = $CI->resend->get_templates($user_id, $page * $limit, $limit, $by);
        if($templates){
            echo json_encode(['templates' => $templates, 'total' => count($total)]);
        }
    }
}
if (!function_exists('planner_childs')) {
    function planner_childs($id) {
        $CI = get_instance();
        // Load Resend Model
        $CI->load->model('resend');
        $user_id = get_instance()->ecl('Instance')->user();
        $childrens = $CI->resend->get_metas($user_id,$id);
        if($childrens){
            echo json_encode($childrens);
        }
    }
}
if (!function_exists('get_meta_publishes')) {
    function get_meta_publishes($id) {
        $CI = get_instance();
        // Load Resend Model
        $CI->load->model('resend');
        $pubs = $CI->resend->get_meta_publishes($id);
        if($pubs) {
            return count($pubs);
        } else {
            return false;
        }
    }
}
if (!function_exists('day_by_time')) {
    function day_by_time($po,$time) {
        if(date('D',$po) == 'Mon'){
            return genitime(timea($po),1,$time);
        } else if(date('D',$po) == 'Tue'){
            return genitime(timea($po),2,$time);
        } else if(date('D',$po) == 'Wed'){
            return genitime(timea($po),3,$time);
        } else if(date('D',$po) == 'Thu'){
            return genitime(timea($po),4,$time);           
        } else if(date('D',$po) == 'Fri'){
            return genitime(timea($po),5,$time);            
        } else if(date('D',$po) == 'Sat'){
            return genitime(timea($po),6,$time);              
        } else if(date('D',$po) == 'Sun'){
            return genitime(timea($po),7,$time);            
        }
    }
}
if (!function_exists('get_sel_accounts_per_post')) {
    function get_sel_accounts_per_post($id) {
        $CI = get_instance();
        // Load Posts Model
        $CI->load->model('posts');
        $user_id = get_instance()->ecl('Instance')->user();
        $meta = $CI->posts->all_social_networks_by_post_id($user_id,$id);
        if($meta){
            echo json_encode($meta);
        }
    }
}
if (!function_exists('hour_minute')) {
    function hour_minute($time) {
        $a1 = substr($time,0,1);
        $a2 = substr($time,1,2);
        $a3 = substr($time,2,3);
        $a4 = substr($time,3,4);
        $a5 = substr($time,4,5);
        if(is_numeric($a1) && is_numeric(substr($a2,0,1)) && (substr($a3,0,1) == ':') && is_numeric($a4) && is_numeric($a5)){
            return '1';
        } else {
            return '0';
        }
    }
}
if (!function_exists('get_accounts_by_search')) {
    function get_accounts_by_search($net,$keys) {
        $CI = get_instance();
        // Load Networks Model
        $CI->load->model('networks');
        $user_id = get_instance()->ecl('Instance')->user();
        $accounts = $CI->networks->get_accounts($user_id,$net,0,$keys);
        if($accounts){
            echo json_encode($accounts);
        }
    }
}
if (!function_exists('the_time')) {
    function the_time() {
        if(date('D', time()) == 'Sun') {
            return strtotime('Today');
        } else {
            return strtotime('last Sunday');
        }
    }
}
if (!function_exists('resend_it')) {
    function resend_it($post_id,$args,$date) {
        $CI = get_instance();
        // Load Resend Model
        $CI->load->model('resend');
        $user_id = get_instance()->ecl('Instance')->user();
        $res_id = $CI->resend->save_resend($user_id,$date);
        if($res_id){
            $args = json_decode($args);
            if($args){
                $ch = 0;
                $act = (get_option('posts_planner_limit'))?get_option('posts_planner_limit'):'1';
                foreach ($args as $arg) {
                    if(($arg[0] > 0) && ($arg[0] < 8) && (hour_minute($arg[1]) > 0) && ($arg[2] > 0) && ($arg[2] < 5) && ($arg[3] > 0) && ($arg[3] < 13)){
                        if($CI->resend->save_meta($res_id,$arg[0],$arg[1],$arg[2],$arg[3]))
                        {
                            $ch++;
                            if($ch >= $act) {
                                break;
                            }
                        }
                    }
                }
                if($ch == 0){
                    $CI->resend->delete($res_id);
                } else {
                    $CI->resend->setup($post_id,$res_id);
                }
            }
        }
    }
}
if (!function_exists('resend_temp')) {
    function resend_temp($template_id,$args,$list_id,$date) {
        $CI = get_instance();
        // Load Resend Model
        $CI->load->model('resend');
        $user_id = get_instance()->ecl('Instance')->user();
        $res_id = $CI->resend->save_resend($user_id,$date);
        if($res_id) {
            $args = json_decode($args);
            if($args) {
                $ch = 0;
                $act = (get_option('emails_planner_limit'))?get_option('emails_planner_limit'):'1';
                foreach ($args as $arg) {
                    if(($arg[0] > 0) && ($arg[0] < 8) && (hour_minute($arg[1]) > 0) && ($arg[2] > 0) && ($arg[2] < 5) && ($arg[3] > 0) && ($arg[3] < 31)){
                        if($CI->resend->save_meta($res_id,$arg[0],$arg[1],$arg[2],$arg[3])) {
                            $ch++;
                            if($ch >= $act) {
                                break;
                            }
                        }
                    }
                }
                if($ch == 0) {
                    $CI->resend->delete($res_id,1);
                } else {
                    $CI->resend->setup_temp($template_id,$res_id,$list_id);
                }
            }
        }
    }
}
if (!function_exists('plafame')) {
    function plafame($time,$stamp) {
        return strtotime(date('Y-m-d',$stamp).' '.$time);
    }
}
if (!function_exists('get_plan_time')) {
    function get_plan_time($date) {
        return time();
    }
}
if (!function_exists('fofime')) {
    function fofime($a1,$a2,$a3,$a4,$a6,$a7) {
        $CI = get_instance();
        // Load Resend Model
        $CI->load->model('resend');
        // Load User_meta Model
        $CI->load->model('user_meta');        
        if(is_numeric($a1) && is_numeric($a2) && is_numeric($a3) && ($a3 > 0)){
            $e = 0;
            $pen = get_meta_publishes($a2);
            if(is_numeric($pen)) {
                if($pen >= $a4){
                    $e++;
                }
            }
            $a5 = 1;
            $posts_published = $CI->user_meta->get_all_user_options($a6);
            $posts_published = unserialize($posts_published['published_posts']);
            if (($posts_published['date'] == date('Y-m'))) {
                $posts_published = $posts_published['posts'];
            } else {
                $posts_published = 0;
            }
            // Load Plans Model
            $CI->load->model('plans');
            $posts = $CI->plans->get_plan_features($a6,'publish_posts');
            if($posts <= $posts_published) {
                $a5 = 2;
            }
            if($e == 0){
                if($CI->resend->save_rules($a1,$a2,($a3 - $a7),$a5)){
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
}
if (!function_exists('add_or_remove_post_group')) {
    function add_or_remove_post_group($a,$b,$c) {
        $CI = get_instance();
        // Load Lists Model
        $CI->load->model('lists');
        // Load Posts Model
        $CI->load->model('posts');
        // First verify if the user is the owner of the list
        $is_owner = $CI->lists->if_user_has_list($a, $c, 'social');
        if($is_owner) {
            // Then verify if the user is the post's owner
            $postu = $CI->posts->get_post($a, $b);
            if($postu) {
                if($postu['category'] == $c) {
                    if($CI->posts->update_group($a, $b, '')) {
                        return '3';
                    } else {
                        return '2';
                    }
                } else {
                    if($CI->posts->update_group($a, $b, $c)) {
                        return '1';
                    } else {
                        return '2';
                    }
                }
            }
        }
    }
}