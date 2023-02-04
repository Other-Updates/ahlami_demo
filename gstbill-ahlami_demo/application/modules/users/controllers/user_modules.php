<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_modules extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in())
            redirect($this->config->item('base_url') . 'users/login');
        $main_module = 'users';
        $access_arr = array(
            'user_modules/index' => array('add', 'edit', 'delete', 'view'),
            'user_modules/add' => array('add'),
            'user_modules/edit' => array('edit'),
            'user_modules/delete' => array('delete'),
            'user_modules/is_user_module_name_available' => array('add', 'edit'),
            'user_modules/get_user_sections_by_module_id' => 'no_restriction',
            'user_modules/insert_all_user_modules' => 'no_restriction'
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('users/user_module_model');
        $this->template->write_view('session_msg', 'users/session_msg');
    }

    public function index() {
        $data = array();
        $data['title'] = 'User Modules - Manage User Modules';
        $data['user_modules'] = $this->user_module_model->get_all_user_modules();
        $this->template->write_view('content', 'users/user_modules', $data);
        $this->template->render();
    }

    public function add() {
        $data = array();
        $data['title'] = 'User Modules - Add New User Module';
        if ($this->input->post('user_module')) {
            $user_module = $this->input->post('user_module');
            $user_module['created_date'] = date('Y-m-d H:i:s');
            $insert = $this->user_module_model->insert_user_module($user_module);
            $this->session->set_flashdata('flashSuccess', 'New User Module successfully added!');
            redirect($this->config->item('base_url') . 'users/user_modules');
        }
        $this->template->write_view('content', 'users/add_user_module', $data);
        $this->template->render();
    }

    public function edit($id) {
        $data = array();
        $data['title'] = 'User Modules - Edit User Modules';
        if ($this->input->post('user_module')) {
            $user_module = $this->input->post('user_module');
            $user_module['updated_date'] = date('Y-m-d H:i:s');
            $update = $this->user_module_model->update_user_module($user_module, $id);
            $this->session->set_flashdata('flashSuccess', 'User Module successfully updated!');
            redirect($this->config->item('base_url') . 'users/user_modules');
        }
        $data['user_module'] = $this->user_module_model->get_user_module_by_id($id);
        //echo '<pre>'; print_r($data); exit;
        $this->template->write_view('content', 'users/edit_user_module', $data);
        $this->template->render();
    }

    public function delete($id) {
        $delete = $this->user_module_model->delete_user_module($id);
        if ($delete) {
            $this->session->set_flashdata('flashSuccess', 'User Module successfully deleted!');
            echo '1';
        } else {
            $this->session->set_flashdata('flashError', 'Opeation Failed!');
            echo '0';
        }
    }

    function is_user_module_name_available() {
        $user_module_name = $this->input->post('user_module_name');
        $id = $this->input->post('module_id');
        $result = $this->user_module_model->is_user_module_name_available($user_module_name, $id);
        if (!empty($result[0]['id'])) {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    function insert_all_user_modules() {
        $this->user_module_model->insert_all_user_modules();
    }

}

/* End of file user_modules.php */
/* Location: ./application/modules/users/controllers/user_modules.php */