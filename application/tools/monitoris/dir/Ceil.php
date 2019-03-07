<?php
/**
 * Ceil
 *
 * PHP Version 5.6
 *
 * The File Ceil manage all Midrub functions
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

/**
 * Ceil - loads the Monitoris's methods
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Ceil {

    protected static $dirs = [
        FCPATH . 'application/tools/monitoris/dir/sets/',
        FCPATH . 'application/tools/monitoris/dir/inc/',
        FCPATH . 'application/tools/monitoris/dir/general/'
    ];

    /**
     * The function all gets all activities
     * 
     * @param $page contains the page's number
     * @param $net contains the network's ID
     */
    public static function all($page = NULL, $net = NULL) {
        return self::single(self::cl('Instance')->mod('posts', 'get_activity', [self::cl('Instance')->user(), $page, $net])) . self::cl('Views')->pages(self::cl('Instance')->mod('posts', 'get_activity', [self::cl('Instance')->user(), $page, $net, 1]), $page, $net);
    }

    /**
     * The function netu loads a random activity
     */
    public static function netu() {
        self::checku(self::resu(self::cl('Instance')->mod('posts', 'load_an_activity')));
    }

    /**
     * The function liku loads a random activity
     */
    public static function liku() {
        return self::checku(self::kes(self::cl('Instance')->mod('posts', 'load_an_activity')));
    }

    /**
     * The function single loads a single activity
     * 
     * @param $param contains the activity's ID
     */
    public static function single($param) {
        return self::cl('Sets')->show() . self::cl('Views')->single($param);
    }
    
    /**
     * The function load_single loads an activity
     * 
     * @param $param contains the activity's ID
     * @return string with post content
     */
    public static function load_single($param) {
        $de = self::cl('Instance')->mod('posts', 'get_single_activity', [self::cl('Instance')->user(),$param]);
        if($de) {
            return self::single($de);
        } else {
            return false;
        }
    }
    
    /**
     * The function apublish gets posts which must be deleted
     */
    public static function apublish() {
        return self::cl('Inc')->adel();
    }

    /**
     * The function resu gets aleator activities
     * 
     * $param contains an object
     */
    public static function resu($param) {
        return self::cl('Res')->aleator($param);
    }

    /**
     * The function resu gets aleator activities
     * 
     * $param contains an object
     */
    public static function kes($param) {
        return self::cl('Res')->likes($param);
    }

    /**
     * The function com publishes a comment
     * 
     * @param $msg contains the comment
     * @param $post contains the post's ID
     * @param $account contains the network ID
     * @param $act contains the activity's ID
     */
    public static function com($msg, $post, $account, $act) {
        $com = self::cl('Res')->com($msg, $post, $account, $act);
        if ($com) {
            if (self::checku($com)) {
                return self::cl('Views')->gcoms($com);
            }
        }
    }

    /**
     * The function dcom deletes a comment
     * 
     * @param $comment contains the comment's ID
     * @param $account contains the network's account ID
     * @param $act contains the activity's ID
     */
    public static function dcom($comment, $account, $act) {
        $com = self::cl('Res')->dcom($comment, $account, $act);
        return self::cl('Views')->gcoms($act);
    }

    /**
     * The function rep will schedule a post
     * 
     * @param $msg contains the scheduled time
     * @param $cd contains the current time
     * @param $act contains the activity's id
     */
    public static function rep($msg, $cd, $act) {
        return self::cl('Inc')->rpsc($msg, $cd, $act);
    }

    /**
     * The function seen mark an activity as seen
     *
     * @param $act contains the activity's ID
     */
    public static function seen($param) {
        return self::cl('Res')->seen(self::cl('Instance')->user(), $param);
    }

    /**
     * The function file checks if a file exists and get it
     *
     * @param $file contains the file name
     */
    public static function file($file) {
        self::check($file);
    }

    /**
     * The function check_del check if some post must be deleted
     */
    public static function delu() {
        return self::cl('Res')->led(self::cl('Instance')->mod('posts', 'activity_del'));
    }

    /**
     * The function cl checks if a class exists and get it
     *
     * @param $name contains the class name
     */
    public static function cl($name) {
        self::check($name);
        return new $name;
    }

    /**
     * The function schedu schedules the posts
     * 
     * @param $id contains the post's ID
     * @param $time contains the scheduled time
     */
    public static function schedu($id, $time) {
        return self::cl('Instance')->mod('posts', 'sched_again', [self::cl('Instance')->user(), $id, $time]);
    }

    /**
     * The function checku checks for new likes and comments
     *
     * @param $params contains an object
     */
    public static function checku($params) {
        if ($params) {
            if (@$params[0][0][1] == 'like') {
                for ($r = 0; $r < count($params); $r++) {
                    if (@$params[$r]) {
                        foreach ($params[$r] as $arg) {
                            self::cl('Instance')->mod('posts', 'insert_meta', [@$arg[0], @$arg[1], @$arg[2], @$arg[3], @$arg[4], @$arg[5], @$arg[6], (@$arg[7]) ? @$arg[7] : '']);
                        }
                    }
                }
            }
            if (@$params[0][0][1] == 'comment') {
                for ($r = 0; $r < count($params); $r++) {
                    if (@$params[$r]) {
                        foreach ($params[$r] as $arg) {
                            self::cl('Instance')->mod('posts', 'insert_meta', [@$arg[0], @$arg[1], @$arg[2], @$arg[3], @$arg[4], @$arg[5], @$arg[6], (@$arg[7]) ? @$arg[7] : '']);
                        }
                    }
                }
            }
            if (is_numeric(@$params[0][0])) {
                foreach ($params as $arg) {
                    self::cl('Instance')->mod('posts', 'insert_meta', [@$arg[0], @$arg[1], @$arg[2], @$arg[3], @$arg[4], @$arg[5], @$arg[6], (@$arg[7]) ? @$arg[7] : '']);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * The function set_d allows you to schedule the deletion of a post
     * 
     * @param $msg contains the scheduled time
     * @param $cd contains the current time
     * @param $act contains the activity's ID
     */
    public static function set_d($msg, $cd, $act) {
        return self::cl('Instance')->mod('posts', 'insert_del', [$act, self::cl('Res')->tim($msg, $cd)]);
    }

    /**
     * The function check checks files by name
     *
     * @param $params contains the file name or class name
     */
    public static function check($name) {
        foreach (self::$dirs as $directory) {
            foreach (glob($directory . '*.php') as $file) {
                if ($file == $directory . $name . '.php') {
                    require_once $file;
                }
            }
        }
    }
}
