<?php
class Instance{
    public static function connect(){
        return get_instance();
    }
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
        if(array_key_exists('4',$value) && !array_key_exists('5',$value))
        {
            return self::connect()->$name->$function($value[0],$value[1],$value[2],$value[3],$value[4]);
        } 
        if(array_key_exists('5',$value) && !array_key_exists('6',$value))
        {
            return self::connect()->$name->$function($value[0],$value[1],$value[2],$value[3],$value[4],$value[5]);
        } 
        if(array_key_exists('4',$value) && !array_key_exists('8',$value))
        {
            return self::connect()->$name->$function($value[0],$value[1],$value[2],$value[3],$value[4],$value[5],$value[6],$value[7]);
        }
        else{
            return self::connect()->$name->$function();
        }
    }
    public static function user(){
        if(@self::connect()->session->userdata['username']) {
            return self::connect()->user->get_user_id_by_username(self::connect()->session->userdata['username']);
        }
    }    
}