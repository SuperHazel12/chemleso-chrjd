<?php

class ThirdPartyController extends CI_Controller {

	function __construct() {
		parent::__construct();

		//  Path to simple_html_dom
		require_once APPPATH.'third_party/PDF_MC_Table.php';
	}

	// index.php/ThirdPartyController/index
	function index() {
        $quarter = $this->uri->segment(4);
        $year = $this->uri->segment(3);
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

        $all_hw_classes = $this->Custom_model->get_all_hw_classes();
        $result = $this->Custom_model->get_compiled_results($start_date, $end_date);


		// QUARTERLY

        
		date_default_timezone_set("Asia/Manila");
		$currentDate = date("Y/m/d");
		$currentTime = date("h:i:sa");

		$title = "HW_Generation_University_Of_Santo_Tomas_" . $currentDate . "T" . $currentTime;

		$pdf = new PDF_MC_Table();
		$pdf->SetTitle($title);
		$pdf->AliasNbPages();
		$pdf->AddPage();

		$startY = 10;
		$startX = 20;

		$pdf->SetFont('Times','',12);

		$pdf->SetXY($startX, $startY);
		$pdf->Cell(10,10, 'Name of Plant:');

		$sY = $startY + 8;

		$pdf->SetXY(20, $sY);
		$pdf->Cell(150,10, 'University of Santo Tomas');

		$pdf->Line(20,26, 120,26);

		$sY += 20;
		$pdf->SetFont('Times','B',16);
		$pdf->SetXY(70, $sY);
		$pdf->Cell(150,10, 'Hazardous Wastes Generator');

		$sY += 15;
		$pdf->SetFont('Times','B',14);
		$pdf->SetXY($startX+1, $sY);
		$pdf->Cell(150,5, 'HW Generation:');


		$pdf->SetFont('Times','',10);

		$sY += 5;
		$col_span = 5;
		$pdf->SetXY($startX-2, $sY);

		
							//                 U	    U			
		$pdf->SetWidths(array(12,45,20,30, 21, 21, 20, 20));
		$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
		$pdf->Row(array("HW No.", "HW Class", "HW Nature", "HW Cataloguing", "Remaining HW Quantity", "Remaining HW Unit", "HW Generated Quantity", 
								"HW Generated Unit"));

		foreach ($all_hw_classes as $value) {
			$pdf->SetX($startX-2);
			$pdf->SetAligns(array('L', 'L', 'C', 'C', 'L', 'C', 'L', 'C'));
			$does_exist = 0;

			foreach($result as $single_result) {
				if($value->hw_number == $single_result->hw_number) {
					$remain_waste = $single_result->remain_waste/1000;
					$remain_quantity = $single_result->report_quantity/1000;
					$pdf->Row(array($value->hw_number, $value->hw_class, $single_result->hw_nature, $single_result->hw_catalogue, $remain_waste, 
						'MT', $remain_quantity, 'MT'));
					$does_exist = 1;
					break;
				}
			}

			if(!$does_exist) {
				$pdf->Row(array($value->hw_number, $value->hw_class, $value->default_hw_nature, $value->default_hw_catalogue, 0, 'MT', 0, 'MT'));
			}

			
		}
		
		// $pdf->Row(array($pat_name,$patient_id, $birthday, $gender, $datetime_perf, $phy . ", M.D." , $ref . ", M.D."));

	
		$pdf->SetFont('Times','I',10);
		$pdf->SetXY(17, 265);
		$pdf->Cell(150,5, "Module 2B: RA 6969 (HW Wastes Generator)");

		$pdf->SetXY(31, 265);
		$pdf->Line(105,269, 175,269);

		$pdf->SetXY(111, 269);
		$pdf->Cell(150,5, "Lab Supervisor/Coordinator Signature");

		$pdf->Output('I', $title . ".pdf");

		
	}

	function report() {
		
	}

}
?>