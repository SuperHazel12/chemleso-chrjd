<div class="page-body">
	<div class="container">
		<div class="section-title">
			<h3>Archived Reports</h3>
		</div>
		<div class="section-body">
			<table id="table-archive-reports" class="table table-hover dt-responsive" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Date</th>
						<th>Report Number</th>
						<th>College</th>
						<th>Department</th>
						<th>Building</th>
						<th>Date Archived</th>
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
						<th>Date Archived</th>
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
		$('#archive-reports a').removeClass('nav-color');
		$('#archive-reports a').addClass('nav-active');
			reports = $("#table-archive-reports").DataTable({
				ajax: {
					url: "<?=base_url()?>ajax/get-all-archive-reports",
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
				{ data: 'report_datedeleted'},
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
							

							return html;
						} 
					}
					]
		});

			$(document).on('click', '.btn-view-report', function(data) {
				var report_id = $(this).attr('data-id');
				window.location.href = "<?=base_url()?>report/"+report_id;
			});
			

	});
</script>