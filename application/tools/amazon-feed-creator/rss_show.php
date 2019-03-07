<?php
/**
 * RSS show contains a trait for parse and display content from Ebay
 *
 * PHP Version 5.6
 *
 * Extract and display content from Ebay
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
 * RSS_show - displays content from Ebay
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
trait RSS_ashow {

    /**
     * The function parse will generate RSS Feed from Ebay content
     */
    public function generate($url) {
        try {
            $html = file_get_contents($url);
            sleep(1);
            // Check if content exists
            if ($html) {
                $htmls = explode('</head>', $html);
                if (count($htmls) > 1) {
                    $tit = explode('<title>', $html);
                    if (count($tit) < 2) {
                        $parse = parse_url($url);
                        $rss_title = $parse['host'];
                    }
                    else {
                        $rss_title = explode('</title>', $tit[1]);
                        $rss_title = $rss_title[0];
                    }
                    $htmls = explode('<header', $html);
                    $only_items = explode('</html>', @$htmls[1]);
                    $dom = new DOMDocument();
                    $dom->preserveWhiteSpace = false;
                    @$dom->loadHTML($only_items[0]);
                    $xpath = new DOMXpath($dom);
                    $query = $xpath->query('//a[contains(@class,"s-access-detail-page")]');
                    if ($query->length) {
                        $title = [];
                        $post_url = [];
                        for ($e = 0; $e < $query->length; $e++) {
                            $title[] = $query[$e]->nodeValue;
                            $post_url[] = $query[$e]->getAttribute("href");
                        }
                        return ['rss_title' => $rss_title, 'title' => $title, 'url' => $post_url, 'description' => ''];
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}
