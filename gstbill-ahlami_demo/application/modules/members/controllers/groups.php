<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Groups extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!in_array($this->router->method, array ('get_street_by_city_name'))) {
            if (!$this->user_auth->is_logged_in())
                redirect($this->config->item('base_url') . 'users/login');
        }

        $main_module = 'members';
        $access_arr = array (
        'groups/index' => array ('add', 'edit', 'delete', 'view'),
        'groups/add' => array ('add'),
        'groups/edit' => array ('edit'),
        'groups/delete' => array ('delete'),
        'groups/view' => array ('view'),
        'groups/is_group_name_available' => array ('add', 'edit'),
        'groups/get_street_by_city_name' => 'no_restriction',
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('members/group_model');
        $this->template->write_view('session_msg', 'users/session_msg');
        date_default_timezone_set($this->timezone->timezone());
    }

    public function index() {
        $data = array ();
        $data['title'] = 'Members - Manage Groups';
        $data['groups'] = $this->group_model->get_all_groups();

        $this->template->write_view('content', 'members/groups', $data);
        $this->template->render();
    }

    public function add($city) {
        $data = array ();
        $data['title'] = 'Manage Groups - Add New Group';
        if ($this->input->post('group')) {
            $group = $this->input->post('group');

            $group['created_date'] = date('Y-m-d H:i:s');
            $insert_id = $this->group_model->insert_group($group);
            if ($insert_id) {
                $this->session->set_flashdata('flashSuccess', 'New Group successfully added!');
                redirect($this->config->item('base_url') . 'members/groups');
            } else {
                $this->session->set_flashdata('flashError', 'Group not added! Please try again.');
                redirect($this->config->item('base_url') . 'members/groups');
            }
        }
        $this->template->write_view('content', 'members/add_group', $data);
        $this->template->render();
    }

    public function edit($id) {
        $data = array ();
        $data['title'] = 'Members - Edit Group';
        if ($this->input->post('group')) {
            $group = $this->input->post('group');
            $group['updated_date'] = date('Y-m-d H:i:s');
            $update = $this->group_model->update_group($group, $id);
            if ($update) {
                $this->session->set_flashdata('flashSuccess', 'Group successfully updated!');
                redirect($this->config->item('base_url') . 'members/groups');
            } else {
                $this->session->set_flashdata('flashError', 'Group not updated! Please try again.');
                redirect($this->config->item('base_url') . 'members/groups');
            }
        }
        $data['group'] = $this->group_model->get_group_by_id($id);

        $data['streets'] = $this->group_model->get_street_by_city($data['group'][0]['city']);
        $this->template->write_view('content', 'members/edit_group', $data);
        $this->template->render();
    }

    function delete($id) {
        $id = $this->input->post('id');
        $delete = $this->group_model->delete_group($id);
        if ($delete == 1) {
            $this->session->set_flashdata('flashSuccess', 'Group successfully deleted!');
            echo '1';
        } else {
            $this->session->set_flashdata('flashError', 'Operation Failed!');
            echo '0';
        }
    }

    function is_group_name_available() {
        $group_name = $this->input->post('group_name');
        $id = $this->input->post('id');
        $result = $this->group_model->is_group_name_available($group_name, $id);
        if (!empty($result[0]['id'])) {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    function get_street_by_city_name($city) {
        $street = $this->group_model->get_street_by_city($city);
        if ($street != 0) {
            echo json_encode($street);
        }
    }

}
