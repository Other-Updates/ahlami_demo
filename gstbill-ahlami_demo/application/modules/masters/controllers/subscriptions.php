<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subscriptions extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in())
            redirect($this->config->item('base_url') . 'users/login');
        $main_module = 'masters';
        $access_arr = array(
            'subscriptions/index' => array('add', 'edit', 'delete'),
            'subscriptions/add' => array('add'),
            'subscriptions/edit' => array('edit'),
            'subscriptions/delete' => array('delete'),
            'subscriptions/is_subscriptions_available' => array('add', 'edit')
        );
        $data = $this->user_auth->is_permission_allowed($access_arr, $main_module);
        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }

        $this->load->model('masters/subscriptions_model');
    }

    public function index() {
        $data = array();
        $data['title'] = 'Subscriptions - Manage Subscriptions';
        $data['subscriptions'] = $this->subscriptions_model->get_all_subscriptions();
        $this->template->write_view('content', 'masters/list_subscriptions', $data);
        $this->template->render();
    }

    public function add() {
        $data = array();
        $data['title'] = 'Subscriptions - Add New Subscriptions';
        if ($this->input->post('subscriptions')) {
            $subscriptions = $this->input->post('subscriptions');
            $subscriptions['created_at']=date('Y-m-d H:i:s');
            $insert = $this->subscriptions_model->insert_subscriptions($subscriptions);
            $this->session->set_flashdata('flashSuccess', 'Subscriptions Added');
            redirect($this->config->item('base_url') . 'masters/subscriptions');
        }
        $this->template->write_view('content', 'masters/add_subscriptions', $data);
        $this->template->render();
    }

    public function edit($id) {
        $data = array();
        $data['title'] = 'Subscriptions - Edit Subscriptions';
        if ($this->input->post('subscriptions')) {
            $subscriptions = $this->input->post('subscriptions');
            $subscriptions['updated_at']=date('Y-m-d H:i:s');
            $update = $this->subscriptions_model->update_subscriptions($subscriptions, $id);
            $this->session->set_flashdata('flashSuccess', 'Subscriptions Updated');
            redirect($this->config->item('base_url') . 'masters/subscriptions');
        }
        $data['subscriptions'] = $this->subscriptions_model->get_subscriptions_by_id($id);
        $this->template->write_view('content', 'masters/edit_subscriptions', $data);
        $this->template->render();
    }

    function delete($id) {
        $id = $this->input->post('id');

        $data = array('is_deleted' => 1);
        $delete = $this->subscriptions_model->update_subscriptions($data,$id);

        if ($delete == 1) {
            $this->session->set_flashdata('flashSuccess', 'Subscriptions successfully deleted!');
            echo 1;exit;
        } else {
            $this->session->set_flashdata('flashError', 'Operation Failed!');
            exit;
        }
    }

}
