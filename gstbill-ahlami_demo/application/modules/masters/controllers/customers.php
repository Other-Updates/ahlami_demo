<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customers extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in())
            redirect($this->config->item('base_url') . 'users/login');
        $main_module = 'masters';
        $access_arr = array(
            'customers/index' => array('view'),
            'customers/edit' => array('edit'),
            'customers/delete' => array('delete'),
        );
        $data = $this->user_auth->is_permission_allowed($access_arr, $main_module);
        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }

        $this->load->model('masters/customers_model');
    }

    public function index() {
        $data = array();
        $data['title'] = 'Customers - Manage Customers';
        $data['customers'] = $this->customers_model->get_all_customers();
        $this->template->write_view('content', 'masters/list_customers', $data);
        $this->template->render();
    }

    public function edit($id) {
        $data = array();
        $data['title'] = 'Customers - Edit Customer';
        if ($this->input->post('customer')) {
            $customer = $this->input->post('customer');
            $customer['dob']=($customer['dob'] != '') ? date('Y-m-d',strtotime($customer['dob'])) : '';
            $customer['updated_at']=date('Y-m-d H:i:s');
            $update = $this->customers_model->update_customer($customer, $id);
            $this->session->set_flashdata('flashSuccess', 'Customer Updated');
            redirect($this->config->item('base_url') . 'masters/customers');
        }
        $data['customer'] = $this->customers_model->get_customer_by_id($id);
        $this->template->write_view('content', 'masters/edit_customer', $data);
        $this->template->render();
    }

    function delete($id) {
        $id = $this->input->post('id');

        $data = array('is_deleted' => 1);
        $delete = $this->customers_model->update_customer($data,$id);

        if ($delete == 1) {
            $this->session->set_flashdata('flashSuccess', 'Customer successfully deleted!');
            echo 1;exit;
        } else {
            $this->session->set_flashdata('flashError', 'Operation Failed!');
            exit;
        }
    }

}
