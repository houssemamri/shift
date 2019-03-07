<?php
/**
 * Instavy
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
class Instavy implements Boots {
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
        $search = '<div class="col col-xl-12 search-zon">
                        <div class="input-group search">
                            <input type="text" placeholder="' . $this->CI->lang->line('mb47') . '" class="form-control search_users">
                            <span class="input-group-append search-m">
                                <button class="btn save-search" type="button"><i class="far fa-save"></i></button>
                                <button class="btn search-users" type="button"><i class="fas fa-binoculars"></i></button>
                            </span>
                        </div>
                    </div>';
        if(($this->username == '') || ($this->password == '')) {
            $search = '<p>' . $this->CI->lang->line('mb50') . '</p>';
        }
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
                                                <a href="#twilos_main" class="active nav-link" data-toggle="tab">
                                                    ' . $this->CI->lang->line('mb47') . '
                                                </a>
                                            </li>
                                            <li class="nav-item leprom">
                                                <a href="#saved_search" class="nav-link" data-toggle="tab">
                                                    ' . $this->CI->lang->line('mb23') . '
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="panel-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="twilos_main">
                                                <div class="row">
                                                    ' . $search . '
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <ul class="user-results">

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="saved_search">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <ul class="search-results">
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 instavy-comments">
                            <div class="col-xl-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a href="#instavy-options" data-toggle="tab" class="nav-link active">
                                                    ' . $this->CI->lang->line('mb89') . '
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#instavy-members" data-toggle="tab" class="nav-link">
                                                    ' . $this->CI->lang->line('mb90') . '
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#instavy-stats" data-toggle="tab" class="nav-link">
                                                    ' . $this->CI->lang->line('mb91') . '
                                                </a>
                                            </li>                                
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="instavy-options">
                                            <div class="setrow row">
                                                <div class="col-xl-10 col-sm-9 col-xs-9">' . $this->CI->lang->line('mb49') . '</div>
                                                <div class="col-xl-2 col-sm-3 col-xs-3 text-right instavy-account-select">
                                                    <a href="" data-toggle="modal" data-target="#new-contu">@' . $this->CI->lang->line('mb48') . '</a>
                                                </div>
                                            </div>
                                            <div class="setrow row">
                                                <div class="col-xl-10 col-sm-9 col-xs-9">' . $this->CI->lang->line('mb32') . '</div>
                                                <div class="col-xl-2 col-sm-3 col-xs-3 text-right instavy-status">
                                                    active
                                                </div>
                                            </div>
                                            <div class="setrow row">
                                                <div class="col-xl-10 col-sm-9 col-xs-9">' . $this->CI->lang->line('mb29') . '</div>
                                                <div class="col-xl-2 col-sm-3 col-xs-3 text-right">
                                                    <div class="checkbox-option pull-right">
                                                        <input id="instavy_auto_follow" name="instavy_auto_follow" class="setopti" type="checkbox">
                                                        <label for="instavy_auto_follow"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="setrow row">
                                                <div class="col-xl-10 col-sm-9 col-xs-9">' . $this->CI->lang->line('mb30') . '</div>
                                                <div class="col-xl-2 col-sm-3 col-xs-3 text-right">
                                                    <div class="checkbox-option pull-right">
                                                        <input id="instavy_auto_unfollow" name="instavy_auto_unfollow" class="setopti" type="checkbox">
                                                        <label for="instavy_auto_unfollow"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="setrow row">
                                                <div class="col-xl-10 col-sm-9 col-xs-9">' . $this->CI->lang->line('mb31') . '</div>
                                                <div class="col-xl-2 col-sm-3 col-xs-3 text-right">
                                                    <div class="checkbox-option pull-right">
                                                        <input id="instavy_delete" name="instavy_delete" class="setopti" type="checkbox">
                                                        <label for="instavy_delete"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="instavy-members">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <ul class="instavy-members-results">
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
                                        <div class="tab-pane" id="instavy-stats">

                                        </div>                            
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="modal fade" id="new-contu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                            '.form_open('#', ['class' => 'add-accounts']).'
                                <div class="form-group multiple-form-group input-group">
                                    <div class="input-group-btn input-group-select">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                            <span class="concept">Instagram</span>
                                        </button>
                                    </div>
                                    <input type="text" name="" placeholder="' . $this->CI->lang->line('mu88') . '" class="form-control search-conts">
                                </div>
                            '.form_close().'
                                <div class="table-responsive"> 
                                    <table class="table table-sm table-hover">
                                        <tbody class="accounts-found">
                                            <tr><td>' . $this->CI->lang->line('mm127') . '</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
    }
    
    public function assets() {
        $this->CI = $this->CI;
        return '<script language="javascript">'
        . 'window.onload = function(){
                var home = document.getElementsByClassName(\'home-page-link\')[0];
                var twi = {\'page\': 1, \'limit\': 10, \'cid\': 0};
                function search_users(e) {
                    e.preventDefault();
                    var key = document.getElementsByClassName(\'search_users\')[0].value;
                    document.getElementsByClassName(\'page-loading\')[0].style.display = \'block\';
                    var url = home+\'user/bot/instavy?action=1&key=\'+key;
                    var http = new XMLHttpRequest();
                    http.open(\'GET\', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if(data){
                                data = JSON.parse(data);
                                var tot = \' \';
                                for(var m = 0; m < data.length; m++) {
                                    tot += \'<li><div class="row"><div class="col-xl-1 col-sm-2 col-xs-2"><img src="\' + data[m][3] + \'"></div><div class="col-xl-11 col-sm-10 col-xs-10"><h3>\' + data[m][1] + \'</h3><h4>' . $this->CI->lang->line('mb68') . ': \' + data[m][2] + \'</h4></div></div></li>\';
                                }
                                document.querySelector(\'.user-results\').innerHTML = tot;
                                document.querySelector(\'#twilos_main .search .btn.save-search\').style.visibility = \'visible\';
                                reload_it();
                            } else {
                                document.querySelector(\'.user-results\').innerHTML = \'<p class="no-results-found clean">' . $this->CI->lang->line('mb36') . '</p>\';
                            }
                            document.getElementsByClassName(\'page-loading\')[0].style.display = \'none\';
                        }
                    }
                    http.send();
                }
                function search_usi() {
                    document.querySelector(\'#twilos_main .search .btn.save-search\').style.visibility = \'hidden\';
                }
                function follow() {
                    var dthis = this;
                    var user = dthis.closest(\'li\').getAttribute(\'data-id\');
                    var url = home+\'user/bot/instavy?action=9&user=\' + user + \'&res=\' + twi.cid;
                    var http = new XMLHttpRequest();
                    http.open(\'GET\', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if(data == 1) {
                                Main.popup_fon(\'subi\', \'' . $this->CI->lang->line('mb51') . '\', 1500, 2000);
                                dthis.style.display = \'none\';
                                dthis.closest(\'li\').querySelector(\'.label-danger\').style.display = \'block\';
                                reload_it();
                                get_stats();
                            } else if(data == 2) {
                                Main.popup_fon(\'sube\', \'' . $this->CI->lang->line('mb33') . '\', 1500, 2000);
                            }
                        }
                    }
                    http.send();
                }
                function unfollow() {
                    var dthis = this;
                    var user = dthis.closest(\'li\').getAttribute(\'data-id\');
                    var url = home+\'user/bot/instavy?action=10&user=\' + user + \'&res=\' + twi.cid;
                    var http = new XMLHttpRequest();
                    http.open(\'GET\', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if(data == 1) {
                                Main.popup_fon(\'subi\', \'' . $this->CI->lang->line('mb42') . '\', 1500, 2000);
                                dthis.style.display = \'none\';
                                dthis.closest(\'li\').querySelector(\'.label-default\').style.display = \'block\';
                                reload_it();
                                get_stats();
                            }
                        }
                    }
                    http.send();
                }
                function save_search(e) {
                    e.preventDefault();
                    document.getElementsByClassName(\'page-loading\')[0].style.display = \'block\';
                    var key = document.getElementsByClassName(\'search_users\')[0].value;
                    var url = home+\'user/bot/instavy?action=2&key=\'+key;
                    var http = new XMLHttpRequest();
                    http.open(\'GET\', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if(data > 0) {
                                document.querySelector(\' .leprom a\').click();
                                document.getElementsByClassName(\'page-loading\')[0].style.display = \'none\';
                                document.getElementsByClassName(\'search_users\')[0].value = \'\';
                                document.getElementsByClassName(\'user-results\')[0].innerHTML = \'\';
                                document.querySelector(\'#twilos_main .search .btn.save-search\').style.visibility = \'hidden\';
                                show_searches(1);
                            } else {
                                Main.popup_fon(\'sube\', Main.translation.mm3, 1500, 2000);
                            }
                        }
                    }
                    http.send();
                }
                function pnumi(e){
                    e.preventDefault();
                    var dez = this.closest(\'.tab-pane\').getAttribute(\'id\');
                    if(dez === \'saved_search\') {
                        show_searches(this.getAttribute(\'data-page\'));
                    }
                }
                function manage_search(e){
                    e.preventDefault();
                    var dez = this.getAttribute(\'data-id\');
                    if(dez) {
                        twi.cid = dez;
                        show_members();
                    }
                }
                function search_conts(){
                    var key = document.getElementsByClassName(\'search-conts\')[0].value;
                    if(!key) {
                        return;
                    }
                    var url = home+\'user/bot/instavy?action=5&key=\' + key;
                    var http = new XMLHttpRequest();
                    http.open(\'GET\', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if(data){
                                data = JSON.parse(data);
                                var show = \'\';
                                for(var o = 0; o < data.length; o++){
                                    show += \'<tr><td>\'+data[o].user_name+\'</td><td style="text-align: right;"><button class="btn-add-to-account btn btn-default btn-xs" type="button" data-id="\' + data[o].network_id + \'"><i class="fa fa-plus" aria-hidden="true"></i></button></td></tr>\';
                                }
                                document.getElementsByClassName(\'accounts-found\')[0].innerHTML = show;
                                reload_it();
                            } else {
                                document.getElementsByClassName(\'accounts-found\')[0].innerHTML = \'<tr><td>' . $this->CI->lang->line('mm127') . '</td></tr>\';                            
                            }
                        }
                    }
                    http.send();
                }
                function load_options() {
                    document.getElementsByClassName(\'instavy-comments\')[0].style.display = \'block\';
                    document.getElementById(\'instavy_auto_follow\').checked = false;
                    document.getElementById(\'instavy_auto_unfollow\').checked = false;
                    document.getElementsByClassName(\'instavy-status\')[0].innerText = \'inactive\';
                    document.getElementsByClassName(\'instavy-status\')[0].style.color = \'#F44336\';
                    var url = home+\'user/bot/instavy?action=7&res=\' + twi.cid;
                    var http = new XMLHttpRequest();
                    http.open(\'GET\', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if(data){
                                data = JSON.parse(data);
                                if(data[0].rule2) {
                                    document.getElementsByClassName(\'instavy-account-select\')[0].innerHTML = \'@\' + data[0].rule2;
                                } else {
                                    document.getElementsByClassName(\'instavy-account-select\')[0].innerHTML = \'<a href="#" data-toggle="modal" data-target="#new-contu">@account</a>\';
                                }
                                if(data[0].rule3 > 0) {
                                    document.getElementById(\'instavy_auto_follow\').checked = true;
                                }
                                if(data[0].rule4 > 0) {
                                    document.getElementById(\'instavy_auto_unfollow\').checked = true;
                                }
                                if(data[0].rule5 > 0) {
                                    document.getElementsByClassName(\'instavy-status\')[0].innerText = \'active\';
                                    document.getElementsByClassName(\'instavy-status\')[0].style.color = \'#337ab7\';
                                }                              
                            } else {
                                document.getElementsByClassName(\'instavy-account-select\')[0].innerHTML = \'<a href="#" data-toggle="modal" data-target="#new-contu">@' . $this->CI->lang->line('mb48') . '</a>\';
                            }
                        }
                    }
                    http.send();
                }
                function add_netu_to_list(e){
                    e.preventDefault();
                    var id = this.getAttribute(\'data-id\');
                    document.querySelector(\'.modal.fade.show\').click();
                    document.getElementsByClassName(\'search-conts\')[0].value = \'\';
                    document.getElementsByClassName(\'accounts-found\')[0].innerHTML = \'<tr><td>' . $this->CI->lang->line('mm127') . '</td></tr>\';
                    var url = home+\'user/bot/instavy?action=6&id=\' + id + \'&res=\' + twi.cid;
                    var http = new XMLHttpRequest();
                    http.open(\'GET\', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if(data){
                                data = JSON.parse(data);
                                document.getElementsByClassName(\'instavy-account-select\')[0].innerHTML = \'@\' + data;
                                show_members();
                                reload_it();
                            } else {
                                Main.popup_fon(\'sube\', Main.translation.mm3, 1500, 2000);
                            }
                        }
                    }
                    http.send();
                }
                function setopti(){
                    var id = this.getAttribute(\'id\');
                    var checked = this.checked;
                    var val = 0;
                    if(checked) {
                        val++;
                    }
                    var url = home+\'user/bot/instavy?action=8&type=\' + id + \'&val=\' + val + \'&res=\' + twi.cid;
                    var http = new XMLHttpRequest();
                    http.open(\'GET\', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if(data) {
                                if(id === \'instavy_auto_follow\') {
                                    document.getElementById(\'instavy_auto_unfollow\').checked = false;
                                } else if(id === \'instavy_auto_unfollow\') {
                                    document.getElementById(\'instavy_auto_follow\').checked = false;
                                } else if(id === \'instavy_delete\') {
                                    Main.popup_fon(\'subi\', \'' . $this->CI->lang->line('mb34') . '\', 1500, 2000);
                                    document.getElementsByClassName(\'instavy-comments\')[0].style.display = \'none\';
                                    document.getElementById(\'instavy_delete\').checked = false;
                                    show_searches(1);
                                    setTimeout(reload_it,500);
                                    return;
                                }
                                if(val > 0) {
                                    document.getElementsByClassName(\'instavy-status\')[0].innerText = \'active\';
                                    document.getElementsByClassName(\'instavy-status\')[0].style.color = \'#337ab7\';
                                } else {
                                    document.getElementsByClassName(\'instavy-status\')[0].innerText = \'inactive\';
                                    document.getElementsByClassName(\'instavy-status\')[0].style.color = \'#F44336\';
                                }
                            } else {
                                if(id === \'instavy_delete\') {
                                    Main.popup_fon(\'sube\', Main.translation.mm3, 1500, 2000);
                                } else {
                                    document.getElementById(\'instavy_auto_follow\').checked = false;
                                    document.getElementById(\'instavy_auto_unfollow\').checked = false;
                                    Main.popup_fon(\'sube\', \'' . $this->CI->lang->line('mb33') . '\', 1500, 2000);
                                }
                            }
                        }
                    }
                    http.send();
                }                
                function reload_it() {
                    var users_search = document.getElementsByClassName(\'search-users\');
                    if(users_search.length) {
                        if(users_search[0].addEventListener){
                            users_search[0].addEventListener(\'click\', search_users, false);
                        } else if(users_search[0].attachEvent) {
                            users_search[0].attachEvent(\'onclick\', search_users);
                        }
                    }
                    var search_us = document.getElementsByClassName(\'search_users\');
                    if(search_us.length) {
                        if(search_us[0].addEventListener){
                            search_us[0].addEventListener(\'keyup\', search_usi, false);
                        } else if(search_us[0].attachEvent) {
                            search_us[0].attachEvent(\'onkeyup\', search_usi);
                        }
                    }
                    var save_sear = document.getElementsByClassName(\'save-search\');
                    if(save_sear.length) {
                        if(save_sear[0].addEventListener){
                            save_sear[0].addEventListener(\'click\', save_search, false);
                        } else if(save_sear[0].attachEvent) {
                            save_sear[0].attachEvent(\'onclick\', save_search);
                        }
                    }
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
                    var manage = document.getElementsByClassName(\'manage-saved-search\');
                    if(manage.length) {
                        if(manage[0].addEventListener) {
                            for(var f = 0; f < manage.length; f++) {
                                manage[f].addEventListener(\'click\', manage_search, false);
                            }
                        } else if(manage[0].attachEvent) {
                            for(var f = 0; f < manage.length; f++) {
                                manage[f].attachEvent(\'onclick\', manage_search);
                            }
                        }
                    }
                    var conts = document.getElementsByClassName(\'search-conts\');
                    if(conts.length) {
                        if(conts[0].addEventListener) {
                            conts[0].addEventListener(\'keyup\', search_conts, false);
                        } else if(conts[0].attachEvent) {
                            conts[0].attachEvent(\'onkeyup\', search_conts);
                        }
                    }
                    var add_net_to_list = document.getElementsByClassName(\'btn-add-to-account\');
                    if(add_net_to_list.length) {
                        if(add_net_to_list[0].addEventListener){
                            for(var f = 0; f < add_net_to_list.length; f++) {
                                add_net_to_list[f].addEventListener(\'click\', add_netu_to_list, false);
                            }
                        } else if(add_net_to_list[0].attachEvent) {
                            for(var f = 0; f < add_net_to_list.length; f++) {
                                add_net_to_list[f].attachEvent(\'onclick\', add_netu_to_list);
                            }
                        }
                    }
                    var setopt = document.getElementsByClassName(\'setopti\');
                    if(setopt.length) {
                        if(setopt[0].addEventListener) {
                            for(var f = 0; f < setopt.length; f++) {
                                setopt[f].addEventListener(\'click\', setopti, false);
                            }
                        } else if(setopt[0].attachEvent) {
                            for(var f = 0; f < setopt.length; f++) {
                                setopt[f].attachEvent(\'onclick\', setopti);
                            }
                        }
                    }
                    var btn_follow = document.getElementsByClassName(\'btn-follow\');
                    if(btn_follow.length) {
                        if(btn_follow[0].addEventListener) {
                            for(var f = 0; f < btn_follow.length; f++) {
                                btn_follow[f].addEventListener(\'click\', follow, false);
                            }
                        } else if(btn_follow[0].attachEvent) {
                            for(var f = 0; f < btn_follow.length; f++) {
                                btn_follow[f].attachEvent(\'onclick\', follow);
                            }
                        }
                    }
                    var btn_unfollow = document.getElementsByClassName(\'btn-unfollow\');
                    if(btn_unfollow.length) {
                        if(btn_unfollow[0].addEventListener) {
                            for(var f = 0; f < btn_unfollow.length; f++) {
                                btn_unfollow[f].addEventListener(\'click\', unfollow, false);
                            }
                        } else if(btn_unfollow[0].attachEvent) {
                            for(var f = 0; f < btn_unfollow.length; f++) {
                                btn_unfollow[f].attachEvent(\'onclick\', unfollow);
                            }
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
                        pages += \'<li class="page-item active"><a data-page="\' + p + \'">\' + p + \'</a></li>\';
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
                    var url = home+\'user/bot/instavy?action=3&page=\' + num;
                    var http = new XMLHttpRequest();
                    http.open(\'GET\', url, true);
                    http.onreadystatechange = function() {
                        var data = http.responseText;
                        if(data) {
                            data = JSON.parse(http.responseText);
                            show_pagination(data.total,\'#saved_search\');
                            var tot = \' \';
                            for(var m = 0; m < data.members.length; m++) {
                                tot += \'<li><div class="row"><div class="col-xl-10 col-sm-10 col-xs-10"><h3>\' + data.members[m][1] + \'</h3><h4>\' + data.members[m][2] + \' ' . $this->CI->lang->line('mb87') . '</h4></div><div class="col-xl-2 col-sm-2 col-xs-2 text-right"><button type="button" data-id="\' + data.members[m][0] + \'" class="btn btn-labeled btn-primary manage-saved-search"><span class="btn-label">' . $this->CI->lang->line('mb67') . '</span></button></div></div></li>\';
                            }
                            document.querySelector(\'#saved_search .search-results\').innerHTML = tot;
                            setTimeout(reload_it,500);
                        } else {
                            document.querySelector(\'#saved_search .search-results\').innerHTML = \'<p class="no-results-found clean">' . $this->CI->lang->line('mb35') . '</p>\';
                        }
                    }
                    http.send();
                }
                function show_members() {
                    var url = home+\'user/bot/instavy?action=4&res=\' + twi.cid;
                    var http = new XMLHttpRequest();
                    http.open(\'GET\', url, true);
                    http.onreadystatechange = function() {
                        var data = http.responseText;
                        if(data) {
                            if(data.search(\']\') < 0) {
                                return;
                            }
                            load_options();
                            get_stats();
                            data = JSON.parse(data);
                            var tot = \' \';
                            for(var m = 0; m < data.length; m++) {
                                var si = \'<button type="button" class="btn label label-success btn-follow pull-right">' . $this->CI->lang->line('mb37') . '</button><button type="button" class="btn label label-danger btn-unfollow pull-right note-group-select-from-files">' . $this->CI->lang->line('mb38') . '</button><button type="button" class="btn label label-default pull-right note-group-select-from-files">' . $this->CI->lang->line('mb39') . '</button>\';
                                if(data[m].fol == 1) {
                                    si = \'<button type="button" class="btn label label-danger btn-unfollow pull-right">' . $this->CI->lang->line('mb38') . '</button><button type="button" class="btn label label-default pull-right note-group-select-from-files">' . $this->CI->lang->line('mb39') . '</button>\';
                                } else if(data[m].fol == 2) {
                                    si = \'<button type="button" class="btn label label-default pull-right">' . $this->CI->lang->line('mb39') . '</button>\';
                                }
                                tot += \'<li data-id="\' + data[m].rule2 + \'"><div class="row"><div class="col-xl-1 col-sm-2 col-xs-2"><img src="\' + data[m].rule7 + \'"></div><div class="col-xl-11 col-sm-10 col-xs-10"><h3>\' + data[m].rule3 + si + \'</h3><h4>' . $this->CI->lang->line('mb68') . ': \' + data[m].rule4 + \'</h4></div></div></li>\';
                            }
                            document.querySelector(\'.instavy-members-results\').innerHTML = tot;
                            reload_it();
                        }
                    }
                    http.send();
                }
                function get_stats() {
                    var url = home+\'user/bot/instavy?action=11&res=\' + twi.cid;
                    var http = new XMLHttpRequest();
                    http.open(\'GET\', url, true);
                    http.onreadystatechange = function() {
                        var data = http.responseText;
                        if(data) {
                            data = JSON.parse(data);
                            document.querySelector(\'#instavy-stats\').innerHTML = data;
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
                . '.instavy-comments,
                   .fa-times,
                   .note-group-select-from-files {
                    display: none;
                }'
                . '.fa-circle, .fa-circle-thin {
                    color: #71d775;
                    font-size: 13px;
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
                . '.search-zon, .user-results > li, .search-results > li, .instavy-members-results > li {
                    padding: 0 15px;
                    min-height: 62px;
                    border: 1px solid #ebedf2;
                    margin-bottom: 15px;
                    padding-top: 5px;
                }'
                . '.search-zon {
                    min-height: 40px;
                    border: 0;
                    padding-top: 0;
                }'                
                . '.search-zon .search_users {
                    border: 1px solid #ebedf2;
                    border-radius: 3px;
                }'  
                . '.search-zon .search-m .btn {
                    height: 38px;
                    box-shadow: none;
                    border: 0;
                    color: #fff;
                    margin-left: 5px;
                    border-radius: 5px;
                    display: block !important;
                }' 
                . '.search-zon .search-users  {
                    background-color: #fd3973;
                    border-color: #fd3973;
                    color: #FFFFFF;
                }' 
                . '.search-zon .search-m .btn:hover {
                    opacity: 0.7;
                }' 
                . '.search-zon .search-users i,
                    .search-zon .search-m .btn i {
                    margin-right: 0;
                }'                
                . '#twilos_main, #saved_search, #instavy-members, #instavy-options {
                    padding: 15px;
                    min-height: 60px;
                }'              
                . '#twilos_main .search .btn.save-search {
                    background: #a5c57d !important;
                    border-radius: 5px;
                    visibility: hidden;
                }'
                . '#twilos_main .search .btn.save-search:hover {
                    background: #99b774 !important;
                }'                
                . '.search .input-group-btn>.btn {
                    margin-left: -1px;
                }'
                . '.instavy-members-results {
                    padding: 0;
                }'
                . 'li > div > .col-xl-1 > img {
                    max-width: 50px;
                }'                
                . '.search-results > li {
                    list-style: none;
                    height: auto;
                    min-height: 66px;
                    padding: 5px 10px !important;
                    margin-bottom: 15px;
                }'                
                 . '.user-results > li > div > div > h3, .instavy-members-results > li > div > div > h3, .search-results > li > div > div > h3 {
                    margin: 0;
                    font-size: 16px;
                    margin-top: 7px;
                }'
                 . '.user-results > li > div > div > h4, .instavy-members-results > li > div > div > h4, .search-results > li > div > div > h4 {
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
                 . '.label-success {
                    background-color: #a5c57d;
                    background: #a5c57d;
                    color: #FFFFFF;
                    margin-top: 5px;
                    border: 0;
                }'
                 . '.label-danger {
                    background-color: #F6694D;
                    background: #F6694D;
                    color: #FFFFFF;
                    margin-top: 5px;
                    border: 0;
                }'
                 . '.label-default {
                    background-color: #A0D46A;
                    background: #A0D46A;
                    color: #FFFFFF;
                    margin-top: 5px;
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
                 . '.search-conts {
                    border: 1px solid #ebedf2;
                    margin-top: 12px;
                }'
                 . '.modal-body .dropdown-toggle {
                    margin-top: 12px;
                    margin-top: 12px;
                    pointer-events: none;
                    background-color: transparent;
                    border: 1px solid #ebedf2;
                    border-right: 0;
                    border-radius: 3px 0 0 3px;
                }'
                 . '.modal-body .dropdown-toggle::after {
                    display: none;
                }'                
                 . '.modal-body .btn-add-to-account {
                    height: 24px !important;
                    padding: 1px 5px !important;
                    font-size: 12px !important;
                    border: 1px solid #ebedf2;
                    background-color: transparent;
                }'
                 . '.modal-body .btn-add-to-account i {
                    margin-right: 0;
                }'
                 . '.modal-body .table-responsive > .table > tbody > tr:hover {
                    background-color: transparent;
                }'
                 . '.modal-body .table-responsive > .table > tbody > tr:first-child > td {
                    border-top: 1px solid #ebedf2;
                }'
                 . '.instavy-status {
                    color: #337ab7;
                    font-weight: 600;
                }'
                 . '#instavy-stats {
                    padding: 15px;
                }'
                 . '#instavy-stats > ul > li {
                    border-radius: 3px;
                    border: 1px solid #e1e8ed;
                    padding: 10px;
                    margin-bottom: 15px;
                }'
                . '#instavy-stats > ul > li > span {
                    font-weight: 600;
                    color: #9C27B0;
                    font-size: 16px;
                }' 
                . '.tool-page .panel-body #twilos_main ul.user-results,
                   .tool-page #instavy-members ul.instavy-members-results {
                    margin-top: 15px;
                }'
                . '.tool-page .panel-body #twilos_main ul.user-results > li,
                   .tool-page #instavy-members ul.instavy-members-results > li {
                    padding: 15px;
                    min-height: 82px;
                    height: auto;
                    border: 1px solid #edf2f9;
                    border-radius: 3px;
                }' 
                . '.tool-page #instavy-members ul.instavy-members-results > li {
                    padding: 15px 0;
                    list-style: none;
                    margin-bottom: 15px;
                }'
                . '.setrow {
                    line-height: 60px;
                    font-size: 15px;
                    padding-right: 15px;
                }' 
                . '.setrow label {
                    margin-right: 0 !important;
                }'
                . '.setrow a:hover {
                    border: 0;
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
                $key = $this->CI->input->get('key', TRUE);
                if($key) {
                    $user_proxy = $this->CI->user->get_user_option($this->CI->ecl('Instance')->user(),'proxy');
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
                    $check->login($this->username, $this->password);
                    $search = $check->people->search($key);
                    if(@$search->users) {
                        $tot = [];
                        $i = 0;
                        foreach ($search->users as $res) {
                            if($i > 19) {
                                break;
                            }
                            $tot[] = [$res->pk, $res->username, $res->full_name, $res->profile_pic_url];
                            $i++;
                        }
                        echo json_encode($tot);
                    }
                }
                break;
            case '2':
                $key = $this->CI->input->get('key', TRUE);
                if($key) {
                    $user_proxy = $this->CI->user->get_user_option($this->CI->ecl('Instance')->user(),'proxy');
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
                    $check->login($this->username, $this->password);
                    $search = $check->people->search($key);
                    if(@$search->users) {
                        $new_bot = $this->CI->ecl('Instance')->mod('botis', 'save_bot', ['instavy-search', $this->CI->ecl('Instance')->user(),$key]);
                        $count = 0;
                        foreach ($search->users as $res) {
                            $this->CI->ecl('Instance')->mod('botis', 'save_bot', ['instavy-follow', $this->CI->ecl('Instance')->user(),$new_bot,$res->pk, $res->username, $res->full_name, $res->profile_pic_url, 1]);
                            $count++;
                        }
                        if($count > 0) {
                            echo 1;
                        }
                    }
                }
                break;
            case '3':
                $page = $this->CI->input->get('page', TRUE);
                if(!is_numeric($page)) {
                    exit();
                } else {
                    $page--;
                    $page = $page * 10;
                }
                $get_all_bots = $this->CI->ecl('Instance')->mod('botis', 'get_all_bots', ['instavy-search', $this->CI->ecl('Instance')->user(),0,$page]);
                if($get_all_bots) {
                    $total = count($this->CI->ecl('Instance')->mod('botis', 'get_all_bots', ['instavy-search', $this->CI->ecl('Instance')->user()]));
                    $members = [];
                    $i = 0;
                    foreach ($get_all_bots as $bot) {
                        $toti = count($this->CI->ecl('Instance')->mod('botis', 'get_all_bots', ['instavy-follow', $this->CI->ecl('Instance')->user(),$bot->bot_id]));
                        $members[] = [$bot->bot_id,$bot->rule1,$toti];
                        $i++;
                    }
                    echo json_encode(['members' => $members, 'total' => $total]);
                }
                break;
            case '4':
                $res = $this->CI->input->get('res', TRUE);
                if(!is_numeric($res)) {
                    exit();
                }
                $get_all_bots = $this->CI->ecl('Instance')->mod('botis', 'get_all_bots', ['instavy-follow', $this->CI->ecl('Instance')->user(), $res]);
                if($get_all_bots) {
                    $members = [];
                    foreach($get_all_bots as $bot) {
                        $fol = 0;
                        $bots = $this->CI->ecl('Instance')->mod('botis', 'check_bot', ['instavy-opts', $this->CI->ecl('Instance')->user(), $res]);
                        if(@$bots[0]->rule6) {
                            $account = $this->CI->ecl('Instance')->mod('networks', 'get_account', [$bots[0]->rule6]);
                            if($account) {
                                $check = $this->CI->ecl('Instance')->mod('botis', 'get_bot', [['type' => 'instavy-follow', 'rule2' => $bot->rule2, 'rule6' => $account[0]->net_id]]);
                                if($check) {
                                    if($check[0]->rule5 == 1) {
                                        $fol = 1;
                                    } else if($check[0]->rule5 == 2) {
                                        $fol = 2;
                                    }
                                }
                            }
                        }
                        $members[] = ['rule2' => $bot->rule2, 'rule3' => $bot->rule3, 'rule4' => $bot->rule4, 'fol' => $fol, 'rule7' => $bot->rule7];
                    }
                    echo json_encode($members);
                }
                break;
            case '5':
                $key = $this->CI->input->get('key', TRUE);
                if(!$key) {
                    exit();
                }
                $this->CI->load->helper('second_helper');
                get_accounts_by_search('instagram',$key);
                break;
            case '6':
                $res = $this->CI->input->get('res', TRUE);
                if(!is_numeric($res)) {
                    exit();
                }
                $id = $this->CI->input->get('id', TRUE);
                if(!is_numeric($id)) {
                    exit();
                }
                // First we need to verify if the user is owner of the bot
                $bot_owner = $this->CI->ecl('Instance')->mod('botis', 'check_bota', [$res, 'instavy-search', $this->CI->ecl('Instance')->user()]);
                if(!$bot_owner) {
                    exit();
                }
                // Then verify if user is the owner of the id
                $account_owner = $this->CI->ecl('Instance')->mod('networks', 'get_account', [$id]);
                if($account_owner[0]->user_id != $this->CI->ecl('Instance')->user()) {
                    exit();
                }
                // Verify if the social network is correct
                if ( $account_owner[0]->network_name != 'instagram' ) {
                    exit();
                }
                $bot_id = $this->CI->ecl('Instance')->mod('botis', 'check_bot', ['instavy-opts', $this->CI->ecl('Instance')->user(), $res]);
                if(!$bot_id) {
                    $bot = $this->CI->ecl('Instance')->mod('botis', 'save_bot', ['instavy-opts', $this->CI->ecl('Instance')->user(), $res, $account_owner[0]->user_name]);
                    if($bot) {
                        $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$bot, $this->CI->ecl('Instance')->user(), 'rule6', $id]);
                        echo json_encode($account_owner[0]->user_name);
                    }
                }
                break;
            case '7':
                $res = $this->CI->input->get('res', TRUE);
                if(!is_numeric($res)) {
                    exit();
                }            
                $bots = $this->CI->ecl('Instance')->mod('botis', 'check_bot', ['instavy-opts', $this->CI->ecl('Instance')->user(), $res]);
                if($bots) {
                    echo json_encode($bots);
                }
                break;
            case '8':
                $res = $this->CI->input->get('res', TRUE);
                if(!is_numeric($res)) {
                    exit();
                }
                $id = $this->CI->input->get('type', TRUE);
                if(($id != 'instavy_auto_follow') && ($id != 'instavy_auto_unfollow') && ($id != 'instavy_delete')) {
                    exit();
                }
                $val = $this->CI->input->get('val', TRUE);
                if(!is_numeric($val)) {
                    exit();
                }
                // First we need to verify if the user is owner of the bot
                $bot_owner = $this->CI->ecl('Instance')->mod('botis', 'check_bota', [$res, 'instavy-search', $this->CI->ecl('Instance')->user()]);
                if(!$bot_owner) {
                    exit();
                }              
                $bot_id = $this->CI->ecl('Instance')->mod('botis', 'check_bot', ['instavy-opts', $this->CI->ecl('Instance')->user(), $res]);
                if($id != 'instavy_delete') {
                    if($bot_id) {
                        if($id == 'instavy_auto_follow') {
                            if($this->CI->ecl('Instance')->mod('botis', 'update_bot', [$bot_id[0]->bot_id, $this->CI->ecl('Instance')->user(), 'rule3', $val])) {
                                $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$bot_id[0]->bot_id, $this->CI->ecl('Instance')->user(), 'rule4', 0]);
                                echo 1;
                            }
                            if($val == 1) {
                                $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$bot_id[0]->bot_id, $this->CI->ecl('Instance')->user(), 'rule5', 1]);
                            } else {
                                $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$bot_id[0]->bot_id, $this->CI->ecl('Instance')->user(), 'rule5', 0]);
                            }
                        } else if($id == 'instavy_auto_unfollow') {
                            if($this->CI->ecl('Instance')->mod('botis', 'update_bot', [$bot_id[0]->bot_id, $this->CI->ecl('Instance')->user(), 'rule4', $val])) {
                                $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$bot_id[0]->bot_id, $this->CI->ecl('Instance')->user(), 'rule3', 0]);
                                echo 1;
                            }
                            if($val == 1) {
                                $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$bot_id[0]->bot_id, $this->CI->ecl('Instance')->user(), 'rule5', 1]);
                            } else {
                                $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$bot_id[0]->bot_id, $this->CI->ecl('Instance')->user(), 'rule5', 0]);
                            }
                        }
                    }
                } else {
                    $del_bot = $this->CI->ecl('Instance')->mod('botis', 'delete_bot', ['instavy-search', $this->CI->ecl('Instance')->user(), $res]);
                    if($del_bot) {
                        echo 1;
                    }
                }
                break;
            case '9':
                $user = $this->CI->input->get('user', TRUE);
                if(!is_numeric($user)) {
                    exit();
                }
                $res = $this->CI->input->get('res', TRUE);
                if(!is_numeric($res)) {
                    exit();
                }
                $get_one_bot = $this->CI->ecl('Instance')->mod('botis', 'get_bot', [['type' => 'instavy-opts', 'rule1' => $res]]);
                if(!@$get_one_bot[0]->rule6) {
                    echo 2;
                    exit();
                }
                $account_owner = $this->CI->ecl('Instance')->mod('networks', 'get_account', [$get_one_bot[0]->rule6]);
                $user_proxy = $this->CI->user->get_user_option($this->CI->ecl('Instance')->user(),'proxy');
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
                $response = $check->people->follow($user);
                if($response) {
                    $check = $this->CI->ecl('Instance')->mod('botis', 'get_bot', [['type' => 'instavy-follow', 'rule1' => $res, 'rule2' => $user]]);
                    if($check) {
                        $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$check[0]->bot_id, $this->CI->ecl('Instance')->user(), 'rule5', 1]);
                        if($get_one_bot) {
                            if($get_one_bot[0]->rule6) {
                                if($account_owner) {
                                    $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$check[0]->bot_id, $this->CI->ecl('Instance')->user(), 'rule6', $account_owner[0]->net_id]);
                                }
                            }
                        }
                    }
                    echo 1;
                }
                break;
            case '10':
                $user = $this->CI->input->get('user', TRUE);
                if(!is_numeric($user)) {
                    exit();
                }
                $res = $this->CI->input->get('res', TRUE);
                if(!is_numeric($res)) {
                    exit();
                }
                $get_one_bot = $this->CI->ecl('Instance')->mod('botis', 'get_bot', [['type' => 'instavy-opts', 'rule1' => $res]]);
                if(!@$get_one_bot[0]->rule6) {
                    echo 2;
                    exit();
                }
                $account_owner = $this->CI->ecl('Instance')->mod('networks', 'get_account', [$get_one_bot[0]->rule6]);
                $user_proxy = $this->CI->user->get_user_option($this->CI->ecl('Instance')->user(),'proxy');
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
                $response = $check->people->unfollow($user);
                if($response) {
                    $check = $this->CI->ecl('Instance')->mod('botis', 'get_bot', [['type' => 'instavy-follow', 'rule1' => $res, 'rule2' => $user]]);
                    if($check) {
                        $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$check[0]->bot_id, $this->CI->ecl('Instance')->user(), 'rule5', 2]);
                    }
                    echo 1;
                }
                break;
            case '11':
                $res = $this->CI->input->get('res', TRUE);
                if(!is_numeric($res)) {
                    exit();
                }
                $sv = 0;
                $check = $this->CI->ecl('Instance')->mod('botis', 'get_bot', [['type' => 'instavy-follow', 'rule1' => $res]]);
                if($check) {
                    $sv = count($check);
                }
                $fw = 0;
                $check = $this->CI->ecl('Instance')->mod('botis', 'get_bot', [['type' => 'instavy-follow', 'rule1' => $res, 'rule5' => 1]]);
                if($check) {
                    $fw = count($check);
                }                
                $uw = 0;
                $check = $this->CI->ecl('Instance')->mod('botis', 'get_bot', [['type' => 'instavy-follow', 'rule1' => $res, 'rule5' => 2]]);
                if($check) {
                    $uw = count($check);
                } 
                echo json_encode('<ul class="list-unstyled">
                                    <li>' . $this->CI->lang->line('mb43') . ' <span class="pull-right">' . $sv . '</span></li>
                                    <li>' . $this->CI->lang->line('mb44') . ' <span class="pull-right">' . $fw . '</span></li>
                                    <li>' . $this->CI->lang->line('mb45') . ' <span class="pull-right">' . $uw . '</span></li>
                                </ul>');
                break;
        }
    }

    /**
     * This function displays information about this class.
     */
    public function get_info() {
        
        return (object) array(
            'name' => 'Instavy',
            'slug' => 'instavy',
            'description' => 'Find people on Instagram and follow/unfollow them automatically or manually'
        );
        
    }
    
    /**
     * This function runs the bot schedules
     * 
     * @param integer $user_id contains the user_id
     */
    public function load_cron($user_id) {
        include_once FCPATH . 'vendor/autoload.php';
        $check = new \InstagramAPI\Instagram(false, false);
        $check2 = rand(0,3);
        if($check2 == 2) {
            $get_one_bot = $this->CI->ecl('Instance')->mod('botis', 'get_bot', [['type' => 'instavy-opts', 'rule3' => 1, 'rule5' => 1, 'user_id' => $user_id]]);
            if($get_one_bot) {
                $count = count($get_one_bot)-1;
                if($count > 0) {
                    $count = rand(0,$count);
                }
                $id = $get_one_bot[$count]->rule6;
                $get_to_folow = $this->CI->ecl('Instance')->mod('botis', 'get_bot', [['type' => 'instavy-follow', 'rule1' => $get_one_bot[$count]->rule1, 'LENGTH(rule5) <' => 1, 'user_id' => $user_id]]);
                if($get_to_folow) {
                    $count = count($get_to_folow);
                    $count--;
                    if($count > 0) {
                        $count = rand(0,$count);
                    }
                    if($id) {
                        $account_owner = $this->CI->ecl('Instance')->mod('networks', 'get_account', [$id]);
                        if($account_owner) {
                            $user_proxy = $this->CI->user->get_user_option($user_id,'proxy');
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
                            $verify = $this->CI->ecl('Instance')->mod('botis', 'get_bot', [['type' => 'inlike-media', 'rule2' => $get_to_folow[$count]->rule2, 'rule5 >' => 0, 'rule6' => $account_owner[0]->net_id]]);
                            if($verify) {
                                $response = 1;
                            } else {
                                $response = $check->people->follow($get_to_folow[$count]->rule2);
                                $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$get_to_folow[$count]->bot_id, $user_id, 'rule6', $account_owner[0]->net_id]);
                            }
                            if($response) {
                                $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$get_to_folow[$count]->bot_id, $user_id, 'rule5', 1]);
                            }
                        }
                    }
                } else {
                    $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$get_one_bot[$count]->bot_id, $user_id, 'rule5', 0]);
                }
            }
        }
        $get_one_bot = $this->CI->ecl('Instance')->mod('botis', 'get_bot', [['type' => 'instavy-opts', 'rule4' => 1, 'rule5' => 1, 'user_id' => $user_id]]);
        if($get_one_bot) {
            $count = count($get_one_bot)-1;
            if($count > 0) {
                $count = rand(0,$count);
            }
            $id = $get_one_bot[$count]->rule6;
            $get_to_folow = $this->CI->ecl('Instance')->mod('botis', 'get_bot', [['type' => 'instavy-follow', 'rule1' => $get_one_bot[$count]->rule1, 'rule5' => 1, 'user_id' => $user_id]]);
            if($get_to_folow) {
                $count = count($get_to_folow);
                $count--;
                if($count > 0) {
                    $count = rand(0,$count);
                }
                if($id) {
                    $account_owner = $this->CI->ecl('Instance')->mod('networks', 'get_account', [$id]);
                    if($account_owner) {
                        $user_proxy = $this->CI->user->get_user_option($user_id,'proxy');
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
                        $verify = $this->CI->ecl('Instance')->mod('botis', 'get_bot', [['type' => 'inlike-media', 'rule2' => $get_to_folow[$count]->rule2, 'rule5 >' => 1, 'rule6' => $account_owner[0]->net_id]]);
                        if($verify) {
                            $response = 1;
                        } else {
                            $response = $check->people->unfollow($get_to_folow[$count]->rule2);
                        }
                        if($response) {
                            $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$get_to_folow[$count]->bot_id, $user_id, 'rule5', 2]);
                        }
                    }
                }
            } else {
                $this->CI->ecl('Instance')->mod('botis', 'update_bot', [$get_one_bot[$count]->bot_id, $user_id, 'rule5', 0]);
            }
        }
    }    
}
