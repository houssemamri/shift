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
require_once 'constants.php';
require_once 'Load.php';
/**
 * The function be_post gets the children of a post
 * 
 * @param $param contains the Post's ID
 */ 
if (!function_exists('be_post')) {
    function be_post($param) {
        if(is_numeric($param))
        {
            $ed = Ceil::cl('Views')->les(Ceil::cl('Instance')->mod('posts', 'cildrens', [$param]));
            return $ed;
        }
        else{
            return false;
        }
    }
}
/**
 * The function be_time calculates the time
 * 
 * @param $param contains the time string
 */ 
if (!function_exists('be_time')) {
    function be_time($param) {
        if(is_numeric($param))
        {
            switch($param)
            {
                case '1':
                    return '3600';
                    break;
                case '2':
                    return '7200';
                    break;
                case '3':
                    return '43200';
                    break;
                case '4':
                    return '86400';
                    break;
                case '5':
                    return '604800';
                    break;
                case '6':
                    return '2592000';
                    break;                
            }
        }
        else{
            return false;
        }
    }
}
/**
 * Schedules the posts
 */  
if (get_instance()->input->get('action', TRUE) == 'schedmu') {
    $id = get_instance()->input->get('id', TRUE);
    $time = get_instance()->input->get('time', TRUE);
    $o = new Load();
    if(be_time($time) && is_numeric($id))
    {
        if($o->time_sched($id,be_time($time)))
        {
            echo 1;
        }   
    }
}
/**
 * Schedule a post
 */
if (get_instance()->input->get('action', TRUE) == 'spm') {
    if ($this->input->post()) {
        $this->form_validation->set_rules('msg', 'Date', 'trim');
        $this->form_validation->set_rules('cd', 'Current Date', 'trim|required');
        $this->form_validation->set_rules('act', 'ACT ID', 'trim|integer|required');
        // Get data
        $msg = $this->security->xss_clean(base64_decode($this->input->post('msg')));
        $cd = $this->security->xss_clean(base64_decode($this->input->post('cd')));
        $act = $this->input->post('act');
        if ($this->form_validation->run()) {
            $o = new Load();
            $p = @(array)$o->scrp(strtotime($msg),strtotime($cd),$act);
            if(@$p['parent'])
            {
                echo json_encode(be_post($p['parent']));
            }
        }
        else{
            echo 0;
        }
    }
}
/**
 * Mark an activity as seen
 */
if (get_instance()->input->get('action', TRUE) == 'seen') {
    $id = get_instance()->input->get('id', TRUE);
    $o = new Load();
    if($o->seen($id))
    {
        echo 1;
    }
}
/**
 * Add a new comment
 */
if (get_instance()->input->get('action', TRUE) == 'comment') {
    if ($this->input->post()) {
        $this->form_validation->set_rules('msg', 'Comment', 'trim|required');
        $this->form_validation->set_rules('post', 'Post ID', 'trim|required');
        $this->form_validation->set_rules('act', 'ACT ID', 'trim|integer|required');
        $this->form_validation->set_rules('account', 'Account ID', 'trim|integer|required');
        // Get data
        $msg = $this->input->post('msg');
        $post = $this->input->post('post');
        $account = $this->input->post('account');
        $act = $this->input->post('act');
        if ($this->form_validation->run()) {
            $o = new Load();
            echo json_encode($o->com($msg,$post,$account,$act));
        }
        else{
            echo 0;
        }
    }
}
/**
 * Schedule when a post will be deleted
 */
if (get_instance()->input->get('action', TRUE) == 'add-del') {
    if ($this->input->post()) {
        $this->form_validation->set_rules('msg', 'Date', 'trim');
        $this->form_validation->set_rules('cd', 'Current Date', 'trim|required');
        $this->form_validation->set_rules('act', 'ACT ID', 'trim|integer|required');
        // Get data
        $msg = $this->security->xss_clean(base64_decode($this->input->post('msg')));
        $cd = $this->security->xss_clean(base64_decode($this->input->post('cd')));
        $act = $this->input->post('act');
        if ($this->form_validation->run()) {
            $o = new Load();
            echo json_encode(['res'=>$o->set_d(strtotime($msg),strtotime($cd),$act),'tm'=>time()]);
        }
        else{
            echo 0;
        }
    }
}
/**
 * Checks for new comments
 */
if (get_instance()->input->get('action', TRUE) == 'check') {
    $o = new Load();
    $o->check();
}
/**
 * Checks for new likes
 */
if (get_instance()->input->get('action', TRUE) == 'check-likes') {
    $o = new Load();
    $o->check_likes();
}
/**
 * Gets posts which must be deleted
 */
if (get_instance()->input->get('action', TRUE) == 'schedel') {
    $o = new Load();
    var_dump($o->apublish());
}
/**
 * Checks if some post must be deleted
 */
if (get_instance()->input->get('action', TRUE) == 'check-del') {
    $o = new Load();
    var_dump($o->check_del());
}
/**
 * Deletes a comment
 */
if (get_instance()->input->get('action', TRUE) == 'del-com') {
    $comment = get_instance()->input->get('comment', TRUE);
    $act = get_instance()->input->get('act', TRUE);
    $account = get_instance()->input->get('account', TRUE);
    if(($comment != '') && ($act != '') && ($account != ''))
    {
        $o = new Load();
        echo json_encode($o->dcom($comment,$account,$act));
    }
}
/**
 * Replies to a comment
 */
if (get_instance()->input->get('action', TRUE) == 'add-reply') {
    if ($this->input->post()) {
        $this->form_validation->set_rules('msg', 'Comment', 'trim|required');
        $this->form_validation->set_rules('post', 'Post ID', 'trim|required');
        $this->form_validation->set_rules('act', 'ACT ID', 'trim|integer|required');
        $this->form_validation->set_rules('account', 'Account ID', 'trim|integer|required');
        // Get data
        $msg = $this->input->post('msg');
        $post = $this->input->post('post');
        $account = $this->input->post('account');
        $act = $this->input->post('act');
        if ($this->form_validation->run()) {
            $o = new Load();
            echo json_encode($o->com($msg,$post,$account,$act));
        }
        else{
            echo 0;
        }
    }
}