<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Streets extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'users/login');
        }
        $main_module = 'masters';
        $access_arr = array (
        'streets/index' => array ('add', 'edit', 'delete', 'view'),
        'streets/add' => array ('add'),
        'streets/edit' => array ('edit'),
        'streets/delete' => array ('delete'),
        'streets/is_street_name_available' => array ('add', 'edit')
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }

        $this->load->model('masters/street_model');
        $this->template->write_view('session_msg', 'users/session_msg');
        date_default_timezone_set($this->timezone->timezone());
    }

    function index() {
        $data = array ();
        $data['title'] = 'Masters - Manage Streets';
        $data['streets'] = $this->street_model->get_all_streets();
        $this->template->write_view('content', 'masters/index', $data);
        $this->template->render();
    }

    function add() {
        $data = array ();
        $data['title'] = 'Masters - Add New Street';

        if ($this->input->post('street', TRUE)) {
            $street = $this->input->post('street');

            $street['created_date'] = date('Y-m-d H:i:s');
            $insert = $this->street_model->insert_street($street);

            $this->session->set_flashdata('flashSuccess', 'New Street successfully added!');
            redirect($this->config->item('base_url') . 'masters/streets');
        }
        $this->template->write_view('content', 'masters/add_street', $data);
        $this->template->render();
    }

    function edit($id) {
        $data = array ();
        $data['title'] = 'Masters - Edit Street';

        if ($this->input->post('street', TRUE)) {
            $street = $this->input->post('street');
            $street['updated_date'] = date('Y-m-d H:i:s');
            $update = $this->street_model->update_street($street, $id);
            $this->session->set_flashdata('flashSuccess', 'Street successfully updated!');
            redirect($this->config->item('base_url') . 'masters/streets');
        }
        $data['street'] = $this->street_model->get_street_by_id($id);

        $this->template->write_view('content', 'masters/edit_street', $data);
        $this->template->render();
    }

    function delete($id = '') {
        $id = $this->input->post('id');
        $data = array ('is_deleted' => 1);
        $delete = $this->street_model->delete_street($id);

        if ($delete == 1) {
            $this->session->set_flashdata('flashSuccess', 'Street successfully deleted!');
            echo '1';
        } else {
            $this->session->set_flashdata('flashError', 'Operation Failed!');
            echo '0';
        }
    }

    function is_street_name_available() {
        $street_name = $this->input->post('street_name');
        $id = $this->input->post('id');

        $city = $this->input->post('city');
        $result = $this->street_model->is_street_name_available($street_name, $id, $city);
        if (!empty($result[0]['id'])) {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

}
