<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_Types extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in())
            redirect($this->config->item('base_url') . 'users/login');
        $main_module = 'users';
        $access_arr = array(
            'user_types/index' => array('add', 'edit', 'delete', 'view'),
            'user_types/add' => array('add'),
            'user_types/edit' => array('edit'),
            'user_types/delete' => array('delete'),
            'user_types/view' => array('view'),
            'user_types/is_user_type_available' => array('add', 'edit')
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }

        $this->load->model('users/user_type_model');
        $this->load->model('users/user_section_model');
    }

    public function index() {
        $data = array();
        $data['title'] = 'User Types - Manage User Types';
        $data['user_types'] = $this->user_type_model->get_all_user_types();
        $this->template->write_view('content', 'users/user_types', $data);
        $this->template->render();
    }

    public function add() {
        $data = array();
        $data['title'] = 'User Types - Add New User Type';
        if ($this->input->post('user_type')) {
            $user_type = $this->input->post('user_type');
            $user_type['created_date'] = date('Y-m-d H:i:s');
            $insert = $this->user_type_model->insert_user_type($user_type);
            $this->session->set_flashdata('flashSuccess', 'User Type Added');
            redirect($this->config->item('base_url') . 'users/user_types');
        }
        $this->template->write_view('content', 'users/add_user_type', $data);
        $this->template->render();
    }

    public function edit($id) {
        $data = array();
        $data['title'] = 'User Types - Edit User Type';
        if ($this->input->post('user_type')) {
            $user_type = $this->input->post('user_type');
            $user_type['updated_date'] = date('Y-m-d H:i:s');
            $update = $this->user_type_model->update_user_type($user_type, $id);
            $this->session->set_flashdata('flashSuccess', 'User Type Updated');
            redirect($this->config->item('base_url') . 'users/user_types');
        }
        $data['user_type'] = $this->user_type_model->get_user_type_by_id($id);
        $this->template->write_view('content', 'users/edit_user_type', $data);
        $this->template->render();
    }

    function view($type) {
        $data = array();
        $data['title'] = 'User Types - Permissions';

        if ($this->input->post('permissions', TRUE)) {
            $permissions = $this->input->post('permissions');
            $grand_all = $this->input->post('grand_all');
            $grand_all = !empty($grand_all) ? $grand_all : 0;
            $user_type = array('grand_all' => $grand_all);
            $this->user_type_model->update_user_type($user_type, $type);
            if (!empty($permissions)) {
                $this->user_type_model->delete_user_permission_by_type($type);
                foreach ($permissions as $module_id => $sections) {
                    if (!empty($sections)) {
                        foreach ($sections as $section_id => $item) {
                            $permission_arr = array(
                                'user_type_id' => $type,
                                'module_id' => $module_id,
                                'section_id' => $section_id,
                                'acc_all' => !empty($item['acc_all']) ? 1 : 0,
                                'acc_view' => !empty($item['acc_view']) ? 1 : 0,
                                'acc_add' => !empty($item['acc_add']) ? 1 : 0,
                                'acc_edit' => !empty($item['acc_edit']) ? 1 : 0,
                                'acc_delete' => !empty($item['acc_delete']) ? 1 : 0,
                                'created_date' => date('Y-m-d H:i:s')
                            );
                            $this->user_type_model->insert_user_permission($permission_arr);
                        }
                    }
                }
            }
            $this->session->set_flashdata('flashSuccess', 'User Type Permission successfully updated!');
            redirect($this->config->item('base_url') . 'users/user_types');
        }

        $data['user_type_id'] = $type;
        $data['user_type'] = $this->user_type_model->get_user_type_by_id($type);
        $data['user_sections'] = $this->user_section_model->get_all_user_sections_with_modules();
        $user_permissions = $this->user_type_model->get_user_permissions_by_type($type);
        $user_permissions_arr = array();
        if (!empty($user_permissions)) {
            foreach ($user_permissions as $key => $value) {
                $user_permissions_arr[$value['module_id']][$value['section_id']] = array('acc_all' => $value['acc_all'], 'acc_view' => $value['acc_view'], 'acc_add' => $value['acc_add'], 'acc_edit' => $value['acc_edit'], 'acc_delete' => $value['acc_delete']);
            }
        }
        $data['user_permissions'] = $user_permissions_arr;
        $this->template->write_view('content', 'users/user_permissions', $data);
        $this->template->render();
    }

    function delete($id) {
        $id = $this->input->post('id');

        $data = array('is_deleted' => 1);
        $delete = $this->user_type_model->delete_user_type($id);

        if ($delete == 1) {
            $this->session->set_flashdata('flashSuccess', 'Street successfully deleted!');
            echo '1';
        } else {
            $this->session->set_flashdata('flashError', 'Operation Failed!');
            echo '0';
        }
    }

    function is_user_type_available() {
        $user_type_name = $this->input->post('user_type_name');
        $id = $this->input->post('id');
        $result = $this->user_type_model->is_user_type_available($user_type_name, $id);
        if (!empty($result[0]['id'])) {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

}
