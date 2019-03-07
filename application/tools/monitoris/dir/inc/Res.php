<?php
/**
 * Face
 *
 * PHP Version 5.6
 *
 * The File contains the Class Face
 *
/**
 * Face - extracts and saves data to the table posts
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

/**
 * Face - extracts and saves data to the table posts
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
include_once FCPATH . 'vendor/autoload.php';
class Res {
    public $tab, $tg, $fb;
    public function aleator($params) {
        include_once APPPATH . 'interfaces/Autopost.php';
        $data = [];
            if($params) {
                foreach($params as $param) {
                    $from = self::get_account($param->network_id);
                    if (($param->network_name == 'facebook') || ($param->network_name == 'facebook_groups') || ($param->network_name == 'facebook_pages')) {
                        $token = $from[0]->token;
                        if ( strlen($from[0]->secret) > 1 ) {
                            $token = $from[0]->secret;
                        }
                        $data[] = self::lear($param->activity_id, $param->network_id, @file_get_contents(fb . $param->net_id . '/comments?filter=stream&fields=parent.fields(id),message,from,likes&access_token=' . $token));
                    } elseif($param->network_name == 'instagram') {
                        $do = [];
                        $network = @ucfirst($from[0]->network_name);
                        if (file_exists(APPPATH . 'autopost/' . $network . '.php')) {
                            include_once APPPATH . 'autopost/' . $network . '.php';
                            $get = new $network;
                            try {
                                $check = new \InstagramAPI\Instagram(false, false);
                                try {
                                    $CI = & get_instance();
                                    // Load User Model
                                    $CI->load->model('user');
                                    $user_proxy = $CI->user->get_user_option($from[0]->user_id,'proxy');
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
                                    $check->login($from[0]->net_id, $from[0]->token);
                                } catch (Exception $e) {
                                    return false;
                                }
                                $fr = @$check->media->getComments($param->net_id,1000);
                                
                                $comments = $fr->getComments();
                                
                                foreach($comments as $comment) {
                                    
                                    $do[] = [
                                        'id'=>$comment->pk,
                                        'user_id'=>$comment->user_id,
                                        'user'=>$comment->user->username,
                                        'msg'=>$comment->text
                                    ];
                                    
                                }
                                
                            } catch (Exception $e) {
                                return $e->getMessage();
                            }
                        }
                    $data[] = self::pro($param->activity_id, $param->network_id, $do);
                } elseif($param->network_name == 'twitter') {
                    $ed = $this->lino($from[0]->user_name,$param->net_id);
                    if(!$ed) die();
                    $ed = explode('<div class="stream">',$ed);
                    $fin = explode('<div class="stream-footer',$ed[1]);
                    $dom = new DOMDocument();
                    $dom->preserveWhiteSpace = false;
                    @$dom->loadHTML($fin[0]);
                    $xpath = new DOMXpath($dom);
                    $query = $xpath->query('//p[contains(@class,"tweet-text")]');
                    $tweet = $xpath->query('//div[contains(@class,"permalink-descendant-tweet")]');
                    $profile = $xpath->query('//a[contains(@class,"js-user-profile-link")]');
                    $do = [];
                    if ($query->length) {
                        $feed = '';
                        for ($e = 0; $e < $query->length; $e++) {
                                if((@$tweet[$e]->getAttribute('data-tweet-id')) && (@$query[$e]->nodeValue) && (@$profile[$e]->getAttribute('data-user-id')) && (@$profile[$e]->getAttribute('href'))) {
                                        $do[] = ['id' => $tweet[$e]->getAttribute('data-tweet-id'), 'msg' => $query[$e]->nodeValue, 'user_id' => $profile[$e]->getAttribute('data-user-id'), 'user' => str_replace('/','',$profile[$e]->getAttribute('href'))];
                                }
                        }
                    }
                    $data[] = $this->lbi($param->activity_id, $param->network_id, $do);
                }
            }
            return $data;
        }
    }
    public function likes($params) {
        include_once APPPATH . 'interfaces/Autopost.php';
        if($params) {
            $data = [];
            foreach($params as $param) {
                $from = self::get_account($param->network_id);
                if (($param->network_name == 'facebook') || ($param->network_name == 'facebook_groups') || ($param->network_name == 'facebook_pages')) {
                    $token = $from[0]->token;
                    if ( strlen($from[0]->secret) > 1 ) {
                        $token = $from[0]->secret;
                    }
                    $data[] = self::lear($param->activity_id, $param->network_id, @file_get_contents(fb . $param->net_id . '/likes?access_token=' . $token), 1);
                } elseif($param->network_name == 'instagram'){
                    $do = [];
                    $network = @ucfirst($from[0]->network_name);
                    if (file_exists(APPPATH . 'autopost/' . $network . '.php')) {
                        include_once APPPATH . 'autopost/' . $network . '.php';
                        $get = new $network;
                        try {
                            $check = new \InstagramAPI\Instagram(false, false);
                            try {
                                $CI = & get_instance();
                                // Load User Model
                                $CI->load->model('user');
                                $user_proxy = $CI->user->get_user_option($from[0]->user_id,'proxy');
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
                                $check->login($from[0]->net_id, $from[0]->token);
                            } catch (Exception $e) {
                                return false;
                            }
                            $fr = @$check->media->getLikers($param->net_id);
                            $do = [];
                            if(@$fr->users) {
                                foreach($fr->users as $like)
                                {
                                    $username = $like->username;
                                    $pk = $like->pk;
                                    $do[] = ['id'=>$pk,'user'=>$username,'msg'=>''];
                                }
                            }
                        } catch (Exception $e) {
                            return $e->getMessage();
                        }
                    }
                    $data[] = self::pro($param->activity_id, $param->network_id, $do);
                    } elseif($param->network_name == 'twitter'){
                        $ed = $this->lino($from[0]->user_name,$param->net_id);
                        if(!$ed) die();
                        $ed = explode('js-face-pile-container',$ed);
                        $fin = explode('</li>','<p class="'.@$ed[1]);
                        $dom = new DOMDocument();
                        $dom->preserveWhiteSpace = false;
                        @$dom->loadHTML(@$fin[0].'</p>');
                        $xpath = new DOMXpath($dom);
                        $profile = $xpath->query('//a[contains(@class,"js-profile-popup-actionable")]');
                        $do = [];
                        if ($profile->length) {
                                $feed = '';
                                for ($e = 0; $e < $profile->length; $e++) {
                                        if((@$profile[$e]->getAttribute('data-user-id')) && (@$profile[$e]->getAttribute('href')))
                                        {
                                                $do[] = ['user_id' => $profile[$e]->getAttribute('data-user-id'), 'user' => str_replace('/','',$profile[$e]->getAttribute('href'))];
                                        }
                                }
                        }
                        $data[] = $this->lbi($param->activity_id, $param->network_id, $do);
                    }
            }
            return $data;
        }
    }

    protected function lear($a, $n, $param, $d = NULL) {
        if ($param) {
            $response = json_decode($param);
            $new = [];
            foreach ($response->data as $data) {
                if (@$data->message) {
                    $msg = $data->message;
                } else {
                    $msg = '';
                }
                if (@$data->parent) {
                    $new[] = [$a, 'parent', $data->id, $data->from->id, $data->from->name, $msg, $n, $data->parent->id];
                } else {
                    if ($d) {
                        if (@$data->name) {
                            $new[] = [$a, 'like', $a.'_'.$data->id, $data->id, $data->name, $msg, $n];
                        } else {
                            continue;
                        }
                    } else {
                        $new[] = [$a, 'comment', $data->id, $data->from->id, $data->from->name, $msg, $n];
                    }
                }
            }
            return $new;
        } else {
            return false;
        }
    }

    public function com($msg, $post, $account, $act) {
        $from = self::get_account($account);
        include_once APPPATH . 'interfaces/Autopost.php';
        if (($from[0]->network_name == 'facebook') || ($from[0]->network_name == 'facebook_groups') || ($from[0]->network_name == 'facebook_pages')) {
            $network = ucfirst($from[0]->network_name);
            if (file_exists(APPPATH . 'autopost/' . $network . '.php')) {
                include_once APPPATH . 'autopost/' . $network . '.php';
                // Verify if the user can use his App Key and App Secret
                if ((get_option('facebook_user_api_key') == '1') && ($network == 'Facebook')) {
                    if (file_exists(FCPATH . 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php')) {
                        try {
                            include FCPATH . 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php';
                            $this->fb = new Facebook\Facebook(
                                [
                                    'app_id' => $from[0]->api_key,
                                    'app_secret' => $from[0]->api_secret,
                                    'default_graph_version' => 'v2.9',
                                    'default_access_token' => '{access-token}',
                                ]
                            );
                            $linkData = ['message' => $msg];
                            $comment = $this->fb->post('/' . $post . '/comments', $linkData, $from[0]->token);
                        } catch (Facebook\Exceptions\FacebookResponseException $e) {
                            // When Graph returns an error
                            echo json_encode($e->getMessage());
                        } catch (Facebook\Exceptions\FacebookSDKException $e) {
                            // When validation fails or other local issues
                            echo json_encode($e->getMessage());
                        }
                    }
                } else if ((get_option('facebook_pages_user_api_key') == '1') && ($network == 'Facebook_pages')) {
                    if (file_exists(FCPATH . 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php')) {
                        try {
                            include FCPATH . 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php';
                            $this->fb = new Facebook\Facebook(
                                [
                                    'app_id' => $from[0]->api_key,
                                    'app_secret' => $from[0]->api_secret,
                                    'default_graph_version' => 'v2.9',
                                    'default_access_token' => '{access-token}',
                                ]
                            );
                            $linkData = ['message' => $msg];
                            $token = $from[0]->token;
                            if( strlen($from[0]->secret) > 1 ) {
                                $token = $from[0]->secret;
                            }
                            $comment = $this->fb->post('/' . $post . '/comments', $linkData, $token);
                        } catch (Facebook\Exceptions\FacebookResponseException $e) {
                            // When Graph returns an error
                            echo json_encode($e->getMessage());
                        } catch (Facebook\Exceptions\FacebookSDKException $e) {
                            // When validation fails or other local issues
                            echo json_encode($e->getMessage());
                        }
                    }
                } else if ((get_option('facebook_groups_user_api_key') == '1') && ($network == 'Facebook_groups')) {
                    if (file_exists(FCPATH . 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php')) {
                        try {
                            include FCPATH . 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php';
                            $this->fb = new Facebook\Facebook(
                                [
                                    'app_id' => $from[0]->api_key,
                                    'app_secret' => $from[0]->api_secret,
                                    'default_graph_version' => 'v2.9',
                                    'default_access_token' => '{access-token}',
                                ]
                            );
                            $linkData = ['message' => $msg];
                            $token = $from[0]->token;
                            $comment = $this->fb->post('/' . $post . '/comments', $linkData, $token);
                        } catch (Facebook\Exceptions\FacebookResponseException $e) {
                            // When Graph returns an error
                            echo json_encode($e->getMessage());
                        } catch (Facebook\Exceptions\FacebookSDKException $e) {
                            // When validation fails or other local issues
                            echo json_encode($e->getMessage());
                        }
                    }
                } else {
                    $get = new $network;
                    $linkData = ['message' => $msg];
                    $token = $from[0]->token;
                    if( strlen($from[0]->secret) > 1 ) {
                        $token = $from[0]->secret;
                    }
                    $comment = $get->fb->post('/' . $post . '/comments', $linkData, $token);                    
                }
                try {
                    $data = $comment->getDecodedBody();
                    if ($data) {
                        Ceil::cl('Instance')->mod('posts', 'save_comment', [$data['id']]);
                    }
                    $net = Ceil::cl('Instance')->mod('posts', 'get_activity_by_id', [$act]);
                    return self::lear($act, $account, @file_get_contents(fb . $net[0]->net_id . '/comments?filter=stream&fields=parent.fields(id),message,from,likes&access_token=' . $from[0]->token));
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }
        } elseif($from[0]->network_name == 'instagram'){
            $network = ucfirst($from[0]->network_name);
            if (file_exists(APPPATH . 'autopost/' . $network . '.php')) {
                include_once APPPATH . 'autopost/' . $network . '.php';
                $get = new $network;
                try {
                    $check = new \InstagramAPI\Instagram(false, false);
                    try {
                        $CI = & get_instance();
                        // Load User Model
                        $CI->load->model('user');
                        $user_proxy = $CI->user->get_user_option($from[0]->user_id,'proxy');
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
                        $check->login($from[0]->net_id, $from[0]->token);
                    } catch (Exception $e) {
                        return false;
                    }
                    $check->media->comment($post,$msg);
                    $fr = @$check->media->getComments($post,1000);
                    $do = [];

                    $comments = $fr->getComments();
                    
                    if ( $comments ) {

                        foreach($comments as $comment) {

                            $do[] = [
                                'id'=>$comment->pk,
                                'user_id'=>$comment->user_id,
                                'user'=>$comment->user->username,
                                'msg'=>$comment->text
                            ];

                        }
                    
                    }
                    
                    return self::pro($act, $account, $do);
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }
        } elseif($from[0]->network_name == 'twitter'){
            $network = ucfirst($from[0]->network_name);
            if (file_exists(APPPATH . 'autopost/' . $network . '.php')) {
                include_once APPPATH . 'autopost/' . $network . '.php';
                $get = new $network;
                try {
                    $this->reg($get->twitter_key, $get->twitter_secret);
                    $this->gty($from[0]->token, $from[0]->secret)->post('statuses/update', ['in_reply_to_status_id'=> $post , 'status' => $msg]);
                    $ed = $this->lino($from[0]->user_name,$post);
                    if(!$ed) die();
                    $ed = explode('<div class="stream">',$ed);
                    $fin = explode('<div class="stream-footer',$ed[1]);
                    $dom = new DOMDocument();
                    $dom->preserveWhiteSpace = false;
                    @$dom->loadHTML($fin[0]);
                    $xpath = new DOMXpath($dom);
                    $query = $xpath->query('//p[contains(@class,"tweet-text")]');
                    $tweet = $xpath->query('//div[contains(@class,"permalink-descendant-tweet")]');
                    $profile = $xpath->query('//a[contains(@class,"js-user-profile-link")]');
                    $do = [];
                    if ($query->length) {
                        $feed = '';
                        for ($e = 0; $e < $query->length; $e++) {
                            if((@$tweet[$e]->getAttribute('data-tweet-id')) && (@$query[$e]->nodeValue) && (@$profile[$e]->getAttribute('data-user-id')) && (@$profile[$e]->getAttribute('href'))) {
                                $do[] = ['id' => $tweet[$e]->getAttribute('data-tweet-id'), 'msg' => $query[$e]->nodeValue, 'user_id' => $profile[$e]->getAttribute('data-user-id'), 'user' => str_replace('/','',$profile[$e]->getAttribute('href'))];
                            }
                        }
                    }
                    return $this->lbi($act, $account, $do);
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }
        } else {
            return false;
        }
    }
    
    protected function pro($a, $n, $param) {
        if ($param) {
            $new = [];
            foreach ($param as $data) {
                if (@$data['msg']) {
                    $msg = $data['msg'];
                } else {
                    $msg = '';
                }
                if (!@$data['user_id']) {
                    $new[] = [$a, 'like', $a.'_'.$data['id'], $data['id'], $data['user'], $msg, $n];
                } else {
                    $new[] = [$a, 'comment', $data['id'], $data['user_id'], $data['user'], $msg, $n];
                }
            }
            return $new;
        } else {
            return false;
        }
    }
    
    public function led($params) {
        if($params) {
            include_once APPPATH . 'interfaces/Autopost.php';
            foreach($params as $param) {
                $from = self::get_account($param->network_id);
                $network = ucfirst($from[0]->network_name); 
                Ceil::cl('Instance')->mod('posts', 'delete_all', [$param->activity_id,$param->net_id]);
                if (($param->network_name == 'facebook') || ($param->network_name == 'facebook_groups') || ($param->network_name == 'facebook_pages')) {
                    if (file_exists(APPPATH . 'autopost/' . $network . '.php')) {
                        include_once APPPATH . 'autopost/' . $network . '.php';
                        // Verify if the user can use his App Key and App Secret
                        if ((get_option('facebook_user_api_key') == '1') && ($network == 'Facebook')) {
                            if (file_exists(FCPATH . 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php')) {
                                try {
                                    include FCPATH . 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php';
                                    $this->fb = new Facebook\Facebook(
                                        [
                                            'app_id' => $from[0]->api_key,
                                            'app_secret' => $from[0]->api_secret,
                                            'default_graph_version' => 'v2.9',
                                            'default_access_token' => '{access-token}',
                                        ]
                                    );
                                    try {
                                        $this->fb->setDefaultAccessToken($from[0]->token);
                                        $this->fb->delete('/'.$param->net_id);
                                    } catch (Exception $e) {
                                        return $e->getMessage();
                                    }
                                } catch (Facebook\Exceptions\FacebookResponseException $e) {
                                    // When Graph returns an error
                                    echo json_encode($e->getMessage());
                                } catch (Facebook\Exceptions\FacebookSDKException $e) {
                                    // When validation fails or other local issues
                                    echo json_encode($e->getMessage());
                                }
                            }
                        } else if ((get_option('facebook_pages_user_api_key') == '1') && ($network == 'Facebook_pages')) {
                            if (file_exists(FCPATH . 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php')) {
                                try {
                                    include FCPATH . 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php';
                                    $this->fb = new Facebook\Facebook(
                                        [
                                            'app_id' => $from[0]->api_key,
                                            'app_secret' => $from[0]->api_secret,
                                            'default_graph_version' => 'v2.9',
                                            'default_access_token' => '{access-token}',
                                        ]
                                    );
                                    try {
                                        $token = $from[0]->token;
                                        $this->fb->setDefaultAccessToken($token);
                                        $this->fb->delete('/'.$param->net_id);
                                    } catch (Exception $e) {
                                        return $e->getMessage();
                                    }
                                } catch (Facebook\Exceptions\FacebookResponseException $e) {
                                    // When Graph returns an error
                                    echo json_encode($e->getMessage());
                                } catch (Facebook\Exceptions\FacebookSDKException $e) {
                                    // When validation fails or other local issues
                                    echo json_encode($e->getMessage());
                                }
                            }
                        } else if ((get_option('facebook_groups_user_api_key') == '1') && ($network == 'Facebook_groups')) {
                            if (file_exists(FCPATH . 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php')) {
                                try {
                                    include FCPATH . 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php';
                                    $this->fb = new Facebook\Facebook(
                                        [
                                            'app_id' => $from[0]->api_key,
                                            'app_secret' => $from[0]->api_secret,
                                            'default_graph_version' => 'v2.9',
                                            'default_access_token' => '{access-token}',
                                        ]
                                    );
                                    try {
                                        $this->fb->setDefaultAccessToken($from[0]->token);
                                        $this->fb->delete('/'.$param->net_id);
                                    } catch (Exception $e) {
                                        return $e->getMessage();
                                    }
                                } catch (Facebook\Exceptions\FacebookResponseException $e) {
                                    // When Graph returns an error
                                    echo json_encode($e->getMessage());
                                } catch (Facebook\Exceptions\FacebookSDKException $e) {
                                    // When validation fails or other local issues
                                    echo json_encode($e->getMessage());
                                }
                            }
                        } else {
                            $get = new $network;
                            try {
                                $token = $from[0]->token;
                                if( strlen($from[0]->secret) > 1 ) {
                                    $token = $from[0]->secret;
                                }
                                $get->fb->setDefaultAccessToken($token);
                                $get->fb->delete('/'.$param->net_id);
                            } catch (Exception $e) {
                                return $e->getMessage();
                            }   
                        }
                    }
                } else if ($param->network_name == 'instagram') {
                    if (file_exists(APPPATH . 'autopost/' . $network . '.php')) {
                        include_once APPPATH . 'autopost/' . $network . '.php';
                        $get = new $network;
                        try {
                            $check = new \InstagramAPI\Instagram(false, false);
                            try {
                                $CI = & get_instance();
                                // Load User Model
                                $CI->load->model('user');
                                $user_proxy = $CI->user->get_user_option($from[0]->user_id,'proxy');
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
                                $check->login($from[0]->net_id, $from[0]->token);
                            } catch (Exception $e) {
                                return false;
                            }
                            @$check->media->delete($param->net_id);
                        } catch (Exception $e) {
                            return $e->getMessage();
                        }
                    }
                } else if ($param->network_name == 'twitter') {
                    if (file_exists(APPPATH . 'autopost/' . $network . '.php')) {
                        include_once APPPATH . 'autopost/' . $network . '.php';
                        $get = new $network;
                        try {
                            $this->reg($get->twitter_key, $get->twitter_secret);
                            $this->gty($from[0]->token, $from[0]->secret)->post('statuses/destroy', ['id'=> $param->net_id]);
                        } catch (Exception $e) {
                            return $e->getMessage();
                        }
                    } 
                }
            }
        } else {
            return false;
        }
    }
    
    public function dcom($comment,$account,$act) {
        $from = self::get_account($account);
        $network = ucfirst($from[0]->network_name);
        if (($from[0]->network_name == 'facebook') || ($from[0]->network_name == 'facebook_groups') || ($from[0]->network_name == 'facebook_pages')) {
            include_once APPPATH . 'interfaces/Autopost.php';
            if (file_exists(APPPATH . 'autopost/' . $network . '.php')) {
                include_once APPPATH . 'autopost/' . $network . '.php';
                // Verify if the user can use his App Key and App Secret
                if ((get_option('facebook_user_api_key') == '1') && ($network == 'Facebook')) {
                    if (file_exists(FCPATH . 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php')) {
                        try {
                            include FCPATH . 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php';
                            $this->fb = new Facebook\Facebook(
                                [
                                    'app_id' => $from[0]->api_key,
                                    'app_secret' => $from[0]->api_secret,
                                    'default_graph_version' => 'v2.9',
                                    'default_access_token' => '{access-token}',
                                ]
                            );
                            Ceil::cl('Instance')->mod('posts', 'delete_comment', [$comment]);
                            $this->fb->setDefaultAccessToken($from[0]->token);
                            @$this->fb->delete('/'.$comment);
                        } catch (Facebook\Exceptions\FacebookResponseException $e) {
                            // When Graph returns an error
                            echo json_encode($e->getMessage());
                        } catch (Facebook\Exceptions\FacebookSDKException $e) {
                            // When validation fails or other local issues
                            echo json_encode($e->getMessage());
                        }
                    }
                } else if ((get_option('facebook_pages_user_api_key') == '1') && ($network == 'Facebook_pages')) {
                    if (file_exists(FCPATH . 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php')) {
                        try {
                            include FCPATH . 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php';
                            $this->fb = new Facebook\Facebook(
                                [
                                    'app_id' => $from[0]->api_key,
                                    'app_secret' => $from[0]->api_secret,
                                    'default_graph_version' => 'v2.9',
                                    'default_access_token' => '{access-token}',
                                ]
                            );
                            Ceil::cl('Instance')->mod('posts', 'delete_comment', [$comment]);
                            $token = $from[0]->token;
                            $this->fb->setDefaultAccessToken($token);
                            @$this->fb->delete('/'.$comment);
                        } catch (Facebook\Exceptions\FacebookResponseException $e) {
                            // When Graph returns an error
                            echo json_encode($e->getMessage());
                        } catch (Facebook\Exceptions\FacebookSDKException $e) {
                            // When validation fails or other local issues
                            echo json_encode($e->getMessage());
                        }
                    }
                } else if ((get_option('facebook_groups_user_api_key') == '1') && ($network == 'Facebook_groups')) {
                    if (file_exists(FCPATH . 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php')) {
                        try {
                            include FCPATH . 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php';
                            $this->fb = new Facebook\Facebook(
                                [
                                    'app_id' => $from[0]->api_key,
                                    'app_secret' => $from[0]->api_secret,
                                    'default_graph_version' => 'v2.9',
                                    'default_access_token' => '{access-token}',
                                ]
                            );
                            Ceil::cl('Instance')->mod('posts', 'delete_comment', [$comment]);
                            $this->fb->setDefaultAccessToken($from[0]->token);
                            @$this->fb->delete('/'.$comment);
                        } catch (Facebook\Exceptions\FacebookResponseException $e) {
                            // When Graph returns an error
                            echo json_encode($e->getMessage());
                        } catch (Facebook\Exceptions\FacebookSDKException $e) {
                            // When validation fails or other local issues
                            echo json_encode($e->getMessage());
                        }
                    }
                } else {
                    $get = new $network;
                    Ceil::cl('Instance')->mod('posts', 'delete_comment', [$comment]);
                    $token = $from[0]->token;
                    if( strlen($from[0]->secret) > 1 ) {
                        $token = $from[0]->secret;
                    }
                    $get->fb->setDefaultAccessToken($token);
                    @$get->fb->delete('/'.$comment);
                }
                try {
                    return $act;
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            } 
        } else if ($from[0]->network_name == 'instagram') {
            include_once APPPATH . 'interfaces/Autopost.php';
            if (file_exists(APPPATH . 'autopost/' . $network . '.php')) {
                include_once APPPATH . 'autopost/' . $network . '.php';
                $get = new $network;
                try {
                    $check = new \InstagramAPI\Instagram(false, false);
                    try {
                        $CI = & get_instance();
                        // Load User Model
                        $CI->load->model('user');
                        $user_proxy = $CI->user->get_user_option($from[0]->user_id,'proxy');
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
                        $check->login($from[0]->net_id, $from[0]->token);
                    } catch (Exception $e) {
                        return false;
                    }
                    Ceil::cl('Instance')->mod('posts', 'delete_comment', [$comment]);
                    $net = Ceil::cl('Instance')->mod('posts', 'get_activity_by_id', [$act]);
                    @$check->media->deleteComment($net[0]->net_id,$comment);
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            } 
        } else if ($from[0]->network_name == 'twitter') {
            include_once APPPATH . 'interfaces/Autopost.php';
            if (file_exists(APPPATH . 'autopost/' . $network . '.php')) {
                include_once APPPATH . 'autopost/' . $network . '.php';
                $get = new $network;
                try {
                    $this->reg($get->twitter_key, $get->twitter_secret);
                    $this->gty($from[0]->token, $from[0]->secret)->post('statuses/destroy', ['id'=> $comment]);
                    Ceil::cl('Instance')->mod('posts', 'delete_comment', [$comment]);
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }             
        } else {
            return false;
        }
    }

    public function get_account($param) {
        if ($param) {
            return Ceil::cl('Instance')->mod('networks', 'get_account', [$param]);
        }
    }
    
    protected function lbi($a, $n, $param) {
        if ($param) {
            $new = [];
            foreach ($param as $data) {
                if (@$data['msg']) {
                    $msg = $data['msg'];
                    $new[] = [$a, 'comment', $data['id'], $data['user_id'], $data['user'], $msg, $n];
                } else {
                    $msg = '';
                    $new[] = [$a, 'like', $a.'-'.$data['user_id'], $data['user_id'], $data['user'], $msg, $n];
                }
            }
            return $new;
        } else {
            return false;
        }
    }
    
    public function seen($user,$param) {
        if (($user != '') && ($param != '')) {
            return Ceil::cl('Instance')->mod('posts', 'seen', [$user,$param]);
        }
    }
    
    public function get_act($param) {
        if ($param) {
            return Ceil::cl('Instance')->mod('posts', 'get_an_activity', [$param]);
        }
    }
    
    public function getProtectedValue($obj,$name) {
      $array = (array)$obj;
      $prefix = chr(0).'*'.chr(0);
      return $array[$prefix.$name];
    }

    public function tim($msg,$cd) {
        if($msg > $cd) {
            $d = $msg - $cd;
            $date = time() + $d;
            return $date;
        } else{
            return time();
        }
    }
    
    public function ifu($v) {
        return [$v[0]->user_id,$v[0]->body,$v[0]->title,$v[0]->url,$v[0]->img,$v[0]->video,$v[0]->category,$v[0]->sent_time,$v[0]->status,$v[0]->post_id,];
    }
    
    protected function lino($a,$t) {
        return get('https://twitter.com/' . $a . '/status/'.$t);
    }
    
    protected function reg($t,$r) {
        $this->tab = $t;
        $this->tg = $r;
    }    
    
    protected function gty($t,$r) {
        return new \Abraham\TwitterOAuth\TwitterOAuth($this->tab, $this->tg,$t,$r);
    }    
}