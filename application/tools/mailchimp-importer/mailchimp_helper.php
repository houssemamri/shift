<?php
/**
 * Mailchimp_helper contains a trait for content displaying
 *
 * PHP Version 5.6
 *
 * Display content in the MailChimp Importer Tool
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Mailchimp_helper - display the content for the MailChimp Importer Tool
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
trait Mailchimp_helper {
    
    /**
     * The function assets contains styles and scripts
     * 
     * @return string with styles and scripts
     */
    public function assets(){
        
        // This function returns the main CodeIgniter object
        $CI = get_instance();
        
        // Load Tool Language file
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_tool_lang.php' ) ) {
            $CI->lang->load( 'default_tool', $CI->config->item('language') );
        }
        
        return '<style>'
        . '
            .tool-page > div > div.row > div.col-xl-12 > div.col-xl-12 {
                background: none !important;
                box-shadow: none !important;
            }
            .tool-page .mess-stat {
                padding-left: 0;
            }             
            .tool-page .mess-planner {
                padding-right: 0;
            }
            .tool-page > div > div.row > div.col-xl-12 > div.col-xl-12 > div > div > .panel-heading {
                display: none;
            }
            .offset-xl-3 {
                padding-bottom: 15px;
                margin-bottom: 20px;
                min-height: 60px;
                border-radius: 3px;
                background-color: #fff;
                -webkit-box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.15);
                box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.15);
            }
            .offset-xl-3 > div {
                padding: 0;
            }
            .tool-page .panel-heading h3 {
                line-height: 60px;
                font-size: 18px;
                color: #6c757d;
            }
            .tool-page .panel-heading i {
                font-size: 20px;
                margin-right: 5px;
            }
            .mailchimp-input {
                border: 1px solid #e6e6e6;
                box-shadow: none;
                width: 100%;
                padding: 7px;
                margin-top: 0;
            }
            .mailchimp-panel {
                width: 100%;
            }
            .mailchimp-panel .btn {
                text-decoration: none;
                color: #fff;
                background-color: #26a69a;
                text-align: center;
                letter-spacing: .5px;
                transition: .2s ease-out;
                cursor: pointer;
                border: 0;
            }
            .mailchimp-panel .col-xl-12 {
                margin-bottom: 15px;
            }
            .clicks-tracking {
                display: none;
            }
            .pageload {
                margin-top: 14px;
                display: none;
            }
            @media(max-width:767px) {
                .new-rss .mess-stat, .new-rss .mess-planner{
                    padding: 0;
                }
                .navbar-nav .open .dropdown-menu {
                    margin-left: -70px;
                }
            }            
            '
        . '</style>'
        . "<script type='text/javascript'>
            window.onload = function(){
            
                // Get Home URL
                var home = document.getElementsByClassName('home-page-link')[0];
                
                // Create a new object
                var mail = new Object();
                
                function mailchimp_parse(e){
                    e.preventDefault();
                    // Get the apikey
                    var apikey = e.target.getElementsByClassName('apikey')[0].value;
                    
                    // Verify if the apikey was already saved
                    if ( typeof mail.apikey === 'undefined') {
                        if ( apikey ) {
                        
                            var url = home+'user/tool/mailchimp-importer?action=check-key&key=' + apikey;
                            var http = new XMLHttpRequest();
                            http.open('GET', url, true);
                            http.onreadystatechange = function() {
                                if(http.readyState == 4 && http.status == 200) {
                                
                                    var data = http.responseText;
                                    if (data) {
                                        // Save ApiKey
                                        data = JSON.parse(data);
                                        mail.apikey = apikey;
                                        e.target.getElementsByClassName('apikey')[0].disabled = true;
                                        e.target.getElementsByClassName('data-center')[0].closest('.col-xl-12').style.display = 'block';
                                        e.target.getElementsByClassName('data-center')[0].value = data;
                                    } else {
                                        
                                        Main.popup_fon('sube', '" . $CI->lang->line('mt68') . "', 1500, 2000);
                                        
                                    }
                                }
                            }
                            http.send();

                        } else {

                            Main.popup_fon('sube', '" . $CI->lang->line('mt68') . "', 1500, 2000);

                        }
                    } else {
                    
                        // Verify if the datacenter was already saved
                        if ( typeof mail.datacenter === 'undefined') {
                        
                            var datacenter = e.target.getElementsByClassName('data-center')[0].value;
                            if ( datacenter ) {

                                var url = home+'user/tool/mailchimp-importer?action=get-lists&key=' + mail.apikey + '&datacenter=' + datacenter;
                                var http = new XMLHttpRequest();
                                http.open('GET', url, true);
                                http.onreadystatechange = function() {
                                    if(http.readyState == 4 && http.status == 200) {

                                        var data = http.responseText;
                                        if (data) {
                                            
                                            data = JSON.parse(data);
                                            // Save data center
                                            mail.datacenter = datacenter;
                                            e.target.getElementsByClassName('data-center')[0].disabled = true;
                                            e.target.getElementsByClassName('mailchimp-list')[0].closest('.col-xl-12').style.display = 'block';
                                            var tots = '<option value=\"0\">" . $CI->lang->line('mt74') . "</option>';
                                            for ( var f = 0; f < data.length; f++ ) {
                                            
                                                tots += '<option value=\"' + data[f].id + '\">' + data[f].name + '</option>';
                                                
                                            }
                                            document.getElementsByClassName('mailchimp-list')[0].innerHTML = tots;
                                        } else {

                                            Main.popup_fon('sube', '" . $CI->lang->line('mt69') . "', 1500, 2000);

                                        }
                                    }
                                }
                                http.send();

                            } else {

                                Main.popup_fon('sube', '" . $CI->lang->line('mt70') . "', 1500, 2000);

                            }
                        } else {

                            // Verify if the mailchimp list was already saved
                            if ( typeof mail.list === 'undefined') {

                                var list = e.target.getElementsByClassName('mailchimp-list')[0].value;
                                if ( list != 0 ) {

                                    // Save list
                                    mail.list = list;
                                    e.target.getElementsByClassName('my-list')[0].closest('.col-xl-12').style.display = 'block';
                                    e.target.getElementsByClassName('btn-next')[0].innerHTML = '" . $CI->lang->line('mt73') . "';

                                } else {

                                    Main.popup_fon('sube', '" . $CI->lang->line('mt71') . "', 1500, 2000);

                                }
                                
                            } else {

                                var mylist = e.target.getElementsByClassName('my-list')[0].value;
                                if ( mylist != 0 ) {

                                    document.getElementsByClassName('pageload')[0].style.display = 'block';
                                    var url = home+'user/tool/mailchimp-importer?action=download&key=' + mail.apikey + '&datacenter=' + mail.datacenter + '&mlist=' + mail.list + '&list=' + mylist;
                                    console.log(url);
                                    var http = new XMLHttpRequest();
                                    http.open('GET', url, true);
                                    http.onreadystatechange = function() {
                                        if(http.readyState == 4 && http.status == 200) {

                                            var data = http.responseText;
                                            if ( data ) {
                                            
                                                data = JSON.parse(data);
                                                Main.popup_fon('subi', data + ' " . $CI->lang->line('mt72') . "', 1500, 2000);

                                            } else {

                                                Main.popup_fon('sube', translation.mm3, 1500, 2000);

                                            }
                                            document.getElementsByClassName('pageload')[0].style.display = 'none';
                                        }
                                    }
                                    http.send();

                                } else {

                                    Main.popup_fon('sube', '" . $CI->lang->line('mt71') . "', 1500, 2000);

                                }

                            }

                        }

                    }
                }
                
                function reload_it() {
                    var mailchimp = document.getElementsByClassName('mailchimp-panel');
                    if ( mailchimp[0].addEventListener ) {
                        mailchimp[0].addEventListener('submit', mailchimp_parse, false);
                    } else if( mailchimp[0].attachEvent ) {
                        mailchimp[0].attachEvent('onsubmit', mailchimp_parse);
                    }                  
                }
                setTimeout(reload_it,500);
            }
            </script>";
    }
    
    /**
     * The function get_lists gets all user's email lists
     * 
     * @return string with all email lists
     */
    public function get_lists() {
        
        // This function returns the main CodeIgniter object
        $CI = get_instance();
        
        // Load Tool Language file
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_tool_lang.php' ) ) {
            $CI->lang->load( 'default_tool', $CI->config->item('language') );
        }
        
        // Gets all user email lists
        $lists = $CI->ecl('Instance')->mod('lists', 'user_lists', [$CI->ecl('Instance')->user(),'email']);
        
        $select = '<option value="0">' . $CI->lang->line('mt75') . ' ' . $CI->config->item('site_name') . '</option>';
        
        if ( $lists ) {
            
            foreach ( $lists as $list ) {
                
                $select .= '<option value="' . $list->list_id . '">' . $list->name . '</option>';
                
            }
            
        }
        
        return $select;
        
    }
}