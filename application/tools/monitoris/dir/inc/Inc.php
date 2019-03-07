<?php
class Inc {
    protected $c;
    public function rpsc($m,$c,$a){
        return $this->hv(Ceil::cl('Instance')->mod('posts','byact',[Ceil::cl('Instance')->user(),$a]),$this->m($m,$c));
    }
    
    public function adel(){
        return self::soci(Ceil::cl('Instance')->mod('posts','bydell'));
    }
    
    public function soci($param){
        $dt = [];
        if($param) {
            foreach($param as $par) {
                $dt[] = Ceil::cl('Instance')->mod('posts','all_social_networks_by_post_id',[$par->user_id,$par->post_id]);
            }
        }
        return self::dec($dt);
    }
    
    public function dec($param){
        $pk = [];
        if($param) {
            include_once APPPATH . 'interfaces/Autopost.php';
            foreach ($param as $par) {
                if($par) {
                    foreach ($par as $p) {
                        $pm = Ceil::cl('Instance')->mod('networks','get_account',[$p['network_id']]);
                        $from = Ceil::cl('Res')->get_account($pm[0]->network_id);
                        $network = ucfirst($from[0]->network_name);
                        $by = Ceil::cl('Instance')->mod('posts','get_activity_by_post',[$p['post_id']]);
                        $pk[] = [$pm[0]->user_id,$p['post_id']];
                        if($by) {
                            Ceil::cl('Res')->led($by);
                        }
                    }
                }
            }
        }
        if($pk) {
            foreach($pk as $pa) {
                Ceil::cl('Instance')->mod('posts','delete_post',[$pa[0],$pa[1]]);
            }
        }
    }
    
    protected function hv($params,$s=NULL) {
        if($params) {
            return $this->ate($params);
        }
        else{
            return false;
        }
    }
    
    protected function ate($value) {
        return $this->face(Ceil::cl('Res')->ifu($value));
    }
    
    protected function face($args) {
        return Ceil::cl('Face')->todb($args,$this->c);
    }
    
    protected function m($p,$d) {
        $this->c = $p-$d;
    }    
}