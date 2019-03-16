<?php
/**
 * Settings Model
 *
 * PHP Version 5.6
 *
 * Settings for the opencart, magento url 
 *
 * @package  Migration
 * @author   KC 
 */
if ( !defined('BASEPATH') ) {    
    exit('No direct script access allowed');    
}

class Settings_migration extends CI_MODEL {
	/**
     * Class variables
     */
    private $table = 'settings';
	
	/**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);        
    }
	
	/* Save settings */
	public function save_settings( $data ) {        
        // Save data
        $this->db->insert($this->table, $data);        
        // Verify if data was saved
        if ( $this->db->affected_rows() ) {            
            // Return inserted id
            return $this->db->insert_id();            
        } else {            
            return false;            
        }        
    }
	
	public function createSettingTable($userid){		
		$qry = 'CREATE TABLE IF NOT EXISTS `'.$userid.'_product_category_mapping` ( `product_category_mapping` varchar(255) NOT NULL, 
			`magento_category_parent` varchar(255) NOT NULL ) ENGINE=InnoDB DEFAULT CHARSET=latin1;';
		$query = $this->db->query($qry);
        return $query;
	}
	
	 public function get_settings( $start, $limit, $order, $key = null, $user_id ) {
        
        $this->db->select('user_id,opencart_websiteurl,magento_websiteurl');
        $this->db->from($this->table);
		$this->db->where('user_id', $user_id); 
        $key = $this->db->escape_like_str($key);
        
        
        // If $order is 1 will be redirected by last_access
        if ( $order ) {            
            $this->db->order_by('id', 'desc');            
        } else {            
            $this->db->order_by('datetime', 'desc');            
        }
        
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {            
            $result = $query->result();
            return $result;
            
        } else {            
            return false;            
        }        
    }
	
	public function count_all_settings( $key = null ,$user_id ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id); 
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {            
            return $query->num_rows();            
        } else {            
            return '0';            
        }        
    }
}
?>