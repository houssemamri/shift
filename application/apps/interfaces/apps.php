<?php
/**
 * Tools
 *
 * PHP Version 5.6
 *
 * Apps Interface for Midrub's Apps
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

// Define the page namespace
namespace MidrubApps\Interfaces;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Apps interface - allows to create apps for Midrub
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
interface Apps {
    
    /**
     * The public method user loads the app's main page in the user panel
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function user();

    /**
     * The public method widgets displays the app's widgets if are enabled
     * 
     * @since 0.0.7.0
     * 
     * @param integer $user_id contains the user's ID
     * @param integer $plan_end contains the time when plan subscription ends
     * @param object $plan_data contains the plan's information
     * 
     * @return array with widgets or false
     */
    public function widgets( $user_id, $plan_end, $plan_data );
    
    /**
     * The public method activities returns the templates for activities
     * 
     * @since 0.0.7.0
     * 
     * @param integer $user_id contains the user's ID
     * @param integer $member_id contains the member's ID
     * @param string $template contains the template's name
     * @param integer $id contains the identificator for the requested template
     * 
     * @return array with template or false
     */
    public function activities( $user_id, $member_id, $template, $id );

    /**
     * The public method user_options displays the app's options for user
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function user_options();
    
    /**
     * The public method admin_options displays the app's options for admin
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function admin_options();
    
    /**
     * The public method plan_limits displays the options for the plans
     * 
     * @since 0.0.7.0
     * 
     * @param integer $plan_id contains the plan's ID
     * 
     * @return void
     */
    public function plan_limits($plan_id);
    
    /**
     * The public method ajax processes the ajax's requests
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function ajax();
    
    /**
     * The public method cron_jobs loads the cron jobs commands
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function cron_jobs();
    
    /**
     * The public method delete_account is called when user's account is deleted
     * 
     * @param integer $user_id contains the user's ID
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */
    public function delete_account($user_id);
    
    /**
     * The public method hooks contains the app's hooks
     * 
     * @param array $args contains the parameters
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    public function hooks($args);
    
    /**
     * The public method app_info contains the app's info
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function app_info();
    
}
