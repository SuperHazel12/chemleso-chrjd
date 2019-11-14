<div class="page-body">
	<div class="container">
		<div class="section-body">
			<div class="row" style="margin-top: 1em;" >
				<div class="col-md-2">
					<button type="button" id="btn-back" class="btn btn-primary btn-back mb-0">Back</button>
				</div>
				<div class="col-md-2">
				</div>
				<div class="col-md-4">
				</div>

				<?php
					if($this->session->userdata('position_Id') == 1 &&
							 !empty($result) && $result[0]->report_status == "Approved") { ?>
						<div class="col-md-4">
							<button type="button" id="btn-export-ind" class="btn btn-primary mb-3">Export to PDF</button>
						</div>
					<?php }elseif($this->session->userdata('position_Id') == 1 && !empty($result) && $result[0]->report_status == "Rejected") { ?>
						<div class="col-md-4">
						<form method='post' action='<?=base_url()?>edit_report' id=<?php echo !empty($result) ? "form_" . $result[0]->hw_report_id : "" ?> ><input type='hidden' name='report_id' value=<?php echo !empty($result) ? $result[0]->hw_report_id : "" ?>>
							<button class='btn btn-primary btn-edit-report' data-id=<?php echo !empty($result) ? $result[0]->hw_report_id : "" ?>>Edit Report</button></form>
					</div>
				<?php } ?>
			</div>
			<div class="report-fields my-2">
				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-4">
						<label><b>College: </b><span><?php echo empty($result) ? "No data" : $result[0]->report_college ?></span></label>
					</div>
					<div class="col-md-4">
						<label><b>Date: </b><span><?php echo empty($result) ? "No data" : $result[0]->report_date ?></span></label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-4">
						<label><b>Department: </b><span><?php echo empty($result) ? "No data" : $result[0]->report_department ?></span></label>
					</div>
					<div class="col-md-4">
						<label><b>Phone Number: </b><span><?php echo empty($result) ? "No data" : $result[0]->report_phone ?></span></label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-4">
						<label><b>Building: </b><span><?php echo empty($result) ? "No data" : $result[0]->report_building ?></span></label>
					</div>
					<div class="col-md-4">
						<label><b>Contact Person: </b><span><?php echo empty($result) ? "No data" : $result[0]->report_person ?></span></label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-4">
						<label><b>Lab No: </b><span><?php echo empty($result) ? "No data" : $result[0]->report_lab_num ?></span></label>
					</div>
					<div class="col-md-4">
						<label><b>Status: </b>
							<span>
							<?php 
							// Reject Color - #C0392B, Accept Color- #007E33 and Pending Color -  #FF8800
								if(empty($result)) {
									echo "No data";
								}else{
									$report_status = $result[0]->report_status;
									if($report_status == "Pending") {
										if($this->session->userdata('position_Id') == 2) { ?>
											<button class='btn btn-success btn-sm btn-approve' data-id=<?php echo !empty($result) ? $result[0]->hw_report_id : "" ?>>Approve</button>
											<button class='btn btn-danger btn-sm btn-reject' data-id=<?php echo !empty($result) ? $result[0]->hw_report_id : "" ?> data-toggle='modal' data-target='#modalContactForm'>Reject</button>
										<?php
										}else{
						               		echo "<font color='#FF8800'>" . $report_status . "</font>";
						               	}
						            } elseif($report_status == "Approved") {
						               echo "<font color='#007E33'>" . $report_status . "</font>";
						            } else {
						               echo "<font color='#C0392B'>" . $report_status . "</font>";
						            }
								}
							 ?></span></label>
					</div>
				</div>

				<div class='modal fade' id='modalContactForm' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
					<form method='post' name='reject_form' action='<?=base_url()?>reject-reason'>
						<div class='modal-dialog' role='document'>
							<div class='modal-content'>
								<div class='modal-header text-center'>
									<h4 class='modal-title w-100 font-weight-bold'>Reject Report Number <?php echo !empty($result) ? $result[0]->hw_report_id : '' ?></h4>
									<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
								</div>
								<div class='modal-body mx-3'>
									<div class='md-form'><i class='fas fa-pencil prefix grey-text'></i>
										<label data-error='wrong' data-success='right' for='form8'>Please specify a reason: </label>
										<br>
										<textarea id='reason_text' name='reason_text' class='md-textarea form-control' rows='4' required='true'></textarea>
										<input type='hidden' name='hw_report_id' id='hw_report_id' value=<?php echo !empty($result) ? $result[0]->hw_report_id : '' ?> />
										<input type='hidden' name='from_view' id='from_view' value="1" />
									</div>
								</div>
								<div class='modal-footer d-flex justify-content-center'>
									<input type='submit' class='btn btn-success' value='Submit' />
								</div>
							</div>
						</div>
					</form>
				</div>

				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-4">
						<label><b>Report Number: </b><span id="span_hw_report_id"><?php echo empty($result) ? "No data" : $result[0]->hw_report_id ?></span></label>
					</div>
					<?php if(!empty($result) && $result[0]->report_status == "Rejected") { ?>
						<div class="col-md-4">
							<label><b>Rejected Reason: </b><span><?php echo $result[0]->report_remarks ?></span></label>
						</div>
					<?php } ?> 
				</div>
			</div>
			<div class="table-report mb-8">
			<table id="submitted-reports" class="table table-hover" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th rowspan="2">Waste Number</th>
						<th rowspan="2">HW Class</th>
						<th rowspan="2">Bottle Number</th>
						<th rowspan="2">Sticker Number</th>
						<th rowspan="2">Hazard Category</th>
						<th rowspan="2">Physical state of Chemical Waste</th>
						<th colspan="2">Remaining Waste From Previous Report</th>
						<th colspan="2">Quantity in Kilogram</th>
					</tr>
					<tr>
		                <th>Quantity</th>
				        <th>Unit</th>
		                <th>Quantity</th>
				        <th>Unit</th>
		            </tr>
					</tr>
				</thead>
				<tbody>
					<?php foreach($result as $single_result) { ?>
					<tr>
						<td width="5%"><?php echo $single_result->hw_number ?></td> <!-- 95 -->
						<td width="25%"><?php echo $single_result->hw_class ?></td> <!-- 75 -->
						<td width="10%"><?php echo $single_result->report_bottle_num ?></td> <!-- 65 -->
						<td width="10%"><?php echo $single_result->report_sticker_num ?></td> <!-- 55 -->
						<td width="10%"><?php echo $single_result->hw_catalogue ?></td> <!-- 40 -->
						<td width="10%"><?php echo $single_result->hw_nature ?></td> <!-- 25 -->
						<td width="10%"><?php echo $single_result->report_remain_waste ?></td> <!-- 15 -->
						<td width="5%"><?php echo "Kg." ?></td> <!-- -->
						<td width="10%"><?php echo $single_result->report_quantity ?></td> <!-- -->
						<td width="5%"><?php echo "Kg." ?></td> <!-- -->
					</tr>
				<?php } ?>
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>

<script>

	$(document).ready(function() {
		$(document).on('click', '.btn-back', function() {
			window.history.go(-1);
		});

		$(document).on('click', '.btn-approve', function(data) {
				var report_id = $(this).attr('data-id');
				var status = "Approved";
				var r = confirm("Are you sure you want to approve this report?");
				if (r == true) {
				  $.ajax({
				  	url: "<?=base_url()?>ajax/update-report-status",
				  	type: "POST",
				  	data: {
				  		report_id: report_id,
				  		status: status
				  	},
				  	success: function(data) {
				  		alert("Report Successfully Approved");
				  		location.reload();
				  	}
				  });
				} else {
					return false;
				}
			});

		$(document).on('click', '#btn-export-ind', function() { 
			var report_id = $('#span_hw_report_id').text();
			window.open('<?=base_url()?>report/export/'+report_id, '_blank');
		});

		$(document).on('click', '.btn-edit-report', function(data) {
			var form_id = "#form_" + $(this).attr('data-id');
			$(form_id).submit();
		});
	});
	
</script>