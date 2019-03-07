<?php
/**
 * Groups_helper contains a trait for content displaying
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
 * Groups_helper - display the content for the Posts Planner Tool
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
trait Spintax_helper {
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
        . ' .btn-default {
                background-color: #ffffff;
                border: 1px solid #ced4da;
                border-left: 0;
                border-radius: 0 3px 3px 0;
            }
            .btn-default:hover,.btn-default:active,.btn-default:focus{
                background-color: #f8f8f8 !important;
                color: #333 !important;
            }
            .new-contu{
                margin-top: 3px;
            }
            .resent>div>.panel-heading {
                color: #5A688B;
            }
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
            section>.new-rss .open ul.sel{
                border-radius: 0;
                border-bottom: 0;
            }
            section>.new-rss .open ul>li{
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
                color: #6c757d;
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
            .resent .list-group-item {
                background: #fff;
                border-radius: 3px;
                border: 1px solid #ebedf2;
                margin: 0;
                min-height: 47px;
                padding: 10px 5px;
                margin-bottom: 15px;
            }
            .resent .list-group {
                margin-bottom: 0;
            }
            .resent .list-group-item>div {
                padding: 0 5px !important;
            }
            .resent .list-group-item .delete-synonym{
                display: block;
                background-color: #ea6759;
                color: #fff;
                text-align: center;
                border-radius: 3px;
                padding: 0.25rem 0.3rem;
            }
            .resent .list-group-item .delete-synonym:hover {
                opacity: 0.7;
                border-bottom: 0;
            }
            .resent .list-group-item input, .resent .list-group-item select {
                border: 1px solid #ccc;
                color: #999;
                border-radius: 3px;
                padding: 0.15rem 0.3rem;
                width: 100%;
            }
            .resent.netshow-list,.resent.plan-shows-detail {
                padding-bottom: 15px;
            }
            .mess-stat .order-by-posts > li {
                background-color: transparent !important;
                padding: 0 !important;
                font-size:14px;
            }
            .mess-stat .order-by-posts > li > a {
                padding-top: 20px;
                color: #416AA6;
            }
            .mess-stat .order-by-posts > li > a:hover {
                border: 0;
                opacity: 0.7;
            }
            .mess-stat li a.select-word {
                border: 0;
                margin: 0 0 0 15px;
            }
            .mess-stat li a.select-word:hover {
                opacity: 0.7;
            }             
            .mess-stat li a.delete-word {
                color: #ea6759;
                border: 0;
                margin: 0 0 0 15px;
            }
            .mess-stat li a.delete-word:hover {
                opacity: 0.7;
            } 
            .mess-stat li a.planner-plan {
                color: #5A688B;
            }
            .plcen:hover {
                opacity: 0.7;
            }
            .post-plans .col-md-10 {
                line-height: 30px;
            }
            .post-plans .icon {
                width: 28px;
                height: 28px;
                border-radius: 50%;
                color: #fff;
                display: inline-block;
                margin-right: 5px;
                line-height: 30px;
                text-align: center;
            }
            .post-plans .icon i {
                margin-right: 0;
            }
            .modal .dropdown-toggle {
                margin-top: 12px;
            }
            .resent .navbar-nav > li > a {
                float: right;
                font-size: 16px;
                line-height: 16px;
            }
            .planner-list {
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
            #general {
                width: 100%;
                padding:15px 15px 0 15px;
            }
            .setrow {
                background-color: rgba(255,255,255,0.8);
                background-color: rgb(255,255,255,0.8);
                padding: 0 5px;
                height: 40px;
                min-height: 40px;
            }
            .add-word .btn-primary {
                color: #fff;
                background-color: #5A688B !important;
                border-color: #5A688B !important;
                border-radius: 0 3px 3px 0;
            }
            .add-word .btn-primary:hover{
                background-color: #505d7e !important;
                border-color: #505d7e !important;
            }
            .add-word .form-group{
                margin-bottom: 10px;
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
                function add_word(e){
                    e.preventDefault();
                    var word = e.target.getElementsByClassName('word-pal')[0].value;
                    var url = home+'user/tool/spintax?action=add-new-word';
                    var csr = e.target.querySelector(\"[name='csrf_test_name']\").value;
                    var params = 'csrf_test_name='+csr+'&word='+word;
                    var http = new XMLHttpRequest();
                    http.open('POST', url, true);
                    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            console.log(data);
                            if(data) {
                                data = JSON.parse(data);
                                if(data == 1) {
                                    Main.popup_fon('subi','" . $CI->lang->line('mt30') . "', 1500, 2000);
                                    presults(1);                                
                                } else {
                                    Main.popup_fon('sube', '" . $CI->lang->line('mt31') . "', 1500, 2000);
                                }
                                document.querySelector('.modal.fade.show').click();
                                document.getElementsByClassName('word-pal')[0].value = '';
                            }
                            reload_it();
                        }
                    }
                    http.send(params);
                }
                function add_synonym(e){
                    e.preventDefault();
                    var synonym = e.target.getElementsByClassName('synonym')[0].value;
                    var url = home+'user/tool/spintax?action=add-new-synonym';
                    var csr = e.target.querySelector(\"[name='csrf_test_name']\").value;
                    var params = 'csrf_test_name='+csr+'&synonym='+synonym+'&cid='+posts.cid;
                    var http = new XMLHttpRequest();
                    http.open('POST', url, true);
                    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if(data) {
                                data = JSON.parse(data);
                                if(data !== 2) {
                                    Main.popup_fon('subi','" . $CI->lang->line('mt30') . "', 1500, 2000);
                                    var sez = ' ';
                                    for(var f = 0; f < data.length; f++) {
                                        sez += '<div class=\"list-group-item\"><div class=\"row\"><div class=\"col-md-10 col-sm-10 col-xs-10\"><span class=\"icon\" style=\"background-color:#5a68a6;font-size: 14px;\"><i class=\"fab fa-wpforms\"></i></span> ' + data[f] + '</div><div class=\"col-md-2 col-sm-2 col-xs-2 text-right\"><a href=\"#\" data-id=\"' + data[f] + '\" class=\"delete-synonym\">" . $CI->lang->line('delete') . "</a></div></div></div>';
                                    }
                                    document.getElementsByClassName('synonym')[0].value = '';
                                    document.querySelector('.sellected-accounts').innerHTML = sez;
                                } else {
                                    Main.popup_fon('sube', '" . $CI->lang->line('mt31') . "', 1500, 2000);
                                }
                                document.querySelector('.modal.fade.show').click();
                                document.getElementsByClassName('word-pal')[0].value = '';
                            }
                            reload_it();
                        }
                    }
                    http.send(params);
                }
                function netil(e){
                    e.preventDefault();
                    document.getElementsByClassName('optionss-list')[0].style.display = 'none';
                    document.getElementsByClassName('netshow-list')[0].style.display = 'block';
                    var res = this.closest('li').getAttribute('data-id');
                    posts.cid = res;
                    var url = home+'user/tool/spintax?action=get-synonyms&res='+res;
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if (data != 2) {
                                var selac = '';
                                data = JSON.parse(data);
                                var sez = ' ';
                                for(var f = 0; f < data.length; f++) {
                                    sez += '<div class=\"list-group-item\"><div class=\"row\"><div class=\"col-md-10 col-sm-10 col-xs-10\"><span class=\"icon\" style=\"background-color:#5a68a6;font-size: 14px;\"><i class=\"fab fa-wpforms\"></i></span> ' + data[f] + '</div><div class=\"col-md-2 col-sm-2 col-xs-2 text-right\"><a href=\"#\" data-id=\"' + data[f] + '\" class=\"delete-synonym\">" . $CI->lang->line('delete') . "</a></div></div></div>';
                                }
                                document.querySelector('.sellected-accounts').innerHTML = sez;
                            } else {
                                document.querySelector('.sellected-accounts').innerHTML = '<p>".$CI->lang->line('mt32')."</p>';
                            }
                            reload_it();
                        }
                    }
                    http.send();
                }
                function show_planner_options(e){
                    e.preventDefault();
                    document.getElementsByClassName('netshow-list')[0].style.display = 'none';
                    document.getElementsByClassName('optionss-list')[0].style.display = 'block';                
                }
                function pnumi(e){
                    e.preventDefault();
                    presults(this.getAttribute('data-page'));
                }
                function sell(e){
                    e.preventDefault();
                    this.closest('.multiple-form-group').getElementsByClassName('concept')[0].innerText = this.innerText;
                    posts.soci = this.getAttribute('href');
                }
                function delete_word(e){
                    e.preventDefault();
                    var id = this.closest('li').getAttribute('data-id');
                    var url = home + 'user/tool/spintax?action=delete-word&word=' + id;
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if (data) {
                                data = JSON.parse(data);
                                if(data == 1) {
                                    presults(1);
                                    document.getElementsByClassName('netshow-list')[0].style.display = 'none';
                                    document.getElementsByClassName('optionss-list')[0].style.display = 'block';  
                                    Main.popup_fon('subi','" . $CI->lang->line('mt35') . "', 1500, 2000);
                                } else {
                                    Main.popup_fon('sube', '" . $CI->lang->line('mt36') . "', 1500, 2000);
                                }
                            }
                            reload_it();
                        }
                    }
                    http.send();
                }
                function delete_synonym(e){
                    e.preventDefault();
                    var id = this.getAttribute('data-id');
                    var res = posts.cid;
                    var url = home + 'user/tool/spintax?action=delete-synonym&synonym=' + id + '&res=' + res;
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if (data != 2) {
                                var selac = '';
                                data = JSON.parse(data);
                                var sez = ' ';
                                for(var f = 0; f < data.length; f++) {
                                    sez += '<div class=\"list-group-item\"><div class=\"row\"><div class=\"col-md-10 col-sm-10 col-xs-10\"><span class=\"icon\" style=\"background-color:#5a68a6;font-size: 14px;\"><i class=\"fab fa-wpforms\"></i></span> ' + data[f] + '</div><div class=\"col-md-2 col-sm-2 col-xs-2 text-right\"><a href=\"#\" data-id=\"' + data[f] + '\" class=\"delete-synonym\">" . $CI->lang->line('delete') . "</a></div></div></div>';
                                }
                                document.querySelector('.sellected-accounts').innerHTML = sez;
                            } else {
                                document.querySelector('.sellected-accounts').innerHTML = '<p>" . $CI->lang->line('mt34') . "</p>';
                            }
                            reload_it();
                        }
                    }
                    http.send();
                }           
                function reload_it(){
                    var delete_g = document.getElementsByClassName('delete-word');
                    if(delete_g.length) {
                        if(delete_g[0].addEventListener){
                            for(var f = 0; f < delete_g.length; f++) {
                                delete_g[f].addEventListener('click', delete_word, false);
                            }
                        }else if(delete_g[0].attachEvent){
                            for(var f = 0; f < delete_g.length; f++) {
                                delete_g[f].attachEvent('onclick', delete_word);
                            }
                        }
                    }
                    var neti = document.getElementsByClassName('select-word');
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
                    var add_net_to_list = document.getElementsByClassName('btn-add-to-group');
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
                    var show_planner_o = document.getElementsByClassName('show-planner-options');
                    if(show_planner_o.length) {
                        if(show_planner_o[0].addEventListener) {
                            show_planner_o[0].addEventListener('click', show_planner_options, false);
                        } else if(show_planner_o[0].attachEvent) {
                            show_planner_o[0].attachEvent('onclick', show_planner_options);
                        }
                    }                    
                    var sel = document.querySelectorAll('.sel>li>a');
                    if(sel.length) {
                        if(sel[0].addEventListener){
                            for(var f = 0; f < sel.length; f++) {
                                sel[f].addEventListener('click', sell, false);
                            }
                        } else if(sel[0].attachEvent) {
                            for(var f = 0; f < sel.length; f++) {
                                sel[f].attachEvent('onclick', sell);
                            }
                        }
                    }
                    var form = document.getElementsByClassName('add-word');
                    if(form.length > 0) {
                        if(form[0].addEventListener){
                            for(var f = 0; f < form.length; f++) {
                                form[f].addEventListener('submit', add_word, false);
                            }
                        } else if(form[0].attachEvent){
                            for(var f = 0; f < form.length; f++) {
                                form[f].attachEvent('onsubmit', add_word);
                            }
                        }
                    }
                    var form = document.getElementsByClassName('add-synonym');
                    if(form.length > 0) {
                        if(form[0].addEventListener){
                            for(var f = 0; f < form.length; f++) {
                                form[f].addEventListener('submit', add_synonym, false);
                            }
                        } else if(form[0].attachEvent){
                            for(var f = 0; f < form.length; f++) {
                                form[f].attachEvent('onsubmit', add_synonym);
                            }
                        }
                    }                    
                    var delete_sy = document.getElementsByClassName('delete-synonym');
                    if(delete_sy.length > 0) {
                        if(delete_sy[0].addEventListener){
                            for(var f = 0; f < delete_sy.length; f++) {
                                delete_sy[f].addEventListener('click', delete_synonym, false);
                            }
                        } else if(delete_sy[0].attachEvent){
                            for(var f = 0; f < delete_sy.length; f++) {
                                delete_sy[f].attachEvent('onclick', delete_synonym);
                            }
                        }
                    }                    
                }
                function show_pagination(total) {
                    // the code bellow displays pagination
                    document.querySelector('.pagination').innerHTML = '';
                    if (parseInt(posts.page) > 1) {
                        var bac = parseInt(posts.page) - 1;
                        var pages = '<li class=\"page-item\"><a href=\"#\" data-page=\"' + bac + '\" class=\"page-link pnum\">' + Main.translation.mm128 + '</a></li>';
                    } else {
                        var pages = '<li class=\"page-item pagehide\"><a href=\"#\" class=\"page-link\">' + Main.translation.mm128 + '</a></li>';
                    }
                    var tot = parseInt(total) / parseInt(posts.limit);
                    tot = Math.ceil(tot) + 1;
                    var from = (parseInt(posts.page) > 2) ? parseInt(posts.page) - 2 : 1;
                    for (var p = from; p < parseInt(tot); p++) {
                        if (p === parseInt(posts.page)) {
                            pages += '<li class=\"page-item active\"><a data-page=\"' + p + '\" class=\"page-link pnum\">' + p + '</a></li>';
                        } else if ((p < parseInt(posts.page) + 3) && (p > parseInt(posts.page) - 3)) {
                            pages += '<li class=\"page-item\"><a href=\"#\" data-page=\"' + p + '\" class=\"page-link pnum\">' + p + '</a></li>';
                        } else if ((p < 6) && (Math.round(tot) > 5) && ((parseInt(posts.page) == 1) || (parseInt(posts.page) == 2))) {
                            pages += '<li class=\"page-item\"><a href=\"#\" data-page=\"' + p + '\" class=\"page-link pnum\">' + p + '</a></li>';
                        } else {
                            break;
                        }
                    }
                    if (p === 1) {
                        pages += '<li class=\"page-item active\"><a data-page=\"' + p + '\" class=\"page-link\">' + p + '</a></li>';
                    }
                    var next = parseInt(posts.page);
                    next++;
                    if (next < Math.round(tot)) {
                        document.querySelector('.pagination').innerHTML = pages + '<li class=\"page-item\"><a href=\"#\" data-page=\"' + next + '\" class=\"page-link\">' + Main.translation.mm129 + '</a></li>';
                    } else {
                        document.querySelector('.pagination').innerHTML = pages + '<li class=\"page-item pagehide\"><a href=\"#\" class=\"page-link\">' + Main.translation.mm129 + '</a></li>';
                    }
                }
                function presults(num){
                    posts.page = num;
                    var url = home+'user/tool/spintax?action=get-words&page='+num;
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if (data) {
                                data = JSON.parse(http.responseText);
                                var allposts = '';
                                document.getElementsByClassName('pagination')[0].style.display = 'block';
                                show_pagination(data.total);
                                for (var u = 0; u < data.words.length; u++) {
                                    var text = (data.words[u].name.length > 50) ? data.words[u].name.substring(0, 50) + '...' : data.words[u].name;
                                    allposts += '<li class=\"getPost\" data-id=\"'+data.words[u].dict_id+'\">'+text+' <div class=\"pull-right\"><a href=\"#\" class=\"delete-word\"><i class=\"icon-trash\"></i></a><a href=\"#\" class=\"select-word plcen\"><i class=\"icon-note\"></i></a></div></li>';
                                }
                                document.querySelector('.mess-stat .list-group ul').innerHTML = allposts;
                                reload_it();
                            } else {
                                document.getElementsByClassName('pagination')[0].style.display = 'none';
                                document.querySelector('.mess-stat .list-group ul').innerHTML = '<p>".$CI->lang->line('mt37')."</p>';
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