<?php
/**
 * Functions
 *
 * PHP Version 5.6
 *
 * In this file is used to process the ajax requests
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
/**
 * Get Word's synonyms if exists
 */
if (get_instance()->input->get('action', TRUE) == 'get-synonyms') {
    $page = get_instance()->input->get('res', TRUE);
    if(is_numeric($page) == TRUE) {
        $res = get_instance()->ecl('Deco')->lits($page);
        if($res) {
            echo json_encode($res);
        } else {
            echo json_encode(2);
        }
    }
}

/**
 * Delete a Word's synonym
 */
if (get_instance()->input->get('action', TRUE) == 'delete-synonym') {
    $synonym = get_instance()->input->get('synonym', TRUE);
    $cid = get_instance()->input->get('res', TRUE);
    $res = get_instance()->ecl('Deco')->lits($cid);
    if($res) {
        if(get_instance()->ecl('Deco')->coli($synonym,$res)) {
            $new = [];
            foreach($res as $syn) {
                if($syn != $synonym) {
                    $new[] = $syn;
                }
            }
            if(get_instance()->ecl('Instance')->mod('dictionary', 'save_synonym', [get_instance()->ecl('Instance')->user(),$cid, get_instance()->ecl('Deco')->sezo($new)])) {
                $res = get_instance()->ecl('Deco')->lits($cid);
                if($res) {
                    echo json_encode($res);
                } else {
                    echo json_encode(2);
                }
            } else {
                echo json_encode(2);
            }
        } else {
            echo json_encode(2);
        }
    } else {
        echo json_encode(2);
    }
}

/**
 * Add a new word
 */
if (get_instance()->input->get('action', TRUE) == 'add-new-word') {
    if ($this->input->post()) {
        $this->form_validation->set_rules('word', 'Word', 'trim|required');
        // Get data
        $word = strtolower($this->input->post('word'));
        if ($this->form_validation->run()) {
            if(get_instance()->ecl('Instance')->mod('dictionary', 'save_word', [get_instance()->ecl('Instance')->user(),$word])) {
                echo json_encode(1);
            } else {
                echo json_encode(2);
            }
        }
    }
}

function geli($a,$b,$c) {
    echo json_encode(get_instance()->ecl('Deco')->lofi($a,$b,$c));
}
/**
 * Add a new synonym
 */
if (get_instance()->input->get('action', TRUE) == 'add-new-synonym') {
    if ($this->input->post()) {
        $this->form_validation->set_rules('synonym', 'Synonym', 'trim|required');
        $this->form_validation->set_rules('cid', 'Current ID', 'trim|integer|required');
        // Get data
        $synonym = strtolower($this->input->post('synonym'));
        $cid = $this->input->post('cid');
        if ($this->form_validation->run()) {
            $res = get_instance()->ecl('Deco')->con($synonym,$cid);
            if($res) {
                echo json_encode($res);
            } else {
                echo json_encode(2);
            }
        }
    }
}

/**
 * Delete a word
 */
if (get_instance()->input->get('action', TRUE) == 'delete-word') {
    $word = get_instance()->input->get('word', TRUE);
    if(is_numeric($word)) {
        if(get_instance()->ecl('Instance')->mod('dictionary', 'delete_word', [get_instance()->ecl('Instance')->user(),$word])) {
            echo json_encode(1);
        } else {
            echo json_encode(2);
        }        
    }
}

/**
 * Get User's Words
 */
if (get_instance()->input->get('action', TRUE) == 'generate') {
    if ($this->input->post()) {
        $this->form_validation->set_rules('content', 'Content', 'trim|required');
        // Get data
        $content = $this->input->post('content');
        if ($this->form_validation->run()) {
            $cip = get_instance()->ecl('Deco')->cipis($content);
            geli($content,$cip[1],$cip[0]);
        }
    }
}

/**
 * Get Words
 */
if (get_instance()->input->get('action', TRUE) == 'get-words') {
    $page = get_instance()->input->get('page', TRUE);
    if(is_numeric($page)) {
        $limit = 10;
        $page--;
        $total = get_instance()->ecl('Instance')->mod('dictionary', 'get_words', [get_instance()->ecl('Instance')->user(),1]);
        $getres = get_instance()->ecl('Instance')->mod('dictionary', 'get_words', [get_instance()->ecl('Instance')->user(),$page * $limit,$limit]);
        if ($getres) {
            $data = ['total' => $total, 'words' => $getres];
            echo json_encode($data);
        }       
    }
}