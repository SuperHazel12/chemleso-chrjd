<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {
		parent::__construct();

		$this->checkSession();
	}

	function checkSession() {

		if($this->uri->segment(1)!='login'){
				if ($this->session->userdata('user_id')=='') {
					header('Location: '.base_url("login"));
				}
		} else {
			if($this->session->userdata('user_id')!=''){
				header('Location: '.base_url("home"));
			}
		}
	}

	public function index()
	{
		$this->load->view('pages/index');

	}

	public function login()
	{
		$this->load->view('pages/index');

	}

	public function home()
	{
		$data['view'] =  "home";
		$data['head'] = array(
			"title"         =>  "Home | Chemical Waste Management System",
			);
		$this->load->view('layouts/template', $data);
	}

	public function makeReport()
	{
		$data['view'] =  "make-report";
		$data['head'] = array(
			"title"         =>  "Make Waste Report | Chemical Waste Management System",
			);
		$this->load->view('layouts/template', $data);
	}

	public function submittedReport()
	{
		$data['view'] =  "submitted-report";
		$data['head'] = array(
			"title"         =>  "Submitted Reports | Chemical Waste Management System",
			);
		$this->load->view('layouts/template', $data);
	}

	public function compiledReports()
	{
		$data['view'] =  "compiled-reports";
		$data['head'] = array(
			"title"         =>  "Compiled Reports | Chemical Waste Management System",
			);
		$this->load->view('layouts/template', $data);
	}

	public function homeCategories($slug)
	{
		$page_array = array("1" => "distribution", "2" => "reminders", "3" => "seminars", "4" => "deadline");

		$data['view'] =  $page_array[$slug];
		$data['result'] = $this->Global_model
								->get_data_with_query_and_single_order('announcements', '*', 'announcement_type_id ='.$slug, 
																		"created_at", "desc");
		$data['head'] = array(
			"title"         =>  "Submitted Reports | Chemical Waste Management System",
			);
		$this->load->view('layouts/template', $data);
	}

	public function changePassword()
	{
		$data['view'] =  'change-password';
		$data['head'] = array(
			"title"         =>  "Change Password | Chemical Waste Management System",
			);
		$this->load->view('layouts/template', $data);
	}

	public function accountManagement()
	{
		$data['view'] =  'account-management';
		$data['head'] = array(
			"title"         =>  "Account Management | Chemical Waste Management System",
			);
		$this->load->view('layouts/template', $data);
	}

	public function submittedReports()
	{
		$data['view'] =  'submitted-reports';
		$data['head'] = array(
			"title"         =>  "Submitted Reports | Chemical Waste Management System",
			);
		$this->load->view('layouts/template', $data);
	}	

	public function createAnnouncement($slug)
	{
		$data['view'] =  'announcements/'.$slug;
		$data['head'] = array(
			"title"         =>  "Announcement - ".ucwords($slug)." | Chemical Waste Management System",
			);
		$this->load->view('layouts/template', $data);
	}	

	public function logout() {
		$this->session->sess_destroy();
		header('Location: '.base_url());
	}

	public function editReport() {
		echo "edit report" . "<br>";
		echo "id: " . $this->input->post('report_id');
		$hw_report_id = $this->input->post('report_id');

		$results = $this->Global_model->get_data_with_query("hw_report_active", "*", "hw_report_id = " . $hw_report_id);
		$waste_reports = $this->Global_model->get_data_with_query("waste_report", "*", "hw_report_id = " . $hw_report_id);

		print("<pre>".print_r($waste_reports,true)."</pre>");

		$data = array(
				'hw_report_id' => $hw_report_id,
				'college' => $results[0]->report_college,
				'department' => $results[0]->report_department,
				'building' => $results[0]->report_building,
				'laboratory_number' => $results[0]->report_lab_num,
				'contact_person' => $results[0]->report_person,
				'contact_person_number' => $results[0]->report_phone,
				'date' => $results[0]->report_date,
				'waste_reports' => $waste_reports
			);

		print("<pre>".print_r($data,true)."</pre>");
		$this->session->set_flashdata($data);

		 $waste_reports = $this->session->flashdata('waste_reports'); 
		 foreach($waste_reports as $report) { 
		 	echo $report->hw_number . "<br>";
		 }
		

		redirect("make-report");

	}

	public function insert() {

		if($this->input->post('hw_report_id')) {
			$hw_report_id = $this->input->post('hw_report_id');

			echo "hw report id: " . $hw_report_id . "<br>";

			if(is_numeric($hw_report_id)) {
				$results = $this->Global_model->get_data_with_query("hw_report_active", "*", "hw_report_id = " . $hw_report_id);

				// echo "last query: " . $this->db->last_query() . "<br>";
				// print("<pre>".print_r($results,true)."</pre>");

				if($results) {
					$waste_report_delete = $this->Global_model->delete_data("waste_report", "hw_report_id", $hw_report_id);
					$hw_report_delete = $this->Global_model->delete_data("hw_report", "hw_report_id", $hw_report_id);
					if($waste_report_delete === "failed" || $hw_report_delete === "failed") {
						$data = array(
							'server_errors' => "Data deletion from database Failed. Please contact your system administrator."
						);

						$this->session->set_flashdata($data);
						redirect("make-report");
					}
				}
			}
		}


		$results = $this->input->post();
		$report_data = [];
		$waste_reports = array();
		$all_data = [];
		$hw_report_data = [];
		$currentDate = date("Y/m/d");

		foreach($results["hw_number"] as $key=>$val) {
			$waste_report = new stdClass;
			$waste_report->hw_number=$results["hw_number"][$key];
			$waste_report->hw_catalogue = $results["hw_catalog"][$key];
			$waste_report->hw_nature= $results["hw_nature"][$key];
			$waste_report->report_bottle_num = $results["bottle_number"][$key];
			$waste_report->report_sticker_num = $results["sticker_number"][$key];
			$waste_report->report_remain_waste = $results["remainig_qty"][$key];
			$waste_report->report_quantity = $results["qty_kg"][$key];
			$waste_report->report_datecreated = $currentDate;
			array_push($waste_reports, $waste_report);
		}

		// print("<pre>".print_r($waste_reports,true)."</pre>");

		$this->form_validation->set_rules('college', 'College', 'required');
		$this->form_validation->set_rules('department', 'Department', 'required');
		$this->form_validation->set_rules('building', 'Building', 'required');
		$this->form_validation->set_rules('contact_person', 'Contact Person', 'required|max_length[25]|alpha_numeric_spaces');
		$this->form_validation->set_rules('laboratory_number', 'Laboratory Number', 'required|max_length[20]|alpha_numeric_spaces');
		$this->form_validation->set_rules('contact_person_number', 'Contact Number', 'required|min_length[7]|max_length[25]|alpha_numeric_spaces');
		$this->form_validation->set_rules('date', 'Date', 'required');

		if($this->form_validation->run() == FALSE) {
			$data = array(
				'college' => $results["college"],
				'department' => $results["department"],
				'building' => $results["building"],
				'laboratory_number' => $results["laboratory_number"],
				'contact_person' => $results["contact_person"],
				'contact_person_number' => $results["contact_person_number"],
				'date' => $results["date"],
				'waste_reports' => $waste_reports,
				'errors' => validation_errors()
			);

			$this->session->set_flashdata($data);
			redirect("make-report");
		}

		$hw_report_data["user_id"] = $this->session->userdata('user_id'); 
	    $hw_report_data["report_college"] = $results["college"];
		$hw_report_data["report_department"] = $results["department"];
		$hw_report_data["report_building"] = $results["building"]; 
		$hw_report_data["report_lab_num"] = $results["laboratory_number"];
		$hw_report_data["report_person"] = $results["contact_person"];
		$hw_report_data["report_phone"] = $results["contact_person_number"];
		$hw_report_data["report_date"] = $results["date"];
		$hw_report_data["report_status"] = "Pending";
		$hw_report_data["report_datecreated"] = $currentDate;

		$hw_report_insert = $this->Global_model->insert_data('hw_report', $hw_report_data);

		if($hw_report_insert === "failed") {
			$data = array(
				'server_errors' => "Data insertion to database Failed. Please contact your system administrator."
			);

			$this->session->set_flashdata($data);

			print("<pre>".print_r($data,true)."</pre>");
			print("<pre>".print_r($hw_report_data,true)."</pre>");

			//redirect("make-report");
		}

		foreach($results["hw_number"] as $key=>$val) {
			$report_data["hw_report_id"] = $hw_report_insert;
			$report_data["hw_number"] = $results["hw_number"][$key];
			$report_data["hw_catalogue"] = $results["hw_catalog"][$key];
			$report_data["hw_nature"] = $results["hw_nature"][$key];
			$report_data["report_bottle_num"] = $results["bottle_number"][$key];
			$report_data["report_sticker_num"] = $results["sticker_number"][$key];
			$report_data["report_remain_waste"] = $results["remainig_qty"][$key];
			$report_data["report_quantity"] = $results["qty_kg"][$key];
			$report_data["report_datecreated"] = $currentDate;
			array_push($all_data, $report_data);
		}

		print("<br><pre>".print_r($all_data,true)."</pre>");

		$report_batch_insert = $this->Global_model->insert_batch_data('waste_report', $all_data);

		if($report_batch_insert === "failed") {
			$data = array(
				'server_errors' => "Batch data insertion to database Failed. Please contact your system administrator."
			);

			$this->session->set_flashdata($data);
			redirect("make-report");
		}

		redirect("HomeController/submittedReports"); 
	}

	public function reports() {
		$reports = $this->Global_model->get_all_data('hw_report_active', '*');
	}

	public function getSpecificReport($slug) {

		$data['result'] = $this->Custom_model->get_specific_report($slug);
		$data['view'] =  'viewreport-page';
		$data['head'] = array(
			"title"         =>  "Reports | Chemical Waste Management System",
			);

		if(empty($data['result'])) {
			$data['errors'] = "Data record not existing in database.";
		}

		$this->load->view('layouts/template', $data);
	}

	public function rejectReason(){
		$results = $this->input->post();

		print("<pre>".print_r($results,true)."</pre>");

		$this->form_validation->set_rules('reason_text', 'Reject Reason', 'required');

		if($this->form_validation->run() == FALSE) {
			$data = array(
				'errors' => validation_errors()
			);

			$this->session->set_flashdata($data);
			redirect("submitted-reports");
		}

		$table = 'hw_report';
        $data = array(
            'report_remarks' => $results['reason_text'],
        );
        $field = 'hw_report_id';
        $where = $results['hw_report_id'];
        $response = $this->Global_model->update_data($table, $data, $field, $where);

        // print_r($this->db->last_query()); 
        // echo "<br>table: " . $table . "<br>";
        // print("<pre>".print_r($data,true)."</pre>");
        // echo "field: " . $field . "<br>";
        // echo "where: " . $where . "<br>";
        // echo "resp: " . $response . "<br>"; 

		if($response === "failed") {
			$data = array(
				'server_errors' => "Updating the remark field of database table failed. Please contact your system adminstrator"
			);

			$this->session->set_flashdata($data);
		}else {
			$table = 'hw_report';
	        $data = array(
				            'report_status' => 'Rejected',
				         );
	        $field = 'hw_report_id';
	        $where = $results['hw_report_id'];
	        $response = $this->Global_model->update_data($table, $data, $field, $where);

	        if($response === "failed") {
				$data = array(
					'server_errors' => "Updating the status field of database table failed. Please contact your system adminstrator"
				);

				$this->session->set_flashdata($data);
			}

			$hw_report_id = $results['hw_report_id'];
			$user_id = $this->Global_model->get_data_with_query("hw_report_active", "user_id", "hw_report_id = " . $hw_report_id);

			// $notifications["hw_report_id"] = $hw_report_id;
			// $notifications["user_id"] = $user_id;
			// $notifications["report_status"] = "Rejected";
			// $notifications["notification_status"] = 0;
			// $notifications["subject"] = "Report " . $hw_report_id . " Rejected.";
			// $notifications["text"] = "Your report with number of " . $hw_report_id . " has been rejected.";
			// $notifications["url"] = "report/" . $hw_report_id;


			$notifications = array(
                            'hw_report_id' => $hw_report_id, 
                            'user_id' => $user_id[0]->user_id,
                            'report_status' => "Rejected",
                            'notification_status' => 0,
                            'subject' => "Report " . $hw_report_id . " Rejected!",
                            'text' => "Your report with number of " . $hw_report_id . " has been rejected.",
                            'url' => "report/" . $hw_report_id
                        );


			 $this->Global_model->insert_data("report_notifications", $notifications);
		}

		 if(!empty($this->input->post('from_view'))) {
		 	redirect("report/" . $hw_report_id); 
		 }else{
		 	redirect("submitted-reports"); 
		 }
	}

	public function archiveReports() {
		$data['view'] =  'archive-reports';
		$data['head'] = array(
			"title"         =>  "Archive Reports | Chemical Waste Management System",
			);
		$this->load->view('layouts/template', $data);
	}

}
