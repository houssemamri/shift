<?php
/**
 * Smtp
 *
 * PHP Version 5.6
 *
 * Smtp contains the main Emails Section Class
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

/**
 * Smtp class - contains the main's methods for Email Marketing
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

class Smtp{
    
    public function __construct(){
        // Check if data was submited
        if (get_instance()->input->post()) {
            if(get_instance()->input->post('emails-upload') || @$_FILES['csv-file']['tmp_name'])
            {                
                $res = get_instance()->ecl('Cpost')->emails_upload();
                if($res)
                {
                    define('response',$res);
                }
            } else {
                get_instance()->ecl('Cpost');
            }
        }
    }
    
    /**
     * The function connect loads all Email Marketing Methods
     *
     * @param $args contains the query
     * @param $val contains the query's value
     */
    public function connect($args=NULL,$val=NULL){
        if($args == 'query')
        {
            exit();
        } elseif($args == 'campaign'){
            // Get Campaign by ID
            return get_instance()->ecl('Inc')->load($args,$val);
        } elseif($args == 'lists'){
            // Get List by ID
            return get_instance()->ecl('Inc')->load($args,$val);
        } elseif($args == 'schedules'){
            // Get List by ID
            return get_instance()->ecl('Inc')->load($args,$val);
        } elseif($args == 'shistory'){
            // Get Sent Templates
            return get_instance()->ecl('Inc')->load($args,$val);
        } elseif($args == 'upload'){
            // Upload email addresses to the list
            return get_instance()->ecl('Inc')->load($args,$val);
        } elseif($args == 'sent'){
            // Get Sent Emails
            return get_instance()->ecl('Inc')->load($args,$val); 
        } elseif($args == 'unsubscribed'){
            // Get Unsubscribed Emails
            return get_instance()->ecl('Inc')->load($args,$val);
        } elseif($args == 'unread'){
            // Get Unread Emails
            return get_instance()->ecl('Inc')->load($args,$val);
        } elseif($args == 'opened'){
            // Get Opened Emails
            return get_instance()->ecl('Inc')->load($args,$val);            
        } elseif($args == 'dcampaign'){
            // Delete Campaign by ID
            get_instance()->ecl('Inc')->load($args,$val); 
            exit();
        } elseif($args == 'dlist'){
            // Delete List by ID
            get_instance()->ecl('Inc')->load($args,$val); 
            exit();
        } elseif($args == 'get-templates'){
            // Get templates
            get_instance()->ecl('Inc')->load('get_templates',$val); 
            exit();
        } elseif($args == 'stemplate'){
            // Get Template content by ID
            get_instance()->ecl('Inc')->load($args,$val); 
            exit();            
        } elseif($args == 'dtemplate'){
            // Delete Template by ID
            get_instance()->ecl('Inc')->load($args,$val); 
            exit();
        } elseif($args == 'dsched'){
            // Delete Schedules by ID
            get_instance()->ecl('Inc')->load($args,$val); 
            exit();
        } elseif($args == 'dmeta'){
            // Delete Meta By ID and List
            get_instance()->ecl('Inc')->load($args,$val); 
            exit();
        } else{
            // Loads the main Email Marketing page
            return get_instance()->ecl('Inc')->load($args);
        }
    }
}