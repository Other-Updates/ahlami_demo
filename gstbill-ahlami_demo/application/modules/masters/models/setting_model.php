<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Setting_model extends CI_Model {

    private $table_name = 'scoo_general_setting';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_all_setting() {
        $this->db->select($this->table_name . '.*');
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function update_setting($data, $id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data)) {
            return TRUE;
        }
        return FALSE;
    }

}
