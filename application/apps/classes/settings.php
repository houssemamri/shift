<?php
/**
 * Midrub Apps User Settings
 *
 * This file contains the class Options
 * which processes the user's options fields
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.5
 */

// Define the page namespace
namespace MidrubApps\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Settings class processes the user's options fields
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.5
*/
class Settings {
    
    /**
     * The public method process processes the user's options fields 
     * 
     * @param array $options contains the options
     *
     * @since 0.0.7.5
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
                
                case 'textedit':
                    
                    $all_options .= $this->textedit( $option );
                    
                    break;  
                
                case 'modal_link':
                    
                    $all_options .= $this->modal_link( $option );
                    
                    break;                 
                
            }
            
        }
        
        return $all_options;
        
    }
    
    /**
     * The protected method checkbox processes the option's type checkbox
     * 
     * @param array $option contains the option's information
     * 
     * @since 0.0.7.5
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
        
        if ( get_user_option( $option['name'] ) ) {
            $checked = 'checked';
        }
        
        // Return html
        return '<li>'
                    . '<div class="row">'
                        . '<div class="col-xl-10 col-md-10 col-8">'
                            . '<h4>' . $option['title'] . '</h4>'
                            . '<p>' . $option['description'] . '</p>'
                        . '</div>'
                        . '<div class="col-xl-2 col-md-2 col-4">'
                            . '<div class="checkbox-option pull-right">'
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
     * @since 0.0.7.5
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
        
        if ( get_user_option( $option['name'] ) ) {
            $value = get_user_option( $option['name'] );
        }
        
        // Return html
        return '<li>'
                    . '<div class="row">'
                        . '<div class="col-xl-8 col-md-8 col-8">'
                            . '<h4>' . $option['title'] . '</h4>'
                            . '<p>' . $option['description'] . '</p>'
                        . '</div>'
                        . '<div class="col-xl-4 col-md-4 col-4">'
                            . '<div class="app-settings-option pull-right">'
                                . '<input id="' . $option['name'] . '" name="' . $option['name'] . '" value="' . $value . '" class="app-option-input" type="text">'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</li>';
        
    }
        
        
    /**
     * The protected method textedit processes the option's type textedit
     * 
     * @param array $option contains the option's information
     * 
     * @since 0.0.7.5
     * 
     * @return string with processed data
     */ 
    protected function textedit( $option ) {
        
        // Verify if option has correct format
        if ( ( @$option['name'] == '') || ( @$option['title'] == '') || ( @$option['description'] == '') ) {
            return '';
        }
        
        // Verify if the option is enabled
        $value = '';
        
        if ( get_user_option( $option['name'] ) ) {
            $value = get_user_option( $option['name'] );
        }
        
        $edit = '';
        
        if ( $option['edit'] ) {
            
            $edit = '<button type="button" class="btn btn-settings-edit-text btn-light">'
                        . '<i class="icon-note"></i>'
                    . '</button>';
            
        }
        
        // Return html
        return '<li>'
                    . '<div class="row">'
                        . '<div class="col-xl-7 col-md-7 col-7">'
                            . '<h4>' . $option['title'] . '</h4>'
                            . '<p>' . $option['description'] . '</p>'
                        . '</div>'
                        . '<div class="col-xl-5 col-md-5 col-5">'
                            . '<div class="textarea-option disabled pull-right">'
                                . '<input id="' . $option['name'] . '" name="' . $option['name'] . '" type="text" value="' . $value . '" class="app-option-input"></input>'
                                . $edit
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</li>';
        
        
    } 
    
    /**
     * The protected method modal_link processes the option's type modal's link
     * 
     * @param array $option contains the option's information
     * 
     * @since 0.0.7.5
     * 
     * @return string with processed data
     */ 
    protected function modal_link( $option ) {
        
        // Verify if option has correct format
        if ( ( @$option['name'] == '') || ( @$option['title'] == '') || ( @$option['description'] == '') ) {
            return '';
        }
        
        // Return html
        return '<li>'
                    . '<div class="row">'
                        . '<div class="col-xl-7 col-md-7 col-7">'
                            . '<h4>' . $option['title'] . '</h4>'
                            . '<p>' . $option['description'] . '</p>'
                        . '</div>'
                        . '<div class="col-xl-5 col-md-5 col-5 text-right">'
                            . '<a href="#" data-toggle="modal" data-target="#' . $option['name'] . '">' . $option['modal_link'] . '</a>'
                        . '</div>'
                    . '</div>'
                . '</li>';
        
        
    }     
    
}

