<?php 
date_default_timezone_set('Asia/Taipei');

	class Custom_model extends CI_Model{

		public function get_all_users() { 
					$this->db->select("*");
					$this->db->from("users");
					$this->db->join("user_position", "users.position_id = user_position.position_id");
					$q = $this->db->get();
					return $q->result();
		}

		public function get_user_submitted_reports($position_id) { 
					$this->db->select("*");
					$this->db->from("hw_report_active");

					if($position_id == 1) {
						$this->db->join("users", "hw_report_active.user_id = users.user_id AND users.user_id = " . $this->session->userdata('user_id'));
					}
					
					$q = $this->db->get();
					return $q->result();
		}

		public function get_specific_report($hw_report_id) { 
					$this->db->select("*");
					$this->db->from("hw_report");
					$this->db->join("waste_report", "hw_report.hw_report_id = waste_report.hw_report_id AND hw_report.hw_report_id = " 
						. $hw_report_id);
					$this->db->join("hazardous_waste", "waste_report.hw_number = hazardous_waste.hw_number");
					$q = $this->db->get();
					return $q->result();
		}

		public function get_unseen_notification_reports($user_id) {
			//  $query->num_rows();
			// SELECT * FROM comments WHERE comment_status=0

				$this->db->select("*");
				$this->db->from("report_notifications");
				$this->db->where('user_id', $user_id);
				$this->db->where('notification_status', 0);
				$query = $this->db->get();

				return $query->result();
		}

		public function get_notification_reports($user_id, $limit){
			$this->db->select("*");
			$this->db->limit($limit);
			$this->db->from("report_notifications");
			$this->db->where('user_id', $user_id);
			$this->db->order_by("notification_id", "desc");

			$query = $this->db->get();
			return $query->result();
		}


		/*
			SELECT `hazardous_waste`.`hw_number`, `hazardous_waste`.`hw_class`, `hazardous_waste`.`hw_nature`, `hazardous_waste`.`hw_cataloguing`, SUM(waste_report.report_remain_waste) as remain_waste, SUM(waste_report.report_quantity) as report_quantity FROM `waste_report` JOIN `hazardous_waste` ON `waste_report`.`hw_number` = `hazardous_waste`.`hw_number` JOIN `hw_report` ON `waste_report`.`hw_report_id` = `hw_report`.`hw_report_id` WHERE `hw_report`.`report_date` >= '2019/09/01' AND `hw_report`.`report_date` <= '2019/09/30' AND hw_report.report_status = "Approved" GROUP BY `hw_number`

			*UPDATED*
			Select waste_report.hw_number, hazardous_waste.hw_class, waste_report.hw_catalogue, waste_report.hw_nature, SUM(waste_report.report_remain_waste) as remain_waste, SUM(waste_report.report_quantity) as report_quantity FROM waste_report JOIN hazardous_waste on waste_report.hw_number = hazardous_waste.hw_number JOIN hw_report on waste_report.hw_report_id = hw_report.hw_report_id WHERE `hw_report`.`report_date` >= '2019/10/01' AND `hw_report`.`report_date` <= '2019/10/30' AND hw_report.report_status = "Approved" GROUP BY waste_report.`hw_number`

		*/
		public function get_compiled_results($start_date, $end_date) {

			$date = "('" . $start_date . "' and '" . $end_date . "')"; 
			$this->db->select("waste_report.hw_number, hazardous_waste.hw_class, waste_report.hw_catalogue, waste_report.hw_nature, SUM(waste_report.report_remain_waste) as remain_waste, SUM(waste_report.report_quantity) as report_quantity");
			$this->db->from("waste_report");
			$this->db->join("hazardous_waste", "waste_report.hw_number = hazardous_waste.hw_number");
			$this->db->join("hw_report_active", "waste_report.hw_report_id = hw_report_active.hw_report_id");
			$this->db->where('hw_report_active.report_date >=', $start_date);
			$this->db->where('hw_report_active.report_date <=', $end_date);
			$this->db->where('hw_report_active.report_status = ', "Approved");
			$this->db->group_by("hw_number");
			$q = $this->db->get();

			return $q->result();
		}

		public function get_all_hw_classes() {
			$this->db->select("*");
			$this->db->from("hazardous_waste");

			$query = $this->db->get();
			return $query->result();

		}

		/*
			Select college.college_name, building.building_name, department.department_name from college inner join building on college.building_id = building.building_id inner JOIN department on college.college_id = department.college_id where college.college_id = 3
		*/
		public function get_college_building_departments($college_id) {
			$this->db->select("college.college_name, building.building_name, department.department_name");
			$this->db->from("college");
			$this->db->join("building", "college.building_id = building.building_id");
			$this->db->join("department", "college.college_id = department.college_id");
			$this->db->where('college.college_id = ', $college_id);
			$q = $this->db->get();

			return $q->result();
		}

		public function get_college_name_from_user($user_id) {
			$this->db->select("college.college_name");
			$this->db->from("college");
			$this->db->join("users", "college.college_id = users.college_id");
			$this->db->where("users.user_id = " . $user_id);
			$q = $this->db->get();
			return $q->result();
		}

		public function get_hw_report_deletions_with_college($college_name) {
			$this->db->select("*");
			$this->db->from("hw_report_deletions");
			$this->db->where("report_college", $college_name);
			$q = $this->db->get();
			return $q->result();
		}

		

	}