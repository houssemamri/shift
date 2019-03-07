<?php
class Feeds{
    private $uri;
    public function single($a,$b,$c) {
        return $this->tre($a,$b,$c);
    }
    private function tre($a,$b,$c) {
        if(preg_match('/media:thumbnail/i',$b->saveHtml($a))) {
            return $this->tris($a,$b);            
        } else if(preg_match('/media:content/i',$b->saveHtml($a))) {
            return $this->puo($a,$b);
        } else if(@$c->getElementsByTagName('image')->item(0)) {
            @$this->vrap($c->getElementsByTagName('image')->item(0)->childNodes->item(0)->nodeValue);
            return $this->uri;
        } else if(preg_match('/enclosure url/i',$b->saveHtml($a))) {
            $vist = explode('<enclosure url="',$b->saveHtml($a));
            $pad = explode('"', $vist[1]);
            return $pad[0];  
        } else {
            return FALSE;
        }
        exit();
    }
    private function puo($a,$b) {
        $per = explode('<media:content url="',$b->saveHtml($a));
        return $this->sle($per);
    }
    private function sle($a) {
        if(@$a[1]) {
            $a = explode('"',$a[1]);
            return $a[0];
        } else {
            return FALSE;
        }
    }
    private function vrap($a) {
        if($a) {
            $this->uri = $a;
        } else {
            $this->uri = '';
        }
    }
    private function tris($a,$b) {
        $per = explode('<media:thumbnail url="',$b->saveHtml($a));
        return $this->sle($per);
    }
}