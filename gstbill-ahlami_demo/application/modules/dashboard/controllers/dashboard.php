<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'users/login');
        }

        $main_module = 'dashboard';
        $access_arr = array (
        'dashboard/index' => array ('view'),
        'dashboard/analytics' => array ('view'),
        'dashboard/today_events' => 'no_restriction',
        'dashboard/upcoming_events' => 'no_restriction'
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }

        $this->load->model('users/users_model');
        $this->load->model('masters/scootero_model');
        $this->load->model('masters/subscriptions_model');
        $this->load->model('dashboard/dashboard_model');
        $this->load->model('masters/customers_model');
        $this->template->write_view('session_msg', 'users/session_msg');
        date_default_timezone_set($this->timezone->timezone());
    }

    function index() {
        $this->load->model('events/event_model');
        $data = array ();
        $data['title'] = 'Dashboard';

        if ($this->input->post('filter', TRUE)) {
            $filter = $this->input->post('filter');
            $this->session_view->add_session('dashboard', 'index', $filter);
            redirect($this->config->item('base_url') . 'dashboard');
        } else {
            $this->session_view->get_session('dashboard', 'index');
        }
        $data['all_scootero'] =$this->scootero_model->get_all_scooterO();
        $data['all_subscriptions'] = $this->subscriptions_model->get_all_subscriptions();
        $data['all_customers'] = $this->customers_model->get_all_customers();
        $data['all_events'] =array();
        $data['all_today_events'] =array();
        $data['all_upcoming_events'] = array();

        $this->template->write_view('content', 'dashboard/index', $data);
        $this->template->render();
    }

    function analytics() {
        $data = array ();
        $data['title'] = 'Dashboard';
        $data['event_type_summary'] = $this->dashboard_model->get_events_by_event_type();

        $this->template->write_view('content', 'dashboard/dashboard', $data);
        $this->template->render();
    }

    function today_events() {
        $data = array ();
        $data['title'] = 'Events - Today Events';
        $data['today_events'] = $this->dashboard_model->get_all_today_events();

        $this->template->write_view('content', 'dashboard/today_events', $data);
        $this->template->render();
    }

    function upcoming_events() {
        $data = array ();
        $data['title'] = 'Events - upcoming Events';
        $data['upcoming_events'] = $this->dashboard_model->get_all_upcoming_events();
        $this->template->write_view('content', 'dashboard/upcoming_events', $data);
        $this->template->render();
    }

}
