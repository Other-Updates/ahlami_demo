<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Increment_model extends CI_Model {

    private $increment_table = 'zim_increment';
    private $prefix_list = array (
    'user_code' => 'USER',
    );

    function __construct() {
        date_default_timezone_set('Asia/Kuwait');
        parent::__construct();
//        $this->load->model('masters/shop_model');
    }

    function get_increment_id($type) {
        $prefix = '';
        $prefix = date('y') . '/' . date('m');
        $this->db->where('type', $type);
        $this->db->where('prefix', $prefix);
        $query = $this->db->get($this->increment_table);
        if ($query->num_rows() == 0) {
            $this->insert_increment_id($type);
            $result = $this->get_new_increment_id($type);
        } else {
            $result = $query->result_array();
        }
        $entry_number = '';
        $entry_number = $result['0']['code'] . '/' . $result['0']['prefix'] . '-' . $result['0']['last_increment_id'];
        return $entry_number;
    }

    function get_new_increment_id($type) {
        $prefix = '';
        $prefix = date('y') . '/' . date('m');
        $this->db->where('type', $type);
        $this->db->where('prefix', $prefix);
        $new_query = $this->db->get($this->increment_table);
        $new_result = $new_query->result_array();
        return $new_result;
    }

    function insert_increment_id($type) {
        $data = array ();
        $data['prefix'] = '';
        $data['prefix'] = date('y') . '/' . date('m');
        $data['type'] = $type;
        $data['code'] = $this->prefix_list[$type];
        //echo '<pre>'; print_r($this->prefix_list[$type]); exit;
        $data['last_increment_id'] = '001';
        if ($this->db->insert($this->increment_table, $data)) {
            $data['id'] = $this->db->insert_id();
            return $data;
        }
        return false;
    }

    function update_increment_id($type) {
        $prefix = '';
        $prefix = date('y') . '/' . date('m');
        $last_id = $this->get_increment_id($type);
        $inc_arr = explode('-', $last_id);
        $str = $inc_arr[1];
        $str = $str + 1;
        $str = sprintf('%1$03d', $str);
        $data = array ();
        $data['last_increment_id'] = $str;
        $this->db->where('type', $type);
        $this->db->where('prefix', $prefix);
        if ($this->db->update($this->increment_table, $data)) {
            return true;
        }
        return false;
    }

    function get_increment_code($type) {
        $this->db->where('type', $type);
        $query = $this->db->get($this->increment_table);
        if ($query->num_rows() == 0) {
            $this->insert_increment_code($type);
            $result = $this->get_new_increment_code($type);
        } else {
            $result = $query->result_array();
        }
        $entry_number = '';
        $increment_id = str_pad($result['0']['last_increment_id'], 4, '0', STR_PAD_LEFT);
        $entry_number = $result['0']['code'] . '-' . $increment_id;
        return $entry_number;
    }

    function get_new_increment_code($type) {
        $this->db->where('type', $type);
        $query = $this->db->get($this->increment_table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_last_increment_code_id($type) {
        $this->db->where('type', $type);
        $query = $this->db->get($this->increment_table);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result['0']['last_increment_id'];
        }
        return FALSE;
    }

    function insert_increment_code($type) {
        $data = array ();
        $data['type'] = $type;
        $data['code'] = $this->prefix_list[$type];
        $data['last_increment_id'] = 1;
        $this->db->where('type', $type);
        if ($this->db->insert($this->increment_table, $data)) {
            return true;
        }
        return false;
    }

    function update_increment_code($type) {
        $last_id = $this->get_last_increment_code_id($type);
        $data = array ();
        $data['last_increment_id'] = $last_id + 1;
        $this->db->where('type', $type);
        if ($this->db->update($this->increment_table, $data)) {
            return true;
        }
        return false;
    }

}
