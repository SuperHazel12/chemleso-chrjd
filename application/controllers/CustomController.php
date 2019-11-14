<?php
class CustomController extends CI_Controller
{

    public function index()
    {
        $this->load->view('welcome_message');
    }

    public function validatePassword()
    {
        $password = $_POST['password'];
        $isExist = $this->Global_model->get_data_with_query('users', 'id', 'password ="' . sha1($password) . '" AND username = "' . $this->session->userdata('username') . '"');
        if (count($isExist) > 0) {
            $status = 'success';
        } else {
            $status = 'error';
        }
        echo json_encode(array('status' => $status));
    }

    public function getNewPassword()
    {
        $length = 6;
        $data['password'] = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);

        print_r(json_encode($data));
    }

    public function getUserCompiledReports() {
        $quarter = $this->input->post('quarter');
        $year = $this->input->post('year');

        $start_date = "";
        $end_date = "";
        if($quarter == "1") {
            $start_date = "01/01";
            $end_date = "03/31";
        }elseif($quarter == "2") {
            $start_date = "02/01";
            $end_date = "06/30";
        }elseif($quarter == "3") {
            $start_date = "07/01";
            $end_date = "09/30";
        }else{
            $start_date = "10/01";
            $end_date = "12/31";
        }

        $start_date = $year . "/" . $start_date;
        $end_date = $year . "/". $end_date;

        $result = $this->Custom_model->get_compiled_results($start_date, $end_date);
        print_r(json_encode($result));
    }

    public function savePageContent()
    {
        $table = 'content_pages';
        $data = array(
            'short_description' => $this->input->post('short_description'),
            'content' => $this->input->post('content'),
            'status' => $this->input->post('status'),
        );
        $field = 'content_id';
        $where = $this->input->post('content_id');
        $response = $this->Global_model->update_data($table, $data, $field, $where);
    }

    public function addAccount()
    {
        $table = 'users';
        $data = array(
            'username' => $this->input->post('username'),
            'password' => sha1($this->input->post('password')),
            'position_id' => $this->input->post('position'),
            'college_id' => $this->input->post('college')
        );
        $response = $this->Global_model->insert_data($table, $data);
        print_r(json_encode($response));
    }

    public function addAnnouncement()
    {
        $table = 'announcements';
        $data = array(
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'user_id' => $this->session->userdata('user_id'),
            'announcement_type_id' => $this->input->post('announcement_type_id')
        );
        $response = $this->Global_model->insert_data($table, $data);
        print_r(json_encode($response));
    }

    public function updatePassword()
    {
        $user_id = $this->session->userdata('user_id');
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');
        $confirm_new_password = $this->input->post('confirm_new_password');
        $user = $this->Global_model->get_data_with_query('users', 'password', 'user_id =' . $user_id);
        if ($new_password == $confirm_new_password) {
            if (sha1($current_password) == $user[0]->password) {
                $table = 'users';
                $data = array('password' => sha1($confirm_new_password));
                $field = 'user_id';
                $where = $user_id;
                $response = $this->Global_model->update_data($table, $data, $field, $where);
                $result['message'] = "Password Successfully Changed";
                $result['status'] = "success";
            } else {
                $result['message'] = "Invalid Password";
                $result['status'] = "error";
            }

        } else {
            $result['message'] = "New password and confirm password does not match";
            $result['status'] = "error";
        }

        print_r(json_encode($result));
    }

    public function getAllAccounts()
    {
        $result = $this->Custom_model->get_all_users();
        
        foreach ($result as $row) {
            $college_name = $this->Global_model->get_data_with_query('college', 'college_name', "college_id = " . $row->college_id);
            $row->college_id = $college_name[0]->college_name;
        }

        // print("<pre>".print_r($result,true)."</pre>");
        print_r(json_encode($result));
    }

    public function getAnnouncement()
    {
        $id = $this->input->post('id');
        $result = $this->Global_model->get_data_with_query('announcements', '*', 'announcement_type_id ='.$id);
        
        print_r(json_encode($result));
    }

    public function getSpecificAnnouncement()
    {
        $id = $this->input->post('id');
        $result = $this->Global_model->get_data_with_query('announcements', '*', 'annc_id ='.$id);
        
        print_r(json_encode($result));
    }

    public function updateAnnouncement() {
        $id = $this->input->post('id');
        $data = array('title' => $this->input->post('title'),
          'description' => $this->input->post('description'));
        $annc_id = $this->input->post('id');
        $this->Global_model->update_data("announcements",$data, "annc_id", $annc_id);

    }
    
    public function deleteAnnouncement()
    {
        $table = "announcements";
        $field = "annc_id";
        $where = $this->input->post("id");
        $result = $this->Global_model->delete_data($table, $field, $where);
        print_r(json_encode($result));
    }


    public function getUserSubmittedReports()
    {
        $result = $this->Custom_model->get_user_submitted_reports($this->session->userdata('position_Id'));

        foreach($result as $value) {
            $status = $value->report_status;

            if($status == "Pending") {
                $value->report_status = "<font color='#FF8800'>" . $status . "</font>";
            } elseif($status == "Approved") {
                $value->report_status = "<font color='#007E33'>" . $status . "</font>";
            } else {
                $value->report_status = "<font color='#C0392B'>" . $status . "</font>";
            }
            
        }

        // print("<pre>".print_r($result,true)."</pre>");
        print_r(json_encode($result));
    }

    public function getReportRecords() {

        $post = $this->input->post('view');
        // echo "is post empty: " . empty($post) . "<br>";

        if(!$post) {

            $user_id = $this->session->userdata('user_id');
            $result = $this->Custom_model->get_notification_reports($user_id, 5);
            $output = '';
            
            if(!empty($result)) {
                foreach($result as $row) {
                    // echo "subject: " . $row->subject . "<br>";
                    // echo "text: " . $row->text . "<br>";
                    $url = ($row->url) ? base_url() . $row->url : '#';
                    $output .= "<li><a href='" . $url . "'><strong>" . $row->subject . "</strong><br><small><em>" . $row->text . "</em></small></a></li><liclass='divider'></li>";
                }
            }else{
                $output .= '<li><a href="#" class="text-bold text-italic">No Notification Found</a></li>';
            }

            $result = $this->Custom_model->get_unseen_notification_reports($user_id);
            $count = count($result);

            // $data["notification"] = $output;
            // $data["unseen_notification"] = $count;

            $data = array(
              'notification'   => $output,
              'unseen_notification' => $count
          );
            
            print_r(json_encode($data));
        }else{
        // "UPDATE comments SET comment_status=1 WHERE comment_status=0";
            $table = "report_notifications";
            $data = array(
                'notification_status' => 1
            );
            $field = "notification_status";
            $where = 0;
            $this->Global_model->update_data($table,$data,$field,$where);

        }
    }


    public function deleteAccount() {
        $table = "users";
        $field = "user_id";
        $where = $this->input->post("id");
        $result = $this->Global_model->delete_data($table, $field, $where);
        print_r(json_encode($result));
    }

    public function updateReportStatus() {
        $data['report_status'] = $this->input->post('status');
        $hw_report_id = $this->input->post('report_id');
        $user_id = $this->Global_model->get_data_with_query("hw_report_active", "user_id", "hw_report_id = " . $hw_report_id);
        
        $this->Global_model->update_data("hw_report_active",$data, "hw_report_id", $hw_report_id);

        $notifications = array(
            'hw_report_id' => $hw_report_id, 
            'user_id' => $user_id[0]->user_id,
            'report_status' => $data['report_status'],
            'notification_status' => 0,
            'subject' => "Report " . $hw_report_id . " Approved!",
            'text' => "Your report with number of " . $hw_report_id . " has been approved.",
            'url' => "report/" . $hw_report_id
        );

        $this->Global_model->insert_data("report_notifications", $notifications);
    }

    public function getCollege() {
        $college_id = $this->Global_model->get_data_with_query('users', "college_id", "user_id = " . $this->session->userdata('user_id'));

        $college_id = $college_id[0]->college_id;


        $result = $this->Custom_model->get_college_building_departments($college_id);

        // print("<pre>".print_r($result,true)."</pre>");

        $departments = array();

        foreach($result as $value) {
            array_push($departments, $value->department_name);
        }

        $results = array(
            "college_name" => $result[0]->college_name,
            "building_name" => $result[0]->building_name,
            "departments" => $departments
        );

       // print("<pre>".print_r($results,true)."</pre>");

        print_r(json_encode($results));
    }

    public function getAllColleges() {
        $colleges = $this->Global_model->get_all_data("college", "college_id, college_name");

        print_r(json_encode($colleges));
    }

    public function getAllArchiveReports() {
        if($this->session->userdata('position_Id') == 1) {
            // Select college.college_name from college inner join users on college.college_id = users.college_id AND users.user_id = 7            
            $college_name = $this->Custom_model->get_college_name_from_user($this->session->userdata('user_id'));
            $college_name = $college_name[0]->college_name;
            $reports = $this->Custom_model->get_hw_report_deletions_with_college($college_name);
        }else {
            $reports = $this->Global_model->get_all_data("hw_report_deletions", "*");
        }

        print_r(json_encode($reports));
    }
}
