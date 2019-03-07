<?php
/**
 * List_load
 *
 * PHP Version 5.6
 *
 * List_load contains the Lists Model Helper
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

/**
 * List_load class - gets, saves and deletes data from the table lists and lists_meta
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class List_load{
    
    /**
     * The function details gets list's details
     *
     * @param $val contains the list_id
     */
    public function details($val){
        get_instance()->efl('list');
        return temp($val);
    }
    
    /**
     * The function delete deletes a list by ID
     *
     * @param $val contains the list_id
     */
    public function delete($val){
        get_instance()->ecl('Clist')->delete_list($val);
    }
    
    /**
     * The function upload uploads emails to a list
     *
     * @param $val contains the list_id
     */
    public function upload($val){
        get_instance()->efl('upload');
        return temp($val);
    }
    
    /**
     * The function upload uploads emails to a list
     *
     * @param $val contains the emails
     * @param $list contains the list_id
     */
    public function delete_meta($val,$list){
        get_instance()->ecl('Clist')->delete_email($val,$list);
    }  
}