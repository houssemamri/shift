<?php
/**
 * Midrub's Autoload Classes
 *
 * This file contains function spl_autoload_register which
 * will loop through all Midrub's apps and include the file that matches the requested class
 *
 * @author Scrisoft
 * @package Midrub
 * @since   0.0.7.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// Register given function as __autoload() implementation
spl_autoload_register( 'midrub_apps_autoload_classes' );

/*
 * The function drasio_careers_plugin_autoload_classes will include a file which contains requested class
 * 
 * @param string $class contains the namespace and class name
 * 
 * @author Scrisoft
 * @package Midrub
 * @since   0.0.7.0
*/
function midrub_apps_autoload_classes( $class ) {
    
    // Replace slash
    $class_file = strtolower(
            
            str_replace(
                    array(
                        'MidrubApps\\',
                        '\\'
                    ),
                    array(
                        '',
                        '/'
                    ),
                    
            $class)
        );

    // Verify if exists
    if ( file_exists( dirname( __FILE__ ) . '/' . $class_file . '.php' ) ) {
        
        // Require the file
        require_once( dirname( __FILE__ ) . '/' . $class_file . '.php' );
        
    }
    
}

