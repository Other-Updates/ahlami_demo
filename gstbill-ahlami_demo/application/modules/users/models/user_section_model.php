<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_section_model extends CI_Model {

    private $table_name = 'scoo_user_sections';
    private $module_table = 'scoo_user_modules';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insert_user_section($data) {
        if ($this->db->insert($this->table_name, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return FALSE;
    }

    function update_user_section($data, $id) {
        $data['updated_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function delete_user_section($id, $data) {
        if ($this->db->delete($this->table_name, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function get_user_section_by_id($id) {
        $this->db->select($this->table_name . '.*');
        $this->db->where($this->table_name . '.id', $id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_user_sections_by_module_id($id) {
        $this->db->select('tab_1.id,tab_1.user_section_name,,tab_1.user_section_key,acc_view,acc_add,acc_edit,acc_delete');
        $this->db->join($this->module_table . ' AS tab_2', 'tab_2.id = tab_1.module_id', 'LEFT');
        $this->db->where('tab_1.module_id', $id);
        $this->db->where('tab_1.status', 1);
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_all_user_sections() {
        $this->db->select($this->table_name . '.*');
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_all_user_sections_with_module_name() {
        $this->db->select('tab_1.id,tab_1.user_section_name,tab_1.module_id,tab_1.status,tab_2.user_module_name');
        $this->db->join($this->module_table . ' AS tab_2', 'tab_2.id = tab_1.module_id', 'LEFT');
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_all_user_sections_with_modules() {
        $this->db->select($this->module_table . '.*');
        $query = $this->db->get($this->module_table);
        $modules = $query->result_array();
        $user_section_arr = array();
        if (!empty($modules)) {
            foreach ($modules as $module) {
                $sections = $this->get_user_sections_by_module_id($module['id']);
                $user_section_arr[$module['id']] = $module;
                $user_section_arr[$module['id']]['sections'] = $sections;
            }
        }
        return $user_section_arr;
    }

    function is_user_section_name_available($user_section_name, $id = NULL) {
        $this->db->select($this->table_name . '.id');
        $this->db->where('LCASE(user_section_name)', strtolower($user_section_name));
        if (!empty($id))
            $this->db->where('id !=', $id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function insert_all_user_sections() {
        $this->delete_all_user_sections();

        $module_array = array(
            array(
                'module_id' => 1,
                'user_section_name' => 'Dashboard',
                'user_section_key' => 'dashboard',
                'acc_view' => 1,
                'acc_add' => 0,
                'acc_edit' => 0,
                'acc_delete' => 0
            ),
            array(
                'module_id' => 2,
                'user_section_name' => 'Manage Streets',
                'user_section_key' => 'streets',
                'acc_view' => 1,
                'acc_add' => 1,
                'acc_edit' => 1,
                'acc_delete' => 1
            ),
            array(
                'module_id' => 3,
                'user_section_name' => 'Manage Users',
                'user_section_key' => 'users',
                'acc_view' => 1,
                'acc_add' => 1,
                'acc_edit' => 1,
                'acc_delete' => 1
            ),
            array(
                'module_id' => 3,
                'user_section_name' => 'Manage User Types',
                'user_section_key' => 'user_types',
                'acc_view' => 1,
                'acc_add' => 1,
                'acc_edit' => 1,
                'acc_delete' => 1
            ),
            array(
                'module_id' => 3,
                'user_section_name' => 'Manage User Modules',
                'user_section_key' => 'user_modules',
                'acc_view' => 1,
                'acc_add' => 1,
                'acc_edit' => 1,
                'acc_delete' => 1
            ),
            array(
                'module_id' => 3,
                'user_section_name' => 'Manage User Sections',
                'user_section_key' => 'user_sections',
                'acc_view' => 1,
                'acc_add' => 1,
                'acc_edit' => 1,
                'acc_delete' => 1
            ),
            array(
                'module_id' => 4,
                'user_section_name' => 'Manage Members',
                'user_section_key' => 'members',
                'acc_view' => 1,
                'acc_add' => 1,
                'acc_edit' => 1,
                'acc_delete' => 1
            ),
            array(
                'module_id' => 4,
                'user_section_name' => 'Manage Groups',
                'user_section_key' => 'groups',
                'acc_view' => 1,
                'acc_add' => 1,
                'acc_edit' => 1,
                'acc_delete' => 1
            ),
            array(
                'module_id' => 5,
                'user_section_name' => 'Manage Events',
                'user_section_key' => 'events',
                'acc_view' => 1,
                'acc_add' => 1,
                'acc_edit' => 1,
                'acc_delete' => 1
            ),
            array(
                'module_id' => 5,
                'user_section_name' => 'Manage Event Types',
                'user_section_key' => 'event_types',
                'acc_view' => 1,
                'acc_add' => 1,
                'acc_edit' => 1,
                'acc_delete' => 1
            ),
            array(
                'module_id' => 6,
                'user_section_name' => 'Manage Contacts',
                'user_section_key' => 'contacts',
                'acc_view' => 1,
                'acc_add' => 1,
                'acc_edit' => 1,
                'acc_delete' => 1
            ),
            array(
                'module_id' => 6,
                'user_section_name' => 'Manage Pricing and Plans',
                'user_section_key' => 'pricing',
                'acc_view' => 1,
                'acc_add' => 1,
                'acc_edit' => 1,
                'acc_delete' => 1
            )
        );
        if (!empty($module_array)) {
            foreach ($module_array as $list) {
                $insert = $this->db->insert($this->table_name, $list);
            }
        }
        return FALSE;
    }

    function delete_all_user_sections() {
        $SQL = 'TRUNCATE TABLE scoo_user_sections';
        if ($this->db->query($SQL)) {
            return TRUE;
        }
        return FALSE;
    }

}
