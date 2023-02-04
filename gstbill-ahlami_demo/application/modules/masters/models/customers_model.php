<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customers_model extends CI_Model {

    private $table_name = 'scoo_customers';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_all_customers() {
        $this->db->select($this->table_name . '.*');
        $this->db->where('is_deleted',0);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function update_customer($data, $id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function get_customer_by_id($id) {
        $this->db->select($this->table_name . '.*');
        $this->db->where($this->table_name . '.id', $id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }


}
