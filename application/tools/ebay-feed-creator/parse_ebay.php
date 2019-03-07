<?php
/**
 * Parse Ebay contains a trait for parse content from Ebay
 *
 * PHP Version 5.6
 *
 * Extract and save content from Ebay
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
 * Parse_ebay - allows to copy content from Ebay
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
trait Parse_ebay {

    /**
     * The function parse will parse content from Ebay
     */
    public function parse($url) {
        // First the script gets the html content
        try {
            $html = get($url);
            // Check if content exists
            if ($html) {
                $htmls = explode('<w-root id="w1-1">', $html);
                if (count($htmls) > 1) {
                    $tit = explode('<title>',$html);
                    $title = explode('</title>',@$tit[1]);
                    $only_items = explode('PaginationAndExpansionsContainer', @$htmls[1]);
                    $dom = new DOMDocument();
                    $dom->preserveWhiteSpace = false;
                    @$dom->loadHTML($only_items[0]);
                    $xpath = new DOMXpath($dom);
                    $query = $xpath->query('//h3[contains(@class,"lvtitle")]/a');
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
