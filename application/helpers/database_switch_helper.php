<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function switch_database($database_host,$database_username,$database_password,$database)
{
     $app_config = array(
            'hostname' => $database_host,
            'username' => $database_username,
            'password' => $database_password,
            'database' => $database,
            'dbdriver' => 'mysqli',
            'dbprefix' => '',
            'pconnect' => FALSE,
            'db_debug' => TRUE
        );
    return $app_config;
}
