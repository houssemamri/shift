<?php
class Views {

    protected $CI;

    /**
     * Load networks and user model.
     */
    public function __construct() {
        $this->CI = & get_instance();
        if ( file_exists( APPPATH . 'language/' . $this->CI->config->item('language') . '/default_tool_lang.php' ) ) {
            $this->CI->lang->load( 'default_tool', $this->CI->config->item('language') );
        }
    }

    public function single($param) {
        if ($param) {
            $data = '';
            foreach ($param as $val) {
                $title = '';
                if ($val->title) {
                    $title = '<h2>' . $val->title . '</h2>';
                }
                $body = '';
                if ($val->body) {
                    $body = '<p>' . $val->body . '</p>';
                }
                $url = '';
                if ($val->url) {
                    $url = '<div class="row">
                        <div class="col-xl-12">
                        <p><a href="' . $val->url . '" target="_blank">' . $val->url . '</a></p>
                        </div></div>';
                }
                $img = '';
                $images = @unserialize($val->img);
                if ($images) {
                    
                    $get_imgages = get_post_media_array($this->CI->user_id, $images );
                          
                    foreach( $get_imgages as $image ) {
                        
                        $img .= '<div class="row">'
                            . '<div class="col-xl-12">'
                                . '<p>'
                                    . '<img src="' . $image['body'] . '" style="max-height:100%">'
                                . '</p>'
                            . '</div>'
                        . '</div>';
                        
                    }
                    
                }
                
                $video = '';
                $videos = @unserialize($val->video);
                if ( $videos ) {
                    
                    $get_videos = get_post_media_array($this->CI->user_id, $videos );
                    
                    foreach( $get_videos as $vid ) {
                    
                        $video = '<div class="row">'
                            . '<div class="col-xl-12">'
                                . '<p>'
                                    . '<video controls="true" style="width:100%;height:300px"><source src="' . $vid['body'] . '" type="video/mp4" /></video>'
                                . '</p>'
                            . '</div>'
                        . '</div>';
                    
                    }
                    
                }
                $del = ' hide';
                $td = '';
                if ($val->dlt) {
                    $del = '';
                    $td = $this->CI->lang->line('mt44') . strip_tags(calculate_time($val->dlt, time()));
                }
                $data .= '<div class="col-xl-6 col-md-6 col-sm-12 col-xs-12 offset-xl-3 single-activity" id="activity-' . $val->activity_id . '">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="panel-heading details">
                                      <h2><a href="' . base_url('user/tools/monitoris?net=' . strtolower(str_replace("_", "-", $val->network_name))) . '&page=1">' . ucwords(str_replace("_", " ", $val->network_name)) . '</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="' . base_url('user/tools/monitoris?net=' . $val->network_id) . '&page=1">' . $val->user_name . '</a></h2>
                                      <ul class="mop">
                                        <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                                          <ul class="dropdown-menu">
                                            <li><a href="#" data-id="' . $val->activity_id . '" class="seen-it">' . $this->CI->lang->line('mt45') . '</a></li>
                                            <li><a href="#" data-toggle="modal" class="repost-post" data-id="' . $val->activity_id . '" data-target=".bs-repost-post">' . $this->CI->lang->line('mt46') . '</a></li>
                                            <li><a href="#" data-toggle="modal" class="delete-post" data-id="' . $val->activity_id . '" data-target=".bs-delete-post">' . $this->CI->lang->line('mt47') . '</a></li>
                                          </ul>
                                        </li>
                                      </ul>
                                    </div>
                                </div>
                                <div class="row will-del' . $del . '">
                                    <div class="col-md-12">
                                      <div class="sched-del">
                                        <div class="del-split del-danger"><i class="icon-bell"></i></div>
                                        <div class="del-text">' . $td . '</div>
                                      </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                    ' . $title . $body . '
                                    </div>
                                </div>
                                ' . $url . $img . $video . '  
                                <div class="row">
                                    <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover">
                                            <tbody id="reposts">
                                            ' . $this->les(Ceil::cl('Instance')->mod('posts', 'cildrens', [$val->post_id])) . '
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="panel-footer" id="act-' . $val->activity_id . '">' . self::com($val->activity_id, self::get_permalink($val->network_name), $val) . '</div>
                                </div>
                            </div>
                        </div>';
            }
        }
        if (!@$data) {
            $data = '<div class="col-xl-6 col-md-6 col-sm-12 col-xs-12 offset-xl-3 single-activity">'
                        . '<div class="col-xl-12">'
                            . '<div class="row">'
                                . '<p class="no-results-found">' . $this->CI->lang->line('mt48') . '</p>'
                            . '</div>'
                        . '</div>'
                    . '</div>';
        }
        return $data . $this->footer();
    }

    public function com($id, $permalink, $post) {
        $comments = self::coms($id);
        $com = '<ul class="list-group">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <div class="like-info">
                                ' . $this->CI->lang->line('mt49') . '
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>';
        if ($comments) {
            $com = '<ul class="list-group">';
            foreach ($comments as $comment) {
                $delete = '';
                if ((@$comment->comment == $comment->net_id || $post->network_name == 'instagram' || $post->network_name == 'twitter') && ($post->network_name != 'google_plus')):
                    $delete = '<a href="" class="dc delete-reply" data-act="' . $post->activity_id . '" data-comment="' . $comment->net_id . '" data-account="' . $post->network_id . '"><i class="fa fa-times" aria-hidden="true"></i> ' . ucfirst($this->CI->lang->line('mm114')) . '</a>';
                endif;
                $replies = '';
                if (self::replies($comment->net_id)) {
                    foreach (self::replies($comment->net_id) as $reply) {
                        $del = '';
                        if (@$reply->comment == $reply->net_id):
                            $del = '<a href="" class="dc delete-reply" data-act="' . $post->activity_id . '" data-comment="' . $reply->net_id . '" data-account="' . $post->network_id . '"><i class="fa fa-times" aria-hidden="true"></i> ' . ucfirst($this->CI->lang->line('mm114')) . '</a>';
                        endif;
                        $replies .= '<li class="list-group-item replies">
                            <div class="row">
                                <div class="col-md-12">
                                    <div>
                                        <div class="com-info">
                                            ' . $this->CI->lang->line('mt50') . ': <a href="' . $permalink . $reply->author_id . '" target="_blank">' . $reply->author_name . '</a>
                                        </div>
                                    </div>
                                    <div class="comment-text">
                                        ' . $reply->body . '
                                    </div>
                                    <div class="comment-reply">
                                        <a href="#" data-toggle="modal" class="reply-this" data-target="#addrep" data-act="' . $post->activity_id . '" data-comment="' . $comment->net_id . '" data-account="' . $post->network_id . '"><i class="fa fa-reply" aria-hidden="true"></i> ' . $this->CI->lang->line('mt51') . '</a>
                                        ' . $del . '
                                    </div>
                                </div>
                            </div>
                        </li>';
                    }
                }
                if(get_option('allow_facebook_commenting')) {
                    $repl = '<div class="comment-reply">
                                <a href="#" data-toggle="modal" class="reply-this" data-target="#addrep" data-act="' . $post->activity_id . '" data-comment="' . $comment->net_id . '" data-account="' . $post->network_id . '"><i class="fa fa-reply" aria-hidden="true"></i> ' . $this->CI->lang->line('mt51') . '</a>
                                ' . $delete . '
                            </div>';
                } else {
                    if($post->network_name == 'facebook_pages') {
                        $repl = '<div class="comment-reply">
                                    <a href="#" data-toggle="modal" class="reply-this" data-target="#addrep" data-act="' . $post->activity_id . '" data-comment="' . $comment->net_id . '" data-account="' . $post->network_id . '"><i class="fa fa-reply" aria-hidden="true"></i> ' . $this->CI->lang->line('mt51') . '</a>
                                    ' . $delete . '
                                </div>';
                    } else {
                        $repl = '';
                    }
                }
                if ($post->network_name == 'twitter') {
                    $repl = '<div class="comment-reply">
                                    ' . $delete . '
                                </div>';
                }
                if ($post->network_name == 'instagram') {
                    $repl = '<div class="comment-reply">
                                    ' . $delete . '
                                </div>';
                }
                $com .= '<li class="list-group-item">
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    <div class="com-info">
                                        ' . $this->CI->lang->line('mt50') . ': <a href="' . $permalink . $comment->author_id . '" target="_blank">' . $comment->author_name . '</a>
                                    </div>
                                </div>
                                <div class="comment-text">
                                    ' . $comment->body . '
                                </div>
                                ' . $repl . '
                            </div>
                        </div>
                    </li>' . $replies;
            }
            $com .= '</ul>';
        }
        $likes = self::liks($id);
        $lik = '<ul class="list-group">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <div class="like-info">
                                ' . $this->CI->lang->line('mt52') . '
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>';
        if ($likes) {
            $lik = '<ul class="list-group">';
            foreach ($likes as $like) {
                $lik .= '<li class="list-group-item">
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    <div class="like-info">
                                        <a href="' . $permalink . $like->author_id . '" target="_blank">' . $like->author_name . '</a> ' . $this->CI->lang->line('mt53') . '
                                    </div>
                                </div>                              
                            </div>
                        </div>
                    </li>';
            }
            $lik .= '</ul>';
        }
        $comments = ($comments) ? count($comments) : '0';
        $likes = ($likes) ? count($likes) : '0';
        $panel_footer = '<div class="row">
                          ' . form_open('#', ['class' => 'add-comment', 'data-post' => $post->net_id, 'data-account' => $post->network_id, 'data-act' => $post->activity_id]) . '
                            <div class="col-md-12">
                                <textarea placeholder="' . $this->CI->lang->line('mt43') . '" class="msg"></textarea>
                            </div>
                            <div class="col-md-12">
                                <button class="pull-right btn" type="submit">' . $this->CI->lang->line('mt54') . '</button>
                            </div>
                          ' . form_close() . '
                        </div>';
        if (!get_option('allow_facebook_commenting')) {
            if (($post->network_name == 'facebook') || ($post->network_name == 'facebook_groups')) {
                $panel_footer = '';
            }
        }
        return '<div class="comfo">
                    <ul class="nav nav-tabs" role="tablist">
                        <li><a href="#comments-' . $id . '" class="show" aria-controls="comments-' . $id . '" role="tab" data-toggle="tab"><i class="fa fa-comments" aria-hidden="true"></i> ' . $this->CI->lang->line('mt55') . ' (' . $comments . ')</a>
                        </li>
                        <li><a href="#likes-' . $id . '" aria-controls="likes-' . $id . '" role="tab" data-toggle="tab"><i class="fa fa-thumbs-up" aria-hidden="true"></i> ' . $this->CI->lang->line('mt56') . ' (' . $likes . ')</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active comments" id="comments-' . $id . '">
                            <div class="row">
                                <div class="col-md-12">
                                    ' . $com . '
                                </div>
                            </div>
                            ' . $panel_footer . '
                        </div>
                        <div role="tabpanel" class="tab-pane likes" id="likes-' . $id . '">
                            ' . $lik . '
                        </div>
                    </div>
                </div>';
    }

    private function footer() {
        return '';
    }

    public function pages($ret, $page, $net = NULL) {
        if (!$page)
            $page = 1;
        $url = 'user/tools/monitoris?page=';
        if ($net) {
            $url = 'user/tools/monitoris?net=' . $net . '&page=';
        }
        $pages = self::show_pages($ret, $page, 10, $url);
        if ($ret > 0) {
            return '<div class="row show">
                      <div class="col-md-12 text-center">
                          <ul class="pagination">' . $pages . '</ul>
                      </div>
                    </div>';
        }
    }

    public function show_pages($total, $current, $limit, $j) {
        if ($current > 1) {
            $bac = $current - 1;
            $pages = '<li class="page-item"><a href="' . base_url($j . $bac) . '" class="page-link">' . $this->CI->lang->line('mm129') . '</a></li>';
        } else {
            $pages = '<li class="page-item pagehide"><a href="#" class="page-link">' . $this->CI->lang->line('mm129') . '</a></li>';
        }
        $tot = (int) $total / (int) $limit;
        $tot = ceil($tot) + 1;
        $from = ($current > 2) ? $current - 2 : 1;
        for ($p = $from; $p < $tot; $p++) {
            if ($p == $current) {
                $pages .= '<li class="page-item active"><a class="page-link">' . $p . '</a></li>';
            } else if (($p < $current + 3) && ($p > $current - 3)) {
                $pages .= '<li class="page-item"><a href="' . base_url($j . $p) . '" class="page-link">' . $p . '</a></li>';
            } else if (($p < 6) && ($tot > 5) && (($current == 1) || ($current == 2))) {
                $pages .= '<li class="page-item"><a href="' . base_url($j . $p) . '" class="page-link">' . $p . '</a></li>';
            } else {
                break;
            }
        }
        if ($p == 1) {
            $pages .= '<li class="page-item active"><a href="' . base_url($j . $p) . '" class="page-link">' . $p . '</a></li>';
        }
        $next = $current;
        $next++;
        if ($next < $tot) {
            return $pages . '<li class="page-item"><a href="' . base_url($j . $next) . '" class="page-link">' . $this->CI->lang->line('mm128') . '</a></li>';
        } else {
            return $pages . '<li class="page-item pagehide"><a href="#" class="page-link">' . $this->CI->lang->line('mm128') . '</a></li>';
        }
    }

    public function les($param) {
        $data = '';
        if ($param) {
            foreach ($param as $par) {
                if ($par->sent_time < time())
                    continue;
                $never = 'never';
                if ($par->dlt) {
                    $never = $this->versa($par->dlt - $par->sent_time);
                }
                $data .= '<tr class="pt-' . $par->post_id . '">
                            <td>
                            <i class="icon-calendar" aria-hidden="true"></i> ' . $this->CI->lang->line('mt60') . ' ' . strip_tags(calculate_time($par->sent_time, time())) . ' ' . $this->CI->lang->line('mt61') . ' 
                                <div class="btn-group">
                                  <button type="button" class="btn btn-default btn-del-sched deleted-after btn-xs">' . $never . '</button>
                                  <button type="button" class="btn btn-default btn-del-sched dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                  </button>
                                  <ul class="dropdown-menu">
                                    <li><a href="#" class="sche-time" data-id="' . $par->post_id . '" data-time="1">1 ' . $this->CI->lang->line('mt62') . '</a></li>
                                    <li><a href="#" class="sche-time" data-id="' . $par->post_id . '" data-time="2">2 ' . $this->CI->lang->line('mt63') . '</a></li>
                                    <li><a href="#" class="sche-time" data-id="' . $par->post_id . '" data-time="3">12 ' . $this->CI->lang->line('mt63') . '</a></li>
                                    <li><a href="#" class="sche-time" data-id="' . $par->post_id . '" data-time="4">1 ' . $this->CI->lang->line('mt64') . '</a></li>
                                    <li><a href="#" class="sche-time" data-id="' . $par->post_id . '" data-time="5">1 ' . $this->CI->lang->line('mt65') . '</a></li>
                                    <li><a href="#" class="sche-time" data-id="' . $par->post_id . '" data-time="6">1 ' . $this->CI->lang->line('mt66') . '</a></li>
                                  </ul>
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <button class="btn-del-sched bschd btn btn-default btn-xs" data-id="' . $par->post_id . '" type="button">
                                    <i class="icon-trash"></i>
                                </button>     
                            </td>
                        </tr>';
            }
        }
        return $data;
    }

    private function versa($param) {
        switch ($param) {
            case '3600':
                return '1 ' . $this->CI->lang->line('mt62');
                break;
            case '7200':
                return '2 ' . $this->CI->lang->line('mt63');
                break;
            case '43200':
                return '12 ' . $this->CI->lang->line('mt63');
                break;
            case '86400':
                return '1 ' . $this->CI->lang->line('mt64');
                break;
            case '604800':
                return '1 ' . $this->CI->lang->line('mt65');
                break;
            case '2592000':
                return '1 ' . $this->CI->lang->line('mt66');
                break;
        }
    }

    private function liks($param) {
        if ($param) {
            return Ceil::cl('Instance')->mod('posts', 'get_likes', [$param]);
        }
    }

    private function coms($param) {
        if ($param) {
            return Ceil::cl('Instance')->mod('posts', 'get_comments', [$param]);
        }
    }

    private function replies($param) {
        if ($param) {
            return Ceil::cl('Instance')->mod('posts', 'get_replies', [$param]);
        }
    }

    public function gcoms($param) {
        if ($param) {
            if (is_numeric($param)) {
                $val = Ceil::cl('Res')->get_act($param);
                if ($val) {
                    return self::com($param, self::get_permalink($val[0]->network_name), $val[0]);
                }
            } else {
                $val = Ceil::cl('Res')->get_act($param[0][0]);
                if ($val) {
                    return self::com($param[0][0], self::get_permalink($val[0]->network_name), $val[0]);
                }
            }
        } else {
            return false;
        }
    }

    private function get_permalink($network) {
        switch ($network) {
            case 'twitter':
                return 'https://twitter.com/intent/user?user_id=';
                break;
            case 'facebook':
                return 'https://www.facebook.com/';
                break;
            case 'facebook_groups':
                return 'https://www.facebook.com/groups/';
                break;
            case 'facebook_pages':
                return 'https://www.facebook.com/';
                break;
            case 'google_plus':
                return 'https://plus.google.com/';
                break;
            case 'instagram':
                return 'https://www.instagram.com/';
                break;
        }
    }

}
