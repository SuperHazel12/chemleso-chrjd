<div class="page-body" >
	<div class="container">
		<div class="section-title">
			<h3>Submitted Reports</h3>
		</div>
		<div class="section-body body-part" >
			<?php 
				if($this->session->flashdata('errors')): 
					echo "<font color='red'>" . $this->session->flashdata('errors') . "</font>";
				endif;

				if($this->session->flashdata('server_errors')):
					echo "alert(" . $this->session->flashdata('server_errors') . ");";
				endif;
			?>
			<table id="table-submitted-reports" class="table table-hover dt-responsive" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Date</th>
						<th>Report Number</th>
						<th>College</th>
						<th>Department</th>
						<th>Building</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Date</th>
						<th>Report Number</th>
						<th>College</th>
						<th>Department</th>
						<th>Building</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</tfoot>
			</table>

		</div>
	</div>

	
</div>

<script>
	var reports
	$(document).ready(function() {
		$('#submitted-reports a').removeClass('nav-color');
		$('#submitted-reports a').addClass('nav-active');
			reports = $("#table-submitted-reports").DataTable({
				ajax: {
					url: "<?=base_url()?>ajax/get-user-submitted-reports",
					type: 'GET',
					dataSrc: ''
				},
				responsive:true,
				"order": [[ 4, "desc" ]],
				columns: [
				{ data: 'report_date' },
				{ "width": "8%", data: 'hw_report_id'},
				{ data: 'report_college' },
				{ data: 'report_department'},
				{ data: 'report_building'},
				{ data: 'report_status'},
				{ data: null}
				],
				columnDefs: [
					{
						"targets": 6,
						"data": 'hw_report_id',
						"render": function ( data, type, row ) {
							var html = "";
							var position_id = <?php echo $this->session->userdata('position_Id'); ?>;
							html += "<button class='btn btn-primary btn-sm btn-view-report' data-id='"+data.hw_report_id+"'>View Report</button> ";
							
							if(position_id == 1){
								if(data.report_status.indexOf("Rejected") !== -1) {
									// html += "<form method='post' action='edit_report' id='form_"+data.hw_report_id+"' ><input type='hidden' name='report_id' value='"+data.hw_report_id+"'>"
								// 	html += "<button class='btn btn-primary btn-sm btn-edit-report' data-id='"+data.hw_report_id+"'>Edit Report</button></form>";
								}
							}
							else if(position_id == 2){
								// data.report_status == "Pending"
								if (data.report_status.indexOf("Pending") !== -1) {

									// <textarea type="text" id="form8" class="md-textarea form-control" rows="4"></textarea>

									<?php $data_textarea = array('name' => 'textarea',
																'rows' => 4,
																'cols' => 50,
																'class' => 'md-textarea form-control'); ?>
									// echo form_textarea($data_textarea);

									html += "<div class='modal fade' id='modalContactForm" + data.hw_report_id + "' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'><form method='post' name='reject_form' action='reject-reason'><div class='modal-dialog' role='document'><div class='modal-content'><div class='modal-header text-center'><h4 class='modal-title w-100 font-weight-bold'>Reject Report Number " + data.hw_report_id + "</h4><button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><div class='modal-body mx-3'><div class='md-form'><i class='fas fa-pencil prefix grey-text'></i><label data-error='wrong' data-success='right' for='form8'>Please specify a reason: </label><br><textarea id='reason_text' name='reason_text' class='md-textarea form-control' rows='4' required='true'></textarea><input type='hidden' name='hw_report_id' id='hw_report_id' value='"+ data.hw_report_id +"' /></div></div><div class='modal-footer d-flex justify-content-center'><input type='submit' class='btn btn-success' value='Submit'/></div></div></div></form></div>";

									html +=  "<br><button class='btn btn-success btn-sm btn-approve' data-id='"+data.hw_report_id+"'>Approve</button> <button class='btn btn-danger btn-sm btn-reject' data-id='"+data.hw_report_id+"' data-toggle='modal' data-target='#modalContactForm" + data.hw_report_id + "'>Reject</button>";
								}
							}

							return html;
						} 
					}
					]
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
				  		reports.ajax.reload();
				  	}
				  });
				} else {
					return false;
				}
			});

			// $(document).on('click', '.btn-reject', function(data) {
			// 	var report_id = $(this).attr('data-id');
			// 	var status = "Rejected";
			// 	var r = confirm("Are you sure you want to reject this report?");
			// 	if (r == true) {
			// 	  $.ajax({
			// 	  	url: "<?=base_url()?>ajax/update-report-status",
			// 	  	type: "POST",
			// 	  	data: {
			// 	  		report_id: report_id,
			// 	  		status: status
			// 	  	},
			// 	  	success: function(data) {
			// 	  		alert("Report Successfully Rejected");
			// 	  		reports.ajax.reload();
			// 	  	}
			// 	  });
			// 	} else 			// 		return false;
			// 	}
			// });

			$(document).on('click', '.btn-reject', function(data) {
				
			});

			$(document).on('click', '.btn-view-report', function(data) {
				var report_id = $(this).attr('data-id');
				window.location.href = "<?=base_url()?>report/"+report_id;
			});

			$(document).on('click', '.btn-edit-report', function(data) {
				var form_id = "#form_" + $(this).attr('data-id');
				$(form_id).submit();
			});

			

	});
</script>