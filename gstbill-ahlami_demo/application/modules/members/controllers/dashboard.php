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
        'dashboard/my_events' => 'no_restriction',
        'dashboard/today_events' => 'no_restriction',
        'dashboard/upcoming_events' => 'no_restriction',
        'dashboard/member_index' => 'no_restriction'
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url') . 'members/dashboard');
        }

        $this->load->model('users/users_model');
        $this->load->model('members/members_model');
        $this->load->model('members/dashboard_model');
        $this->template->set_master_template('../../themes/event/member_template.php');
        $this->template->write_view('session_msg', 'users/session_msg');
        date_default_timezone_set($this->timezone->timezone());
    }

    function index() {
        $this->load->model('events/event_model');
        $data = array ();
        $data['title'] = 'Dashboard';
        $member_id = $this->user_auth->get_user_id();

        if ($this->input->post('filter', TRUE)) {
            $filter = $this->input->post('filter');
            $this->session_view->add_session('dashboard', 'index', $filter);
            redirect($this->config->item('base_url') . 'dashboard');
        } else {
            $this->session_view->get_session('dashboard', 'index');
        }
        $data['my_events'] = $this->dashboard_model->get_my_events($member_id);
        $data['today_events'] = $this->dashboard_model->get_today_events($member_id);
        $data['upcoming_events'] = $this->dashboard_model->get_upcoming_events($member_id);
//        echo '<pre>';
//        print_r($data['upcoming_events']);
//        exit;


        $data['all_events'] = $this->dashboard_model->get_all_events($member_id);

        $this->template->write_view('content', 'members/dashboard', $data);
        $this->template->render();
    }

    function analytics() {
        $data = array ();
        $data['title'] = 'Dashboard';
        $data['event_type_summary'] = $this->dashboard_model->get_events_by_event_type($member_id);

        $this->template->write_view('content', 'dashboard/dashboard', $data);
        $this->template->render();
    }

    function my_events() {
        $data = array ();
        $data['title'] = 'Events - My Events';
        $member_id = $this->user_auth->get_user_id();
        $data['my_events'] = $this->dashboard_model->get_my_events($member_id);

        $this->template->write_view('content', 'dashboard/my_events', $data);
        $this->template->render();
    }

    function today_events() {
        $data = array ();
        $data['title'] = 'Events - Today Events';
        $data['today_events'] = $this->dashboard_model->get_today_events($member_id);
        $this->template->write_view('content', 'dashboard/today_events', $data);
        $this->template->render();
    }

    function upcoming_events() {
        $data = array ();
        $data['title'] = 'Events - Upcoming Events';
        $data['upcoming_events'] = $this->dashboard_model->get_upcoming_events($member_id);
        $this->template->write_view('content', 'dashboard/upcoming_events', $data);
        $this->template->render();
    }

    function member_index($username) {
        $data = array ();
        $data['title'] = 'Members - Manage Members';
        $family = $this->members_model->get_user_family_id($username);
        $data['members'] = $this->members_model->get_all_members_by_family($family);

        $this->template->write_view('content', 'members/member_index', $data);
        $this->template->render();
    }

}
