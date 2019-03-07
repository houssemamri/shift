<?php
/**
 * Functions
 *
 * PHP Version 5.6
 *
 * In this file is used to process the ajax requests
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

// This function returns the main CodeIgniter object
$CI = get_instance();
        
/**
 * Verify if the key is valid
 */
if ( $CI->input->get('action', TRUE) == 'check-key' ) {
    
    if ( $CI->input->get('key', TRUE) ) {
        $apikey = $CI->input->get('key', TRUE);
        $key = explode('-', $apikey);
        if ( count($key) > 1 ) {
            $results = get('https://' . $key[1] . '.api.mailchimp.com/3.0/lists?apikey=' . $apikey);
            if ( $results ) {

                $results = json_decode($results);
                if ( @$results->lists ) {

                    echo json_encode($key[1]);

                }

            }
        }
    }
    
}

/**
 * Gets the lists
 */
if ( $CI->input->get('action', TRUE) == 'get-lists' ) {
    
    if ( $CI->input->get('key', TRUE) ) {
        $apikey = $CI->input->get('key', TRUE);
        $datacenter = $CI->input->get('datacenter', TRUE);
        if ( $datacenter ) {
            $results = get('https://' . $datacenter . '.api.mailchimp.com/3.0/lists?apikey=' . $apikey);
            if ( $results ) {

                $results = json_decode($results);
                if ( @$results->lists ) {

                    echo json_encode( $results->lists );

                }

            }
        }
    }
    
}

/**
 * Download emails
 */
if ( $CI->input->get('action', TRUE) == 'download' ) {
    
    // Verify if the key exists
    if ( $CI->input->get('key', TRUE) ) {
        
        // Gets variables
        $apikey = $CI->input->get('key', TRUE);
        $datacenter = $CI->input->get('datacenter', TRUE);
        $mlist = $CI->input->get('mlist', TRUE);
        $list = $CI->input->get('list', TRUE);
        
        // Verify if variables aren't empty
        if ( ( $mlist != '' ) && ($datacenter != '') && ( $list != '' ) ) {
            
            // Verify if the user has the list
            if ( $CI->ecl('Instance')->mod('lists', 'if_user_has_list', [$CI->ecl('Instance')->user(),$list,'email'] ) ) {
                
                // Get all eail addresses
                $results = get('https://' . $datacenter . '.api.mailchimp.com/3.0/lists/' . $mlist . '/members?apikey=' . $apikey);
                if ( $results ) {

                    $results = json_decode($results);

                    if ( @$results->members ) {
                        
                        $total = 0;
                        foreach ( $results->members as $member ) {
                            
                            // Verify if the email isn't in the list
                            if ( !$CI->ecl('Instance')->mod( 'lists', 'if_item_is_in_list', [$CI->ecl('Instance')->user(),$list,$member->email_address] ) ) {
                                
                                // Save email in the email list
                                if ( $CI->ecl('Instance')->mod( 'lists', 'upload_to_list', [ $CI->ecl('Instance')->user(), $list, $member->email_address] ) ) {
                                    
                                    $total++;
                                    
                                }
                            }
                            
                        }
                        
                        echo json_encode($total);

                    }

                }
            }
            
        }
        
    }
    
}