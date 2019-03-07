<?php
/**
 * Apps Functions
 *
 * PHP Version 5.6
 *
 * I've created this file for default Apps methods
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
if ( !defined('BASEPATH') ) {
    exit('No direct script access allowed');
}


if ( !function_exists( 'app_load_hooks' ) ) {
    
    /**
     * The function app_load_hooks calls all hooks
     * 
     * @param array $args contains the hooks arguments
     * 
     * @return voi
     */
    function app_load_hooks( $args ) {
        
        // List all apps
        foreach (glob(APPPATH . 'apps/collection/*', GLOB_ONLYDIR) as $dir) {

            $app = trim(ucfirst(basename($dir).PHP_EOL));
            
            // Create an array
            $array = array(
                'MidrubApps',
                'Collection',
                $app,
                'Main'
            );       

            // Implode the array above
            $cl = implode('\\',$array);

            // Instantiate the class
            (new $cl())->hooks( $args );

        }
        
    }
    
}