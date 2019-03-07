<?php
/**
 * Parse Amazon contains a trait for parse content from Amazon
 *
 * PHP Version 5.6
 *
 * Extract and save content from Amazon
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
 * Parse_amazon - allows to copy content from Amazon
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
trait Parse_amazon {

    /**
     * The function parse will parse content from Amazon
     */
    public function parse($url) {
        // First the script gets the html content
        try {
            $html = file_get_contents($url);
            // Check if content exists
            if ($html) {
                $htmls = explode('</head>', $html);
                if (count($htmls) > 1) {
                    $tit = explode('<title>',$html);
                    $title = explode('</title>',@$tit[1]);
                    $htmls = explode('<header', $html);
                    $only_items = explode('</html>', @$htmls[1]);
                    $dom = new DOMDocument();
                    $dom->preserveWhiteSpace = false;
                    @$dom->loadHTML($only_items[0]);
                    $xpath = new DOMXpath($dom);
                    $query = $xpath->query('//a[contains(@class,"s-access-detail-page")]');
                    if ($query->length) {
                        $feed = '';
                        for ($e = 0; $e < $query->length; $e++) {
                            $feed .= '<li>'
                                        . '<div class="single-rss-post">'
                                            . '<h3>'
                                                . $query[$e]->nodeValue
                                            . '</h3>'
                                            . '<p>'
                                                . '<a href="' . $query[$e]->getAttribute('href') . '" target="_blank">'
                                                    . $query[$e]->getAttribute('href')
                                                . '</a>'
                                            . '</p>'
                                        . '</div>'
                                    . '</li>';
                        }
                        return ['title' => $title[0], 'feed' => $feed];
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
