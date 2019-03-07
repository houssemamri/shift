<?php
/**
 * Sched_load
 *
 * PHP Version 5.6
 *
 * List_load contains the Sched Model Helper
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

/**
 * Sched_load class - gets, saves and deletes data from the table sched_load
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Sched_load{
    
    /**
     * The function get gets schedules
     *
     * @param $val contains the campaign's ID
     */
    public function get($val){
        get_instance()->ecl('Sched')->get_scheduleds($val);
    }

    /**
     * The function sent gets sent templates
     *
     * @param $val contains the campaign's ID
     * @param $page contains the page number
     */
    public function sent($val,$page){
        get_instance()->ecl('Sched')->get_sent($val,$page);
    }
    
    /**
     * The function sents gets receiver emails
     *
     * @param $val contains the scheduled's ID
     */
    public function sents($val){
        get_instance()->efl('sent');
        return temp($val,'sent');
    }
    
    /**
     * The function unsubscribed gets unsubscribed emails
     *
     * @param $val contains the scheduled's ID
     */
    public function unsubscribed($val){
        get_instance()->efl('sent');
        return temp($val,'unsubscribed');
    }
    
    /**
     * The function unread gets unread emails
     *
     * @param $val contains the scheduled's ID
     */
    public function unread($val){
        get_instance()->efl('sent');
        return temp($val,'unread');
    }
    
    /**
     * The function opened gets opened emails
     *
     * @param $val contains the scheduled's ID
     */
    public function opened($val){
        get_instance()->efl('sent');
        return temp($val,'opened');
    }    
    
    /**
     * The function delete deletes a Schedules
     *
     * @param $val contains the scheduled's ID
     */
    public function delete($val){
        get_instance()->ecl('Sched')->delete_schedules($val);
    }
}