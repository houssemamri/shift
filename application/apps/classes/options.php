<?php
/**
 * Midrub Apps Admin Options
 *
 * This file contains the class Options
 * which processes the admin's options
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */

// Define the page namespace
namespace MidrubApps\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Options class processes the admin's options
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
*/
class Options {
    
    /**
     * The public method process processes options
     * 
     * @param array $options contains the options
     *
     * @since 0.0.7.0
     * 
     * @return void
     */ 
    public function process( $options ) {
        
        // Define all_options variable
        $all_options = '';
        
        // List all available options
        foreach ( $options as $option ) {
            
            // Call a method by option's type
            switch ( $option['type'] ) {               
                
                case 'checkbox':
                    
                    $all_options .= $this->checkbox( $option );
                    
                    break;
                
                case 'text':
                    
                    $all_options .= $this->text( $option );
                    
                    break;
                
            }
            
        }
        
        return '<ul>' . $all_options . '</ul>';
        
    }
    
    /**
     * The protected method checkbox processes the option's type checkbox
     * 
     * @param array $option contains the option's information
     * 
     * @since 0.0.7.0
     * 
     * @return string with processed data
     */ 
    protected function checkbox( $option ) {
        
        // Verify if option has correct format
        if ( ( @$option['name'] == '') || ( @$option['title'] == '') || ( @$option['description'] == '') ) {
            return '';
        }

        // Verify if the option is enabled
        $checked = '';
        
        if ( get_option( $option['name'] ) ) {
            $checked = 'checked';
        }
        
        // Return html
        return '<li>'
                    . '<div class="row">'
                        . '<div class="col-lg-10">'
                            . '<h3>' . $option['title'] . '</h3>'
                            . '<p>' . $option['description'] . '</p>'
                        . '</div>'
                        . '<div class="col-lg-2">'
                            . '<div class="app-settings-option pull-right">'
                                . '<input id="' . $option['name'] . '" name="' . $option['name'] . '" class="app-option-checkbox" type="checkbox" ' . $checked . '>'
                                . '<label for="' . $option['name'] . '"></label>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</li>';
        
    }
    
    /**
     * The protected method text processes the option's type text
     * 
     * @param array $option contains the option's information
     * 
     * @since 0.0.7.0
     * 
     * @return string with processed data
     */ 
    protected function text( $option ) {
        
        // Verify if option has correct format
        if ( ( @$option['name'] == '') || ( @$option['title'] == '') || ( @$option['description'] == '') ) {
            return '';
        }
        
        // Verify if the option is enabled
        $value = '';
        
        if ( get_option( $option['name'] ) ) {
            $value = get_option( $option['name'] );
        }
        
        // Return html
        return '<li>'
                    . '<div class="row">'
                        . '<div class="col-lg-8">'
                            . '<h3>' . $option['title'] . '</h3>'
                            . '<p>' . $option['description'] . '</p>'
                        . '</div>'
                        . '<div class="col-lg-4">'
                            . '<div class="app-settings-option pull-right">'
                                . '<input id="' . $option['name'] . '" name="' . $option['name'] . '" value="' . $value . '" class="app-option-input" type="text">'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</li>';
        
    }  
    
}

