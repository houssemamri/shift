<?php
/**
 * Clist
 *
 * PHP Version 5.6
 *
 * Clist contains the Lists Model Helper
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

/**
 * Clist class - gets, saves and deletes data from the table lists and lists_meta
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

class Clist{
    /**
     * Load the lists model
     */
    public function __construct(){
        get_instance()->load->model('lists');
    }

    /**
     * The function create creates a new list
     *
     * @param $n contains the list's name
     * @param $d contains the list's description
     */
    public function create($n,$d){
        if(get_instance()->ecl('Instance')->mod('lists', 'save_list', [get_instance()->ecl('Instance')->user(),'email',$n,$d])) {
            display_mess(112);
        } else {
            display_mess(113);
        }
    }
    
    /**
     * The function delete_list deletes a list
     *
     * @param $val contains the list's ID
     */
    public function delete_list($val){
        if(get_instance()->ecl('Instance')->mod('lists', 'delete_list', [get_instance()->ecl('Instance')->user(),$val])) {
            echo 1;
        } else {
            echo 0;
        }
    }
    
    /**
     * The function uploads uploads emails on list
     *
     * @param $val contains the emails
     */
    public function upload($list,$val){
        $emails = explode('<br>', nl2br($val, false));
        if($emails)
        {
            $verify = 0;
            
            foreach ($emails as $email) {
                $email = trim($email);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                    if(!get_instance()->ecl('Instance')->mod('lists', 'if_item_is_in_list', [get_instance()->ecl('Instance')->user(),$list,$email])){
                        if ( get_instance()->ecl('Instance')->mod('lists', 'upload_to_list', [get_instance()->ecl('Instance')->user(),$list,$email]) ) {
                            $verify++;
                        }
                    }
                }
            }
            
            if ( $verify ) {
                
                return display_mess(119);
                
            } else {
                
                return display_mess(120);
                
            }
            
            return display_mess(119);
            
        } else {
            return display_mess(120);
        }
    }
    
    /**
     * The function extract_upload extracts and uploads emails from csv
     *
     * @param $list contains the list's ID
     * @param $val contains the emails
     */
    public function extract_upload($list,$val){
        $row = 0;
        if (($handle = fopen($val, 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $num = count($data);
                $row++;
                for ($c=0; $c < $num; $c++) {
                    $email = trim($data[$c]);
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                        if(!get_instance()->ecl('Instance')->mod('lists', 'if_item_is_in_list', [get_instance()->ecl('Instance')->user(),$list,$email])){
                            get_instance()->ecl('Instance')->mod('lists', 'upload_to_list', [get_instance()->ecl('Instance')->user(),$list,$email]);
                        }
                    }
                }
            }
            fclose($handle);
            return display_mess(119);
        } else {
            return display_mess(120);
        }
    }
    
    /**
     * The function delete_email deletes emails from database
     *
     * @param $list contains the list's ID
     * @param $val contains the email's ID
     */
    public function delete_email($list,$val){
        if(get_instance()->ecl('Instance')->mod('lists', 'delete_meta', [get_instance()->ecl('Instance')->user(),$list,$val]))
        {
            echo 1;
        } else {
            echo 0;
        }
    }
    
    /**
     * The function get_user_list check if the user has the list
     *
     * @param $list contains the list_id
     */
    public function get_user_list($list){
        if(get_instance()->ecl('Instance')->mod('lists', 'if_user_has_list', [get_instance()->ecl('Instance')->user(),$list,'email'])){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * The function user_lists gets user's lists
     *
     * @param $user_id contains the user_id
     * @return lists or false
     */
    public function user_lists(){
        return get_instance()->ecl('Instance')->mod('lists', 'user_lists', [get_instance()->ecl('Instance')->user(),'email']);
    }    
}