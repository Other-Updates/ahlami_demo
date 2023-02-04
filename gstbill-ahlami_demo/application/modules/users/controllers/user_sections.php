<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_sections extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'users/login');
        }
        $main_module = 'users';
        $access_arr = array(
            'user_sections/index' => array('add', 'edit', 'delete', 'view'),
            'user_sections/add' => array('add'),
            'user_sections/edit' => array('edit'),
            'user_sections/delete' => array('delete'),
            'user_sections/is_user_section_name_available' => array('add', 'edit'),
            'user_sections/get_user_sections_by_module_id' => 'no_restriction',
            'user_sections/insert_all_user_sections' => 'no_restriction'
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }

        $this->load->model('users/user_module_model');
        $this->load->model('users/user_section_model');
        $this->template->write_view('session_msg', 'users/session_msg');
    }

    function index() {
        $data = array();
        $data['title'] = 'Masters - Manage User Sections';
        $data['user_sections'] = $this->user_section_model->get_all_user_sections_with_module_name();
        $this->template->write_view('content', 'users/user_sections', $data);
        $this->template->render();
    }

    function add() {
        $data = array();
        $data['title'] = 'Masters - Add New User Section';

        if ($this->input->post('user_section', TRUE)) {
            $user_section = $this->input->post('user_section');
            $actions = $this->input->post('actions');
            $user_section['acc_view'] = !empty($actions['acc_view']) ? 1 : 0;
            $user_section['acc_add'] = !empty($actions['acc_add']) ? 1 : 0;
            $user_section['acc_edit'] = !empty($actions['acc_edit']) ? 1 : 0;
            $user_section['acc_delete'] = !empty($actions['acc_delete']) ? 1 : 0;
            $user_section['created_date'] = date('Y-m-d H:i:s');
            $insert = $this->user_section_model->insert_user_section($user_section);

            $this->session->set_flashdata('flashSuccess', 'New User Section successfully added!');
            redirect($this->config->item('base_url') . 'users/user_sections');
        }
        $data['user_modules'] = $this->user_module_model->get_all_user_modules();
        $this->template->write_view('content', 'users/add_user_section', $data);
        $this->template->render();
    }

    function edit($id) {
        $data = array();
        $data['title'] = 'Masters - Edit User Section';

        if ($this->input->post('user_section', TRUE)) {
            $user_section = $this->input->post('user_section');
            $actions = $this->input->post('actions');
            $user_section['acc_view'] = !empty($actions['acc_view']) ? 1 : 0;
            $user_section['acc_add'] = !empty($actions['acc_add']) ? 1 : 0;
            $user_section['acc_edit'] = !empty($actions['acc_edit']) ? 1 : 0;
            $user_section['acc_delete'] = !empty($actions['acc_delete']) ? 1 : 0;
            $user_section['created_date'] = date('Y-m-d H:i:s');
            $user_section['updated_date'] = date('Y-m-d H:i:s');
            $update = $this->user_section_model->update_user_section($user_section, $id);

            $this->session->set_flashdata('flashSuccess', 'User Section successfully updated!');
            redirect($this->config->item('base_url') . 'users/user_sections');
        }
        $data['user_section'] = $this->user_section_model->get_user_section_by_id($id);
        $data['user_modules'] = $this->user_module_model->get_all_user_modules();
        $this->template->write_view('content', 'users/edit_user_section', $data);
        $this->template->render();
    }

    function delete($id) {
        $delete = $this->user_section_model->delete_user_section($id);
        if ($delete) {
            $this->session->set_flashdata('flashSuccess', 'User Section successfully deleted!');
            echo '1';
        } else {
            $this->session->set_flashdata('flashError', 'Operation Failed!');
            echo '0';
        }
    }

    function is_user_section_name_available() {
        $user_section_name = $this->input->post('user_section_name');
        $id = $this->input->post('section_id');
        $result = $this->user_section_model->is_user_section_name_available($user_section_name, $id);
        if (!empty($result[0]['id'])) {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    public function get_user_sections_by_module_id($id) {
        $sections = $this->user_section_model->get_user_sections_by_module_id($id);
        echo json_encode($sections);
    }

    function insert_all_user_sections() {
        $this->user_section_model->insert_all_user_sections();
    }

}
