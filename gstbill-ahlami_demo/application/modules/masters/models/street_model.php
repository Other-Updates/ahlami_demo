<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Street_model extends CI_Model {

    private $table_name = 'eve_streets';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insert_street($data) {
        if ($this->db->insert($this->table_name, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return FALSE;
    }

    function update_street($data, $id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function delete_street($id) {
        $this->db->where('id', $id);
        if ($this->db->delete($this->table_name)) {
            return 1;
        }
        return 0;
    }

    function get_street_by_id($id) {
        $this->db->select($this->table_name . '.*');
        $this->db->where($this->table_name . '.id', $id);
        $this->db->where($this->table_name . '.is_deleted', 0);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_all_streets() {
        $this->db->select($this->table_name . '.*');
        $this->db->order_by('id', DESC);
        $this->db->where($this->table_name . '.is_deleted', 0);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_streets_by_city_name($city) {
        $this->db->select('tab_1.*');
        $this->db->order_by('tab_1.street_name', 'ASC');
        $this->db->where('tab_1.city', $city);
        $this->db->where('tab_1.is_deleted', 0);
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function is_street_name_available($street_name, $id = NULL, $city) {
        $this->db->select($this->table_name . '.id');
        $this->db->where('LCASE(street_name)', strtolower($street_name));
        $this->db->where($this->table_name . '.is_deleted', 0);
        if (!empty($id))
            $this->db->where('id !=', $id);
        $this->db->where('city', $city);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

}
