<?php
/**
 * Midrub Apps Admin Plans Limits
 *
 * This file contains the class Plans
 * which processes the admin's plans limits
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.4
 */

// Define the page namespace
namespace MidrubApps\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Plans class processes the admin's plans limits
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.4
*/
class Plans {
    
    /**
     * Class variables
     */   
    private $plan_id;
    
    /**
     * The public method process processes plans options
     * 
     * @param integer $plan_id contains the plan's ID
     * @param array $options contains the option
     *
     * @since 0.0.7.4
     * 
     * @return void
     */ 
    public function process( $plan_id, $options ) {
        
        // Set the plan
        $this->plan_id = $plan_id;
        
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
                
                case 'textarea':
                    
                    $all_options .= $this->textarea( $option );
                    
                    break;
                
            }
            
        }
        
        return '<ul>' . $all_options . '</ul>';
        
    }
    
    /**
     * The protected method checkbox processes the plans option's type checkbox
     * 
     * @param array $option contains the option's information
     * 
     * @since 0.0.7.4
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
        
        if ( plan_feature( $option['name'], $this->plan_id ) === '1' ) {
            $checked = ' checked';
        }
        
        // Return html
        return '<li>'
                    . '<div class="row">'
                        . '<div class="col-lg-10">'
                            . '<h3>' . $option['title'] . '</h3>'
                            . '<p>' . $option['description'] . '</p>'
                        . '</div>'
                        . '<div class="col-lg-2">'
                            . '<div class="app-plans-option pull-right">'
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
     * @since 0.0.7.4
     * 
     * @return string with processed data
     */ 
    protected function text( $option ) {
        
        // Verify if option has correct format
        if ( ( $option['name'] == '') || ( $option['title'] == '') || ( $option['description'] == '') ) {
            return '';
        }
        
        // Verify if the option is enabled
        $value = '';
        
        if ( plan_feature( $option['name'], $this->plan_id ) ) {
            $value = plan_feature( $option['name'], $this->plan_id );
        }
        
        $maxlength = '';
        
        if ( isset($option['maxlength']) ) {
            $maxlength = ' maxlength="12"';
        }  
        
        $type = 'text';
        
        if ( isset($option['input_type']) ) {
            $type = $option['input_type'];
        }         
        
        // Return html
        return '<li>'
                    . '<div class="row">'
                        . '<div class="col-lg-8">'
                            . '<h3>' . $option['title'] . '</h3>'
                            . '<p>' . $option['description'] . '</p>'
                        . '</div>'
                        . '<div class="col-lg-4">'
                            . '<div class="app-plans-option pull-right">'
                                . '<input id="' . $option['name'] . '" name="' . $option['name'] . '" value="' . $value . '" class="app-plan-input" type="' . $type . '"' . $maxlength . '>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</li>';
        
    }
    
    /**
     * The protected method textarea processes the option's type textarea
     * 
     * @param array $option contains the option's information
     * 
     * @since 0.0.7.4
     * 
     * @return string with processed data
     */ 
    protected function textarea( $option ) {
        
        // Verify if option has correct format
        if ( ( @$option['name'] == '') || ( @$option['title'] == '') || ( @$option['description'] == '') ) {
            return '';
        }
        
        // Verify if the option is enabled
        $value = '';
        
        if ( plan_feature( $option['name'], $this->plan_id ) ) {
            $value = plan_feature( $option['name'], $this->plan_id );
        }
        
        // Return html
        return '<li>'
                    . '<div class="row">'
                        . '<div class="col-lg-8">'
                            . '<h3>' . $option['title'] . '</h3>'
                            . '<p>' . $option['description'] . '</p>'
                        . '</div>'
                        . '<div class="col-lg-4">'
                            . '<div class="app-plans-option pull-right">'
                                . '<textarea id="' . $option['name'] . '" name="' . $option['name'] . '" class="app-plan-input">' . $value . '</textarea>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</li>';
        
    }
    
}

