<?php
/**
 * User Controller
 *
 * This file loads the Dashboard app in the user panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */

// Define the page namespace
namespace MidrubApps\Collection\Dashboard\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubApps\Collection\Dashboard\Helpers as MidrubAppsCollectionDashboardHelpers;

/*
 * User class loads the Dashboard app loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */
class User {
    
    /**
     * Class variables
     *
     * @since 0.0.7.0
     */
    protected $CI, $css_urls_widgets = array(), $js_urls_widgets = array();

    /**
     * Initialise the Class
     *
     * @since 0.0.7.0
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
        // Load Team Model
        $this->CI->load->model('team');
        
        // Load language
        if ( file_exists( MIDRUB_DASHBOARD_APP_PATH . '/language/' . $this->CI->config->item('language') . '/dashboard_user_lang.php' ) ) {
            $this->CI->lang->load( 'dashboard_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_DASHBOARD_APP_PATH . '/' );
        }
        
    }
    
    /**
     * The public method view loads the app's template
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function view() {
        
        // Get the user's plan
        $user_plan = get_user_option( 'plan', $this->CI->user_id );
        
        // Get plan end
        $plan_end = get_user_option( 'plan_end', $this->CI->user_id );
        
        // Get plan data
        $plan_data = $this->CI->plans->get_plan( $user_plan );
        
        // Set widgets
        $widgets = array();
        
        // Get default widgets
        $default_widgets = array();
        
        if ( get_option('app_dashboard_left_side_position') && get_option('app_dashboard_enable_default_widgets') ) {

            $full_size = 'col-xl-5';

            $plan_data[0]['size'] = 6;

        } else {

            $full_size = 'col-xl-12';

            $plan_data[0]['size'] = 3;

        }        

        if ( get_option('app_dashboard_enable_default_widgets') ) {
            
            foreach ( glob(MIDRUB_DASHBOARD_APP_PATH . '/widgets/*.php') as $filename ) {

                $className = str_replace( array( MIDRUB_DASHBOARD_APP_PATH . '/widgets/', '.php' ), '', $filename );

                // Create an array
                $array = array(
                    'MidrubApps',
                    'Collection',
                    'Dashboard',
                    'Widgets',
                    ucfirst($className)
                );       

                // Implode the array above
                $cl = implode('\\',$array);

                // Instantiate the class
                $response = (new $cl())->display_widget( $this->CI->user_id, $plan_end, $plan_data );

                // Add widget to $default_widgets array
                $default_widgets[$response['order']] = $response['widget'];

            }

            arsort($default_widgets);
            
            if ( $default_widgets ) {
                
                $widgets[0] = '<div class="' . $full_size . ' col-lg-12 col-md-12 stats">'
                                . '<div class="row">';

                $i = 0;
                
                foreach ( $default_widgets as $widget ) {
                    
                    if ( get_option('app_dashboard_left_side_position') && $i % 1 ) {
                        
                        $widgets[0] .= '</div><div class="row">';
                        
                    }
                    
                    $widgets[0] .= $widget;
                    
                    $i++;
                    
                }
                
                $widgets[0] .= '</div>'
                            . '</div>';
            
            }
        
        }
        
        $apps_widgets = array();
        
        foreach ( glob( MIDRUB_APPS_PATH . '/collection/*') as $directory ) {

            $dir = str_replace( MIDRUB_APPS_PATH . '/collection/', '', $directory );
            
            if ( !get_option('app_' . $dir . '_enable') || !plan_feature('app_' . $dir) ) {
                continue;
            }

            if ( $dir === 'dashboard' ) {
                
                continue;
                
            } else {
                
                // Create an array
                $array = array(
                    'MidrubApps',
                    'Collection',
                    ucfirst($dir),
                    'Main'
                );       

                // Implode the array above
                $cl = implode('\\',$array);

                // Instantiate the class
                $response = (new $cl())->widgets( $this->CI->user_id, $plan_end, $plan_data );
                
                foreach ( $response as $key => $value ) {
                    
                    // Add widget to $apps_widgets array
                    $apps_widgets[$key] = $value;
                    
                }
                
            }

        }

        if ( $apps_widgets ) {
            
            arsort($apps_widgets);
            
            $e = 0;
            
            foreach ( $apps_widgets as $key_w => $value_w ) {

                if ( $full_size === 'col-xl-5' && $e === 0 ) {

                    if ( !isset($widgets[0]) ) {
                        $widgets[0] = '';
                    }
                    
                    $widgets[0] .= str_replace( '[xl]', '7', $value_w['widget'] );
                    
                } else {
                    
                    $widgets[$key_w] = str_replace( '[xl]', '12', $value_w['widget'] );
                    
                }
                
                if ( $value_w['styles_url'] && !in_array( $value_w['styles_url'], $this->css_urls_widgets ) ) {
                    $this->css_urls_widgets[] = $value_w['styles_url'];
                }
                
                if ( $value_w['js_url'] && !in_array( $value_w['js_url'], $this->js_urls_widgets )  ) {
                    $this->js_urls_widgets[] = $value_w['js_url'];
                } 
                
                $e++;
                
            }
            
        }
        
        $this->CI->user_header = user_header();
        
        $this->CI->user_header['app'] = 'dashboard';
        
        $expired = 0;
        
        $expires_soon = 0;
        
        if ( $plan_end ) {
            
            if ( strtotime($plan_end) < time() ) {
                
                $this->CI->plans->delete_user_plan($this->CI->user_id);
                redirect('user/app/dashboard');
                
            } elseif ( strtotime($plan_end) < time() + 432000 ) {
                
                $expires_soon = 1;
                
            }
            
        }
        
        // Making temlate and send data to view.
        $this->CI->template['header'] = $this->CI->load->view('user/layout/header', array('app_styles' => $this->assets_css(), 'title' => $this->CI->lang->line('dashboard')), true);
        $this->CI->template['left'] = $this->CI->load->view('user/layout/left', $this->CI->user_header, true);
        $this->CI->template['body'] = $this->CI->load->ext_view( MIDRUB_DASHBOARD_APP_PATH .  '/views', 'main', array('widgets' => $widgets, 'expired' => $expired, 'expires_soon' => $expires_soon), true);
        $this->CI->template['footer'] = $this->CI->load->view('user/layout/footer', array('app_scripts' => $this->assets_js()), true);
        $this->CI->load->ext_view( MIDRUB_DASHBOARD_APP_PATH . '/views/layout', 'index', $this->CI->template);
        
    }
    
    public function array_sort($array, $on, $order = SORT_ASC) {
        
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
        
    }

    /**
     * The private method assets_css contains the app's css links
     * 
     * @since 0.0.7.0
     * 
     * @return string with css links
     */
    public function assets_css() {
        
        $data = '<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css?ver=' . MD_VER . '" media="all"/> ';
        $data .= "\n";
        $data .= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'assets/apps/dashboard/styles/css/dashboard.css?ver=' . MD_VER . '" media="all"/> ';
        $data .= "\n";
        
        if ( $this->css_urls_widgets ) {
            
            foreach ( $this->css_urls_widgets as $url ) {
                
                $data .= '<link rel="stylesheet" type="text/css" href="' . $url . '?ver=' . MD_VER . '" media="all"/> ';
                $data .= "\n";                
                
            }
            
        }
        
        return $data;
        
    }
    
    /**
     * The private method assets_js contains the app's javascript links
     * 
     * @since 0.0.7.0
     * 
     * @return string with javascript links
     */
    public function assets_js() {
        
        $data = '<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>';
        $data .= "\n";
        $data .= '<script src="//www.chartjs.org/dist/2.7.2/Chart.js"></script>';
        $data .= "\n";
        $data .= '<script src="//www.chartjs.org/samples/latest/utils.js"></script>';        
        $data .= "\n"; 
        $data .= '<script src="' . base_url() . 'assets/apps/dashboard/js/dashboard.js?ver=' . MD_VER . '"></script>';
        $data .= "\n";
        
        foreach ( $this->js_urls_widgets as $url ) {

            $data .= '<script src="' . $url . '?ver=' . MD_VER . '"></script>';
            $data .= "\n";                

        }        
        
        return $data;
        
    }

}
