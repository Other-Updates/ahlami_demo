<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Group_model extends CI_Model {

    private $table_name = 'eve_groups';
    private $street_table = 'eve_streets';
    private $member_table = 'eve_members';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insert_group($data) {
        if ($this->db->insert($this->table_name, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return FALSE;
    }

    function update_group($data, $id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function delete_group($id) {
        $this->db->where('id', $id);
        if ($this->db->delete($this->table_name)) {
            return TRUE;
        }
        return FALSE;
    }

    function get_group_by_id($id) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.id', $id);

        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_street_by_city($city) {
        $this->db->select('*');
        $this->db->where('city', $city);
        $query = $this->db->get('eve_streets');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }

    function get_all_groups() {
        $this->db->select('tab_1.*,eve_streets.street_name');
        $this->db->join('eve_streets', 'eve_streets.id=tab_1.street_id');
        $this->db->order_by('id', DESC);
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_family_by_mobile_number($mobile_number) {
        $this->db->select('tab_1.*,tab_2.group_name');
        $this->db->join($this->table_name . ' AS tab_2', 'tab_2.id= tab_1.family_id');
        $this->db->where('tab_1.mobile_number', $mobile_number);
        $query = $this->db->get($this->member_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result;
        }
        return FALSE;
    }

    function get_family_types_by_street_id($street_id) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.street_id', $street_id);
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    function is_group_name_available($group_name, $id = NULL) {
        $this->db->select('tab_1.id');
        $this->db->where('LCASE(tab_1.group_name)', strtolower($group_name));
        if (!empty($id))
            $this->db->where('tab_1.id != ', $id);
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

}
