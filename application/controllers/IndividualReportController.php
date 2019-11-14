<?php

class IndividualReportController extends CI_Controller {

	function __construct() {
		parent::__construct();

		//  Path to simple_html_dom
		 require_once APPPATH.'third_party/PDF_MC_Table.php';
	}

	// index.php/ThirdPartyController/index
	function index() {
       
		date_default_timezone_set("Asia/Manila");
		$currentDate = date("Y/m/d");
		$currentTime = date("h:i:sa");
		$slug = $this->uri->segment(3);

		$title = "Hazardous_Waste_Collection_Form_" . $currentDate . "T" . $currentTime;
		$ust_logo_path = base_url(). "assets/img/logos/ust.png";
		$leso_logo_path = base_url() . "assets/img/logos/leso.png";
		$pdf = new PDF_MC_Table();
		$pdf->SetTitle($title);
		$pdf->AliasNbPages();
		$pdf->AddPage();

		$x = 10;
		$y = 16;
		$ustLogoX = 10;
		$fullX = $pdf->GetPageWidth(); // Width of Current Page
		$fullY = $pdf->GetPageHeight(); // Height of Current Page

		// START OF HEADERS
		$pdf->Image($ust_logo_path, $ustLogoX, 20, 20);
		$pdf->Image($leso_logo_path, 180, 20, 20);

		$ust = 'UNIVERSITY OF SANTO TOMAS';
		$ustX = ($fullX / 2) - strlen($ust) - 5;
		$pdf->SetFont('Arial','B',11);
		// $pdf->Cell(100,10,$ust);

		$pdf->setY($y);
		$pdf->Cell(0, 10, $ust, 0, 0, 'C');

		$y += 5;
		$pdf->setY($y);
		$pdf->Cell(0, 10, 'Laboratory Equipment and Supplies Office', 0, 0, 'C');
		
		// Contact No.: 406-1611 loc. 8266, 7126349 
		$pdf->SetFont('Arial','',11);
		$y += 5;
		$pdf->setY($y);
		$pdf->Cell(0, 10, 'Contact No.: 406-1611 loc. 8266, 7126349', 0, 0, 'C');

		$pdf->SetFont('Arial','B',12);
		$y += 5;
		$pdf->setY($y);
		$pdf->Cell(0, 10, 'HAZARDOUS WASTE COLLECTION FORM', 0, 0, 'C');

		// END OF HEADERS

		$pdf->SetFont('Arial','B',10);
		$y += 16;
		$pdf->setXY($ustLogoX, $y);
		$pdf->Cell(0, 10, 'GENERATOR INFORMATION:');

		$results = $this->Custom_model->get_specific_report($slug);

		if(!empty($results)) {
			$college = $results[0]->report_college;
			$department = $results[0]->report_department;
			$buildingLabNo = $results[0]->report_building . " / " . $results[0]->report_lab_num;
			$phone_number = $results[0]->report_phone;
			$contact_person = $results[0]->report_person;
			$date = $results[0]->report_date;
			$accumulation_date = $date;
		}else{
			$college = "";
			$department = "";
			$buildingLabNo = "";
			$phone_number = "";
			$contact_person = "";
			$date = "";
			$accumulation_date = "";
		}

		$blanks_flag = 0;
		$blanks_height = 10;

		$pdf->SetFont('Arial','',10);
		$y += 6;
		$pdf->setXY($ustLogoX, $y);
		$pdf->Multicell(75, $blanks_height, "COLLEGE: " . $college, $blanks_flag);

		$pdf->setXY($ustLogoX + 75, $y);
		$pdf->Multicell(115, $blanks_height, "DEPARTMENT: " . $department, $blanks_flag);

		$y += 8;
		$pdf->setXY($ustLogoX, $y);
		$pdf->Multicell(195, $blanks_height, "BUILDING/LAB NO.: " . $buildingLabNo, $blanks_flag);

		$y += 8;
		$pdf->setXY($ustLogoX, $y);
		$pdf->Multicell(75, $blanks_height, "PHONE NUMBER: " . $phone_number, $blanks_flag);

		$pdf->setXY($ustLogoX + 75, $y);
		$pdf->Multicell(115, 10, "CONTACT PERSON: " . $contact_person, $blanks_flag);

		$y += 8;
		$pdf->setXY($ustLogoX, $y);
		$pdf->Multicell(75, $blanks_height, "DATE: " . $date, $blanks_flag);

		$pdf->setXY($ustLogoX + 75, $y);
		$pdf->Multicell(115, $blanks_height, "ACCUMULATION DATE: " . $accumulation_date, $blanks_flag);

		$pdf->SetFont('Arial','B',10);
		$y += 15;
		$pdf->setXY($ustLogoX, $y);
		$pdf->SetWidths(array(30, 40, 35, 60, 25));
		$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C'));
		$pdf->Row(array("\nHAZARD NO.\n ", "\nSTICKER NO.\n ", "\nHAZARD CATEGORY\n ", "\nHAZARD WASTE CLASS\n ", "\nQUANTITY\n "));

		$pdf->SetFont('Arial','',10);
		$pdf->SetAligns(array('L', 'L', 'C', 'C', 'L'));
		$sum_quantity = 0;
		if(!empty($results)) {
			foreach($results as $value) {	
				$quantity = 0.000;
				if(!empty($value->report_quantity)) {
					$quantity = $value->report_quantity;
					$sum_quantity += $quantity;
				}

				$pdf->Row(array($value->hw_number, $value->report_sticker_num, $value->hw_catalogue, $value->hw_class, $quantity));
			}
		}

		$total = "TOTAL QUANTITY: " . number_format((float)$sum_quantity, 3, '.', '') . "			";
		$pdf->Multicell(190, 8, $total, 1, 'R');

		$footerY = $fullY - 45;
		$pdf->SetY($footerY);
		$pdf->Cell(5, 5, "Prepared by: ");

		$curX = $pdf->GetX();
		$curY = $pdf->GetY();
		$pdf->Line($curX + 16, $curY + 5, $curX + 75, $curY + 5);

		$pdf->SetXY($curX + 95, $footerY);
		$pdf->Cell(5, 5, "Endorsed by: ");
		$pdf->Line($curX + 117, $curY + 5, $curX + 176, $curY + 5);

		$pdf->SetFont('Arial','',9);
		$pdf->SetXY($curX + 23, $curY + 7);
		$pdf->Cell(5, 2, "Signature over Printed Name");

		$pdf->SetXY($curX + 123, $curY + 7);
		$pdf->Cell(5, 2, "(Father Regent/Dean/Director)");


		// UST: S022-00-FO02 rev01 [date]
		$pdf->SetXY($curX + 120, $fullY - 24);
		$pdf->SetFont('Arial','I',9);
		$pdf->Cell(5, 2, "UST: S022-00-FO02 rev01 " . $currentDate);


		$pdf->Output('I', $title . ".pdf");

		
	}

	function report() {
		
	}

}
?>