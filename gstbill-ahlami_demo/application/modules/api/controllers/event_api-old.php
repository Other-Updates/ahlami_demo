<?php

if (!defined('BASEPATH'))
    echo 'No Direct Access Allowed';

Class Event_api extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('api/event_api_model');
        $this->load->model('api/increment_model');
        date_default_timezone_set($this->timezone->timezone());
    }

    function api_login() {
        //$json_input = '{"username":"kane","password":"123456"}';
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);

        if (!empty($input_data)) {
            if (!empty($input_data['password']) && !empty($input_data['username'])) {
                $username = $input_data['username'];
                $password = $input_data['password'];
                $member_data = $this->event_api_model->get_member_by_login($username, $password);
                if (!empty($member_data[0]['id'])) {
                    $output = array('status' => 'success', 'message' => 'Member Login successfull!', 'data' => $member_data);
                    echo json_encode($output);
                } else {
                    $output = array('status' => 'error', 'message' => 'Wrong Credentials');
                    echo json_encode($output);
                }
            } else {
                $output = array('status' => 'error', 'message' => 'Please Enter Valid Username and Password!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Please Enter Username and Password');
            echo json_encode($output);
        }
    }

    function api_edit_profile() {
        //$json_input = '{"member_id":"1"}';
        $json_input = file_get_contents('php://input'); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data['member_id'])) {
            $member_id = $input_data['member_id'];
            $member_data = array();
            $member_data = $this->event_api_model->get_member_by_id($member_id);
            if (!empty($member_data)) {
                $output = array('status' => 'success', 'message' => 'Edit Profile details!', 'member_data' => $member_data);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Edit Profile details not found!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_save_profile() {
        //$json_input = '{"member_id":"1","member_info":{"firstname":"David","lastname":"Warner","username":"david","password":"","email_address":"david@test.com","mobile_number":"9999999999","dob":"1991-10-25","gender":"male","status":"1","address_line_1":"Kalyalpattinam,Tamilnadu","address_line_2":"Coimbatore,Tamilnadu","on_kayalpattinam":"temporary","duration_from":"2018-12-01","duration_to":"2018-12-31","family_id":"1","street_id":"1","relation":"parent"}}';
        $json_input = file_get_contents('php://input'); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data['member_id'])) {
            $member_id = $input_data['member_id'];
            $update_data = $input_data['member_info'];
            if (!empty($update_data['password']) && trim($update_data['password']) != '') {
                $update_data['password'] = md5($update_data['password']);
            } else {
                unset($update_data['password']);
            }
            if ($update_data['on_kayalpattinam'] != 'temporary') {
                $dur_from_formatted = NULL;
                $dur_to_formatted = NULL;
            }
            $update_data['updated_date'] = date('Y-m-d H:i:s');
            $update = $this->event_api_model->update_member_by_id($update_data, $member_id);
            if ($update != 0) {
                $output = array('status' => 'success', 'message' => 'Memeber Profile successfully updated!');
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Memeber Profile not updated!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_save_profile_image() {
        //$json_input = '{"member_id":"1","member_profile_image_info":[{"file_name":"my_profile.png","image_data":"data:image/png;base64,iVBORw0KGgoAAAANSUhEErkJggg=="}]}';
        $json_input = file_get_contents('php://input'); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data['member_id'])) {
            $member_id = $input_data['member_id'];
            $member_profile_image_info = $input_data['member_profile_image_info'];

            $update_data = array();
            if (!empty($member_profile_image_info[0]['file_name']) && !empty($member_profile_image_info[0]['image_data'])) {
                $base_data = $member_profile_image_info[0]['image_data'];
                $file_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base_data));

                $random_hash = substr(str_shuffle(time()), 0, 3) . strrev(mt_rand(100000, 999999));
                $extension = pathinfo($member_profile_image_info[0]['file_name'], PATHINFO_EXTENSION);
                $file_name = 'MI_' . $random_hash . '.' . $extension;
                $upload_path = FCPATH . 'attachments/member_image';
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }
                $img_save_path = $upload_path . '/' . $file_name;
                $img_full_path = base_url() . 'attachments/member_image/' . $file_name;
                if (file_put_contents($img_save_path, $file_data) !== FALSE) {
                    $update_data['profile_image'] = $file_name;
                } else {
                    $update_data['profile_image'] = 'NULL';
                }
                $update_data['updated_date'] = date('Y-m-d H:i:s');
            }
            if (!empty($update_data)) {
                $update = $this->event_api_model->update_profile_image($update_data, $member_id);
                if ($update) {
                    $output = array('status' => 'success', 'message' => 'Memeber Profile Image successfully updated!');
                    echo json_encode($output);
                } else {
                    $output = array('status' => 'error', 'message' => 'Memeber Profile Image not updated!');
                    echo json_encode($output);
                }
            } else {
                $output = array('status' => 'error', 'message' => 'Memeber Profile Image not found!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_get_member_increment_id() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);

        $member_id = $this->increment_model->get_increment_code('member_code');
        if (!empty($member_id)) {
            $output = array('status' => 'success', 'message' => 'Memeber ID details!', 'member_id' => $member_id);
            echo json_encode($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Memeber ID details not found!');
            echo json_encode($output);
        }
    }

    function api_get_streets() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        $streets = $this->event_api_model->get_all_streets();
        if (!empty($streets)) {
            $output = array('status' => 'success', 'message' => 'Streets List!', 'streets' => $streets);
            echo json_encode($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Streets not found!');
            echo json_encode($output);
        }
    }

    function api_get_family_groups() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        $groups = $this->event_api_model->get_all_groups();
        if (!empty($groups)) {
            $output = array('status' => 'success', 'message' => 'Groups List!', 'groups' => $groups);
            echo json_encode($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Groups not found!');
            echo json_encode($output);
        }
    }

    function api_get_relations() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        $relations = array(
            0 => array('key' => 'parent', 'value' => 'Parent'),
            1 => array('key' => 'children', 'value' => 'Children'),
            2 => array('key' => 'siblings', 'value' => 'Siblings'),
            3 => array('key' => 'relatives', 'value' => 'Relatives'),
            4 => array('key' => 'others', 'value' => 'Others')
        );
        if (!empty($relations)) {
            $output = array('status' => 'success', 'message' => 'Relations List!', 'relations' => $relations);
            echo json_encode($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Relations not found!');
            echo json_encode($output);
        }
    }

    function api_get_streets_by_city_name() {
        //$json_input = '{"city":"1"}';
        $json_input = file_get_contents('php://input'); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data)) {
            $city = (!empty($input_data['city'])) ? $input_data['city'] : 0;
            if (!empty($city)) {
                $streets = $this->event_api_model->get_streets_by_city_name($city);
                if (!empty($streets)) {
                    $output = array('status' => 'success', 'message' => 'Street Details!', 'street_data' => $streets);
                    echo json_encode($output);
                } else {
                    $output = array('status' => 'error', 'message' => 'Street Details not found!');
                    echo json_encode($output);
                }
            } else {
                $output = array('status' => 'error', 'message' => 'Invalid data!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_get_family_type_by_street_id() {
        //$json_input = '{"street_id":"1"}';
        $json_input = file_get_contents('php://input'); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data)) {
            $street_id = (!empty($input_data['street_id'])) ? $input_data['street_id'] : 0;
            if (!empty($street_id)) {
                $family_types = $this->event_api_model->get_family_type_by_street_id($street_id);
                if (!empty($family_types)) {
                    $output = array('status' => 'success', 'message' => 'Family Type Details!', 'family_type_data' => $family_types);
                    echo json_encode($output);
                } else {
                    $output = array('status' => 'error', 'message' => 'Family Type Details not found!');
                    echo json_encode($output);
                }
            } else {
                $output = array('status' => 'error', 'message' => 'Invalid data!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_register_member() {
        //$json_input = '{"member_info":[{"firstname":"Mathew","lastname":"Hayden","username":"hayden","password":"1234","email_address":"hayden@test.com","mobile_number":"8940257645","dob":"1990-05-01","gender":"male","status":"1","address_line_1":"Kalyalpattinam,Tamilnadu","address_line_2":"Coimbatore,Tamilnadu","on_kayalpattinam":"temporary","duration_from":"2019-01-01","duration_to":"2019-01-21","family_id":"2","street_id":"2","relation":"parent"}]}';
        $json_input = file_get_contents('php://input'); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data)) {
            $member_data = (!empty($input_data['member_info'][0])) ? $input_data['member_info'][0] : array();
            if (!empty($member_data)) {
                $member_data['password'] = md5($member_data['password']);
                $member_data['member_id'] = $this->increment_model->get_increment_code('member_code');
                if ($member_data['on_kayalpattinam'] != 'temporary') {
                    $member_data['duration_from'] = NULL;
                    $member_data['duration_to'] = NULL;
                }
                $member_data['profile_image'] = 'NULL';

                $is_username_exists = $this->event_api_model->is_username_exists($member_data['username']);
                if ($is_username_exists) {
                    $output = array('status' => 'error', 'message' => 'Username already exists!');
                    echo json_encode($output);
                    exit;
                }

                $is_email_address_exists = $this->event_api_model->is_email_address_exists($member_data['email_address']);
                if ($is_email_address_exists) {
                    $output = array('status' => 'error', 'message' => 'Email Address already exists!');
                    echo json_encode($output);
                    exit;
                }

                if (!empty($member_data) && !$is_username_exists && !$is_email_address_exists) {
                    $insert_id = $this->event_api_model->insert_member($member_data);
                    if (!empty($insert_id)) {
                        $this->increment_model->update_increment_code('member_code');
                        $output = array('status' => 'success', 'message' => 'New Memeber successfully registered!');
                        echo json_encode($output);
                    } else {
                        $output = array('status' => 'error', 'message' => 'Memeber not registered!');
                        echo json_encode($output);
                    }
                } else {
                    $output = array('status' => 'error', 'message' => 'Memeber not registered!');
                    echo json_encode($output);
                }
            } else {
                $output = array('status' => 'error', 'message' => 'Invalid data!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_get_event_details_by_id() {
        //$json_input = '{"event_id":"1","member_id":"2"}';
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data['event_id'])) {
            $id = $input_data['event_id'];
            $member_id = $input_data['member_id'];
            $event_details = $this->event_api_model->get_event_details_by_id($id, $member_id);
            if (!empty($event_details)) {
                $output = array('status' => 'success', 'message' => 'Event Details!', 'event_details' => $event_details);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Event Details not found!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_get_event_invitations_by_id() {
        //$json_input = '{"event_id":"1"}';
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data['event_id'])) {
            $event_id = $input_data['event_id'];
            $event_invitations = $this->event_api_model->get_event_invitations_by_id($event_id);
            if (!empty($event_invitations)) {
                $output = array('status' => 'success', 'message' => 'Event Invitations List!', 'event_invitations' => $event_invitations);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Event Invitations not found!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_update_event_action() {
        //$json_input = '{"event_id":"1","member_id":"4","post_user_id":"10","family_id":"1","street_id":"1","status":"1","comments":""}';
        $json_input = file_get_contents('php://input'); // JSON Input
        $input_data = json_decode($json_input, TRUE);

        if (!empty($input_data['event_id'])) {
            $event_action = $input_data;
            $id = $event_action['member_id'];
            $event_id = $event_action['event_id'];
            $delete = $this->event_api_model->delete_view($id, $event_id);
            $insert_id = $this->event_api_model->insert_events_action($event_action);
            if (!empty($insert_id)) {
                if ($events_action['status'] == 1) {
                    $output = array('status' => 'success', 'message' => 'Event successfully accepted!');
                    echo json_encode($output);
                } else {
                    $output = array('status' => 'success', 'message' => 'Event successfully rejected!');
                    echo json_encode($output);
                }
            } else {
                $output = array('status' => 'error', 'message' => 'Event not updated!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_get_event_type_details() {
        //$json_input = '{"event_type_id":"1"}';
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data['event_type_id'])) {
            $id = $input_data['event_type_id'];
            $event_type_details = $this->event_api_model->api_get_event_type_details($id);
            if (!empty($event_type_details)) {
                $output = array('status' => 'success', 'message' => 'Event Type details!', 'event_type_details' => $event_type_details);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Event Type details not found!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_search_family() {
        //$json_input = '{"mobile_number":"9999999999"}';
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data['mobile_number'])) {
            $mobile_number = $input_data['mobile_number'];
            $family_details = $this->event_api_model->get_family($mobile_number);
            if (!empty($family_details)) {
                $output = array('status' => 'success', 'message' => 'Family Details!', 'family_details' => $family_details);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Family Details not found!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_get_all_event_types() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);

        $event_types = $this->event_api_model->get_all_event_types();
        if (!empty($event_types)) {
            $output = array('status' => 'success', 'message' => 'Event Types List!', 'event_types' => $event_types);
            echo json_encode($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Event Types not found!');
            echo json_encode($output);
        }
    }

    function api_get_all_event_types_list() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);

        $event_types = $this->event_api_model->get_all_event_types_list();
        if (!empty($event_types)) {
            $output = array('status' => 'success', 'message' => 'Event Types List!', 'event_types' => $event_types);
            echo json_encode($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Event Types not found!');
            echo json_encode($output);
        }
    }

    function api_get_members_tree_structure() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);

        $streets = $this->event_api_model->get_all_streets();
        $streets_list = array();
        if (!empty($streets)) {
            foreach ($streets as $list) {
                $streets_list[$list['id']] = $list;
            }
        }

        $groups = $this->event_api_model->get_all_groups();
        $groups_list = array();
        if (!empty($groups)) {
            foreach ($groups as $list) {
                $groups_list[$list['id']] = $list;
            }
        }

        $tree_structure = $this->event_api_model->get_all_members_tree_structure();
        $members_tree = (isset($tree_structure['all_members'])) ? $tree_structure['all_members'] : array();
        $members_section = (isset($tree_structure['members_section'])) ? $tree_structure['members_section'] : array();
        $members_count = (isset($tree_structure['members_count'])) ? $tree_structure['members_count'] : array();

        $tree_data = array(
            'members_tree' => $members_tree,
            'members_section' => $members_section,
            'members_count' => $members_count,
            'streets' => $streets,
            'groups' => $groups_list,
        );
        if (!empty($tree_data)) {
            $output = array('status' => 'success', 'message' => 'Members Tree Structure!', 'tree_data' => $tree_data);
            echo json_encode($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Members Tree Structure not found!');
            echo json_encode($output);
        }
    }

    function api_add_member_location() {
        //$json_input = '{"user_id":"1","latitude":"11.0283506","longitude":"76.9494668","location":"Coimbatore,Tamil Nadu"}';
        $json_input = file_get_contents('php://input'); // JSON Input
        $input_data = json_decode($json_input, TRUE);

        if (!empty($input_data['user_id'])) {
            $location_data = $input_data;
            $location_data['created_date'] = date('Y-m-d H:i:s');
            $id = $input_data['user_id'];
            if (!empty($location_data)) {
                $delete = $this->event_api_model->delete_member_location($id);
                $location_id = $this->event_api_model->insert_member_location($location_data);
                if (!empty($location_id)) {
                    $output = array('status' => 'success', 'message' => 'Member Location successfully inserted!');
                    echo json_encode($output);
                } else {
                    $output = array('status' => 'error', 'message' => 'Member Location not inserted!');
                    echo json_encode($output);
                }
            } else {
                $output = array('status' => 'error', 'message' => 'Member Location not inserted!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_today_events() {
        //$json_input = '{"member_id":"1"}';
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data['member_id'])) {
            $member_id = $input_data['member_id'];
            $today_events = $this->event_api_model->get_today_events($member_id);
            $today_events_count = (!empty($today_events)) ? count($today_events) : 0;
            if (!empty($today_events)) {
                $output = array('status' => 'success', 'message' => 'Today Events List!', 'today_events_count' => $today_events_count, 'today_events' => $today_events);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Today Events not found!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_upcoming_events() {
        //$json_input = '{"member_id":"1"}';
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data['member_id'])) {
            $member_id = $input_data['member_id'];
            $upcoming_events = $this->event_api_model->get_upcoming_events($member_id);
            $upcoming_events_count = (!empty($upcoming_events)) ? count($upcoming_events) : 0;
            if (!empty($today_events)) {
                $output = array('status' => 'success', 'message' => 'Upcoming Events List!', 'upcoming_events_count' => $upcoming_events_count, 'upcoming_events' => $upcoming_events);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Upcoming Events not found!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_past_events() {
        //$json_input = '{"member_id":"1"}';
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data['member_id'])) {
            $member_id = $input_data['member_id'];
            $past_events = $this->event_api_model->get_past_events($member_id);
            $past_events_count = (!empty($past_events)) ? count($past_events) : 0;
            if (!empty($today_events)) {
                $output = array('status' => 'success', 'message' => 'Past Events List!', 'past_events_count' => $past_events_count, 'past_events' => $past_events);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Past Events not found!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_all_events() {
        //$json_input = '{"member_id":"1"}';
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data['member_id'])) {
            $member_id = $input_data['member_id'];
            $check_event_nearby = $this->event_api_model->check_user_in_location($member_id);
            if ($check_event_nearby != '0') {
                $past_events = $this->event_api_model->get_past_events($member_id);
            } else {
                $past_events = '0';
            }
            if ($check_event_nearby != '0') {
                $upcoming_events = $this->event_api_model->get_upcoming_events($member_id);
            } else {
                $upcoming_events = '0';
            }
            $my_events = $this->event_api_model->get_my_events($member_id);

            if (!empty($my_events) || !empty($past_events) || !empty($upcoming_events)) {
                $past_events = array_values($past_events);
                $upcoming_events = array_values($upcoming_events);
                $output = array('status' => 'success', 'message' => 'All Event details!', 'my_events' => $my_events, 'past_events' => $past_events, 'upcoming_events' => $upcoming_events);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Event details not found!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_accept_members_details() {
        //$json_input = '{"event_id":"1"}';
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data['event_id'])) {
            $event_id = $input_data['event_id'];
            $accept_details = $this->event_api_model->get_accept_members_details($event_id);
            if (!empty($accept_details)) {
                $output = array('status' => 'success', 'message' => 'Accept Details!', 'accept_details' => $accept_details);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Accept Details not found!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_reject_members_details() {
        //$json_input = '{"event_id":"1"}';
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data['event_id'])) {
            $event_id = $input_data['event_id'];
            $reject_details = $this->event_api_model->get_reject_members_details($event_id);
            if (!empty($reject_details)) {
                $output = array('status' => 'success', 'message' => 'Reject Details!', 'reject_details' => $reject_details);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Reject Details not found!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_invited_members_details() {
        //$json_input = '{"event_id":"1"}';
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data['event_id'])) {
            $event_id = $input_data['event_id'];
            $invited_members_details = $this->event_api_model->get_invited_members_details($event_id);
            if (!empty($invited_members_details)) {
                $output = array('status' => 'success', 'message' => 'Invited Members Details!', 'invited_members_details' => $invited_members_details);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Invited Members Details not found!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_get_events_list() {
        //$json_input = '{"user_id":"151"}';
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data['user_id'])) {
            $id = $input_data['user_id'];
            $check_event_nearby = $this->event_api_model->check_user_in_location($id);
            if ($check_event_nearby != '0') {
                $events_list = $this->event_api_model->get_all_events_list($id);
            } else {
                $events_list = '0';
            }
            if ($events_list != '0') {
                $output = array('status' => 'success', 'message' => 'Events List!', 'events_list' => $events_list);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Events List not found!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_add_event() {
        $json_input = file_get_contents('php://input'); // JSON Input
        //$json_input = '{"event_info":[{"event_type_id":"1","event_name":"Yuvi Marriage Reception","from_date":"2019-02-06 10:00","to_date":"2019-02-08 05:00","latitude":"8.565985","longitude":"78.12379299999998","user_id":"1","status":"1"}],"event_members_info":["1","2","3"],"event_invitation_info":[{"file_name":"invitation.png","image_data":"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAADggg=="}],"event_dynamic_info":[{"1":"Birthday Party","2":"3","4":"07/02/2019","5":"Sample Description"}]}';

        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data)) {
            $event_info = (!empty($input_data['event_info'][0])) ? $input_data['event_info'][0] : array();
            $event_members_info = (!empty($input_data['event_members_info'])) ? $input_data['event_members_info'] : array();
            $event_invitation_info = (!empty($input_data['event_invitation_info'][0])) ? $input_data['event_invitation_info'][0] : array();
            $event_dynamic_info = (!empty($input_data['event_dynamic_info'][0])) ? $input_data['event_dynamic_info'][0] : array();

            $is_event_name_available = $this->event_api_model->is_event_name_available($event_info['event_name']);
            if ($is_event_name_available) {
                $time = date('Y-m-d H:i:s');
                $event_info['created_date'] = $time;
                if (!empty($event_info)) {
                    $event_id = $this->event_api_model->insert_event($event_info);
                    if (!empty($event_id)) {
                        $invited_members_json = json_encode($event_members_info);
                        $invited_members_arr = array(
                            'event_id' => $event_id,
                            'total_invited_members' => count($event_members_info),
                            'invited_members' => $invited_members_json,
                            'created_date' => $time
                        );
                        $this->event_api_model->insert_event_invited_members($invited_members_arr);

                        if (!empty($event_invitation_info)) {
                            $base_data = $event_invitation_info['image_data'];
                            $file_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base_data));
                            $file_name = $event_invitation_info['file_name'];
                            mkdir('./attachments/events/invitations', 0777, true);
                            $save_path = 'attachments/events/invitations/' . $file_name;
                            if (file_put_contents($save_path, $file_data) !== false) {
                                $image_data = array(
                                    'file_name' => $file_name,
                                    'event_id' => $event_id,
                                    'img_path' => base_url() . $save_path,
                                    'created_date' => $time
                                );
                                $insert_invitation = $this->event_api_model->insert_event_invitation($image_data);
                            }
                        }

                        if (!empty($event_dynamic_info)) {
                            $event_dynamic_arr = array();
                            foreach ($event_dynamic_info as $dynamic_key => $dynamic_val) {
                                $dynamic_val = (is_array($dynamic_val)) ? implode(',', $dynamic_val) : $dynamic_val;
                                $event_dynamic_arr[] = array(
                                    'field_id' => $dynamic_key,
                                    'value' => $dynamic_val,
                                    'event_id' => $event_id,
                                    'event_type_id' => $event_info['event_type_id'],
                                    'created_date' => $time
                                );
                            }
                            $dynamic = $this->event_api_model->insert_event_dynamic_values($event_dynamic_arr);
                        }
                        $output = array('status' => 'success', 'message' => 'Event successfully added!');
                        echo json_encode($output);
                    } else {
                        $output = array('status' => 'error', 'message' => 'Event not added!');
                        echo json_encode($output);
                    }
                }
            } else {
                $output = array('status' => 'error', 'message' => 'Event Name already exists!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_edit_event() {
        $json_input = file_get_contents('php://input'); // JSON Input
        //$json_input = '{"event_id":"5","event_info":[{"event_type_id":"1","event_name":"Vijay Marriage Reception","from_date":"2019-02-06 10:00","to_date":"2019-02-08 05:00","latitude":"8.565985","longitude":"78.12379299999998","user_id":"1","status":"1"}],"event_members_info":["1","2","3"],"event_invitation_info":[{"file_name":"sample.png","image_data":"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADgg=="}],"event_dynamic_info":[{"1":"DJ Birthday Party","2":"3","4":"05/02/2019","5":"Test Description"}]}';

        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data)) {
            $event_id = $input_data['event_id'];
            $event_info = (!empty($input_data['event_info'][0])) ? $input_data['event_info'][0] : array();
            $event_members_info = (!empty($input_data['event_members_info'])) ? $input_data['event_members_info'] : array();
            $event_invitation_info = (!empty($input_data['event_invitation_info'][0])) ? $input_data['event_invitation_info'][0] : array();
            $event_dynamic_info = (!empty($input_data['event_dynamic_info'][0])) ? $input_data['event_dynamic_info'][0] : array();

            $is_event_name_available = $this->event_api_model->is_event_name_available($event_info['event_name'], $event_id);

            if ($is_event_name_available) {
                $time = date('Y-m-d H:i:s');
                $event_info['updated_date'] = $time;

                if (!empty($event_info)) {
                    $update_id = $this->event_api_model->update_event($event_info, $event_id);

                    if (!empty($update_id)) {
                        $invited_members_json = json_encode($event_members_info);
                        $invited_members_arr = array(
                            'event_id' => $event_id,
                            'total_invited_members' => count($event_members_info),
                            'invited_members' => $invited_members_json,
                            'updated_date' => $time
                        );
                        $this->event_api_model->update_event_invited_members($invited_members_arr, $event_id);

                        if (!empty($event_invitation_info)) {
                            $base_data = $event_invitation_info['image_data'];
                            $file_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base_data));
                            $file_name = $event_invitation_info['file_name'];
                            mkdir('./attachments/events/invitations', 0777, true);
                            $save_path = 'attachments/events/invitations/' . $file_name;
                            if (file_put_contents($save_path, $file_data) !== false) {
                                $image_data = array(
                                    'file_name' => $file_name,
                                    'event_id' => $event_id,
                                    'img_path' => base_url() . $save_path,
                                    'created_date' => $time
                                );
                                $insert_invitation = $this->event_api_model->insert_event_invitation($image_data);
                            }
                        }

                        if (!empty($event_dynamic_info)) {
                            $event_dynamic_arr = array();
                            foreach ($event_dynamic_info as $dynamic_key => $dynamic_val) {
                                $dynamic_val = (is_array($dynamic_val)) ? implode(',', $dynamic_val) : $dynamic_val;
                                $event_dynamic_arr[$dynamic_key] = array(
                                    'field_id' => $dynamic_key,
                                    'value' => $dynamic_val,
                                    'event_id' => $event_id,
                                    'event_type_id' => $event_info['event_type_id'],
                                    'updated_date' => $time
                                );
                            }
                            $dynamic = $this->event_api_model->update_event_dynamic_values($event_dynamic_arr, $event_id);
                        }
                        $output = array('status' => 'success', 'message' => 'Event successfully updated!');
                        echo json_encode($output);
                    } else {
                        $output = array('status' => 'error', 'message' => 'Event not updated!');
                        echo json_encode($output);
                    }
                }
            } else {
                $output = array('status' => 'error', 'message' => 'Event Name already exists!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_get_event_by_id() {
        //$json_input = '{"event_id":"1"}';
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data['event_id'])) {
            $id = $input_data['event_id'];
            $event_details = $this->event_api_model->get_event_details_by_id($id);
            if (!empty($event_details)) {
                $output = array('status' => 'success', 'message' => 'Event Details!', 'event_details' => $event_details);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Event Details not found!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_get_event_invitations() {
        //$json_input = '{"event_id":"1"}';
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data['event_id'])) {
            $id = $input_data['event_id'];
            $event_invitations = $this->event_api_model->get_event_invitations_by_event_id($id);
            if (!empty($event_invitations)) {
                $output = array('status' => 'success', 'message' => 'Event Invitations List!', 'event_invitations' => $event_invitations);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Event Invitations not found!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

    function api_delete_event_invitation_image() {
        //$json_input = '{"event_invitation_id":"1"}';
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $input_data = json_decode($json_input, TRUE);
        if (!empty($input_data['event_invitation_id'])) {
            $id = $input_data['event_invitation_id'];
            $delete = $this->event_api_model->delete_event_invitation_by_id($id);
            if ($delete) {
                $output = array('status' => 'success', 'message' => 'Event Invitation Image successfully deleted!');
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Event Invitation Image not deleted!');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Invalid data!');
            echo json_encode($output);
        }
    }

}
