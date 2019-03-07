<?php
class Sets {
    protected $CI;
    /**
     * Load networks and user model.
     */
    public function __construct() {
        $this->CI =& get_instance();
        if ( file_exists( APPPATH . 'language/' . $this->CI->config->item('language') . '/default_tool_lang.php' ) ) {
            $this->CI->lang->load( 'default_tool', $this->CI->config->item('language') );
        }
    }
    public function show() {
        return "
            <link rel=\"stylesheet\" type=\"text/css\" href=\"" . base_url() . "assets/user/styles/css/bootstrap-datetimepicker.css\"/>
            <style>
            .btn-default {
                background-color: #ffffff;
                border: 1px solid #ced4da;
                border-radius: 3px;
                height: 30px;
                padding: 5px 10px;
                line-height: 1;
                font-size: 14px;
            }
            .btn-default:hover {
                background-color: #f8f8f8;
                color: #333;
            }
            .table-sm tr,
            .table-sm td {
                line-height: 40px;
                background-color: transparent !important;
                color: #999 !important;
            }
            form {
                width: 100%;
            }
            .single-activity{
                margin-bottom: 30px;
                min-height: 60px;
                border-radius: 3px;
                background-color: #fff;
                padding: 0;
                -webkit-box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.15);
                box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.15);
            }
            p.no-results-found {
                line-height: 60px !important;
                width: 100%;
                text-align: center;
            }
            @media screen and (max-width: 767px){
                .col-xl-6, .col-md-6, .col-sm-12, .col-xs-12, .col-md-12{
                    position: inherit !important;
                }            
            }
            .tool-page .container-fluid > .row > .col-xl-12 > .col-xl-12 {
                box-shadow: none !important;
            }
            .tool-page .container-fluid > .row > .col-xl-12 > .col-xl-12.clean .panel-heading {
                display: none;
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
            .panel-heading{
                min-height: 40px;
                padding: 12px 15px;
                border-bottom: 1px solid rgba(65, 106, 166, 0.1);
            }
            .panel-heading h2 {
                font-size: 16px;
                color: #6c757d;
                margin-bottom: 0;
                line-height: 60px;
            }
            .panel-heading .mop {
                position: absolute;
                top: 20px;
                right: 15px;
            }
            .panel-heading .dropdown-toggle {
                color: #212529;
            }
            .panel-heading .dropdown-toggle:hover {
                border: 0;
                color: #9ea1a5;
            }            
            .panel-heading .dropdown-toggle::after {
                display: none;
            }
            .panel-heading .dropdown-menu {
                margin-left: -185px;
            }
            .panel-heading .dropdown-menu li:hover a {
                border: 0 !important;
                text-decoration: none;
            }
            p{
                margin: 7px 0 15px 0;
            }
            img{
            max-width:100%;
            }
            .fa-angle-right{
            margin:0 7px;
            color: #999;
            }
            .panel-footer,.modal-content {
                width: 100%;
                background: #fafafa;
                border: 1px solid #eeeeee;
                margin: 15px;
                padding: 10px 0px !important;
            }
            .nav-tabs > li{
                width: initial !important;
                display: inline-block !important;
                min-height: 30px !important;
            }
            .nav-tabs > li > a:hover{
                background-color: transparent !important;
                text-decoration:underline !important;
            }
            .nav-tabs>li{
                min-height: 30px !important;
                border:0 !important;
            }
            .nav-tabs > li > a {
                line-height: 30px !important;
                padding: 5px 15px !important;
                border:0 !important;
                color:#7f7f7f;
                font-weight:400;
            }
            .nav-tabs > li > a:hover {
                background-color: transparent !important;
                text-decoration:none !important;
                color: #7f7f7f;
            }
            .nav-tabs > li > a.show,
            .nav-tabs > li > a:focus,
            .nav-tabs > li > a:hover {
                background-color: transparent !important;
                text-decoration:none !important;
                border-bottom: 2px solid #7f7f7f !important;
            }
            .nav-tabs>li{
                width: initial !important;
                display: inline-block !important;
                min-height: 30px !important;
            }
            .comfo .tab-content{
            padding:15px;
            }
            .comfo .tab-content textarea,.modal-content textarea{
                width: 100%;
                height: 100px;
                border: 0;
                padding: 10px;
                resize: none;
                border-bottom: 2px solid #1dc3d3;
            }
            .comfo .tab-content textarea:focus,.comfo .tab-content textarea:active,.modal-content textarea:focus,.modal-content textarea:active{
                outline:none;
            }
            .comments > div > div > ul {
                margin-bottom: 20px !important;
            }
            .comments > div > div > ul > li,
            .likes > ul > li {
                border: 1px solid #ddd !important;
                border-radius: 0 !important;
                margin-bottom:15px;
                min-height: 10px !important;
            }
            .comments>div>div>ul>li .com-info{
                margin-bottom: 5px;
            }
            .likes>div>div>ul>li .like-info{
                margin-bottom: 0;
            }
            .comments>div>div>ul>li .comment-reply{
                margin-top:10px;
            }
            .comments > div > div > ul > li .comment-reply > a {
                color: #00a28a;
                font-size: 14px;
                margin-right: 15px;
            }
            .comments > div > div > ul > li .comment-reply > a:hover {
               border-bottom: 1px solid #00a28a;
            }
            .comments > div > div > ul > li .comment-reply > a.dc {
                color: #ea6759;
                font-size: 14px;
                margin-right: 15px;
            }
            .comments > div > div > ul > li .comment-reply > a.dc:hover {
               border-bottom: 1px solid #ea6759;
            }
            .comfo .tab-content .btn,.modal-content .btn{
                text-decoration: none;
                color: #fff;
                background-color: #26a69a;
                text-align: center;
                letter-spacing: .5px;
                transition: .2s ease-out;
                cursor: pointer;
                border:0;
            }
            .comfo .tab-content .btn:hover,.modal-content .btn:hover{
                position: relative;
                cursor: pointer;
                display: inline-block;
                overflow: hidden;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                -webkit-tap-highlight-color: transparent;
                vertical-align: middle;
                z-index: 1;
                will-change: opacity, transform;
                transition: .3s ease-out;
                background-color: #2bbbad;
            }
            .replies{
                margin-left: 5% !important;
                width: 95% !important;
            }
            .pagehide>a{
                background: #eeeeee !important;
            }
            .schedule-deletion{
                height: 32px;
                padding: 0 5px !important;
            }
            .schedule-deletion:focus,.schedule-deletion:active{
                outline:none !important;
                box-shadow: none !important;
                border-color: #dbdbdb !important;
            }
            .bs-delete-post form,
            .bs-repost-post form {
                padding: 0 18px !important;
            }
            .sched-del{
                display: inline-block;
                font-size: 14px;
                text-align: left;
                background-color: #fff;
                height: 40px;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.2);
                box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
                margin-bottom: 10px;
                width: 100% !important;
            }
            .will-del.hide{
                display:none;
            }
            .sched-del>.del-text{
                line-height: 40px;
                padding: 0 45px;
            }            
            .sched-del > .del-split{
                background: #337ab7;
                width: 33px;
                float: left;
                color: #fff!important;
                height: 100%;
                text-align: center;
                line-height: 40px;
                font-size: 17px;
            }
            .sched-del > .del-split.del-danger{
                background: #d9534f!important;
            }
            .btn-del-sched{
                margin-top: -2px !important;
            }
            .table-sm .fa-calendar-check-o{
                margin-right: 5px !important;            
            }
            .table-sm .btn-group
            {
                position:absolute !important;
                margin-top: 7px !important;
                margin-left: 10px !important;
            }
            .table-sm .btn-group.open li,.table-sm .btn-group.open li>a
            {
                min-height: 30px !important;
                width: 100% !important;
                margin-top: 0px !important;
            }
            .table-sm{
                color: #999;
            }
            .table-sm.table>tbody>tr>td:hover,.table-sm.table>tbody>tr>td:hover button{
                color: #333;
            }
            .table-sm .glyphicon{
                top: 2px;
                left: 0px;
            }
            .modal .btn-circle{
                height: 34px;
                border-radius: 0 3px 3px 0;
            }
            .modal .time-schedule{
                height: 34px;
            }
            .pagination {
                margin: auto !important;
                width: fit-content;
            }
            </style>
            <script type=\"text/javascript\">
            window.onload = function(){
                var com = {},sched = {};
                function cl(m){
                    var mess = btoa(encodeURIComponent(m));
                    mess = mess.replace('/', '-');
                    mess = mess.replace(/=/g, '');
                    return mess;
                }
                var home = document.getElementsByClassName('home-page-link')[0];
                function caload(e){
                    e.preventDefault();
                    var url = home+'user/tool/monitoris?action=comment';
                    var msg = e.target.getElementsByClassName('msg')[0].value;
                    var post = this.getAttribute('data-post');
                    var account = this.getAttribute('data-account');
                    var act = this.getAttribute('data-act');
                    var csr = document.querySelector(\"[name='csrf_test_name']\").value;
                    var params = 'csrf_test_name='+csr+'&msg='+msg+'&post='+post+'&account='+account+'&act='+act;
                    var http = new XMLHttpRequest();
                    http.open('POST', url, true);
                    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if(data) {
                                data = JSON.parse(data);
                                document.getElementById('act-'+act).innerHTML = data;
                                loadEx();
                            } else {
                                Main.popup_fon('sube', translation.mm3, 1500, 2000);
                            }
                        }
                    }
                    http.send(params);
                }
                function mark_seen(e) {
                    e.preventDefault();
                    var act = this.getAttribute('data-id');
                    var url = home+'user/tool/monitoris?action=seen&id='+act;
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            if(http.responseText == 1) {
                                document.getElementById('activity-'+act).remove();
                            } else {
                                popup_fon('sube', translation.mm3, 1500, 2000);
                            }
                        }
                    }
                    http.send();
                }
                function deload(e){
                    e.preventDefault();
                    var comment = this.getAttribute('data-comment');
                    var account = this.getAttribute('data-account');
                    var act = this.getAttribute('data-act');
                    var url = home+'user/tool/monitoris?action=del-com&comment='+comment+'&account='+account+'&act='+act;
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if(data) {
                                data = JSON.parse(data);
                                document.getElementById('act-'+act).innerHTML = data;
                                loadEx();
                            } else {
                                popup_fon('sube', translation.mm3, 1500, 2000);
                            }
                        }
                    }
                    http.send();
                }
                function dshed(e){
                    e.preventDefault();
                    var idu = this.getAttribute('data-id');
                    var his = this;
                    var url = home+'user/app-ajax/posts?action=history_delete_post&post_id='+idu;
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if(data) {
                            
                                data = JSON.parse(data);
                                if ( data.success ) {
                                    document.querySelector('.pt-'+idu).remove();
                                } else {
                                    popup_fon('sube', translation.mm3, 1500, 2000);
                                }      
                                
                            } else {
                                popup_fon('sube', translation.mm3, 1500, 2000);
                            }
                        }
                    }
                    http.send();
                }
                function stime(e){
                    e.preventDefault();
                    var idu = this.getAttribute('data-id');
                    var tim = this.getAttribute('data-time');
                    var text = this.textContent;
                    var his = this;
                    var url = home+'user/tool/monitoris?action=schedmu&id='+idu+'&time='+tim;
                    var http = new XMLHttpRequest();
                    http.open('GET', url, true);
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            var data = http.responseText;
                            if(data) {
                                data = JSON.parse(data);
                                document.querySelector('.pt-'+idu+' .deleted-after').innerText = text;
                            } else {
                                popup_fon('sube', translation.mm3, 1500, 2000);
                            }
                        }
                    }
                    http.send();
                }                
                function dpi(e)
                {
                    e.preventDefault();
                    var act = this.getAttribute('data-id');
                    sched.id = act;
                }
                function rpi(e)
                {
                    e.preventDefault();
                    var act = this.getAttribute('data-id');
                    sched.id = act;
                }                
                function loadThis(e)
                {
                    e.preventDefault();
                    var comment = this.getAttribute('data-comment');
                    var account = this.getAttribute('data-account');
                    var act = this.getAttribute('data-act');
                    com.comment = comment;
                    com.account = account;
                    com.act = act;
                }
                function relo(e){
                    e.preventDefault();
                    var url = home+'user/tool/monitoris?action=add-reply';
                    var msg = e.target.getElementsByClassName('msg')[0].value;
                    var post = com.comment;
                    var account = com.account;
                    var act = com.act;
                    var csr = document.querySelector(\"[name='csrf_test_name']\").value;
                    var params = 'csrf_test_name='+csr+'&msg='+msg+'&post='+post+'&account='+account+'&act='+act;
                    var http = new XMLHttpRequest();
                    http.open('POST', url, true);
                    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            document.querySelector('.modal.fade.show').click();
                            var data = http.responseText;
                            if(data) {
                                data = JSON.parse(data);
                                document.getElementById('act-'+act).innerHTML = data;
                                loadEx();                                
                            } else {
                                popup_fon('sube', translation.mm3, 1500, 2000);
                            }
                        }
                    }
                    http.send(params);
                }
                function deli(e){
                    e.preventDefault();
                    var cd = new Date();
                    var datetime = cd.getFullYear() + '-' + (cd.getMonth() + 1) + '-' + cd.getDate() + ' ' + cd.getHours() + ':' + cd.getMinutes() + ':' + cd.getSeconds();
                    var url = home+'user/tool/monitoris?action=add-del';
                    var act = sched.id;
                    var msg = document.getElementsByClassName('schedule-deletion')[0].value;
                    var csr = document.querySelector(\"[name='csrf_test_name']\").value;
                    var params = 'csrf_test_name='+csr+'&act='+act+'&msg='+cl(msg)+'&cd='+cl(datetime);
                    var http = new XMLHttpRequest();
                    http.open('POST', url, true);
                    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            document.querySelector('.modal.fade.show').click();
                            var data = http.responseText;
                            if(data) {
                                data = JSON.parse(data);
                                if(!isNaN(data.res)) {
                                    document.querySelector('#activity-'+act+' .will-del').classList.remove('hide');
                                    var tv = calculate_time(data.res, data.tm);
                                    tv = tv.replace('<i class=\"fa fa-calendar-check-o\" aria-hidden=\"true\"></i>','');
                                    document.querySelector('#activity-'+act+' .del-text').innerText = '" . $this->CI->lang->line('mt67') . " '+tv+'.';
                                } else {
                                    popup_fon('sube', translation.mm3, 1500, 2000);
                                }
                            } else {
                                popup_fon('sube', translation.mm3, 1500, 2000);
                            }
                        }
                    }
                    http.send(params);
                }
                function fali(e){
                    e.preventDefault();
                    var cd = new Date();
                    var datetime = cd.getFullYear() + '-' + (cd.getMonth() + 1) + '-' + cd.getDate() + ' ' + cd.getHours() + ':' + cd.getMinutes() + ':' + cd.getSeconds();
                    var url = home+'user/tool/monitoris?action=spm';
                    var act = sched.id;
                    var msg = document.getElementsByClassName('schedule-rep')[0].value;
                    var csr = document.querySelector(\"[name='csrf_test_name']\").value;
                    var params = 'csrf_test_name='+csr+'&act='+act+'&msg='+cl(msg)+'&cd='+cl(datetime);
                    var http = new XMLHttpRequest();
                    http.open('POST', url, true);
                    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    http.onreadystatechange = function() {
                        if(http.readyState == 4 && http.status == 200) {
                            document.querySelector('.modal.fade.show').click();
                            var data = http.responseText;
                            if(data) {
                                data = JSON.parse(data);
                                document.querySelector('#activity-'+act+' #reposts').innerHTML = data;
                                loadEx();
                            } else {
                                popup_fon('sube', translation.mm3, 1500, 2000);
                            }
                        }
                    }
                    http.send(params);
                }
                function loadEx(){
                    var form = document.getElementsByClassName('add-comment');
                    if(form.length > 0) {
                        if(form[0].addEventListener){
                            for(var f = 0; f < form.length; f++) {
                                form[f].addEventListener('submit', caload, false);
                            }
                        } else if(form[0].attachEvent) {
                            for(var f = 0; f < form.length; f++) {
                                form[f].attachEvent('onsubmit', caload);
                            }
                        }
                    }
                    var repo = document.getElementsByClassName('add-reply');
                    if(repo.length > 0) {
                        if(repo[0].addEventListener) {
                            for(var f = 0; f < repo.length; f++) {
                                repo[f].addEventListener('submit', relo, false);
                            }
                        }else if(repo[0].attachEvent){
                            for(var f = 0; f < repo.length; f++) {
                                repo[f].attachEvent('onsubmit', relo);
                            }
                        }
                    }        
                    var del = document.getElementsByClassName('delete-reply');
                    if(del.length) {
                        if(del[0].addEventListener) {
                            for(var f = 0; f < del.length; f++) {
                                del[f].addEventListener('click', deload, false);
                            }
                        } else if(del[0].attachEvent) {
                            for(var f = 0; f < del.length; f++) {
                                del[f].attachEvent('onclick', deload);
                            }
                        }
                    }
                    var reply = document.getElementsByClassName('reply-this');
                    if(reply.length) {
                        if(reply[0].addEventListener){
                            for(var f = 0; f < reply.length; f++) {
                                reply[f].addEventListener('click', loadThis, false);
                            }
                        }else if(reply[0].attachEvent){
                            for(var f = 0; f < reply.length; f++) {
                                reply[f].attachEvent('onclick', loadThis);
                            }
                        }
                    }
                    var seen = document.getElementsByClassName('seen-it');
                    if(seen.length) {
                        if(seen[0].addEventListener) {
                            for(var f = 0; f < seen.length; f++) {
                                seen[f].addEventListener('click', mark_seen, false);
                            }
                        } else if(seen[0].attachEvent) {
                            for(var f = 0; f < seen.length; f++) {
                                seen[f].attachEvent('onclick', mark_seen);
                            }
                        }
                    }
                    var rp = document.getElementsByClassName('repost-post');
                    if(rp.length) {
                        if(rp[0].addEventListener) {
                            for(var f = 0; f < rp.length; f++) {
                                rp[f].addEventListener('click', rpi, false);
                            }
                        } else if(rp[0].attachEvent) {
                            for(var f = 0; f < rp.length; f++) {
                                rp[f].attachEvent('onclick', rpi);
                            }
                        }
                    }                    
                    var dp = document.getElementsByClassName('delete-post');
                    if(dp.length) {
                        if(dp[0].addEventListener) {
                            for(var f = 0; f < dp.length; f++)
                            {
                                dp[f].addEventListener('click', dpi, false);
                            }
                        } else if(dp[0].attachEvent) {
                            for(var f = 0; f < dp.length; f++) {
                                dp[f].attachEvent('onclick', dpi);
                            }
                        }
                    }
                    var ds = document.getElementsByClassName('bschd');
                    if(ds.length) {
                        if(ds[0].addEventListener){
                            for(var f = 0; f < ds.length; f++) {
                                ds[f].addEventListener('click', dshed, false);
                            }
                        }else if(ds[0].attachEvent){
                            for(var f = 0; f < ds.length; f++) {
                                ds[f].attachEvent('onclick', dshed);
                            }
                        }
                    }
                    var sct = document.getElementsByClassName('sche-time');
                    if(sct.length) {
                        if(sct[0].addEventListener){
                            for(var f = 0; f < sct.length; f++)
                            {
                                sct[f].addEventListener('click', stime, false);
                            }
                        }else if(sct[0].attachEvent){
                            for(var f = 0; f < sct.length; f++)
                            {
                                sct[f].attachEvent('onclick', stime);
                            }
                        }
                    }                    
                    var set_date = document.getElementsByClassName('set-date')[0];
                    if(set_date) {
                        if(set_date.addEventListener) {
                            set_date.addEventListener('submit', deli, false);
                        } else if(set_date.attachEvent) {
                            set_date.attachEvent('onsubmit', deli);
                        }
                    }
                    var shed_date = document.getElementsByClassName('shed-date')[0];
                    if(shed_date) {
                        if(shed_date.addEventListener) {
                            shed_date.addEventListener('submit', fali, false);
                        } else if(shed_date.attachEvent) {
                            shed_date.attachEvent('onsubmit', fali);
                        }
                    }
                }
                loadEx();
            }
            </script>";

    }

}
