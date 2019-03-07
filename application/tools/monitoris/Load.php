<?php
/**
 * Load
 *
 * PHP Version 5.6
 *
 * The File Load loads the Monitoris's library
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
require_once 'dir/Ceil.php';
/**
 * Load - loads the Monitoris's library
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Load {
    /**
     * The function seen mark an activity as seen
     *
     * @param $act contains the activity's ID
     */
    public function seen($act) {
        return Ceil::seen($act);
    }
    
    /**
     * The function show the activities
     */    
    public function show() {
        if(get_instance()->input->get('page', TRUE)) {
            $page = get_instance()->input->get('page', TRUE);
            $net = get_instance()->input->get('net', TRUE);
            return Ceil::all($page,$net);
        } else if(get_instance()->input->get('act', TRUE)) {
            $act = get_instance()->input->get('act', TRUE);
            return Ceil::load_single($act);
        } else {
            return Ceil::all();
        }
    }
    
    /**
     * The function time_sched schedules the posts
     * 
     * @param $id contains the post's ID
     * @param $time contains the scheduled time
     */ 
    public function time_sched($id,$time) {
        return Ceil::schedu($id,$time);
    }
    
    /**
     * The function scrp will schedule a post
     * 
     * @param $msg contains the scheduled time
     * @param $cd contains the current time
     * @param $act contains the activity's id
     */     
    public function scrp($msg,$cd,$act) {
        return Ceil::rep($msg,$cd,$act);
    }
    
    /**
     * The function com publishes a comment
     * 
     * @param $msg contains the comment
     * @param $post contains the post's ID
     * @param $account contains the network ID
     * @param $act contains the activity's ID
     */ 
    public function com($msg,$post,$account,$act) {
        return Ceil::com($msg,$post,$account,$act);
    }
    
    /**
     * The function set_d allows you to schedule the deletion of a post
     * 
     * @param $msg contains the scheduled time
     * @param $cd contains the current time
     * @param $act contains the activity's ID
     */
    public function set_d($msg,$cd,$act) {
        return Ceil::set_d($msg,$cd,$act);
    }
    
    /**
     * The function check checks for new comments
     */
    public function check() {
        Ceil::netu();
    }
    
    /**
     * The function check checks for new likes
     */
    public function check_likes() {
        return Ceil::liku();
    }
    
    /**
     * The function dcom deletes a comment
     * 
     * @param $comment contains the comment's ID
     * @param $account contains the network's account ID
     * @param $act contains the activity's ID
     */
    public function dcom($comment,$account,$act) {
        return Ceil::dcom($comment,$account,$act);
    }
    
    /**
     * The function check_del check if some post must be deleted
     */
    public function check_del() {
        return Ceil::delu();
    }
    
    /**
     * The function apublish gets posts which must be deleted
     */    
    public function apublish() {
        return Ceil::apublish();
    } 
}
