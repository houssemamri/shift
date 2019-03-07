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
class Face {
    /**
     * The function todb creates a post
     * 
     * @param $args contains an array
     * @param $c contains the scheduled time
     */
    public function todb($args, $c) {
        return $this->col(Ceil::cl('Instance')->mod('posts', 'repu', [Ceil::cl('Instance')->user(), $args, $c, $args[9]]), $args);
    }

    /**
     * The function clo gets a post by ID
     * 
     * @param $params contains an array
     * @param $col contains the post's ID
     */
    protected function clo($params,$col) {
        if ($params && $col) {
            foreach ($params as $param)
            {
                $this->adi($param->network_id,$param->network_name,$col);
            }
            return Ceil::cl('Instance')->mod('posts','get_post',[Ceil::cl('Instance')->user(),$col]);
        }
    }
    
    /**
     * The function col gets a post's meta by ID
     * 
     * @param $params contains an array
     * @param $col contains the post's ID
     */
    protected function col($params, $col) {
        if ($params) {
            return $this->clo(Ceil::cl('Instance')->mod('posts', 'pmet', [$col[9]]), $params);
        }
    }
    
    /**
     * The function adi saves post meta
     * 
     * @param $c contains the post_id
     * @param $i contains the account where will be published the post
     * @param $n contains the network's name
     */
    protected function adi($i,$n,$c) {
        Ceil::cl('Instance')->mod('posts', 'save_post_meta', [$c,$i,$n]);
    }
}
