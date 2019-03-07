<?php
/**
 * Guide Model
 *
 * PHP Version 5.6
 *
 * Guide file contains the Guide Model
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
if ( !defined('BASEPATH') ) {
    
    exit('No direct script access allowed');
    
}

/**
 * Guide class - operates the guide table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Guide extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'guides';

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();
        
        $tables = $this->db->table_exists('guides');
        
        if (!$tables) {
            $this->db->query('CREATE TABLE `guides` (
              `guide_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
              `title` varchar(250) NOT NULL,
              `short` varchar(250) NOT NULL,
              `body` text NOT NULL,
              `cover` text NOT NULL,
              `created` varchar(30) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');
        }
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
    }
    
    /**
     * The public method save_guide saves a guide
     *
     * @param string $title contains the guide's title
     * @param string $short contains the guide's short description
     * @param string $body contains the guide's body
     * @param integer $guide contains the guide's ID
     * 
     * @return boolean true or false
     */
    public function save_guide( $title, $short, $body, $guide ) {
        
        $cover = get_option( 'guide-cover' );
        
        if ( $guide ) {
            
            $data = [
                'title' => $title,
                'body' => $body,
                'short' => $short
                ];
            
            if ( $cover ) {

                $data['cover'] = $cover;

            }
            
            $this->db->where('guide_id', $guide);
            $this->db->update($this->table, $data);
            
        } else {
            
            // Set data to save
            $data = [
                'title' => $title,
                'short' => $short,
                'body' => $body,
                'created' => time()
                ];
            
            if ( $cover ) {

                $data['cover'] = $cover;

            }

            // Insert data
            $this->db->insert($this->table, $data);
            
        }
        
        // Verify if the data was inserted
        if ( $this->db->affected_rows() ) {
            
            delete_option( 'guide-cover' );
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_guides gets all available guides
     * 
     * @return object with guides or false
     */
    public function get_guides() {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('guide_id', 'desc');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            // Return results
            return $query->result();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_guide gets a guide
     * 
     * @param integer $guide_id contains the guide_id
     * 
     * @return object with guide or false
     */
    public function get_guide($guide_id) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['guide_id' => $guide_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            // Return results
            return $query->result();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_guide deletes a guide
     * 
     * @param integer $guide_id contains the guide_id
     * 
     * @return object with guide or false
     */
    public function delete_guide($guide_id) {
        
        $this->db->where('guide_id', $guide_id);
        $this->db->delete($this->table);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }    
    
}

/* End of file Guide.php */
