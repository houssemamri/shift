<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
  Name: Fifth Helper
  Author: Scrisoft
  Created: 17/09/2016
 * */
if (!function_exists('parse_rss_feed')) {

    function parse_rss_feed($url) {
        
        $params = parse_url($url);
        if(isset($params['query'])) {
            parse_str($params['query'], $query);
            if(isset($query['rss-url']) && isset($query['tool'])) {
                include_once APPPATH . 'interfaces/Tools.php';
                if (file_exists(APPPATH . 'tools' . '/' . $query['tool'] . '/' . $query['tool'] . '.php')) {
                    include_once APPPATH . 'tools' . '/' . $query['tool'] . '/' . $query['tool'] . '.php';
                    $class = ucfirst(str_replace('-', '_', $query['tool']));
                    $get = new $class;
                    $page = $get->page(['user_id'=>'', 'rss-url' => $query['rss-url']]);
                    return $page;
                } 
                exit();
            }   
        }
        
        $xmlDoc = new DOMDocument();

        @$xmlDoc->load($url);
        
        if ( !$xmlDoc->getElementsByTagName('channel')->length && !$xmlDoc->getElementsByTagName('entry')->length ) {
            return false;
        }
        
        if (!$xmlDoc->getElementsByTagName('channel')->length) {
            $channel = $xmlDoc->getElementsByTagName('title')->item(0);
            $rss_title = strip_tags($channel->nodeValue);
            $channel = $xmlDoc->getElementsByTagName('description')->item(0);
            $rss_description = @strip_tags($channel->nodeValue);
            if ($rss_title) {
                $title = [];
                $url = [];
                $pri = [];
                $description = [];
                for ($i = 0; $i < $xmlDoc->getElementsByTagName('entry')->length; $i++) {
                    $channel = $xmlDoc->getElementsByTagName('entry')->item($i);
                    $title[] = stripslashes(strip_tags($channel->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue));
                    $pri[] = get_instance()->ecl('Feeds')->single($channel,$xmlDoc,@$channel);
                    $text = $xmlDoc->saveHtml($channel);
                    $xml = @simplexml_load_string($text);
                    $linkAttributes = @$xml->link->attributes();
                    $u = $linkAttributes->href[0];
                    $url[] = strip_tags($u[0]);
                    if (@$channel->getElementsByTagName('summary')->length) {
                        $description[] = @stripslashes(strip_tags($channel->getElementsByTagName('summary')->item(0)->childNodes->item(0)->nodeValue));
                    } elseif (@$channel->getElementsByTagName('description')->length) {
                        $description[] = @stripslashes(strip_tags($channel->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue));
                    } elseif (@$channel->getElementsByTagName('encoded')->length) {
                        $description[] = @stripslashes(strip_tags($channel->getElementsByTagName('encoded')->item(0)->childNodes->item(0)->nodeValue));
                    } elseif (@$channel->getElementsByTagName('content')->length) {
                        $description[] = @stripslashes(strip_tags($channel->getElementsByTagName('content')->item(0)->childNodes->item(0)->nodeValue));
                    }
                }
                return array(
                    'rss_title' => $rss_title,
                    'rss_description' => $rss_description,
                    'title' => $title,
                    'url' => $url,
                    'description' => $description,
                    'show' => $pri
                );
            }
            
        } else {

            if (!@$xmlDoc->getElementsByTagName('channel')) {
                return false;
            }

            $channel = $xmlDoc->getElementsByTagName('channel')->item(0);
            $rss_title = strip_tags($channel->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue);
            $rss_description = @strip_tags($channel->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue);
            if ($rss_title) {
                $rss = $xmlDoc->getElementsByTagName('item');
                $title = [];
                $url = [];
                $description = [];
                $pri = [];
                $i = 0;
                foreach ($rss as $item) {
                    $title[] = @stripslashes(strip_tags($rss->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue));
                    $url[] = @strip_tags($rss->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue);
                    $pri[] = get_instance()->ecl('Feeds')->single($item,$xmlDoc,$rss->item($i));
                    if (@$rss->item($i)->getElementsByTagName('content')->length) {
                        $description[] = @stripslashes(strip_tags($rss->item($i)->getElementsByTagName('content')->item(0)->childNodes->item(0)->nodeValue));
                    } elseif (@$rss->item($i)->getElementsByTagName('encoded')->length) {
                        $description[] = @stripslashes(strip_tags($rss->item($i)->getElementsByTagName('encoded')->item(0)->childNodes->item(0)->nodeValue));
                    } elseif (@$rss->item($i)->getElementsByTagName('description')->length) {
                        $description[] = @stripslashes(strip_tags($rss->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue));
                    } elseif (@$rss->item($i)->getElementsByTagName('summary')->length) {
                        $description[] = @stripslashes(strip_tags($rss->item($i)->getElementsByTagName('summary')->item(0)->childNodes->item(0)->nodeValue));
                    }
                    $i++;
                }

                return array(
                    'rss_title' => $rss_title,
                    'rss_description' => $rss_description,
                    'title' => $title,
                    'url' => $url,
                    'description' => $description,
                    'show' => $pri
                );

            } else {

                $rss = $xmlDoc->getElementsByTagName('item');

                if ($rss) {

                    if (!$rss_title) {
                        $parse = parse_url($url);
                        $rss_title = $parse['host'];
                    }

                    $title = [];
                    $url = [];
                    $pri = [];
                    $description = [];
                    $i = 0;
                    foreach ($rss as $item) {
                        $title[] = stripslashes(strip_tags($rss->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue));
                        $url[] = strip_tags($rss->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue);
                        $pri[] = get_instance()->ecl('Feeds')->single($item,$xmlDoc,$rss->item($i));
                        if (@$rss->item($i)->getElementsByTagName('content')->length) {
                            $description[] = @stripslashes(strip_tags($rss->item($i)->getElementsByTagName('content')->item(0)->childNodes->item(0)->nodeValue));
                        } elseif (@$rss->item($i)->getElementsByTagName('encoded')->length) {
                            $description[] = @stripslashes(strip_tags($rss->item($i)->getElementsByTagName('encoded')->item(0)->childNodes->item(0)->nodeValue));
                        } elseif (@$rss->item($i)->getElementsByTagName('description')->length) {
                            $description[] = @stripslashes(strip_tags($rss->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue));
                        } elseif (@$rss->item($i)->getElementsByTagName('summary')->length) {
                            $description[] = @stripslashes(strip_tags($rss->item($i)->getElementsByTagName('summary')->item(0)->childNodes->item(0)->nodeValue));
                        }
                        $i++;
                    }

                    return array(
                        'rss_title' => $rss_title,
                        'rss_description' => $rss_description,
                        'title' => $title,
                        'url' => $url,
                        'description' => $description,
                        'show' => $pri
                    );

                }

            }

        }
        
    }
    
}

if (!function_exists('get_feed_net')) {
    function get_feed_net($data) {
        if($data) {
            $bt = [];
            foreach($data as $name => $account) {
                $accounts = json_decode($account);
                if(is_numeric($accounts)) {
                    $bt[] = $accounts;
                } else {
                    foreach ($accounts as $acc) {
                        $bt[] = (INT)$acc;
                    }
                }
            }
            return $bt;
        }
    }
}
if (!function_exists('show_post_stats')) {
    function show_post_stats($data) {
        $CI = get_instance();
        // Load Networks Model
        $CI->load->model('networks');
        if($data) {
            $arr = [];
            $res = [];
            if($data[0]->networks) {
                $edre = json_decode($data[0]->networks,true);
                foreach ($edre as $soci) {
                    if($soci) {
                        $icon = '';
                        $cont = ucfirst(str_replace('"','',$soci[1]));
                        $forico = ucfirst(str_replace('"','',$soci[0]));
                        if(!@$arr[$forico]) {
                            require_once APPPATH . 'interfaces/Autopost.php';
                            // Check if the network exists in autopost
                            if (file_exists(APPPATH . 'autopost/' . $forico . '.php')) {
                                // Now we need to get the key
                                require_once APPPATH . 'autopost/' . $forico . '.php';
                                $get = new $forico;
                                $info = $get->get_info();
                                $color = $info->color;
                                if(preg_match('/color/i', $info->icon)) {
                                    $icon = str_replace('#ffffff',$color,$info->icon);
                                } else {
                                    $icon = str_replace('><',' style="color:' . $color . '"><',$info->icon);
                                }
                                $arr[$forico] = $icon;
                            }
                        } else {
                            $icon = $arr[$forico];
                        }
                        if(is_numeric($cont)) {
                            $re = $CI->networks->get_account($cont);
                            if ( @$re[0]->user_name ) {
                                $res[] = array($icon,$re[0]->user_name,$soci[2]);
                            }
                        }
                    }
                }
                echo json_encode($res);
            }
        }
    }
}