<?php
/**
 * Posts_helper contains a trait for content displaying
 *
 * PHP Version 5.6
 *
 * Display content in the Posts Planner Tool
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
 * Posts_helper - display the content for the Posts Planner Tool
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
trait Posts_helper {
    // Get all autopost files
    public function get_socials(){
        $CI = & get_instance();
        // Load Options Model
        $CI->load->model('options');
        include_once APPPATH . 'interfaces/Autopost.php';
        $classes = [];
        foreach (glob(APPPATH . 'autopost/*.php') as $filename) {
            include_once $filename;
            $className = str_replace([APPPATH . 'autopost/', '.php'], '', $filename);
            // Check if the administrator has disabled the $className social network
            if ($CI->options->check_enabled(strtolower($className)) == false) {
                continue;
            }
            $get = new $className;
            $info = $get->get_info();
            $classes[] = [$info->color,$info->icon,$className];
        }
        return $classes;
    }
    // Get Class Icons
    public function get_account_assets(){
        $nets = $this->get_socials();
        if($nets){
            $socios = [];
            foreach ($nets as $net){
                $socios[] = ['soci' => strtolower($net[2]), 'value' => '<span class="icon" style="background-color:'.$net[0].'">'.$net[1].'</span>'];
            }
            return json_encode($socios);
        }
    }
    // Display Styles
    public function assets(){
        $CI = get_instance();
        $nets = $this->get_socials();
        return '<style>'
        . ' 
            section ul.dropdown-menu,
            .modal ul.dropdown-menu {
                margin: 0;
                padding: 0;
                border: 1px solid #e0e6e8;
                border-radius: 0;
                -webkit-box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.05);
                box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.05);
            }
            section ul.dropdown-menu li,
            .modal ul.dropdown-menu li {
                padding: 0 10px;
                height: 35px;
                font-size: 14px;
            }
            section ul.dropdown-menu li a,
            .modal ul.dropdown-menu li a {
                color: #333333;
                display: block;
                height: 35px;
                line-height: 35px;
                width: 100%;
            }
            section ul.dropdown-menu li a:hover,
            .modal ul.dropdown-menu li a:hover {
                text-decoration: none;
                border: 0;
            }
            section ul.dropdown-menu li:hover,
            .modal ul.dropdown-menu li:hover {
                background-color: #f7f7f7;
            }
            .modal .table-sm tr {
                border: 1px solid #f7f7f7;
                background-color: transparent !important;
            }            
            .modal .table-sm td,
            .modal .table-sm th {
                line-height: 48px;
                border: 0;
                padding: 0 10px;
            }
            .modal .table-sm tr:hover
            .modal .table-sm td:hover {
                background-color: transparent !important;
            }
            .modal .btn-add-cont {
                padding: 0;
                font-size: 20px;
            }
            .btn-default:hover,.btn-default:active,.btn-default:focus{
                color:#333;
                background-color:#e6e6e6;
                border-color:#adadad;
            }
            .resent .list-group-item>div>.select-group-meta, .resent .list-group-item>div>.select-group-meta:hover {
                background-color: #00a1f1;
                border-color: #00a1f1;            
            }
            .resent .list-group-item>div>.select-group-meta.active, .resent .list-group-item>div>.select-group-meta.active:hover {
                background-color: #5fd0b9;
                border-color: #5fd0b9;            
            }
            .resent .list-group-item>div>.select-group-meta:hover, .resent .list-group-item>div>.select-group-meta:focus{
                opacity: 0.7;
                text-decoration: none;
            }
            .new-contu{
                margin-top: 3px;
            }
            .delete-planner-meta,.resent .list-group-item>div>.select-group-meta {
                margin-top: -2.8px;
            }
            .tool-page > div > div.row > div.col-xl-12 > div.col-xl-12 {
                background: none !important;
                box-shadow: none !important;
            }
            .tool-page .mess-stat{
                padding-left: 0;
            }             
            .tool-page .mess-planner{
                padding-right: 0;
            }
            .tool-page > div > div.row > div.col-xl-12 > div.col-xl-12 > div > div > .panel-heading,
            .plan-add-action,
            .plan-shows-detail, 
            .netshow-list {
                display:none;
            }
            .panel-heading ul > li {
                height: 50px;
                min-height: 50px;
                margin: 0px;
                padding: 0 15px;
                width: 100%;
                line-height: 50px;
                margin-bottom: 10px;
                font-weight: 400;
                color: #555;
                list-style: none;
                background-color: #ffffff;
                border-bottom: 0;
                border: 0;
                border-radius: 3px;
            }
            .panel-heading ul.dropdown-menu>li {
                padding: 0 10px;
                height: 35px;
                min-height: 35px;
                font-size: 14px;
                margin-bottom: 0;
            }
            .panel-heading ul.dropdown-menu > li > a {
                border: 0;
                padding: 0 10px;
            }
            .panel-heading ul.dropdown-menu > li > a:hover {
                color: #333333;
            }
            .post-plans ul > li {
                height: auto;
                min-height: 50px;
                margin: 0px;
                padding: 0 15px;
                width: 100%;
                line-height: 50px;
                margin-bottom: 10px;
                font-weight: 400;
                color: #555;
                list-style: none;
                background-color: #ffffff;
                border-bottom: 0;
                border: 1px solid #ebedf2;
                border-radius: 3px;
            }  
            .post-plans ul > li p {
                margin: 0;
                line-height: 0;
                font-size: 12px;
                margin-top: -10px;
                margin-bottom: 15px;
            }
            .post-plans ul > li .pull-right a:hover {
                border: 0;
            }
            section>.tool-page .open ul.sel{
                border-radius: 0;
                border-bottom: 0;
            }
            section>.tool-page .open ul>li{
                min-height: 26px;
                margin-top: 0;
            }
            .resent{
                padding-bottom: 15px;
                margin-bottom: 20px;
                min-height: 60px;
                border-radius: 3px;
                background-color: #fff;
                -webkit-box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.15);
                box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.15);
            }
            .resent > div > .panel-heading h3 {
                line-height: 60px;
                font-size: 18px;
                color: $primary-black;
            }

            .resent > div > .panel-heading i {
                font-size: 20px;
                margin-right: 5px;
            }
            .resent.spintax>div>.panel-heading > .loading-image {
                margin: 10px 3px auto;
            }
            .resent.spintax textarea {
                margin: 15px 0 0;
            }
            .resent .add-repeat,
            .resent .new-contu {
                border: thin solid #d3d3d3;
                background-color: #ffffff;
                color: #333;
                height: 38px;
                line-height: 25px;
                vertical-align: middle;
                font-weight: 300;
                box-shadow: 0 1px 0 rgba(0,0,0,0.05);
                font-size: 14px;
                margin-top: 10px;
            }
            .resent .add-repeat:hover,
            .resent .new-contu:hover {
                background-color: #f8f8f8 !important;
                color: #333 !important;
            }
            .resent .add-repeat.active,
            .resent .new-contu.active {
                border: 1px solid #f05a75 !important;
            }
            .delete-planner-meta {
                background-color: #ea6759;
                border-color: #ea6759;
                color: #FFFFFF;
                padding: 7px 15px;
                line-height: 16px;
                margin-top: 0px;
                border-radius: 3px;
                display: block;
                text-align: center;
            }
            .delete-planner-meta:hover {
                opacity: 0.7;
                border: 0;
                color: #FFFFFF;
            }
            .resent .list-group-item input, .resent .list-group-item select {
                border: 1px solid #ebedf2;
                color: #999;
                border-radius: 3px;
                padding: 0.15rem 0.3rem;
                width: 100%;
            }
            .resent.netshow-list,.resent.plan-shows-detail {
                padding-bottom: 15px;
            }
            .mess-stat .order-by-posts > li{
                padding: 0 !important;
                font-size:14px;
            }
            .mess-stat .order-by-posts > li.active > a{
                background-color: #f0f8ff !important;
                color: #333;
            }
            .mess-stat .order-by-posts > li > a {
                padding-top: 20px;
                color: #416AA6;
            }
            .mess-stat .order-by-posts > li > a:hover {
                border: 0;
                opacity: 0.7;
            }
            .mess-stat li a.emails-selected-lists{
                color: #FFC107;
            }
            .mess-stat li a.planner-details{
                color: #7ac3ff;
                margin-right: 10px;
                margin-left: 10px;
            }
            .mess-stat li a.planner-plan{
                color: #ea6b4b;
            }
            .plcen:hover{
                opacity: 0.7;
            }
            .post-plans .icon {
                width: 24px;
                height: 24px;
                border-radius: 50%;
                color: #fff;
                display: inline-block;
                margin-right: 5px;
                line-height: 24px;
                text-align: center;
                font-size: 16px;
            }
            .post-plans .icon i {
                color: #FFFFFF;
                margin-right: 0;
                line-height: 25px;
                font-size: 13px;
            }            
            .modal .dropdown-toggle {
                border: thin solid #d3d3d3;
                background-color: #ffffff;
                color: #333;
                font-weight: 300;
                box-shadow: 0 1px 0 rgba(0,0,0,0.05);
                border-radius: 3px 0 0 3px;
            }
            .modal .dropdown-toggle:hover{
                background-color: #f8f8f8;
                color: #333;
                cursor: pointer;
            }
            .modal .btn-add-cont {
                border: 0;
                background-color: #ffffff;
                color: #333;
                font-weight: 300;
            }
            .modal .btn-add-cont:hover {
                color: #333;
                cursor: pointer;
            }
            section>.tool-page .getPost{
                cursor: initial !important;
            }
            section>.tool-page .getPost p {
                margin: 0;
                padding: 0;
                line-height: 12px;
                font-size: 12px;
                color: #999;
                margin-top: -5px;
            }
            section>.tool-page .getPost p>a {
                color: #999;
            }
            .resent .navbar-nav > li > a {
                float: right;
                font-size: 16px;
                line-height: 16px;
            }
            .resent .navbar-nav > li > a:after {
                margin-left: 7px;
            }
            .planner-list{
                padding-bottom: 15px;
            }
            .planner-list>p {
                line-height: 35px;
                height: 35px;
                background-color: #ffffff;
                margin-top: 10px;
                padding: 0 10px;
                margin-bottom: 0;
            }
            .add-accounts input{
                border-left: 0;
            }
            #general{
                padding:15px;
            }
            .setrow{
                background-color: rgba(255,255,255,0.8);
                background-color: rgb(255,255,255,0.8);
                padding: 0 5px;
                height: 40px;
                min-height: 40px;
                margin-bottom: 15px;
            }
            .setrow>div{
                font-size: 16px;
                color: #343a40;
                line-height: 42px;
            }
            .resent .list-group-item{
                line-height: 25px;
                background: #fff;
                border-radius: 3px;
                border: 1px solid #ebedf2;
                margin: 0;
                min-height: 47px;
                padding: 10px 12px;
                margin-bottom: 15px;
            }
            .resent .list-group-item>div>a {
                background-color: #ea6b4b;
            }
            .cancel-planner-sched, .delete-planner-rule {
                background-color: #ea6759;
                border-color: #ea6759;
                color: #FFFFFF;
                padding: 7px 15px;
                line-height: 16px;
                margin-top: 0px;
                border-radius: 3px;
                display: block;
                text-align: center;
            }
            .cancel-planner-sched:hover, .delete-planner-rule:hover {
                opacity: 0.7;
                border: 0;
                color: #FFFFFF;
            }
            .sellected-accounts.list-group>ul>li {
                background-color: #ffffff;
                list-style: none;
                color: #607d8b;
                height: 50px;
                line-height: 50px;
                width: 100%;
                border-bottom: 0;
                border: 1px solid rgba(0,0,0,.08);
                box-shadow: 0 1px 5px rgba(0,0,0,.01);
                margin-bottom: 15px;
                padding: 4px 10px;
                border-radius: 5px;
                margin: 9.4px 0;
            }
            section>.tool-page ul>li {
                border-bottom: 0;
                min-height: 50px;
                margin-top: 0;
            }
            section>.tool-page ul>li>h4>a {
                font-size: 16px;
                color: #607d8b;
            }
            section>.tool-page .sellos {
                margin-top: -7px !important;
            }
            .sellected-accounts.list-group > ul > li {
                background-color: #ffffff;
                list-style: none;
                color: #607d8b;
                height: 50px;
                line-height: 50px;
                width: 100%;
                border-bottom: 0;
                border: 1px solid #ebedf2;
                box-shadow: 0 1px 5px rgba(0,0,0,.01);
                margin-bottom: 15px;
                padding: 4px 10px;
                border-radius: 5px;
                margin: 0 0 10px;
            }
            .sellected-accounts.list-group .select-group-meta {
                background-color: #00a28a;
                border-color: #00a28a;
                color: #FFFFFF;
                padding: 7px 15px;
                line-height: 16px;
                border: 0 !important;
                margin-top: 0px;
                border-radius: 3px;
                display: block;
                text-align: center;
            }
            .sellected-accounts.list-group .select-group-meta:hover {
                opacity: 0.7;
            }
            .sellected-accounts.list-group .select-group-meta.active {
                background-color: #ea6759;
                border-color: #ea6759;
            }
            .sellected-accounts.list-group .select-group-meta.active:hover {
                opacity: 0.7;
            }
            @media(max-width:992px) {
                .tool-page .mess-stat, .tool-page .mess-planner{
                    padding: 0;
                    margin-bottom: 20px;
                }
                .navbar-nav .open .dropdown-menu {
                    margin-left: -70px;
                }
                .resent .list-group-item > div {
                    width: 100%;
                    float: inherit;
                    margin-bottom: 15px;
                }
            }
            @media(max-width:767px) {
                .order-by-posts {
                    display: table;
                }
                .order-by-posts > li {
                    display: inline-table !important;
                }    
            }
            '
        . '</style>'
        . "<script type='text/javascript'>
            window.onload = function(){
                var home = document.getElementsByClassName('home-page-link')[0];
                var posts = {'page': 1, 'limit': 10, 'by': 1, 'soci': '".@$nets[0][2]."', 'cid': 1};
                function get_socio(tag)
                {
                    var socio = ".$this->get_account_assets().";
                    if(socio.length){
                        for(var f = 0; f < socio.length; f++){
                            if(socio[f].soci == tag){
                                return socio[f].value;
                            }
                        }
                    }
                }
                function add_netu_to_list(e){
                    e.preventDefault();
                    var id = this.getAttribute('data-id');
                    var res = posts.cid;
                    var url = home+'user/tool/posts-planner?action=update-selected-accounts&res='+res+'&net='+id;
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if (data)
                            {
                                var selac = '';
                                data = JSON.parse(data);
                                if(data === 2) {
                                
                                    Main.popup_fon('sube', Main.translation.mm121 + ' " . plan_feature('publish_accounts') . " ' + Main.translation.mm122, 1500, 2000);
                                        
                                } else {
                                
                                    Main.popup_fon('subi', ' " . $CI->lang->line('account_added_successfully') . "', 1500, 2000);
                                    for (var u = 0; u < data.length; u++) {
                                    
                                        selac += '<div class=\"list-group-item\"><div class=\"row\"><div class=\"col-md-10 col-sm-10 col-xs-10\">'+get_socio(data[u].network_name)+' '+data[u].user_name+'</div><div class=\"col-md-2 col-sm-2 col-xs-2 text-right\"><a href=\"#\" data-id=\"'+data[u].meta_id+'\" class=\"delete-planner-meta\">".$CI->lang->line('mm133')."</a></div></div></div>';
                                            
                                    }
                                    document.querySelector('.sellected-accounts').innerHTML = selac;
                                }
                                
                            } else {
                                
                                Main.popup_fon('sube', ' " . $CI->lang->line('account_not_added_successfully') . "', 1500, 2000);
                                    
                            }
                            reload_it();
                        }
                    }
                    http.send();
                }
                function cancel_planner_sched(e){
                    e.preventDefault();
                    var id = this.getAttribute('data-id');
                    var res = this.getAttribute('data-res');
                    var url = home+'user/tool/posts-planner?action=cancel-planner-sched&res='+res+'&id='+id;
                    console.log(url);
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            var selo = '';
                            if (data) {
                                data = JSON.parse(data);
                                for (var u = 0; u < data.length; u++)
                                {
                                    if(data[u].status == 1){
                                        var shotim = Main.calculate_time(data[u].totime, data[u].tim)+'</div><div class=\"col-md-2 col-sm-2 col-xs-2 text-right\"><a href=\"#\" data-id=\"'+data[u].rule_id+'\" data-res=\"'+data[u].resend_id+'\" class=\"cancel-planner-sched\">".$CI->lang->line('mt7')."</a></div>';                                
                                    } else if(data[u].status == 2){
                                        var shotim = Main.calculate_time(data[u].totime, data[u].tim)+' ".$CI->lang->line('mm104')."</div>';                                  
                                    } else if(data[u].status == 3){
                                        var shotim = '<i class=\"fa fa-calendar-times-o\"></i> <strong style=\"color: #f05a75;\">".$CI->lang->line('mt9')."</strong></div>';                                  
                                    }
                                    selo += '<div class=\"list-group-item\"><div class=\"row\"><div class=\"col-md-10 col-sm-10 col-xs-10\">'+shotim+'</div></div>';
                                }
                                document.querySelector('.planner-schedules').innerHTML = selo;
                                var cancel_sched = document.getElementsByClassName('cancel-planner-sched');
                                if(cancel_sched.length)
                                {
                                    if(cancel_sched[0].addEventListener){
                                        for(var f = 0; f < cancel_sched.length; f++)
                                        {
                                            cancel_sched[f].addEventListener('click', cancel_planner_sched, false);
                                        }
                                    }else if(cancel_sched[0].attachEvent){
                                        for(var f = 0; f < cancel_sched.length; f++)
                                        {
                                            cancel_sched[f].attachEvent('onclick', cancel_planner_sched);
                                        }
                                    }
                                }
                            } else {
                                document.querySelector('.planner-schedules').innerHTML = '<p>".$CI->lang->line('mt10')."</p>';
                            }
                        }
                    }
                    http.send();
                }
                function netil(e){
                    e.preventDefault();
                    document.getElementsByClassName('plan-add-action')[0].style.display = 'none';
                    document.getElementsByClassName('plan-shows-detail')[0].style.display = 'none';
                    document.getElementsByClassName('optionss-list')[0].style.display = 'none';
                    document.getElementsByClassName('netshow-list')[0].style.display = 'block';
                    document.querySelector('.sellected-accounts').innerHTML = '<p>".$CI->lang->line('mm124')."</p>';
                    var res = this.closest('li').getAttribute('data-id');
                    posts.cid = res;
                    var url = home+'user/tool/posts-planner?action=get-selected&res='+res;
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if (data) {
                                var selac = '';
                                data = JSON.parse(data);
                                if(typeof data.category !== 'undefined') {
                                    document.getElementsByClassName('new-contu')[0].style.display = 'none';
                                    for (var u = 0; u < data.res.length; u++) {
                                        var selo = '".$CI->lang->line('mu42')."';
                                        var ini = '';
                                        if(data.category == data.res[u].list_id) {
                                            selo = '".$CI->lang->line('mu206')."';
                                            ini = ' active';
                                        }
                                        selac += '<div class=\"list-group-item\"><div class=\"row\"><div class=\"col-md-10 col-sm-10 col-xs-10\"><span class=\"icon pull-left\" style=\"background-color: #5fd0b9\"><i class=\"fa fa-users\" style=\"color:#fff;font-size: small;\"></i></span> ' + data.res[u].name + '</div><div class=\"col-md-2 col-sm-2 col-xs-2 text-right\"><a href=\"#\" data-id=\"' + data.res[u].list_id + '\" class=\"select-group-meta'+ini+'\">' + selo + '</a></div></div></div>';
                                    }
                                    document.querySelector('.sellected-accounts').innerHTML = selac;
                                } else {
                                    document.getElementsByClassName('new-contu')[0].style.display = 'block';
                                    for (var u = 0; u < data.length; u++) {
                                        selac += '<div class=\"list-group-item\"><div class=\"row\"><div class=\"col-md-10 col-sm-10 col-xs-10\">'+get_socio(data[u].network_name)+' '+data[u].user_name+'</div><div class=\"col-md-2 col-sm-2 col-xs-2 text-right\"><a href=\"#\" data-id=\"'+data[u].meta_id+'\" class=\"delete-planner-meta\">".$CI->lang->line('mm133')."</a></div></div></div>';
                                    }
                                    document.querySelector('.sellected-accounts').innerHTML = selac;
                                }
                            } else {
                                document.querySelector('.sellected-accounts').innerHTML = '<p>".$CI->lang->line('mm124')."</p>';
                            }
                            reload_it();
                        }
                    }
                    http.send();
                }
                function delete_planner_meta(e){
                    e.preventDefault();
                    var id = this.getAttribute('data-id');
                    var res = posts.cid;
                    var url = home+'user/tool/posts-planner?action=delete-meta-post&res='+res+'&net='+id;
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if (data) {
                                Main.popup_fon('subi', ' " . $CI->lang->line('account_deleted_successfully') . "', 1500, 2000);
                                var selac = '';
                                data = JSON.parse(data);
                                for (var u = 0; u < data.length; u++) {
                                    selac += '<div class=\"list-group-item\"><div class=\"row\"><div class=\"col-md-10 col-sm-10 col-xs-10\">'+get_socio(data[u].network_name)+' '+data[u].user_name+'</div><div class=\"col-md-2 col-sm-2 col-xs-2 text-right\"><a href=\"#\" data-id=\"'+data[u].meta_id+'\" class=\"delete-planner-meta\">".$CI->lang->line('mm133')."</a></div></div></div>';
                                }
                                document.querySelector('.sellected-accounts').innerHTML = selac;
                            } else {
                                Main.popup_fon('subi', ' " . $CI->lang->line('account_deleted_successfully') . "', 1500, 2000);
                                document.querySelector('.sellected-accounts').innerHTML = '<p>".$CI->lang->line('mm124')."</p>';
                            }
                            reload_it();
                        }
                    }
                    http.send();
                }                
                function detalu(e){
                    e.preventDefault();
                    document.getElementsByClassName('plan-add-action')[0].style.display = 'none';
                    document.getElementsByClassName('netshow-list')[0].style.display = 'none';
                    document.getElementsByClassName('optionss-list')[0].style.display = 'none';
                    document.getElementsByClassName('plan-shows-detail')[0].style.display = 'block';
                    var res = this.closest('li').getAttribute('data-id');
                    posts.cid = res;
                    var url = home+'user/tool/posts-planner?action=get-schedules&res='+res;
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if (data)
                            {
                                var selo = '';
                                data = JSON.parse(data);
                                for (var u = 0; u < data.length; u++)
                                {
                                    var toti = Main.calculate_time(data[u].totime, data[u].tim);
                                    toti = toti.replace('fa fa-calendar-check-o','');
                                    if(data[u].status == 1){
                                        var shotim = toti+'</div><div class=\"col-md-2 col-sm-2 col-xs-2 text-right\"><a href=\"#\" data-id=\"'+data[u].rule_id+'\" data-res=\"'+data[u].resend_id+'\" class=\"cancel-planner-sched\">".$CI->lang->line('mt7')."</a></div>';                                
                                    } else if(data[u].status == 2){
                                        var shotim = toti+'</div>';                                  
                                    } else if(data[u].status == 3){
                                        var shotim = '<i class=\"fa fa-calendar-times-o\"></i> <strong style=\"color: #f05a75;\">".$CI->lang->line('mt9')."</strong></div>';                                  
                                    }
                                    selo += '<div class=\"list-group-item\"><div class=\"row\"><div class=\"col-md-10 col-sm-10 col-xs-10\">'+shotim+'</div></div>';
                                }
                                document.querySelector('.planner-schedules').innerHTML = selo;
                                var cancel_sched = document.getElementsByClassName('cancel-planner-sched');
                                if(cancel_sched.length)
                                {
                                    if(cancel_sched[0].addEventListener){
                                        for(var f = 0; f < cancel_sched.length; f++)
                                        {
                                            cancel_sched[f].addEventListener('click', cancel_planner_sched, false);
                                        }
                                    }else if(cancel_sched[0].attachEvent){
                                        for(var f = 0; f < cancel_sched.length; f++)
                                        {
                                            cancel_sched[f].attachEvent('onclick', cancel_planner_sched);
                                        }
                                    }
                                }
                            } else {
                                document.querySelector('.planner-schedules').innerHTML = '<p>".$CI->lang->line('mt10')."</p>';
                            }
                        }
                    }
                    http.send();
                }
                function delete_rule(e){
                    e.preventDefault();
                    var mess_plann = document.getElementsByClassName('mess-planner')[0].getAttribute('data-act');
                    var rf = document.getElementsByClassName('planner-list')[0].childNodes.length;
                    if(document.getElementsByClassName('planner-list')[0].innerHTML.indexOf('<p>') == 0) {
                        rf = 0;
                    }
                    if(rf <= mess_plann) {
                        document.getElementsByClassName('add-repeat')[0].classList.remove('active');
                    }
                    var dthis = this;
                    var res = dthis.closest('.list-group-item').getAttribute('data-res');
                    var met = dthis.closest('.list-group-item').getAttribute('data-met');
                    var url = home+'user/tool/posts-planner?action=delete-meta&res='+res+'&met='+met;
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if(data){
                                data = JSON.parse(data);
                                if(data == 1){
                                    dthis.closest('.list-group-item').remove();
                                } else if(data == 2){
                                    document.querySelector('.planner-list').innerHTML = '<p>".$CI->lang->line('mu192')."</p>';
                                }
                            }
                            reload_it();
                        }
                    }
                    http.send();
                }
                function save_days(e){
                    e.preventDefault();
                    var dthis = this;
                    var res = dthis.closest('.list-group-item').getAttribute('data-res');
                    var met = dthis.closest('.list-group-item').getAttribute('data-met');
                    var value = dthis.value;
                    var url = home+'user/tool/posts-planner?action=edit-meta&res='+res+'&met='+met+'&rule1='+value;
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if(data){
                                data = JSON.parse(data);
                                if(data == 1){
                                    dthis.setAttribute('style', 'border-color: #2196f3 !important');
                                } else if(data == 2){
                                    dthis.setAttribute('style', 'border-color: #f05a75 !important');
                                }
                                setTimeout(function(){dthis.setAttribute('style', 'border-color: #cccccc !important');},3000);
                            }
                        }
                    }
                    http.send();
                }
                function save_plan_when(e){
                    e.preventDefault();
                    var dthis = this;
                    var res = dthis.closest('.list-group-item').getAttribute('data-res');
                    var met = dthis.closest('.list-group-item').getAttribute('data-met');
                    var value = dthis.value;
                    var url = home+'user/tool/posts-planner?action=edit-meta&res='+res+'&met='+met+'&rule3='+value;
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if(data){
                                data = JSON.parse(data);
                                if(data == 1){
                                    dthis.setAttribute('style', 'border-color: #2196f3 !important');
                                } else if(data == 2){
                                    dthis.setAttribute('style', 'border-color: #f05a75 !important');
                                }
                                setTimeout(function(){dthis.setAttribute('style', 'border-color: #cccccc !important');},3000);
                            }
                        }
                    }
                    http.send();
                }
                function save_plan_repeat(e){
                    e.preventDefault();
                    var dthis = this;
                    var res = dthis.closest('.list-group-item').getAttribute('data-res');
                    var met = dthis.closest('.list-group-item').getAttribute('data-met');
                    var value = dthis.value;
                    var url = home+'user/tool/posts-planner?action=edit-meta&res='+res+'&met='+met+'&rule4='+value;
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if(data){
                                data = JSON.parse(data);
                                if(data == 1){
                                    dthis.setAttribute('style', 'border-color: #2196f3 !important');
                                } else if(data == 2){
                                    dthis.setAttribute('style', 'border-color: #f05a75 !important');
                                }
                                setTimeout(function(){dthis.setAttribute('style', 'border-color: #cccccc !important');},3000);
                            }
                        }
                    }
                    http.send();
                }                
                function save_plan_time(e){
                    e.preventDefault();
                    var dthis = this;
                    var res = dthis.closest('.list-group-item').getAttribute('data-res');
                    var met = dthis.closest('.list-group-item').getAttribute('data-met');
                    var value = dthis.value;
                    var url = home+'user/tool/posts-planner?action=edit-meta&res='+res+'&met='+met+'&rule2='+value;
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if(data){
                                data = JSON.parse(data);
                                if(data == 1){
                                    dthis.setAttribute('style', 'border-color: #2196f3 !important');
                                } else if(data == 2){
                                    dthis.setAttribute('style', 'border-color: #f05a75 !important');
                                }
                                setTimeout(function(){dthis.setAttribute('style', 'border-color: #cccccc !important');},3000);
                            }
                        }
                    }
                    http.send();
                }
                function select_group_meta(e){
                    e.preventDefault();
                    var dthis = this;
                    var status = dthis.classList.contains('active');
                    var res = dthis.getAttribute('data-id');
                    var url = home+'user/tool/posts-planner?action=save-post-groups&res='+res+'&page='+posts.cid;
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                    
                        if(http.readyState == 4 && http.status == 200) {
                        
                            var data = http.responseText;
                            
                            if (data) {
                            
                                var selac = '';
                                data = JSON.parse(data);
                                
                                if(data != 2) {
                                
                                    for (var u = 0; u < data.res.length; u++) {
                                    
                                        var selo = '" . $CI->lang->line('mu42') . "';
                                        var ini = '';
                                        
                                        if(data.category == data.res[u].list_id) {
                                            selo = '" . $CI->lang->line('mu206') . "';
                                            ini = ' active';
                                        }
                                        
                                        if ( data.res[u].list_id === res ) {
                                            
                                            if ( status === true && ini === '' ) {
                                                Main.popup_fon('subi', ' " . $CI->lang->line('group_unselected_successfully') . "', 1500, 2000);
                                            } else if ( status === false && ini === ' active' ) {
                                                Main.popup_fon('subi', ' " . $CI->lang->line('group_selected_successfully') . "', 1500, 2000);
                                            } else {
                                                Main.popup_fon('subi', ' " . $CI->lang->line('mm3') . "', 1500, 2000);
                                            }

                                        }
                                        
                                        selac += '<div class=\"list-group-item\"><div class=\"row\"><div class=\"col-md-10 col-sm-10 col-xs-10\"><span class=\"icon pull-left\" style=\"background-color: #5fd0b9\"><i class=\"fa fa-users\" style=\"color:#fff;font-size: small;\"></i></span> ' + data.res[u].name + '</div><div class=\"col-md-2 col-sm-2 col-xs-2 text-right\"><a href=\"#\" data-id=\"' + data.res[u].list_id + '\" class=\"select-group-meta'+ini+'\">' + selo + '</a></div></div></div>';
                                    }
                                    document.querySelector('.sellected-accounts').innerHTML = selac;
                                    
                                }
                                
                            } else {
                                
                            }
                            
                            reload_it();
                            
                        }
                        
                    }
                    
                    http.send();
                }                
                function show_planner_options(e){
                    e.preventDefault();
                    document.getElementsByClassName('plan-shows-detail')[0].style.display = 'none';
                    document.getElementsByClassName('netshow-list')[0].style.display = 'none';
                    document.getElementsByClassName('plan-add-action')[0].style.display = 'none';
                    document.getElementsByClassName('optionss-list')[0].style.display = 'block';                
                }
                function plannis(e){
                    e.preventDefault();
                    document.getElementsByClassName('plan-shows-detail')[0].style.display = 'none';
                    document.getElementsByClassName('netshow-list')[0].style.display = 'none';
                    document.getElementsByClassName('optionss-list')[0].style.display = 'none';
                    document.getElementsByClassName('plan-add-action')[0].style.display = 'block';
                    document.getElementsByClassName('add-repeat')[0].classList.remove('active');
                    var dthis = this;
                    posts.von = dthis;
                    var res = dthis.closest('li').getAttribute('data-res');
                    posts.cid = dthis.closest('li').getAttribute('data-id');
                    var url = home+'user/tool/posts-planner?action=getplanns&res='+res;
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if (data)
                            {
                                data = JSON.parse(data);
                                var allpll = '';
                                for (var u = 0; u < data.length; u++)
                                {
                                    allpll += '<div class=\"list-group-item\" data-res=\"'+data[u].resend_id+'\" data-met=\"'+data[u].meta_id+'\"><div class=\"row\"><div class=\"col-md-2 col-sm-2 col-xs-2\"><select class=\"days\">';
                                        var rule1 = '';
                                        if(data[u].rule1 == 1){
                                            var rule1 = ' selected=\"selected\"';
                                        }
                                        allpll += '<option value=\"1\" '+rule1+'>".$CI->lang->line('mu193')."</option>';
                                        rule1 = '';
                                        if(data[u].rule1 == 2){
                                            var rule1 = ' selected=\"selected\"';
                                        }
                                        allpll += '<option value=\"2\" '+rule1+'>".$CI->lang->line('mu194')."</option>';
                                        rule1 = '';
                                        if(data[u].rule1 == 3){
                                            var rule1 = ' selected=\"selected\"';
                                        }                                                    
                                        allpll += '<option value=\"3\" '+rule1+'>".$CI->lang->line('mu195')."</option>';
                                        rule1 = '';
                                        if(data[u].rule1 == 4){
                                            var rule1 = ' selected=\"selected\"';
                                        }                                                      
                                        allpll += '<option value=\"4\" '+rule1+'>".$CI->lang->line('mu196')."</option>';
                                        rule1 = '';
                                        if(data[u].rule1 == 5){
                                            var rule1 = ' selected=\"selected\"';
                                        }                                                    
                                        allpll += '<option value=\"5\" '+rule1+'>".$CI->lang->line('mu197')."</option>';
                                        rule1 = '';
                                        if(data[u].rule1 == 6){
                                            var rule1 = ' selected=\"selected\"';
                                        }                                                    
                                        allpll += '<option value=\"6\" '+rule1+'>".$CI->lang->line('mu198')."</option>';
                                        rule1 = '';
                                        if(data[u].rule1 == 7){
                                            var rule1 = ' selected=\"selected\"';
                                        }                                                    
                                        allpll += '<option value=\"7\" '+rule1+'>".$CI->lang->line('mu199')."</option></select>';
                                    allpll += '</div><div class=\"col-md-3 clean\"><select class=\"plan-time\">';
                                        var rule2 = '';
                                        if(data[u].rule2 == '00:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }
                                        allpll += '<option value=\"00:00\" '+rule2+'>00:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '01:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                
                                        allpll += '<option value=\"01:00\" '+rule2+'>01:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '02:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                   
                                        allpll += '<option value=\"02:00\" '+rule2+'>02:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '03:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                  
                                        allpll += '<option value=\"03:00\" '+rule2+'>03:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '04:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                 
                                        allpll += '<option value=\"04:00\" '+rule2+'>04:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '05:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                    
                                        allpll += '<option value=\"05:00\" '+rule2+'>05:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '06:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                 
                                        allpll += '<option value=\"06:00\" '+rule2+'>06:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '07:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                 
                                        allpll += '<option value=\"07:00\" '+rule2+'>07:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '08:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                  
                                        allpll += '<option value=\"08:00\" '+rule2+'>08:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '09:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                 
                                        allpll += '<option value=\"09:00\" '+rule2+'>09:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '10:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }
                                        allpll += '<option value=\"10:00\" '+rule2+'>10:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '11:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                
                                        allpll += '<option value=\"11:00\" '+rule2+'>11:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '12:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                
                                        allpll += '<option value=\"12:00\" '+rule2+'>12:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '13:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                 
                                        allpll += '<option value=\"13:00\" '+rule2+'>13:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '14:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                 
                                        allpll += '<option value=\"14:00\" '+rule2+'>14:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '15:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                 
                                        allpll += '<option value=\"15:00\" '+rule2+'>15:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '16:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                 
                                        allpll += '<option value=\"16:00\" '+rule2+'>16:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '17:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                 
                                        allpll += '<option value=\"17:00\" '+rule2+'>17:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '18:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                
                                        allpll += '<option value=\"18:00\" '+rule2+'>18:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '19:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                 
                                        allpll += '<option value=\"19:00\" '+rule2+'>19:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '20:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                
                                        allpll += '<option value=\"20:00\" '+rule2+'>20:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '21:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                
                                        allpll += '<option value=\"21:00\" '+rule2+'>21:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '22:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                 
                                        allpll += '<option value=\"22:00\" '+rule2+'>22:00</option>';
                                        rule2 = '';
                                        if(data[u].rule2 == '23:00'){
                                            var rule2 = ' selected=\"selected\"';
                                        }                                                
                                        allpll += '<option value=\"23:00\" '+rule2+'>23:00</option>';
                                    allpll += '</select></div><div class=\"col-md-3\"><select class=\"when\">';
                                        var rule3 = '';
                                        if(data[u].rule3 == 1){
                                            var rule3 = ' selected=\"selected\"';
                                        }
                                        allpll += '<option value=\"1\" '+rule3+'>".$CI->lang->line('mu200')."</option>';
                                        rule3 = '';
                                        if(data[u].rule3 == 2){
                                            var rule3 = ' selected=\"selected\"';
                                        }                                                    
                                        allpll += '<option value=\"2\" '+rule3+'>".$CI->lang->line('mu201')."</option>';
                                        rule3 = '';
                                        if(data[u].rule3 == 3){
                                            var rule3 = ' selected=\"selected\"';
                                        }                                                    
                                        allpll += '<option value=\"3\" '+rule3+'>".$CI->lang->line('mu202')."</option>';
                                        rule3 = '';
                                        if(data[u].rule3 == 4){
                                            var rule3 = ' selected=\"selected\"';
                                        }                                                     
                                        allpll += '<option value=\"4\" '+rule3+'>".$CI->lang->line('mu203')."</option>';
                                    allpll += '</select></div><div class=\"col-md-2 col-sm-2 col-xs-2 clean\"><select class=\"repeat\">';
                                        var rule4 = '';
                                        if(data[u].rule4 == 1){
                                            var rule4 = ' selected=\"selected\"';
                                        }
                                        allpll += '<option value=\"1\" '+rule4+'>1 ".$CI->lang->line('mu204')."</option>';
                                        rule4 = '';
                                        if(data[u].rule4 == 2){
                                            var rule4 = ' selected=\"selected\"';
                                        }                                                    
                                        allpll += '<option value=\"2\" '+rule4+'>2 ".$CI->lang->line('mu205')."</option>';
                                        rule4 = '';
                                        if(data[u].rule4 == 3){
                                            var rule4 = ' selected=\"selected\"';
                                        }                                                      
                                        allpll += '<option value=\"3\" '+rule4+'>3 ".$CI->lang->line('mu205')."</option>';
                                        rule4 = '';
                                        if(data[u].rule4 == 4){
                                            var rule4 = ' selected=\"selected\"';
                                        }                                                     
                                        allpll += '<option value=\"4\" '+rule4+'>4 ".$CI->lang->line('mu205')."</option>';
                                        rule4 = '';
                                        if(data[u].rule4 == 5){
                                            var rule4 = ' selected=\"selected\"';
                                        }                                                     
                                        allpll += '<option value=\"5\" '+rule4+'>5 ".$CI->lang->line('mu205')."</option>';
                                        rule4 = '';
                                        if(data[u].rule4 == 6){
                                            var rule4 = ' selected=\"selected\"';
                                        }                                                     
                                        allpll += '<option value=\"6\" '+rule4+'>6 ".$CI->lang->line('mu205')."</option>';
                                        rule4 = '';
                                        if(data[u].rule4 == 7){
                                            var rule4 = ' selected=\"selected\"';
                                        }
                                        allpll += '<option value=\"7\" '+rule4+'>7 ".$CI->lang->line('mu205')."</option>';
                                        rule4 = '';
                                        if(data[u].rule4 == 8){
                                            var rule4 = ' selected=\"selected\"';
                                        }                                                    
                                        allpll += '<option value=\"8\" '+rule4+'>8 ".$CI->lang->line('mu205')."</option>';
                                        rule4 = '';
                                        if(data[u].rule4 == 9){
                                            var rule4 = ' selected=\"selected\"';
                                        }                                                    
                                        allpll += '<option value=\"9\" '+rule4+'>9 ".$CI->lang->line('mu205')."</option>';
                                        rule4 = '';
                                        if(data[u].rule4 == 10){
                                            var rule4 = ' selected=\"selected\"';
                                        }                                                    
                                        allpll += '<option value=\"10\" '+rule4+'>10 ".$CI->lang->line('mu205')."</option>';
                                        rule4 = '';
                                        if(data[u].rule4 == 11){
                                            var rule4 = ' selected=\"selected\"';
                                        }                                                     
                                        allpll += '<option value=\"11\" '+rule4+'>11 ".$CI->lang->line('mu205')."</option>';
                                        rule4 = '';
                                        if(data[u].rule4 == 12){
                                            var rule4 = ' selected=\"selected\"';
                                        }                                                     
                                        allpll += '<option value=\"12\" '+rule4+'>12 ".$CI->lang->line('mu205')."</option>';
                                    allpll += '</select></div><div class=\"col-md-2 col-sm-2 col-xs-2 text-right\"><a href=\"#\" class=\"delete-planner-rule\">".$CI->lang->line('mm133')."</a></div></div></div>';                     
                                }
                                document.querySelector('.planner-list').innerHTML = allpll;
                                reload_it();
                            } else {
                                document.querySelector('.planner-list').innerHTML = '<p>".$CI->lang->line('mu192')."</p>';
                            }
                        }
                    }
                    http.send();
                }
                function pnumi(e){
                    e.preventDefault();
                    presults(this.getAttribute('data-page'));
                }
                function plnios(e){
                    e.preventDefault();
                    posts.by = this.getAttribute('data-type');
                    presults(1);
                }
                function add_repeate(e){
                    e.preventDefault();
                    var mess_plann = document.getElementsByClassName('mess-planner')[0].getAttribute('data-act');
                    var rf = document.getElementsByClassName('planner-list')[0].childNodes.length;
                    if(document.getElementsByClassName('planner-list')[0].innerHTML.indexOf('<p>') == 0) {
                        rf = 0;
                    }
                    if(rf >= mess_plann) {
                        document.getElementsByClassName('add-repeat')[0].className += ' active';
                        return
                    }
                    var id = posts.cid;
                    var von = posts.von;
                    var currentdate = new Date();
                    var datetime = currentdate.getFullYear() + '-' + (currentdate.getMonth() + 1) + '-' + currentdate.getDate() + ' ' + currentdate.getHours() + ':' + currentdate.getMinutes() + ':' + currentdate.getSeconds();
                    var url = home+'user/tool/posts-planner?action=add-new-planner&net='+id+'&time='+datetime;
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if (data) {
                                var dat = JSON.parse(data);
                                von.closest('li').setAttribute('data-res',dat.resend_id);
                                if(document.querySelectorAll('.planner-list .list-group-item').length > 0){
                                    document.getElementsByClassName('planner-list')[0].insertAdjacentHTML('beforeend','<div class=\"list-group-item\" data-res=\"'+dat.resend_id+'\" data-met=\"'+dat.meta_id+'\"><div class=\"row\"><div class=\"col-md-2 col-sm-2 col-xs-2\"><select class=\"days\"><option value=\"1\">".$CI->lang->line('mu193')."</option><option value=\"2\">".$CI->lang->line('mu194')."</option><option value=\"3\">".$CI->lang->line('mu195')."</option><option value=\"4\">".$CI->lang->line('mu196')."</option><option value=\"5\">".$CI->lang->line('mu197')."</option><option value=\"6\">".$CI->lang->line('mu198')."</option><option value=\"7\">".$CI->lang->line('mu199')."</option></select></div><div class=\"col-md-3 clean\"><select class=\"plan-time\"><option value=\"00:00\">00:00</option><option value=\"01:00\">01:00</option><option value=\"02:00\">02:00</option><option value=\"03:00\">03:00</option><option value=\"04:00\">04:00</option><option value=\"05:00\">05:00</option><option value=\"06:00\">06:00</option><option value=\"07:00\">07:00</option><option value=\"08:00\">08:00</option><option value=\"09:00\">09:00</option><option value=\"10:00\">10:00</option><option value=\"11:00\">11:00</option><option value=\"12:00\">12:00</option><option value=\"13:00\">13:00</option><option value=\"14:00\">14:00</option><option value=\"15:00\">15:00</option><option value=\"16:00\">16:00</option><option value=\"17:00\">17:00</option><option value=\"18:00\">18:00</option><option value=\"19:00\">19:00</option><option value=\"20:00\">20:00</option><option value=\"21:00\">21:00</option><option value=\"22:00\">22:00</option><option value=\"23:00\">23:00</option></select></div><div class=\"col-md-3\"><select class=\"when\"><option value=\"1\">".$CI->lang->line('mu200')."</option><option value=\"2\">".$CI->lang->line('mu201')."</option><option value=\"3\">".$CI->lang->line('mu202')."</option><option value=\"4\">".$CI->lang->line('mu203')."</option></select></div><div class=\"col-md-2 clean\"><select class=\"repeat\"><option value=\"1\">1 ".$CI->lang->line('mu204')."</option><option value=\"2\">2 ".$CI->lang->line('mu205')."</option><option value=\"3\">3 ".$CI->lang->line('mu205')."</option><option value=\"4\">4 ".$CI->lang->line('mu205')."</option><option value=\"5\">5 ".$CI->lang->line('mu205')."</option><option value=\"6\">6 ".$CI->lang->line('mu205')."</option><option value=\"7\">7 ".$CI->lang->line('mu205')."</option><option value=\"8\">8 ".$CI->lang->line('mu205')."</option><option value=\"9\">9 ".$CI->lang->line('mu205')."</option><option value=\"10\">10 ".$CI->lang->line('mu205')."</option><option value=\"11\">11 ".$CI->lang->line('mu205')."</option><option value=\"12\">12 ".$CI->lang->line('mu205')."</option></select></div><div class=\"col-md-2 col-sm-2 col-xs-2 text-right\"><a href=\"#\" class=\"delete-planner-rule\">".$CI->lang->line('mm133')."</a></div></div>');
                                } else {
                                    document.getElementsByClassName('planner-list')[0].innerHTML = '<div class=\"list-group-item\" data-res=\"'+dat.resend_id+'\" data-met=\"'+dat.meta_id+'\"><div class=\"row\"><div class=\"col-md-2 col-sm-2 col-xs-2\"><select class=\"days\"><option value=\"1\">".$CI->lang->line('mu193')."</option><option value=\"2\">".$CI->lang->line('mu194')."</option><option value=\"3\">".$CI->lang->line('mu195')."</option><option value=\"4\">".$CI->lang->line('mu196')."</option><option value=\"5\">".$CI->lang->line('mu197')."</option><option value=\"6\">".$CI->lang->line('mu198')."</option><option value=\"7\">".$CI->lang->line('mu199')."</option></select></div><div class=\"col-md-3 clean\"><select class=\"plan-time\"><option value=\"00:00\">00:00</option><option value=\"01:00\">01:00</option><option value=\"02:00\">02:00</option><option value=\"03:00\">03:00</option><option value=\"04:00\">04:00</option><option value=\"05:00\">05:00</option><option value=\"06:00\">06:00</option><option value=\"07:00\">07:00</option><option value=\"08:00\">08:00</option><option value=\"09:00\">09:00</option><option value=\"10:00\">10:00</option><option value=\"11:00\">11:00</option><option value=\"12:00\">12:00</option><option value=\"13:00\">13:00</option><option value=\"14:00\">14:00</option><option value=\"15:00\">15:00</option><option value=\"16:00\">16:00</option><option value=\"17:00\">17:00</option><option value=\"18:00\">18:00</option><option value=\"19:00\">19:00</option><option value=\"20:00\">20:00</option><option value=\"21:00\">21:00</option><option value=\"22:00\">22:00</option><option value=\"23:00\">23:00</option></select></div><div class=\"col-md-3\"><select class=\"when\"><option value=\"1\">".$CI->lang->line('mu200')."</option><option value=\"2\">".$CI->lang->line('mu201')."</option><option value=\"3\">".$CI->lang->line('mu202')."</option><option value=\"4\">".$CI->lang->line('mu203')."</option></select></div><div class=\"col-md-2 col-sm-2 col-xs-2 clean\"><select class=\"repeat\"><option value=\"1\">1 ".$CI->lang->line('mu204')."</option><option value=\"2\">2 ".$CI->lang->line('mu205')."</option><option value=\"3\">3 ".$CI->lang->line('mu205')."</option><option value=\"4\">4 ".$CI->lang->line('mu205')."</option><option value=\"5\">5 ".$CI->lang->line('mu205')."</option><option value=\"6\">6 ".$CI->lang->line('mu205')."</option><option value=\"7\">7 ".$CI->lang->line('mu205')."</option><option value=\"8\">8 ".$CI->lang->line('mu205')."</option><option value=\"9\">9 ".$CI->lang->line('mu205')."</option><option value=\"10\">10 ".$CI->lang->line('mu205')."</option><option value=\"11\">11 ".$CI->lang->line('mu205')."</option><option value=\"12\">12 ".$CI->lang->line('mu205')."</option></select></div><div class=\"col-md-2 col-sm-2 col-xs-2 text-right\"><a href=\"#\" class=\"delete-planner-rule\">".$CI->lang->line('mm133')."</a></div></div>';
                                }
                            }
                            reload_it();
                        }
                    }
                    http.send();
                }
                function sell(e){
                    e.preventDefault();
                    this.closest('.multiple-form-group').getElementsByClassName('concept')[0].innerText = this.innerText;
                    posts.soci = this.getAttribute('href');
                }
                function search_conts(){
                    var url = home+'user/tool/posts-planner?action=search-accounts';
                    var keys = document.getElementsByClassName('search-conts')[0].value;
                    var csr = document.querySelector(\"[name='csrf_test_name']\").value;
                    var soci = posts.soci;
                    var params = 'csrf_test_name='+csr+'&keys='+keys+'&net='+soci;
                    var http = new XMLHttpRequest();
                    http.open('POST', url, true);
                    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if(data){
                                data = JSON.parse(data);
                                var show = '';
                                for(var o = 0; o < data.length; o++){
                                    show += '<tr><td>'+data[o].user_name+'</td><td style=\"text-align: right;\"><button class=\"btn-add-cont btn btn-default btn-xs\" type=\"button\" data-id=\"'+data[o].network_id+'\"><i class=\"icon-plus\"></i></button></td></tr>';
                                }
                                document.getElementsByClassName('accounts-found')[0].innerHTML = show;
                                reload_it();
                            } else {
                                document.getElementsByClassName('accounts-found')[0].innerHTML = '<tr><td>".$CI->lang->line('mm127')."</td></tr>';                            
                            }
                        }
                    }
                    http.send(params);
                }                
                function reload_it(){
                    var add_repeat = document.getElementsByClassName('add-repeat');
                    if(add_repeat.length) {
                        if(add_repeat[0].addEventListener){
                            add_repeat[0].addEventListener('click', add_repeate, false);
                        }else if(add_repeat[0].attachEvent){
                            add_repeat[0].attachEvent('onclick', add_repeate);
                        }
                    }                
                    var neti = document.getElementsByClassName('planner-networks');
                    if(neti.length)
                    {
                        if(neti[0].addEventListener){
                            for(var f = 0; f < neti.length; f++)
                            {
                                neti[f].addEventListener('click', netil, false);
                            }
                        }else if(neti[0].attachEvent){
                            for(var f = 0; f < neti.length; f++)
                            {
                                neti[f].attachEvent('onclick', netil);
                            }
                        }
                    }
                    var delete_meta = document.getElementsByClassName('delete-planner-meta');
                    if(delete_meta.length)
                    {
                        if(delete_meta[0].addEventListener){
                            for(var f = 0; f < delete_meta.length; f++)
                            {
                                delete_meta[f].addEventListener('click', delete_planner_meta, false);
                            }
                        }else if(delete_meta[0].attachEvent){
                            for(var f = 0; f < delete_meta.length; f++)
                            {
                                delete_meta[f].attachEvent('onclick', delete_planner_meta);
                            }
                        }
                    }                    
                    var detal = document.getElementsByClassName('planner-details');
                    if(detal.length)
                    {
                        if(detal[0].addEventListener){
                            for(var f = 0; f < detal.length; f++)
                            {
                                detal[f].addEventListener('click', detalu, false);
                            }
                        }else if(detal[0].attachEvent){
                            for(var f = 0; f < detal.length; f++)
                            {
                                detal[f].attachEvent('onclick', detalu);
                            }
                        }
                    } 
                    var planis = document.getElementsByClassName('planner-plan');
                    if(planis.length)
                    {
                        if(planis[0].addEventListener){
                            for(var f = 0; f < planis.length; f++)
                            {
                                planis[f].addEventListener('click', plannis, false);
                            }
                        }else if(planis[0].attachEvent){
                            for(var f = 0; f < planis.length; f++)
                            {
                                planis[f].attachEvent('onclick', plannis);
                            }
                        }
                    }
                    var pnum = document.getElementsByClassName('pnum');
                    if(pnum.length)
                    {
                        if(pnum[0].addEventListener){
                            for(var f = 0; f < pnum.length; f++)
                            {
                                pnum[f].addEventListener('click', pnumi, false);
                            }
                        }else if(pnum[0].attachEvent){
                            for(var f = 0; f < pnum.length; f++)
                            {
                                pnum[f].attachEvent('onclick', pnumi);
                            }
                        }
                    }
                    var delete_planner_rule = document.getElementsByClassName('delete-planner-rule');
                    if(delete_planner_rule.length)
                    {
                        if(delete_planner_rule[0].addEventListener){
                            for(var f = 0; f < delete_planner_rule.length; f++)
                            {
                                delete_planner_rule[f].addEventListener('click', delete_rule, false);
                            }
                        }else if(delete_planner_rule[0].attachEvent){
                            for(var f = 0; f < delete_planner_rule.length; f++)
                            {
                                delete_planner_rule[f].attachEvent('onclick', delete_rule);
                            }
                        }
                    }
                    var select_group = document.getElementsByClassName('select-group-meta');
                    if(select_group.length)
                    {
                        if(select_group[0].addEventListener){
                            for(var f = 0; f < select_group.length; f++)
                            {
                                select_group[f].addEventListener('click', select_group_meta, false);
                            }
                        }else if(select_group[0].attachEvent){
                            for(var f = 0; f < select_group.length; f++)
                            {
                                select_group[f].attachEvent('onclick', select_group_meta);
                            }
                        }
                    }                    
                    var plnio = document.getElementsByClassName('order-planned-posts');
                    if(plnio.length)
                    {
                        if(plnio[0].addEventListener){
                            for(var f = 0; f < plnio.length; f++)
                            {
                                plnio[f].addEventListener('click', plnios, false);
                            }
                        }else if(plnio[0].attachEvent){
                            for(var f = 0; f < plnio.length; f++)
                            {
                                plnio[f].attachEvent('onclick', plnios);
                            }
                        }
                    }
                    var add_net_to_list = document.getElementsByClassName('btn-add-cont');
                    if(add_net_to_list.length)
                    {
                        if(add_net_to_list[0].addEventListener){
                            for(var f = 0; f < add_net_to_list.length; f++)
                            {
                                add_net_to_list[f].addEventListener('click', add_netu_to_list, false);
                            }
                        }else if(add_net_to_list[0].attachEvent){
                            for(var f = 0; f < add_net_to_list.length; f++)
                            {
                                add_net_to_list[f].attachEvent('onclick', add_netu_to_list);
                            }
                        }
                    }
                    var days = document.getElementsByClassName('days');
                    if(days.length)
                    {
                        if(days[0].addEventListener){
                            for(var f = 0; f < days.length; f++)
                            {
                                days[f].addEventListener('click', function(){console.clear();});
                                days[f].addEventListener('change', save_days, false);
                            }
                        }else if(days[0].attachEvent){
                            for(var f = 0; f < days.length; f++)
                            {
                                days[f].attachEvent('onchange', save_days);
                            }
                        }
                    }
                    var plan_time = document.getElementsByClassName('plan-time');
                    if(plan_time.length)
                    {
                        if(plan_time[0].addEventListener){
                            for(var f = 0; f < plan_time.length; f++)
                            {
                                plan_time[f].addEventListener('click', function(){console.clear();});              
                                plan_time[f].addEventListener('change', save_plan_time, false);
                            }
                        }else if(plan_time[0].attachEvent){
                            for(var f = 0; f < plan_time.length; f++)
                            {
                                plan_time[f].attachEvent('onchange', save_plan_time);
                            }
                        }
                    }
                    var plan_when = document.getElementsByClassName('when');
                    if(plan_when.length)
                    {
                        if(plan_when[0].addEventListener){
                            for(var f = 0; f < plan_when.length; f++)
                            {
                                plan_when[f].addEventListener('click', function(){console.clear();});
                                plan_when[f].addEventListener('change', save_plan_when, false);
                            }
                        }else if(plan_when[0].attachEvent){
                            for(var f = 0; f < plan_when.length; f++)
                            {
                                plan_when[f].attachEvent('onchange', save_plan_when);
                            }
                        }
                    }
                    var plan_repeat = document.getElementsByClassName('repeat');
                    if(plan_repeat.length)
                    {
                        if(plan_repeat[0].addEventListener){
                            for(var f = 0; f < plan_repeat.length; f++)
                            {
                                plan_repeat[f].addEventListener('click', function(){console.clear();});
                                plan_repeat[f].addEventListener('change', save_plan_repeat, false);
                            }
                        }else if(plan_repeat[0].attachEvent){
                            for(var f = 0; f < plan_repeat.length; f++)
                            {
                                plan_repeat[f].attachEvent('onchange', save_plan_repeat);
                            }
                        }
                    }                    
                    var conts = document.getElementsByClassName('search-conts');
                    if(conts.length)
                    {
                        if(conts[0].addEventListener){
                            conts[0].addEventListener('keyup', search_conts, false);
                        }else if(conts[0].attachEvent){
                            conts[0].attachEvent('onkeyup', search_conts);
                        }
                    }
                    var show_planner_o = document.getElementsByClassName('show-planner-options');
                    if(show_planner_o.length)
                    {
                        if(show_planner_o[0].addEventListener){
                            show_planner_o[0].addEventListener('click', show_planner_options, false);
                        }else if(show_planner_o[0].attachEvent){
                            show_planner_o[0].attachEvent('onclick', show_planner_options);
                        }
                    }                    
                    var sel = document.querySelectorAll('.sel>li>a');
                    if(sel.length)
                    {
                        if(sel[0].addEventListener){
                            for(var f = 0; f < sel.length; f++)
                            {
                                sel[f].addEventListener('click', sell, false);
                            }
                        }else if(sel[0].attachEvent){
                            for(var f = 0; f < sel.length; f++)
                            {
                                sel[f].attachEvent('onclick', sell);
                            }
                        }
                    }
                    
                }
                function show_pagination(total)
                {
                    // the code bellow displays pagination
                    document.querySelector('.pagination').innerHTML = '';
                    if (parseInt(posts.page) > 1)
                    {
                        var bac = parseInt(posts.page) - 1;
                        var pages = '<li class=\"page-item\"><a href=\"#\" data-page=\"' + bac + '\" class=\"page-link pnum\">' + Main.translation.mm128 + '</a></li>';
                    } else
                    {
                        var pages = '<li class=\"page-item pagehide\"><a href=\"#\" class=\"page-link pnum\">' + Main.translation.mm128 + '</a></li>';
                    }
                    var tot = parseInt(total) / parseInt(posts.limit);
                    tot = Math.ceil(tot) + 1;
                    var from = (parseInt(posts.page) > 2) ? parseInt(posts.page) - 2 : 1;
                    for (var p = from; p < parseInt(tot); p++)
                    {
                        if (p === parseInt(posts.page))
                        {
                            pages += '<li class=\"page-item active\"><a data-page=\"' + p + '\" class=\"page-link pnum\">' + p + '</a></li>';
                        } else if ((p < parseInt(posts.page) + 3) && (p > parseInt(posts.page) - 3))
                        {
                            pages += '<li class=\"page-item\"><a href=\"#\" data-page=\"' + p + '\" class=\"page-link pnum\">' + p + '</a></li>';
                        } else if ((p < 6) && (Math.round(tot) > 5) && ((parseInt(posts.page) == 1) || (parseInt(posts.page) == 2)))
                        {
                            pages += '<li class=\"page-item\"><a href=\"#\" data-page=\"' + p + '\" class=\"page-link pnum\">' + p + '</a></li>';
                        } else
                        {
                            break;
                        }
                    }
                    if (p === 1)
                    {
                        pages += '<li class=\"page-item active\"><a data-page=\"' + p + '\" class=\"page-link\">' + p + '</a></li>';
                    }
                    var next = parseInt(posts.page);
                    next++;
                    if (next < Math.round(tot))
                    {
                        document.querySelector('.pagination').innerHTML = pages + '<li class=\"page-item\"><a href=\"#\" data-page=\"' + next + '\" class=\"page-link\">' + Main.translation.mm129 + '</a></li>';
                    } else
                    {
                        document.querySelector('.pagination').innerHTML = pages + '<li class=\"page-item pagehide\"><a href=\"#\" class=\"page-link\">' + Main.translation.mm129 + '</a></li>';
                    }
                }
                function presults(num){
                    posts.page = num;
                    var url = home+'user/tool/posts-planner?action=results&page='+num+'&by='+posts.by;
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if (data)
                            {
                                data = JSON.parse(http.responseText);
                                var allposts = '';
                                document.getElementsByClassName('pagination')[0].style.display = 'block';
                                show_pagination(data.total);
                                for (var u = 0; u < data.posts.length; u++)
                                {
                                    var text = (data.posts[u].body.length > 0) ? data.posts[u].body.substring(0, 50) + '...' : data.posts[u].img.substring(0, 50) + '...';
                                    allposts += '<li class=\"getPost\" data-id=\"'+data.posts[u].post_id+'\" data-res=\"'+data.posts[u].resend+'\"><a href=\"'+home+'user/app/posts?q=post&post_id='+data.posts[u].post_id+'\">'+text+'</a> <div class=\"pull-right\"><a href=\"#\" class=\"planner-networks plcen\"><i class=\"icon-share-alt\"></i></a><a href=\"#\" class=\"planner-details plcen\"><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i></a><a href=\"#\" class=\"planner-plan plcen\"><i class=\"fa fa-calendar\"></i></a></div></li>';
                                }
                                document.querySelector('.mess-stat .list-group ul').innerHTML = allposts;
                                reload_it();
                            } else {
                                document.getElementsByClassName('pagination')[0].style.display = 'none';
                                document.querySelector('.mess-stat .list-group ul').innerHTML = '<p>".$CI->lang->line('mu23')."</p>';
                            }
                            if(posts.by == 1){                               
                                document.getElementsByClassName('display-by')[0].innerHTML = '".$CI->lang->line('mt1')." <span class=\"caret\"></span>';
                            } else{
                                document.getElementsByClassName('display-by')[0].innerHTML = '".$CI->lang->line('mt2')." <span class=\"caret\"></span>';
                            }
                        }
                    }
                    http.send();
                }
                reload_it();
                presults(1);
            }
            </script>";
    }
}