<?php
/**
 * Retweet
 *
 * PHP Version 5.6
 *
 * Retweets your tweets automatically
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

use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * Retweet class - allows you to retweet your tweets on Twitter
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Retweet implements Boots {
    protected $CI, $connection, $twitter_key, $twitter_secret;
    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        $this->CI =& get_instance();
        
        // Load Networks Model
        $this->CI->load->model('networks');
        
        // Get the Twitter app_id
        $this->twitter_key = get_option('twitter_app_id');
        
        // Get the Twitter app_secret
        $this->twitter_secret = get_option('twitter_app_secret');
        
        // Require the vendor autoload
        include_once FCPATH . 'vendor/autoload.php';
        
        // Call the TwitterOAuth
        $this->connection = new TwitterOAuth($this->twitter_key, $this->twitter_secret);
        
    }
    
    /**
     * First function check if the Instagram api is configured correctly.
     *
     * @return will be true if the client and client_secret is not empty
     */
    public function check_availability() {
        return true;
    }
    
    /**
     * The public method content contains the bot's interface
     *
     * @return string with the bot's content
     */
    public function content() {
        $imu = $this->CI->lang->line('mu33');
        return $this->assets().' 
            <section class="bot-page">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="col-xl-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a href="#retweet_main" data-toggle="tab" class="active nav-link">
                                                    ' . ucfirst($this->CI->lang->line('mu111')) . '
                                                </a>
                                            </li>
                                            <img src="' . base_url() . 'assets/img/load-prev2.gif" class="loading-image">
                                        </ul>
                                    </div>
                                    <div class="panel-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active show" id="retweet_main">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <ul class="user-results">
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <ul class="pagination">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>              
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        </div>
                        <div class="col-xl-6 retweet-options">
                            <div class="col-xl-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a href="#retweet-members" data-toggle="tab" class="nav-link active">
                                                    ' . ucfirst( $this->CI->lang->line('mu140') ) . '
                                                </a>
                                            </li>   
                                            <li class="nav-item">
                                                <a href="#selected-members" data-toggle="tab" class="nav-link">
                                                    ' . ucfirst( $this->CI->lang->line('mb93') ) . '
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#statistics" data-toggle="tab" class="nav-link">
                                                    ' . $this->CI->lang->line('mb91') . '
                                                </a>
                                            </li>                                
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="retweet-members">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <ul class="retweet-accounts-results">
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col col-lg-12">
                                                    <ul class="pagination">
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="selected-members">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <ul class="retweet-selected-results"></ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="statistics">
                                            <div class="row">
                                                <div class="col-lg-12">                            
                                                    <ul class="list-unstyled">
                                                        <li>' . $this->CI->lang->line('mb92') . ' <span class="pull-right">0</span></li>
                                                    </ul>
                                                </div>
                                            </div>                                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>';
    }
    
    public function assets() {
        $this->CI = $this->CI;
        return '<script language="javascript">'
        . 'window.onload = function(){
                var home = document.getElementsByClassName(\'home-page-link\')[0];
                var twi = {\'page\': 1, \'limit\': 10, \'cid\': 0, \'data\': \'\'};
                function pnumi(e){
                    e.preventDefault();
                    var dez = this.closest(\'.tab-pane\').getAttribute(\'id\');
                    if ( dez === \'retweet_main\' ) {
                        show_searches(this.getAttribute(\'data-page\'));
                    } else if( dez === \'retweet-members\' ) {
                        show_all_accounts(this.getAttribute(\'data-page\'));
                    }
                }
                function manage_acc() {
                    var acc = this.getAttribute(\'data-id\');
                    twi.data = acc;
                    load_accounts_to_select();
                }     
                function load_accounts_to_select() {
                    delete twi.selected;
                    twi.selected = [];
                    document.getElementsByClassName(\'retweet-options\')[0].style.display = \'block\';
                    var url = home+\'user/bot/retweet?action=2&res=\' + twi.data;
                    var http = new XMLHttpRequest();
                    http.open(\'GET\', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if ( data ) {
                                data = JSON.parse(data);
                                if ( data.length ) {
                                    var selected_accounts = \' \';
                                    for ( var k = 0; k < data.length; k++ ) {
                                        twi.selected.push(data[k][0].network_id);
                                        selected_accounts += \'<li><div class="row"><div class="col-lg-11 col-md-11 col-sm-10 col-xs-10"><h3>\' + data[k][0].user_name + \'</h3></div><div class="col-lg-1 col-md-1 col-sm-2 col-xs-2 text-center"><button class="btn unselect-account" type="button" data-id="\' + data[k][0].network_id + \'"><i class="fa fa-thumbs-down"></i></button></div></div></li>\';
                                    }
                                    document.querySelector(\'.retweet-selected-results\').innerHTML = selected_accounts;
                                }
                            } else {
                                document.querySelector(\'.retweet-selected-results\').innerHTML = \'<p>' . $this->CI->lang->line('mb88') . '</p>\';
                            }
                        }
                        show_all_accounts(1);
                    }
                    http.send();
                }
                function select_account() {
                    var dthis = this;
                    var account_id = dthis.getAttribute(\'data-id\');
                    var url = home+\'user/bot/retweet?action=1&account=\' + account_id + \'&for=\' + twi.data;
                    var http = new XMLHttpRequest();
                    http.open(\'GET\', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if ( data ) {
                                load_accounts_to_select();
                            }
                        }
                    }
                    http.send();
                }
                function unselect_account() {
                    var dthis = this;
                    var account_id = dthis.getAttribute(\'data-id\');
                    var url = home+\'user/bot/retweet?action=3&account=\' + account_id + \'&for=\' + twi.data;
                    var http = new XMLHttpRequest();
                    http.open(\'GET\', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if ( data ) {
                                load_accounts_to_select();
                            }
                        }
                    }
                    http.send();
                }                
                function reload_it() {
                    var pnum = document.getElementsByClassName(\'pnum\');
                    if(pnum.length) {
                        if(pnum[0].addEventListener) {
                            for(var f = 0; f < pnum.length; f++) {
                                pnum[f].addEventListener(\'click\', pnumi, false);
                            }
                        } else if(pnum[0].attachEvent) {
                            for(var f = 0; f < pnum.length; f++) {
                                pnum[f].attachEvent(\'onclick\', pnumi);
                            }
                        }
                    }
                    var manage_account = document.getElementsByClassName(\'manage-account\');
                    if(manage_account.length) {
                        if(manage_account[0].addEventListener) {
                            for(var f = 0; f < manage_account.length; f++) {
                                manage_account[f].addEventListener(\'click\', manage_acc, false);
                            }
                        } else if(manage_account[0].attachEvent) {
                            for(var f = 0; f < manage_account.length; f++) {
                                manage_account[f].attachEvent(\'onclick\', manage_acc);
                            }
                        }
                    }  
                    var select_account_btn = document.getElementsByClassName(\'select-account\');
                    if ( select_account_btn.length ) {
                        if ( select_account_btn[0].addEventListener ) {
                            for ( var f = 0; f < select_account_btn.length; f++ ) {
                                select_account_btn[f].addEventListener(\'click\', select_account, false);
                            }
                        } else if ( select_account_btn[0].attachEvent ) {
                            for ( var f = 0; f < select_account_btn.length; f++ ) {
                                select_account_btn[f].attachEvent(\'onclick\', select_account);
                            }
                        }
                    }
                    var unselect_account_btn = document.getElementsByClassName(\'unselect-account\');
                    if ( unselect_account_btn.length ) {
                        if ( unselect_account_btn[0].addEventListener ) {
                            for ( var f = 0; f < unselect_account_btn.length; f++ ) {
                                unselect_account_btn[f].addEventListener(\'click\', unselect_account, false);
                            }
                        } else if ( unselect_account_btn[0].attachEvent ) {
                            for ( var f = 0; f < unselect_account_btn.length; f++ ) {
                                unselect_account_btn[f].attachEvent(\'onclick\', unselect_account);
                            }
                        }
                    }
                }
                function show_pagination(total,id) {
                    // the code bellow displays pagination
                    if (parseInt(twi.page) > 1) {
                        var bac = parseInt(twi.page) - 1;
                        var pages = \'<li class="page-item page-item"><a href="#" data-page="\' + bac + \'" class="page-link pnum">\' + Main.translation.mm128 + \'</a></li>\';
                    } else {
                        var pages = \'<li class="page-item pagehide"><a href="#" class="page-link">\' + Main.translation.mm128 + \'</a></li>\';
                    }
                    var tot = parseInt(total) / parseInt(twi.limit);
                    tot = Math.ceil(tot) + 1;
                    var from = (parseInt(twi.page) > 2) ? parseInt(twi.page) - 2 : 1;
                    for (var p = from; p < parseInt(tot); p++) {
                        if (p === parseInt(twi.page)) {
                            pages += \'<li class="page-item active"><a data-page="\' + p + \'" class="page-link pnum">\' + p + \'</a></li>\';
                        } else if ((p < parseInt(twi.page) + 3) && (p > parseInt(twi.page) - 3)) {
                            pages += \'<li class="page-item page-item"><a href="#" data-page="\' + p + \'" class="page-link pnum">\' + p + \'</a></li>\';
                        } else if ((p < 6) && (Math.round(tot) > 5) && ((parseInt(twi.page) == 1) || (parseInt(twi.page) == 2))) {
                            pages += \'<li class="page-item page-item"><a href="#" data-page="\' + p + \'" class="page-link pnum">\' + p + \'</a></li>\';
                        } else {
                            break;
                        }
                    }
                    if (p === 1) {
                        pages += \'<li class="page-item active"><a data-page="\' + p + \'" class="page-link">\' + p + \'</a></li>\';
                    }
                    var next = parseInt(twi.page);
                    next++;
                    if (next < Math.round(tot)) {
                        document.querySelector(id + \' .pagination\').innerHTML = pages + \'<li class="page-item"><a href="#" data-page="\' + next + \'" class="page-link">\' + Main.translation.mm129 + \'</a></li>\';
                    } else {
                        document.querySelector(id + \' .pagination\').innerHTML = pages + \'<li class="page-item pagehide"><a href="#" class="page-link">\' + Main.translation.mm129 + \'</a></li>\';
                    }
                }
                function show_searches(num) {
                    twi.page = num;
                    var url = home+\'user/show-accounts/twitter/\' + num;
                    var http = new XMLHttpRequest();
                    http.open(\'GET\', url, true);
                    http.onreadystatechange = function() {
                        var data = http.responseText;
                        if(data) {
                            data = JSON.parse(http.responseText);
                            show_pagination(data.total,\'#retweet_main\');
                            var tot = \' \';
                            for(var m = 0; m < data.accounts.length; m++) {
                                tot += \'<li><div class="row"><div class="col-lg-11 col-md-11 col-sm-10 col-xs-10"><h3>\' + data.accounts[m].user_name + \'</h3></div><div class="col-lg-1 col-md-1 col-sm-2 col-xs-2 text-center"><button class="btn manage-account" type="button" data-id="\' + data.accounts[m].network_id + \'"><i class="fas fa-sliders-h"></i></button></div></div></li>\';
                            }
                            document.querySelector(\'.user-results\').innerHTML = tot;
                            setTimeout(reload_it,500);
                        } else {
                            document.querySelector(\'.user-results\').innerHTML = \'<p class="no-results-found">' . $this->CI->lang->line('mb46') . '</p>\';
                        }
                    }
                    http.send();
                }
                function show_all_accounts(num) {
                    twi.page = num;
                    var url = home+\'user/show-accounts/twitter/\' + num;
                    var http = new XMLHttpRequest();
                    http.open(\'GET\', url, true);
                    http.onreadystatechange = function() {
                        var data = http.responseText;
                        if(data) {
                            data = JSON.parse(http.responseText);
                            show_pagination(data.total,\'#retweet-members\');
                            var tot = \' \';
                            for(var m = 0; m < data.accounts.length; m++) {
                                var display_select = \' \';
                                var display_unselect = \' d-none\';
                                if ( twi.selected.indexOf(data.accounts[m].network_id) > -1 ) {
                                    display_select = \' d-none\';
                                    display_unselect = \' block\';                                    
                                }
                                tot += \'<li><div class="row"><div class="col-lg-11 col-md-11 col-sm-10 col-xs-10"><h3>\' + data.accounts[m].user_name + \'</h3></div><div class="col-lg-1 col-md-1 col-sm-2 col-xs-2 text-center"><button class="btn select-account\' + display_select + \'" type="button" data-id="\' + data.accounts[m].network_id + \'"><i class="fa fa-thumbs-up"></i></button><button class="btn unselect-account\' + display_unselect + \'" type="button" data-id="\' + data.accounts[m].network_id + \'"><i class="fa fa-thumbs-down"></i></button></div></div></li>\';
                            }
                            document.querySelector(\'.retweet-accounts-results\').innerHTML = tot;
                            setTimeout(reload_it,500);
                        } else {
                            document.querySelector(\'.retweet-accounts-results\').innerHTML = \'<p class="no-results-found">' . $this->CI->lang->line('mb46') . '</p>\';
                        }
                    }
                    http.send();
                }
                show_searches(1);
                setTimeout(reload_it,500);
            }
            '
        . '</script>'
        . '<style>'
                . '#retweet_main {
                    padding: 15px;
                }'
                . '.retweet-options {
                    display: none;
                }'                
                . '.fa-circle, .fa-circle-thin {
                    color: #71d775;
                    font-size: 13px;
                }'                
                . '.tool-page .nav-tabs>li.leposts>a {
                    border-bottom-color: transparent;
                    color: #01aeee !important;
                }'
                . '.tab-pane>div>.panel-default {
                    min-height: 150px;
                }'
                . '.panel-heading .fa-history {
                    color: #a5c57d !important;
                }'
                . '#retweet-members .pagination {
                    margin-bottom: 0;
                }'                
                . '.tab-pane>div>.panel-default, .tab-pane#history_lists .panel-default {
                    border: 1px solid #ebeae8;
                    border-radius: 3px;
                    box-shadow: 0 0 1px #ebeae8;
                    margin-bottom: 20px !important;
                    padding: 10px 10px 14px;
                }'
                . '.tab-pane>div>.panel-default>.panel-heading {
                    background: #ffffff !important;
                }'
                . '.tab-pane#history_lists .panel-default>.panel-heading {
                    padding: 10px 0 !important;
                }'                
                . '.tab-pane>div>.panel-default>.panel-heading {
                    padding: 10px 0 0 !important;
                }'
                . '.tab-pane#history_lists .panel-default, .tab-pane#comment_lists .panel-default {
                    margin-bottom: 0 !important;
                }'             
                . '.tab-pane>div>.panel-default>.panel-heading>img, #comment_lists .panel-default>.panel-heading>img, #history_lists .panel-default>.panel-heading>img {
                    margin-right: 15px;
                }'
                . '.tab-pane>div>.panel-default>.panel-heading>h3, #comment_lists .panel-default>.panel-heading>h3, #history_lists .panel-default>.panel-heading>h3 {
                    margin: 0;
                    font-weight: 600;
                    font-size: 14px;
                }'
                . '.tab-pane>div>.panel-default>.panel-heading>h5 {
                    color: #90949c;
                }'
                . '.tab-pane>.panel-body {
                    padding: 15px 15px 0 !important;
                }'
                . '.tab-pane>.panel-body:last-child {
                    padding: 15px !important;
                }'
                . '.tab-pane>div>.panel-default>.panel-footer {
                    margin-top: 0;
                    border-top: 1px solid #e5e5e5;
                    background-color: transparent;
                    padding: 0;
                    height: 25px;
                }'
                . '.tab-pane>div>.panel-default>.panel-footer>.col-md-3 {
                    height: 35px;
                    line-height: 35px;
                }'
                . '.tab-pane>div>.panel-default>.panel-footer>.col-md-3>a {
                    color: #999;
                }'
                . '.tab-pane>div>.panel-default>.panel-footer>.col-md-3>a:hover {
                    color: #616770;
                    text-decoration: none;
                }'                
                . '.tab-pane>div>.panel-default>.panel-footer>.col-md-3>a>.fa {
                    margin-right: 10px;
                }'
                . '.retweet-accounts-results, .retweet-selected-results {
                    padding-left: 0;
                }'                
                . '.search-zon, .user-results > li, .retweet-accounts-results > li, .retweet-selected-results > li {
                    border-radius: 3px;
                    border: 1px solid #ebedf2;
                    height: 50px;
                }'
                . '#statistics ul > li {
                    border-radius: 3px;
                    border: 1px solid #ebedf2;
                    padding: 10px;
                    margin-bottom: 15px;
                }'
                . '#twilos_main, #saved_search, #retweet-members, #selected-members, #statistics {
                    padding: 15px;
                }'
                . '#twilos_main .search input {
                    height: 48px;
                    border: 0;
                    box-shadow: none;
                    width: 98%;
                }'
                . '#twilos_main .search input:focus, #twilos_main .search input:active {
                    border: 0 !important;
                    box-shadow: none !important;
                    outline: focus !important;
                }'
                . '#twilos_main .search .btn {
                    height: 38px;
                    box-shadow: none;
                    border: 0;
                    color: #fff;
                    margin-right: 5px;
                    border-radius: 5px;
                }'        
                . '#retweet_main .btn.manage-account {
                    background: #e76e25 !important;
                    border-color: #e76e25 !important;
                    color: #ffffff;
                    margin-top: 2px;
                }'
                . '#retweet_main .btn.manage-account:hover, #retweet_main .btn.manage-account:focus {
                    background: #f69555 !important;
                    border-color: #f69555 !important;
                }'                
                . '.retweet-options .btn.select-account {
                    background: #12b886 !important;
                    border-color: #12b886 !important;
                    color: #ffffff;
                }'
                . '.retweet-options .btn.select-account:hover, .retweet-options .btn.select-account:focus {
                    background: #10a578 !important;
                    border-color: #10a578 !important;
                }' 
                . '#retweet_main .btn.manage-account i, .retweet-options .btn.select-account i {
                    margin-right: 0;
                }' 
                . '.retweet-options .btn.unselect-account {
                    background: #F05A75 !important;
                    border-color: #F05A75 !important;
                    color: #ffffff;
                }'
                . '.retweet-options .btn.unselect-account:hover, .retweet-options .btn.unselect-account:focus {
                    background: #dc4b65 !important;
                    border-color: #dc4b65 !important;
                }'                
                . '.search .input-group-btn>.btn {
                    margin-top: 0;
                }'
                . '.retweet-members-results {
                    padding: 15px 0 0;
                }'
                . '.user-results .no-results-found {
                    line-height: 22px;
                    font-size: 16px;
                    color: #212529;
                    padding: 15px !important;
                }'                
                . '.user-results > li, .retweet-accounts-results > li, .retweet-selected-results > li {
                    list-style: none;
                    height: auto;
                    min-height: 50px;
                    padding: 15px 15px;
                    margin-bottom: 15px;
                }'
                . 'li > .col-lg-1 > img {
                    max-width: 50px;
                }'                
                . '.search-results > li {
                    list-style: none;
                    height: auto;
                    min-height: 66px;
                    padding: 7px 0;
                    margin-bottom: 15px;
                }'                
                 . '.user-results > li > div h3, .retweet-accounts-results > li > div h3, .search-results > li > div h3, .retweet-selected-results > li > div h3 {
                    margin: 0;
                    font-size: 16px;
                }'
                 . '.retweet-accounts-results > li > div h3,
                    .retweet-selected-results > li > div h3 {
                    line-height: 35px;
                }'                
                 . '.user-results > li > div h3 {
                    line-height: 37px;
                }'          
                 . '.user-results > li > div h4, .retweet-accounts-results > li > div h4, .search-results > li > div h4, .retweet-selected-results > li > div h4 {
                    font-size: 14px;
                    color: #999;
                }'
                 . '.manage-saved-search {
                    height: 35px;
                    margin-top: 6px;
                    background-color: #a5c57d;
                    border-color: #a5c57d;
                }'
                 . '.manage-saved-search:hover, .manage-saved-search:focus, .manage-saved-search:active {
                    background-color: #8ca76a !important;
                    border-color: #8ca76a !important;
                }'
                 . '.tool-page .nav-tabs>li>a.bolis, .tool-page .nav-tabs>li.active>a.bolis {
                    color: #F5CF10 !important;
                }'                
                 . '.tool-page .nav-tabs>li>a.bolis2 {
                    color: #3bc9db !important;
                }'
                 . '.tool-page .nav-tabs>li>a.bolis3 {
                    color: #228ae6 !important;
                }'                
                 . '.tool-page .panel-body .tab-pane ul>li {
                    padding: 4px 0;
                }'
                 . '.tool-page .panel-body .tab-pane ul.pagination>li {
                    padding: 4px 0;
                    border: 0;
                    box-shadow: none;
                }'
                 . '.label-success {
                    background-color: #a5c57d;
                    background: #a5c57d;
                    border: 0;
                    pointer-events: none;
                }'
                 . '.label-danger {
                    background-color: #F6694D;
                    background: #F6694D;
                    border: 0;
                }'
                 . '.label-default {
                    background-color: #A0D46A;
                    background: #A0D46A;
                    border: 0;
                }'
                 . '.label:focus, .label:active {
                    outline: none;
                    border: 0;
                }'
                 . '.instavy-account-select, .instavy-account-select > a, .instavy-account-select > a:focus {
                    color: #F0A580;
                    outline: 0;
                }'
                . '#instavy-options .setrow:nth-child(2) {
                    min-height: 175px;
                }'               
                 . '.retweet-text {
                    line-height: 20px;
                    width: 100%;
                    margin-top: 10px;
                    border-radius: 3px;
                    border-color: #efefef;
                    height: 150px;
                    padding: 5px;
                }'
                 . '.setrow>.col-lg-6 {
                    font-weight: 400;
                    color: #555;
                    padding-left: 5px;
                }'                
                 . '.tool-page .dropdown-toggle {
                    margin-top: 12px;
                    height: 34px !important;
                }'
                 . '.tool-page .btn-add-to-account {
                    height: 24px !important;
                    padding: 1px 5px !important;
                    font-size: 12px !important;
                }'
                 . '.tool-page .table-responsive>.table>tbody>tr:first-child>td {
                    border-top: 1px solid #ddd !important
                }'
                 . '.instavy-status {
                    color: #337ab7;
                    font-weight: 600;
                }'
                 . '.loading-image {
                    margin-top: 5px;
                }'
                 . '#retweet-stats {
                    padding: 15px;
                }'
                 . '#retweet-stats > ul > li {
                    border-radius: 3px;
                    border: 1px solid #ebedf2;
                    padding: 10px;
                    margin-bottom: 15px;
                }'
                . '#retweet-stats > ul > li > span {
                    font-weight: 600;
                    color: #9C27B0;
                    font-size: 16px;
                }'
                . '.loading-image {
                    margin-top: -40px;
                    margin-right: 15px;
                    float: right;
                    width: 24px;
                    height: 24px;
                    display: none;
                }'
        . '</style>';
    }
    
    /**
     * First function load was created for http requests
     *
     * @param string $act contains parameter
     */
    public function load($act) {
        switch ($act) {
            
            case '1':
                
                $account = $this->CI->input->get('account', TRUE);
                $for = $this->CI->input->get('for', TRUE);
                
                // Then verify if user is the owner of the for retweeting
                $account_owner = $this->CI->ecl('Instance')->mod('networks', 'get_account', [$account]);
                
                if ( $account_owner[0]->user_id != $this->CI->ecl('Instance')->user() ) {
                    exit();
                }
                
                // Then verify if user is the owner of the account to retweet
                $account_owner2 = $this->CI->ecl('Instance')->mod('networks', 'get_account', [$for]);
                
                if ( $account_owner2[0]->user_id != $this->CI->ecl('Instance')->user() ) {
                    exit();
                }
                
                // Verify if the bot was already created
                $verify = $this->CI->ecl('Instance')->mod('botis', 'check_bot', ['retweet', $this->CI->ecl('Instance')->user(), $for, $account]);
                
                // If not exists, create
                if ( !$verify ) {
                 
                    if ( $this->CI->ecl('Instance')->mod('botis', 'save_bot', ['retweet', $this->CI->ecl('Instance')->user(), $for, $account]) ) {
                     
                        echo json_encode(1);
                        
                    }
                    
                }
                    
                break;
                
            case '2':
                
                $res = $this->CI->input->get('res', TRUE);
                
                if ( !is_numeric($res) ) {
                    
                    exit();
                    
                }   
                
                $bots = $this->CI->ecl('Instance')->mod('botis', 'check_bot', ['retweet', $this->CI->ecl('Instance')->user(), $res]);
                if ( $bots ) {
                    
                    $accounts = [];
                    
                    foreach ( $bots as $bot ) {
                        
                        $accounts[] = $this->CI->ecl('Instance')->mod('networks', 'get_account', [$bot->rule2]);
                        
                    }
                    
                    echo json_encode($accounts);
                    
                }
                    
                break;
            case '3':
                
                $account = $this->CI->input->get('account', TRUE);
                $for = $this->CI->input->get('for', TRUE);
                
                // Get the bot's id
                $bots = $this->CI->ecl('Instance')->mod('botis', 'check_bot', ['retweet', $this->CI->ecl('Instance')->user(), $for, $account]);

                if ( $bots ) {
                    
                    // Try to delete the bot
                    $del_bot = $this->CI->ecl('Instance')->mod('botis', 'delete_bot', ['retweet', $this->CI->ecl('Instance')->user(), $for, $bots[0]->bot_id]);
                    
                    // Verify if the bot was deleted
                    if ( $del_bot ) {
                        
                        echo 1;
                        
                    }
                    
                }
                
                break;
        }
        
    }

    /**
     * This function displays information about this class.
     */
    public function get_info() {
        return (object) array(
            'name' => 'Retweet',
            'slug' => 'retweet',
            'description' => 'Retweets the tweets posted from a selected Twitter\'s account'
        );
    }
    
    /**
     * This function runs the bot schedules
     * 
     * @param integer $user_id contains the user_id
     */
    public function load_cron($user_id) {
 
        // Get available user bots
        $this->CI->db->select( 'DISTINCT(rule1)', FALSE );
        $this->CI->db->select( 'bot_id' );
        $this->CI->db->from( 'bots' );
        $this->CI->db->where(['type' => 'retweet', 'user_id' => $user_id, 'rule3 !=' => 1]);
        $this->CI->db->limit(1);
        $query = $this->CI->db->get();
        if ( $query->num_rows() > 0 ) {

            $result = $query->result();

            $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$result[0]->bot_id, $user_id, 'rule3', 1]);

            $this->CI->db->select( 'net_id' );
            $this->CI->db->from( 'activity' );
            $this->CI->db->where(['network_id' => $result[0]->rule1, 'created >' => time() - 86400]);
            $activities = $this->CI->db->get();

            if ( $query->num_rows() > 0 ) {

                $all_activities = $activities->result();
                
                foreach ( $all_activities as $activity ) {

                    // Verify if the bot was already created
                    $verify = $this->CI->ecl('Instance')->mod('botis', 'check_bot', ['retweeted', $user_id, $result[0]->rule1, $activity->net_id]);

                    // If not exists, create
                    if ( !$verify ) {

                        if ( $this->CI->ecl('Instance')->mod('botis', 'save_bot', ['retweeted', $user_id, $result[0]->rule1, $activity->net_id]) ) {

                            // Get all accounts which must retweet the tweet
                            $bots = $this->CI->ecl('Instance')->mod('botis', 'get_bot', [['rule1' => $result[0]->rule1, 'user_id' => $user_id]]);

                            if ( $bots ) {

                                foreach ( $bots as $bot ) {

                                    $account = $this->CI->ecl('Instance')->mod('networks', 'get_account', [$bot->rule2]);

                                    $this->connection = new TwitterOAuth($this->twitter_key, $this->twitter_secret, @$account[0]->token, @$account[0]->secret);

                                    $status = $this->connection->post('statuses/retweet', ['id' => $activity->net_id]);

                                }

                            }

                        }

                    }

                }

            }

        } else {

            $this->CI->db->set(['rule3' => '0']);
            $this->CI->db->where(['type' => 'retweet', 'user_id' => $user_id]);
            $this->CI->db->update('bots');

        }
        
    }  
    
}
