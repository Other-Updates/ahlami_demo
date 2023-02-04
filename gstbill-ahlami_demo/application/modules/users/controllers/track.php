<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Track extends MX_Controller {

    function __construct() {
        parent::__construct();

        $main_module = 'users';
        $access_arr = array (
        'track/search_family' => 'no_restriction'
        );

        $this->load->model('users/users_model');
        $this->template->write_view('session_msg', 'users/session_msg');
        date_default_timezone_set($this->timezone->timezone());
    }

    public function search_family() {
        $mobnum = $_POST['mobnum'];
        $data = $this->users_model->get_family($mobnum);
        echo json_encode($data);
    }

}
