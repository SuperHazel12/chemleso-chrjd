<div class="page-body">
	<div class="container">
		<div class="section-title">
			<h3>Compiled Reports</h3>
		</div>
		<div class="section-body">
			<div class="row">
				<div class="col-md-6">
				</div>
				<div class="col-md-2">
					<select class="form-control required-input" name="year" id="year" data-parsley-required="true">
				    	<option value="2019">2019</option>
				    	<option value="2018">2018</option>
				    </select>
				</div>
				<div class="col-md-2">
					<select class="form-control required-input" name="quarter" id="quarter" data-parsley-required="true">
				    	<option value="1" selected>1st Quarter (January 1 to March 30)</option>
				    	<option value="2">2nd Quarter (February 1 to June 30)</option>
				    	<option value="3">3rd Quarter (July 1 to September 30)</option>
				    	<option value="4">4th Quarter (October 1 to December 31)</option>
				    </select>
				</div>
				<div class="col-md-2">
					<button type="button" id="btn-export" class="btn btn-primary mb-3">Export to PDF</button>
				</div>
			</div>
			<table id="table-compiled-reports" class="table table-hover dt-responsive" cellspacing="0" width="100%">
				<thead>
		            <tr>
		                <th rowspan="2">HW Number</th>
		                <th rowspan="2">HW Class</th>
						<th rowspan="2">HW Catalouging</th>
						<th rowspan="2">HW Nature</th>
		                <th colspan="2">Remaining Quantity</th>
		                <th colspan="2">Quantity in Kg</th>
		            </tr>
		            <tr>
		                <th>Quantity</th>
				        <th>Unit</th>
		                <th>Quantity</th>
				        <th>Unit</th>
		            </tr>
	       		</thead>
			</table>

		</div>
	</div>
</div>

	
	
<script>
	var reports;
	var year;
	var quarter;
	$(document).ready(function() {
		year = $('#year').val();
		quarter  = $('#quarter').val();
		$('#compiled-reports a').removeClass('nav-color');
		$('#compiled-reports a').addClass('nav-active');
			
		GetCompiledReports();
			$(document).on('change', '#year', function() {
				year = $(this).val();
				reports.destroy();
				GetCompiledReports();
			});

			$(document).on('change', '#quarter', function() {
				quarter = $(this).val();
				reports.destroy();
				GetCompiledReports();
			});

			$(document).on('click', '#btn-export', function() {
				window.open('<?=base_url()?>compiled-reports/export/'+year+'/'+quarter, '_blank');
			});
	});

	function GetCompiledReports() {
		reports = $("#table-compiled-reports").DataTable({
				ajax: {
					url: "<?=base_url()?>ajax/get-user-compiled-reports",
					type: 'POST',
					data: {
						year: year,
						quarter: quarter
					},
					dataSrc: ""
				},
				responsive:true,
				"order": [[ 4, "desc" ]],
				columns: [
				{ data: 'hw_number' },
				{ data: 'hw_class'},
				{ data: 'hw_catalogue' },
				{ data: 'hw_nature'},
				{ data: 'remain_waste'},
				{ data: null,
					render: function (data) {
							return "kg";
						} 
				},
				{ data: 'report_quantity'},
				{ data: null,
					render: function (data) {
							return "kg";
						} 
				},
				]
		});
	}
</script>