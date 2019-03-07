<?php
/**
 * Dmitas
 *
 * PHP Version 5.6
 *
 * Find new friends on Instagram
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
 * Instavy class - allows users to search and follow friends from Instagram.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Dmitas implements Boots {
    protected $CI,$username,$password;
    /**
     * Load networks and user model.
     */
    public function __construct() {
        $this->CI =& get_instance();
        // Load Networks Model
        $this->CI->load->model('networks');
        // Load User Model
        $this->CI->load->model('user');
        if($this->CI->ecl('Instance')->user()) {
            $nets = $this->CI->networks->get_all_accounts($this->CI->ecl('Instance')->user(),'instagram');
            if($nets) {
                $this->username = $nets[0]->user_name;
                $this->password = $nets[0]->token;
            }
        }
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
     * First function content provides bot's content
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
                                            <li class="nav-item leposts">
                                                <a href="#dmitas_main" class="nav-link active" data-toggle="tab">
                                                    ' . ucfirst($this->CI->lang->line('mu111')) . '
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="panel-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="dmitas_main">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <ul class="user-results">
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-12">
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
                        <div class="col-xl-6 dmitas-options">
                            <div class="col-xl-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a href="#instavy-options" data-toggle="tab" class="nav-link bolis active">
                                                    ' . $this->CI->lang->line('mb89') . '
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#dmitas-members" data-toggle="tab" class="nav-link bolis2">
                                                    ' . $this->CI->lang->line('new_friends') . '
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#dmitas-stats" data-toggle="tab" class="nav-link bolis3">
                                                    ' . $this->CI->lang->line('mb91') . '
                                                </a>
                                            </li>                                
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="instavy-options">
                                            <div class="setrow row">
                                                <div class="col-xl-10 col-sm-9 col-xs-9">' . $this->CI->lang->line('mb80') . '</div>
                                                <div class="col-xl-2 col-sm-3 col-xs-3 text-right">
                                                    <div class="checkbox-option pull-right">
                                                        <input id="dmitas_enable" name="dmitas_enable" class="setopti" type="checkbox">
                                                        <label for="dmitas_enable"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="setrow row">
                                                <div class="col-xl-6 col-sm-12 col-xs-12">' . $this->CI->lang->line('mb81') . '</div>
                                                <div class="col-xl-6 col-sm-12 col-xs-12 text-center">
                                                    <textarea class="dmitas-text" placeholder="' . $this->CI->lang->line('mb84') . '"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="dmitas-members">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <ul class="dmitas-members-results">
                                                        <p>' . $this->CI->lang->line('mb86') . '</p>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col col-xl-12">
                                                    <ul class="pagination">
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="dmitas-stats">
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
                    if(dez === \'dmitas_main\') {
                        show_searches(this.getAttribute(\'data-page\'));
                    } else if(dez === \'dmitas-members\') {
                        show_members(this.getAttribute(\'data-page\'));
                    }
                }
                function dmitas_enab() {
                    var dthis = this;
                    var url = home+\'user/bot/dmitas?action=1&res=\' + twi.data;
                    var http = new XMLHttpRequest();
                    http.open(\'GET\', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if ( !data ) {
                                document.getElementById(\'dmitas_enable\').checked = false;
                                Main.popup_fon(\'sube\', Main.translation.mm3, 1500, 2000);
                            } else {
                                Main.popup_fon(\'subi\', \'' . $this->CI->lang->line('mm2') . '\', 1500, 2000);
                            }
                        }
                    }
                    http.send();
                }
                function manage_acc() {
                    var acc = this.getAttribute(\'data-id\');
                    twi.data = acc;
                    document.getElementsByClassName(\'dmitas-options\')[0].style.display = \'block\';
                    var url = home+\'user/bot/dmitas?action=3&res=\' + twi.data;
                    var http = new XMLHttpRequest();
                    http.open(\'GET\', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if ( data ) {
                                data = JSON.parse(data);
                                if(data[0].rule2 > 0) {
                                    document.getElementById(\'dmitas_enable\').checked = true;
                                }
                                if ( data[0].rule3 ) {
                                    document.getElementsByClassName(\'dmitas-text\')[0].value = data[0].rule3;
                                } else {
                                    document.getElementsByClassName(\'dmitas-text\')[0].value = \'\';
                                }
                                show_members(1);
                            }
                        }
                    }
                    http.send();
                    get_stats();
                }
                function dmitas_value() {
                    var dthis = this;
                    var csr = \'' . $this->CI->security->get_csrf_hash() . '\';
                    var url = home+\'user/bot/dmitas?action=2&res=\' + twi.data;
                    var params = \'csrf_test_name=\'+csr+\'&comment=\' + dthis.value;
                    var http = new XMLHttpRequest();
                    http.open(\'POST\', url, true);
                    http.setRequestHeader(\'Content-type\', \'application/x-www-form-urlencoded\');
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if ( !data ) {
                                document.getElementById(\'dmitas_enable\').checked = false;
                                Main.popup_fon(\'sube\', Main.translation.mm3, 1500, 2000);
                            } else {
                                Main.popup_fon(\'subi\', \'' . $this->CI->lang->line('mb85') . '\', 1500, 2000);
                            }
                        }
                    }
                    http.send(params);
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
                    var dmitas_enable = document.getElementsByClassName(\'setopti\');
                    if(dmitas_enable.length) {
                        if(dmitas_enable[0].addEventListener) {
                            dmitas_enable[0].addEventListener(\'click\', dmitas_enab, false);
                        } else if(dmitas_enable[0].attachEvent) {
                            dmitas_enable[0].attachEvent(\'onclick\', dmitas_enab);
                        }
                    }
                    var dmitas_text = document.getElementsByClassName(\'dmitas-text\');
                    if(dmitas_text.length) {
                        if(dmitas_text[0].addEventListener) {
                            dmitas_text[0].addEventListener(\'change\', dmitas_value, false);
                        } else if(dmitas_text[0].attachEvent) {
                            dmitas_text[0].attachEvent(\'onchange\', dmitas_value);
                        }
                    }                    
                }
                function show_pagination(total,id) {
                    // the code bellow displays pagination
                    if (parseInt(twi.page) > 1) {
                        var bac = parseInt(twi.page) - 1;
                        var pages = \'<li class="page-item"><a href="#" data-page="\' + bac + \'" class="page-link pnum">\' + Main.translation.mm128 + \'</a></li>\';
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
                            pages += \'<li class="page-item"><a href="#" data-page="\' + p + \'" class="page-link pnum">\' + p + \'</a></li>\';
                        } else if ((p < 6) && (Math.round(tot) > 5) && ((parseInt(twi.page) == 1) || (parseInt(twi.page) == 2))) {
                            pages += \'<li class="page-item"><a href="#" data-page="\' + p + \'" class="page-link pnum">\' + p + \'</a></li>\';
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
                    var url = home+\'user/show-accounts/instagram/\' + num;
                    var http = new XMLHttpRequest();
                    http.open(\'GET\', url, true);
                    http.onreadystatechange = function() {
                        var data = http.responseText;
                        if(data) {
                            data = JSON.parse(http.responseText);
                            show_pagination(data.total,\'#dmitas_main\');
                            var tot = \' \';
                            for(var m = 0; m < data.accounts.length; m++) {
                                tot += \'<li><div class="row"><div class="col-xl-11 col-md-11 col-sm-10 col-xs-10"><h3>\' + data.accounts[m].user_name + \'</h3></div><div class="col-xl-1 col-md-1 col-sm-2 col-xs-2 text-center"><button class="btn manage-account" type="button" data-id="\' + data.accounts[m].network_id + \'"><i class="fas fa-sliders-h"></i></button></div></div></li>\';
                            }
                            document.querySelector(\'.user-results\').innerHTML = tot;
                            setTimeout(reload_it,500);
                        } else {
                            document.querySelector(\'.user-results\').innerHTML = \'<p class="no-results-found">' . $this->CI->lang->line('mb50') . '</p>\';
                        }
                    }
                    http.send();
                }
                function show_members(num) {
                    twi.page = num;
                    var url = home+\'user/bot/dmitas?action=4&res=\' + twi.data + \'&page=\' + num;
                    var http = new XMLHttpRequest();
                    http.open(\'GET\', url, true);
                    http.onreadystatechange = function() {
                        var data = http.responseText;
                        if(data) {
                            data = JSON.parse(data);
                            show_pagination(data.total,\'#dmitas-members\');
                            var tot = \' \';
                            for(var m = 0; m < data.users.length; m++) {
                                var bibo = \'\';
                                if ( data.users[m].rule5 === \'2\' ) {
                                    bibo = \'<button type="button" class="btn label label-success pull-right"><i class="fa fa-envelope"></i></button>\';
                                }
                                tot += \'<li><div class="row"><div class="col-xl-1"><img src="\' + data.users[m].rule7 + \'"></div><div class="col-xl-11"><h3>\' + data.users[m].rule3 + bibo + \'</h3><h4>' . $this->CI->lang->line('mb68') . ': \' + data.users[m].rule4 + \'</h4></div></div></li>\';
                            }
                            document.querySelector(\'.dmitas-members-results\').innerHTML = tot;
                            reload_it();
                        }
                    }
                    http.send();
                }
                function get_stats() {
                    var url = home+\'user/bot/dmitas?action=5&res=\' + twi.data;
                    var http = new XMLHttpRequest();
                    http.open(\'GET\', url, true);
                    http.onreadystatechange = function() {
                        var data = http.responseText;
                        if(data) {
                            data = JSON.parse(data);
                            document.querySelector(\'#dmitas-stats\').innerHTML = data;
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
                . '#dmitas_main {
                    padding: 15px;
                }'
                . '.dmitas-options {
                    display: none;
                }'                
                . '.fa-circle, .fa-circle-thin {
                    color: #71d775;
                    font-size: 13px;
                }'                
                . '.tool-page .nav-tabs>li.leposts>a {
                    border-bottom-color: transparent;
                    color: #8686FA !important;
                }'
                . '.tab-pane>div>.panel-default {
                    min-height: 150px;
                }'
                . '.panel-heading .fa-history {
                    color: #a5c57d !important;
                }'
                . '#history_lists .pagination {
                    margin: 15px;
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
                . '.search-zon, .user-results > li, .search-results > li, .dmitas-members-results > li {
                    border-radius: 3px;
                    border: 1px solid #e1e8ed;
                    height: 50px;
                }'
                . '.user-results > .no-results-found {
                    padding: 0 !important;
                }'
                . '#twilos_main, #saved_search, #dmitas-members, #instavy-options {
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
                . '#dmitas_main .btn.manage-account {
                    background: #F2686A !important;
                    border-color: #f58283 !important;
                    color: #ffffff;
                    margin-top: 2px;
                }'
                . '#dmitas_main .btn.manage-account:hover, #dmitas_main .btn.manage-account:focus {
                    background: #f58283 !important;
                    border-color: #f58283 !important;
                }'    
                . '#dmitas_main .btn.manage-account i {
                    margin-right: 0;
                }'                
                . '.search .input-group-btn>.btn {
                    margin-top: 0;
                }'
                . '.dmitas-members-results {
                    padding: 15px 0 0;
                }'                
                . '.user-results > li,
                    .dmitas-members-results > li {
                    list-style: none;
                    height: auto;
                    min-height: 50px;
                    margin-bottom: 15px;
                    padding: 15px;
                }'
                . '.dmitas-members-results > li {
                    min-height: 80px;
                }'
                . '.dmitas-members-results > p {
                    padding: 15px 0;
                }'                
                . 'li > .row > .col-xl-1 > img {
                    max-width: 50px;
                }'                
                . '.search-results > li {
                    list-style: none;
                    height: auto;
                    min-height: 66px;
                    padding: 7px 0;
                    margin-bottom: 15px;
                }'                
                 . '.user-results > li > div > div > h3,
                    .dmitas-members-results > li > div > div > h3,
                    .search-results > li > div > div > h3 {
                    margin: 0;
                    font-size: 16px;
                }'
                 . '.user-results > li > div > div > h3 {
                    line-height: 37px;
                }'          
                 . '.user-results > li > div > div > h4,
                    .dmitas-members-results > li > div > div > h4,
                    .search-results > li > div > div > h4 {
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
                    color: #F2686A !important;
                }'
                 . '.tool-page .nav-tabs>li>a.bolis2 {
                    color: #FA965A !important;
                }'
                 . '.tool-page .nav-tabs>li>a.bolis3 {
                    color: #4B4C7C !important;
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
                 . '.dmitas-text {
                    line-height: 20px;
                    width: 100%;
                    margin-top: 10px;
                    border-radius: 3px;
                    border-color: #efefef;
                    height: 150px;
                    padding: 5px;
                }'
                 . '.setrow {
                    margin-bottom: 15px;
                }' 
                 . '.setrow>.col-xl-6 {
                    font-weight: 400;
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
                 . '#dmitas-stats {
                    padding: 15px;
                }'
                 . '#dmitas-stats > ul > li {
                    border-radius: 3px;
                    border: 1px solid #e1e8ed;
                    padding: 10px;
                    margin-bottom: 15px;
                }'
                . '#dmitas-stats > ul > li > span {
                    font-weight: 600;
                    color: #9C27B0;
                    font-size: 16px;
                }'               
        . '</style>';
    }
    
    /**
     * First function load was created for http requests
     *
     * @param string $act contains parameter
     */
    public function load($act) {
        include_once FCPATH . 'vendor/autoload.php';
        $check = new \InstagramAPI\Instagram(false, false);
        switch ($act) {
            case '1':
                $res = $this->CI->input->get('res', TRUE);
                if ( !is_numeric($res) ) {
                    exit();
                }
                // Verify if user is the owner of the account
                $account_owner = $this->CI->ecl('Instance')->mod('networks', 'get_account', [$res]);
                if ( !$account_owner ) {
                    exit();
                }
                if ( $account_owner[0]->user_id != $this->CI->ecl('Instance')->user() ) {
                    exit();
                }
                if ( $account_owner[0]->network_name != 'instagram' ) {
                    exit();
                }                
                $botu = $this->CI->ecl('Instance')->mod('botis', 'check_bot', ['dmitas-opts', $this->CI->ecl('Instance')->user(), $res]);
                if ( !$botu ) {
                    $bot = $this->CI->ecl('Instance')->mod('botis', 'save_bot', ['dmitas-opts', $this->CI->ecl('Instance')->user(), $res, 1]);
                    if ( $bot ) {
                        echo 1;
                    }
                } else {
                    if ( $botu[0]->rule2 ) {
                        $bot = $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$botu[0]->bot_id, $this->CI->ecl('Instance')->user(), 'rule2', 0]);
                        if ( $bot ) {
                            echo 1;
                        }
                    } else {
                        $bot = $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$botu[0]->bot_id, $this->CI->ecl('Instance')->user(), 'rule2', 1]);
                        if ( $bot ) {
                            echo 1;
                        }                        
                    }
                }
                break;
            case '2':
                $res = $this->CI->input->get('res', TRUE);
                if ( !is_numeric($res) ) {
                    exit();
                }
                if ($this->CI->input->post()) {
                    $this->CI->form_validation->set_rules('comment', 'Comment', 'trim');
                    // Get data
                    $comment = $this->CI->input->post('comment');
                    if ($this->CI->form_validation->run()) {
                        $res = $this->CI->input->get('res', TRUE);
                        if ( !is_numeric($res) ) {
                            exit();
                        }
                        $botu = $this->CI->ecl('Instance')->mod('botis', 'check_bot', ['dmitas-opts', $this->CI->ecl('Instance')->user(), $res]);
                        if ( !$botu ) {
                            $bot = $this->CI->ecl('Instance')->mod('botis', 'save_bot', ['dmitas-opts', $this->CI->ecl('Instance')->user(), $res, 0, $comment]);
                            if ( $bot ) {
                                echo 1;
                            }
                        } else {
                            if ( $botu[0]->rule2 ) {
                                $bot = $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$botu[0]->bot_id, $this->CI->ecl('Instance')->user(), 'rule3', $comment]);
                                if ( $bot ) {
                                    echo 1;
                                }
                            } else {
                                $bot = $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$botu[0]->bot_id, $this->CI->ecl('Instance')->user(), 'rule3', $comment]);
                                if ( $bot ) {
                                    echo 1;
                                }                        
                            }
                        }
                    }
                }
                break;
            case '3':
                $res = $this->CI->input->get('res', TRUE);
                if(!is_numeric($res)) {
                    exit();
                }       
                $bots = $this->CI->ecl('Instance')->mod('botis', 'check_bot', ['dmitas-opts', $this->CI->ecl('Instance')->user(), $res]);
                if($bots) {
                    echo json_encode($bots);
                }
                break;
            case '4':
                $res = $this->CI->input->get('res', TRUE);
                if(!is_numeric($res)) {
                    exit();
                }
                $account_owner = $this->CI->ecl('Instance')->mod('networks', 'get_account', [$res]);
                if ( !$account_owner ) {
                    exit();
                }
                $botis = $this->CI->ecl('Instance')->mod('botis', 'get_bot', [['type' => 'dmitas-account', 'rule1' => $account_owner[0]->network_id]]);
                if ( !$botis ) {
                    exit();
                }
                $res = $botis[0]->bot_id;
                $page = $this->CI->input->get('page', TRUE);
                if(!is_numeric($page)) {
                    exit();
                } else {
                    $page--;
                    $page = $page * 10;
                }
                $get_all_bots = $this->CI->ecl('Instance')->mod('botis', 'get_all_bots', ['dmitas-follow', $this->CI->ecl('Instance')->user(), $res, $page]);
                if($get_all_bots) {
                    $total = count($this->CI->ecl('Instance')->mod('botis', 'get_all_bots', ['dmitas-follow', $this->CI->ecl('Instance')->user(), $res]));
                    echo json_encode(['users' => $get_all_bots, 'total' => $total, 'date' => time()]);
                }
                break;
            case '5':
                $res = $this->CI->input->get('res', TRUE);
                if ( !is_numeric($res) ) {
                    exit();
                }
                
                $get_all_bots = $this->CI->ecl('Instance')->mod('botis', 'get_bot', [['type' => 'dmitas-follow', 'rule5 >' => 0]]);
                if ( $get_all_bots ) {
                    $sent = $this->CI->ecl('Instance')->mod('botis', 'get_bot', [['type' => 'dmitas-follow', 'rule5' => 2]]);
                    if ( $sent ) {
                        $sent = count($sent);
                    } else {
                        $sent = 0;
                    }
                    echo json_encode('<ul class="list-unstyled">
                                        <li>' . $this->CI->lang->line('mb82') . ' <span class="pull-right">' . count($get_all_bots) . '</span></li>
                                        <li>' . $this->CI->lang->line('mb83') . ' <span class="pull-right">' . $sent . '</span></li>
                                    </ul>');
                } else {
                    echo json_encode('<ul class="list-unstyled">
                                        <li>' . $this->CI->lang->line('mb82') . ' <span class="pull-right">0</span></li>
                                        <li>' . $this->CI->lang->line('mb83') . ' <span class="pull-right">0</span></li>
                                    </ul>');
                }
                break;                
        }
    }

    /**
     * This function displays information about this class.
     */
    public function get_info() {
        return (object) array(
            'name' => 'Dmitas',
            'slug' => 'dmitas',
            'description' => 'Replies with private messages to new followers and follow them back'
        );
    }
    
    /**
     * This function runs the bot schedules
     * 
     * @param integer $user_id contains the user_id
     */
    public function load_cron($user_id) {
        $check2 = rand(0,5);
        if($check2 == 2) {
            $botis = $this->CI->ecl('Instance')->mod('botis', 'get_bot', [['user_id' => $user_id, 'type' => 'dmitas-opts', 'rule2' => 1], 1]);
            if ( $botis ) {
                $account_owner = $this->CI->ecl('Instance')->mod('networks', 'get_account', [$botis[0]->rule1]);
                include_once FCPATH . 'vendor/autoload.php';
                $check = new \InstagramAPI\Instagram(false, false);
                $user_proxy = $this->CI->user->get_user_option($user_id, 'proxy');
                if($user_proxy) {
                    $check->setProxy($user_proxy);
                } else {
                    $proxies = @trim(get_option('instagram_proxy'));
                    if ($proxies) {
                        $proxies = explode('<br>', nl2br($proxies, false));
                        $rand = rand(0, count($proxies));
                        if (@$proxies[$rand]) {
                            $check->setProxy($proxies[$rand]);
                        }
                    }   
                }
                $check->login($account_owner[0]->user_name, $account_owner[0]->token);
                $rankToken = \InstagramAPI\Signatures::generateUUID();
                $friends = $check->people->getSelfFollowers($rankToken);
                if ( @$friends->users ) {
                    $mi = 0;
                    $bots = $this->CI->ecl('Instance')->mod('botis', 'check_bot', ['dmitas-account', $user_id, $account_owner[0]->network_id]);
                    if ( !$bots ) {
                        $new_bot = $this->CI->ecl('Instance')->mod('botis', 'save_bot', ['dmitas-account', $user_id, $account_owner[0]->network_id]);
                    } else {
                        $new_bot = $bots;
                        $mi++;
                    }
                    foreach ( $friends->users as $res )
                    {
                        $botu = $this->CI->ecl('Instance')->mod('botis', 'check_bot', ['dmitas-follow', $user_id, $new_bot, $res->pk]);
                        if ( !$botu ) {
                            $new = $this->CI->ecl('Instance')->mod('botis', 'save_bot', ['dmitas-follow', $user_id, $new_bot,$res->pk, $res->username, $res->full_name, $res->profile_pic_url, 1]);
                            if ( $mi > 0 ) {
                                if ( $new ) {
                                    if ( $check->people->follow($res->pk) ) {
                                        $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$new, $user_id, 'rule5', 1]);
                                    }
                                    if ( $botis[0]->rule3 ) {
                                        if ( $check->direct->sendText(['users'=>[$res->pk]], $botis[0]->rule3) ) {
                                            $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$new, $user_id, 'rule5', 2]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }    
}
