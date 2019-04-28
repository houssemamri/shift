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

	public function update_settings($id, $user_id, $data_value){
		$data = $data_value;
		$this->db->where(['user_id' => $user_id, 'id' => $id ]);
		$this->db->update($this->table, $data);
	}

	public function createSettingTable($userid){
		$qry = 'CREATE TABLE IF NOT EXISTS `'.$userid.'_product_category_mapping` (
			`opencart_category_id` INT PRIMARY KEY,
			`opencart_category_parent` INT,
			`magento_category_id` INT,
			`magento_category_parent` INT ) ENGINE=InnoDB DEFAULT CHARSET=latin1;';
		$query = $this->db->query($qry);
        return $query;
	}

	public function createProductMappingTable($userid){
		$qry = 'CREATE TABLE IF NOT EXISTS `'.$userid.'_product_mapping` (
			`opencart_product_id` INT PRIMARY KEY,
			`magento_product_id` INT
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;';
		$query = $this->db->query($qry);
        //return $query;
	}


	public function get_settings( $start, $limit, $order, $key = null, $user_id ) {

        $this->db->select('id,user_id,opencart_website_url,magento_website_url');
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

	public function get_migration_info($id){
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ( $query->num_rows() == 1 ) {
            $result = $query->row();
			return $result;
		}else{
			return false;
		}
	}
}
?>
