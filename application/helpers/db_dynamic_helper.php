<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function switch_db_dynamic($db_host,$db_user,$db_password,$db_database)
{
     $config_app = array(
            'hostname' => $db_host,
            'username' => $db_user,
            'password' => $db_password,
            'database' => $db_database,
            'dbdriver' => 'mysqli',
            'dbprefix' => '',
            'pconnect' => FALSE,
            'db_debug' => TRUE
        );
    return $config_app;       
}
