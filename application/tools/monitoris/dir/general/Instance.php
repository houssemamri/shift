<?php
/**
 * Instance
 *
 * PHP Version 5.6
 *
 * The File Instance contains the Instance Class
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

/**
 * Instance - manage the database tables
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Instance{
    
    /**
     * The function connect gets the Controller super-object 
     */
    public static function connect(){
        return get_instance();
    }
    
    /**
     * The function mod gets a model method
     * 
     * @param $name contains the model's name
     * @param $function the model's method
     * @param $value contains an array with variables
     */ 
    public static function mod($name,$function,$value=[]){
        self::connect()->load->model($name);
        if(array_key_exists('0',$value) && !array_key_exists('1',$value))
        {
            return self::connect()->$name->$function($value[0]);
        }
        if(array_key_exists('1',$value) && !array_key_exists('2',$value))
        {
            return self::connect()->$name->$function($value[0],$value[1]);
        }
        if(array_key_exists('2',$value) && !array_key_exists('3',$value))
        {
            return self::connect()->$name->$function($value[0],$value[1],$value[2]);
        }
        if(array_key_exists('3',$value) && !array_key_exists('4',$value))
        {
            return self::connect()->$name->$function($value[0],$value[1],$value[2],$value[3]);
        }
        if(array_key_exists('4',$value) && !array_key_exists('8',$value))
        {
            return self::connect()->$name->$function($value[0],$value[1],$value[2],$value[3],$value[4],$value[5],$value[6],$value[7]);
        }
        else{
            return self::connect()->$name->$function();
        }
    }
    
    /**
     * The function user gets the current user_id
     */
    public static function user(){
        return self::connect()->user->get_user_id_by_username(self::connect()->session->userdata["username"]);
    }    
}