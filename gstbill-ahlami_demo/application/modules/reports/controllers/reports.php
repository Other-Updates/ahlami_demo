<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in())
            redirect($this->config->item('base_url') . 'users/login');
        $main_module = 'reports';
        $access_arr = array(
            'reports/invoice_report' => array('view'),
            'reports/invoice_ajaxList' => 'no_restriction',
            'reports/customer_feedback_report' => array('view'),
            'reports/customer_feedback_ajaxlist'  => 'no_restriction',
            'reports/transaction_report' => array('view'),
            'reports/transaction_report_ajaxlist'  => 'no_restriction',
            'reports/wallet_report' =>  array('view'),
            'reports/wallet_report_ajaxlist'  => 'no_restriction',
        );
        $data = $this->user_auth->is_permission_allowed($access_arr, $main_module);
        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('reports/report_model');
        $this->load->model('masters/customers_model');
    }

    function invoice_report() {
        $data=array();
        $data['customers'] = $this->customers_model->get_all_customers();
        $this->template->write_view('content', 'reports/invoice_report', $data);
        $this->template->render();
    }

    function invoice_ajaxList() {
        $output = array();
        $output_data = array();
        $input_data = $this->input->post();
        $search_data['from_date']=$input_data['from_date'];
        $search_data['to_date']=$input_data['to_date'];
        $search_data['customer_id']=$input_data['customer_id'];
        $invoice_data = $this->report_model->get_all_invoice_report($search_data);
        if (!empty($invoice_data)) {
            $i=1;
            foreach ($invoice_data as $list) {
                $output_data[] = array($i,$list['trip_number'],$list['invoice_number'],$list['serial_number'],$list['name'],date('d/m/Y H:i',strtotime($list['ride_start'])),date('d/m/Y H:i',strtotime($list['ride_end'])),number_format($list['ride_distance'],2),number_format($list['total_ride_amt'],2),number_format($list['unlock_charge'],2),number_format($list['sub_total'],2),number_format($list['vat_charge'],2),number_format($list['grand_total'],2));
                $i++;
            }
        }
        $output['draw'] = $input_data['draw'];
        $output['recordsTotal'] = $this->report_model->count_filtered_invoice($search_data);
        $output['recordsFiltered'] = $this->report_model->count_filtered_invoice($search_data);
        $output['data'] = $output_data;
        echo json_encode($output);
        die;
    }


    function customer_feedback_report() {
        $data=array();
        $data['customers'] = $this->customers_model->get_all_customers();
        $this->template->write_view('content', 'reports/customer_feedback_report', $data);
        $this->template->render();
    }

    function customer_feedback_ajaxlist() {
        $output = array();
        $output_data = array();
        $input_data = $this->input->post();
        $search_data['from_date']=$input_data['from_date'];
        $search_data['to_date']=$input_data['to_date'];
        $search_data['customer_id']=$input_data['customer_id'];
        $feedback_data = $this->report_model->get_all_feedback_report($search_data);
        if (!empty($feedback_data)) {
            $i=1;
            foreach ($feedback_data as $list) {
                $output_data[] = array($i,$list['trip_number'],$list['serial_number'],$list['name'],$list['feedback']." - ".$list['ratings'] );
                $i++;
            }
        }
        $output['draw'] = $input_data['draw'];
        $output['recordsTotal'] = $this->report_model->count_filtered_feedback($search_data);
        $output['recordsFiltered'] = $this->report_model->count_filtered_feedback($search_data);
        $output['data'] = $output_data;
        echo json_encode($output);
        die;
    }

    function transaction_report() {
        $data=array();
        $data['customers'] = $this->customers_model->get_all_customers();
        $this->template->write_view('content', 'reports/transaction_report', $data);
        $this->template->render();
    }

    function transaction_report_ajaxlist() {
        $output = array();
        $output_data = array();
        $input_data = $this->input->post();
        $search_data['from_date']=$input_data['from_date'];
        $search_data['to_date']=$input_data['to_date'];
        $search_data['customer_id']=$input_data['customer_id'];
        $search_data['payment_method_type']=$input_data['payment_method_type'];
        $payment_report = $this->report_model->get_all_transaction_report($search_data);
        if (!empty($payment_report)) {
            $i=1;
            foreach ($payment_report as $list) {
                $output_data[] = array(
                $i,
                $list['customer_name'],
                $list['trip_number'],
                $list['serial_number'],
                $list['source'],
                $list['payment_method_name'],
                number_format($list['amount'],2),
                date('d/m/Y',strtotime($list['created_date']))
            );
                $i++;
            }
        }
        $output['draw'] = $input_data['draw'];
        $output['recordsTotal'] = $this->report_model->count_filtered_transaction($search_data);
        $output['recordsFiltered'] = $this->report_model->count_filtered_transaction($search_data);
        $output['data'] = $output_data;
        echo json_encode($output);
        die;
    }

    function wallet_report() {
        $data=array();
        $data['customers'] = $this->customers_model->get_all_customers();
        $this->template->write_view('content', 'reports/wallet_report', $data);
        $this->template->render();
    }

    function wallet_report_ajaxlist() {
        $output = array();
        $output_data = array();
        $input_data = $this->input->post();
        $search_data['from_date']=$input_data['from_date'];
        $search_data['to_date']=$input_data['to_date'];
        $search_data['customer_id']=$input_data['customer_id'];
        $search_data['payment_type']=$input_data['payment_type'];
        $payment_report = $this->report_model->get_all_wallet_report($search_data);
        if (!empty($payment_report)) {
            $i=1;
            foreach ($payment_report as $list) {
                $output_data[] = array(
                $i,
                $list['customer_name'],
                $list['type'],
                ($list['type'] == 'Credit') ? number_format($list['amount'],2) : -(number_format($list['amount'],2)),
                date('d/m/Y',strtotime($list['created_date']))
            );
                $i++;
            }
        }
        $output['draw'] = $input_data['draw'];
        $output['recordsTotal'] = $this->report_model->count_filtered_wallet($search_data);
        $output['recordsFiltered'] = $this->report_model->count_filtered_wallet($search_data);
        $output['data'] = $output_data;
        echo json_encode($output);
        die;
    }

}
