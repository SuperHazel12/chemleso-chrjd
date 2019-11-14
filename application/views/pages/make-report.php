<div class="page-body">
	<div class="container">
		<div class="section-title">
			<h3>Make Waste Report</h3>
		</div>
		<div class="section-bod">
			<?php 
				if($this->session->flashdata('errors')): 
					echo "<font color='red'>" . $this->session->flashdata('errors') . "</font>";
				endif;

				if($this->session->flashdata('server_errors')):
					echo "<font color='red'>" . $this->session->flashdata('server_errors') . "</font>";
				endif;

				if($this->session->flashdata('college')):

				endif;
			?>
			<form id="form-addadmin" method="post" action="insert">
			<form id="form-add-waste-report" method="post">
				<div class="form-group">
					<input type="hidden" name="hw_report_id" value=<?php echo $this->session->flashdata('hw_report_id') ? 
									$this->session->flashdata('hw_report_id') : '' ?> />
                	<div class="row">
						<div class="col-md-6">
							<div class="label-input">College <span class="required">*</span></div>
							<select class="form-control required-input" name="college" id="college" data-parsley-required="true">
		                    	
		                	</select>
						</div>
						<div class="col-md-6">
							<div class="label-input">Department <span class="required">*</span></div>
							<select class="form-control required-input" name="department" id="department" data-parsley-required="true">
								<option value="">Select Department</option>
								
	                    	</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
							<div class="label-input">Building <span class="required">*</span></div>
							<select class="form-control required-input" name="building" id="building" data-parsley-required="true">
                            	
                        	</select>	
						</div>
						<div class="col-md-6">
							<div class="label-input">Laboratory Number <span class="required">*</span></div>
							<input type="text" class="form-control required-input" name="laboratory_number" id="laboratory_number" 
								value=<?php echo $this->session->flashdata('laboratory_number') ? 
									$this->session->flashdata('laboratory_number') : '' ?> >
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-4">
							<div class="label-input">Contact Person <span class="required">*</span></div>
							<input type="text" class="form-control required-input" name="contact_person" id="contact_person" 
							 	value=<?php echo $this->session->flashdata('contact_person') ? $this->session->flashdata('contact_person') : '' ?>>
						</div>
						<div class="col-md-4">
							<div class="label-input">Contact Number <span class="required">*</span></div>
							<input type="text" class="form-control required-input" name="contact_person_number" id="contact_person_number" 
							 	value=<?php echo $this->session->flashdata('contact_person_number') ? $this->session->flashdata('contact_person_number') : '' ?>>
						</div>
						<div class="col-md-4">
							<div class="label-input">Date <span class="required">*</span></div>
							<input type="date" class="form-control required-input" name="date" id="date" 
							 	value=<?php echo $this->session->flashdata('date') ? $this->session->flashdata('date') : '' ?>>
						</div>
					</div>
				</div>
			<hr>
			<div class="chem-table-fields">
			<div class="form-group chem-fields"> 
			</form>
			<div class="form-group"> 
					<div class="row">
						<div class="col-md-12">
							<table id="table-chem-fields" class="table table-hover" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th width="15%">HW No/Class</th>
										<th width="15%">HW Catalogue</th>
										<th width="15%">HW Nature</th>
										<th width="15%">Bottle Number</th>
										<th width="15%">Sticker Number</th>
										<th width="10%">Remaining Qty.</th>
										<th width="10%">Remaining Unit</th>
										<th width="10%">Quantity in kg</th>
										<th width="10%">Quantity Unit</th>
										<th width="8%">Action</th>
									</tr>
								</thead>
								<tbody class="tbody-chem-fields">

									<?php $waste_reports = $this->session->flashdata('waste_reports'); 
										if (is_array($waste_reports) || is_object($waste_reports)) {
									?>
									<?php foreach($waste_reports as $report) { ?>
									<tr id="tr-chem-field0">
										<td>
										<select class="form-control required-input hw_number" name="hw_number[]" id="hw_number" data-parsley-required="true">
											<option value="">Select HW Class</option>
			                            	<option value="A101" <?php echo ($report->hw_number == "A101") ? "selected" : '' ?> >A101 - Cyanide</option>
											<option value="B201" <?php echo ($report->hw_number == "B201") ? "selected" : '' ?> >B201 - Sulfuring Acid</option>
											<option value="B202" <?php echo ($report->hw_number == "B202") ? "selected" : '' ?> >B202 - Hydrochloric Acid</option>
											<option value="B203" <?php echo ($report->hw_number == "B203") ? "selected" : '' ?> >B203 - Nitric Acid</option>
											<option value="B204" <?php echo ($report->hw_number == "B204") ? "selected" : '' ?> >B204 - Phosphoric Acid</option>
											<option value="B205" <?php echo ($report->hw_number == "B205") ? "selected" : '' ?> >B205 - Hydrofluoric Acid</option>
											<option value="B206" <?php echo ($report->hw_number == "B206") ? "selected" : '' ?> >B206 - Mixture, Hydrochloric & Sulfuric Acid</option>
											<option value="B207" <?php echo ($report->hw_number == "B207") ? "selected" : '' ?> >B207 - Other Inorganic Acid</option>
											<option value="B208" <?php echo ($report->hw_number == "B208") ? "selected" : '' ?> >B208 - Organic Acid</option>
											<option value="B299" <?php echo ($report->hw_number == "B299") ? "selected" : '' ?> >B299 - Other Acid Wastes</option>
											<option value="C301" <?php echo ($report->hw_number == "C301") ? "selected" : '' ?> >C301 - Caustic Soda</option>
											<option value="C302" <?php echo ($report->hw_number == "C302") ? "selected" : '' ?> >C302 - Potash</option>
											<option value="C304" <?php echo ($report->hw_number == "C304") ? "selected" : '' ?> >C304 - Ammonium Hydroxide</option>
											<option value="C399" <?php echo ($report->hw_number == "C399") ? "selected" : '' ?> >C399 - Other Alkali Wastes</option>
											<option value="D401" <?php echo ($report->hw_number == "D401") ? "selected" : '' ?> >D401 - Selenium and its compounds</option>
											<option value="D402" <?php echo ($report->hw_number == "D402") ? "selected" : '' ?> >D402 - Arsenic and its compounds</option>
											<option value="D403" <?php echo ($report->hw_number == "D403") ? "selected" : '' ?> >D403 - Barium and its compounds</option>
											<option value="D404" <?php echo ($report->hw_number == "D404") ? "selected" : '' ?> >D404 - Cadmium and its compounds</option>
											<option value="D405" <?php echo ($report->hw_number == "D405") ? "selected" : '' ?> >D405 - Chromium and its compounds</option>
											<option value="D406" <?php echo ($report->hw_number == "D406") ? "selected" : '' ?> >D406 - Lead and its compounds</option>
											<option value="D407" <?php echo ($report->hw_number == "D407") ? "selected" : '' ?> >D407 - Mercury and its compounds</option>
											<option value="D408" <?php echo ($report->hw_number == "D408") ? "selected" : '' ?> >D408 - Fluoride and its compounds</option>
											<option value="D499" <?php echo ($report->hw_number == "D499") ? "selected" : '' ?> >D499 - Other wastes with Inorganic chemicals</option>
											<option value="E501" <?php echo ($report->hw_number == "E501") ? "selected" : '' ?> >E501 - Oxidizing Agents</option>
											<option value="E502" <?php echo ($report->hw_number == "E502") ? "selected" : '' ?> >E502 - Reducing Agents</option>
											<option value="E503" <?php echo ($report->hw_number == "E503") ? "selected" : '' ?> >E503 - Explosive and Unstable Chemicals</option>
											<option value="E599" <?php echo ($report->hw_number == "E599") ? "selected" : '' ?> >E599 - Highly Reactive Chemicals</option>
											<option value="F601" <?php echo ($report->hw_number == "F601") ? "selected" : '' ?> >F601 - Solvent based dyes</option>
											<option value="F699" <?php echo ($report->hw_number == "F699") ? "selected" : '' ?> >F699 - Other mixed dyes</option>
											<option value="G703" <?php echo ($report->hw_number == "G703") ? "selected" : '' ?> >G703 - Halogenated Organic Solvents</option>
			                        	</select>
			                        	</td>
			                        	<td>
			                        	<select class="form-control required-input hw_catalog" name="hw_catalog[]" id="hw_catalog" data-parsley-required="true">
											<option value="">Select HW Catalogue</option>
			                            	<option value="Flammable" <?php echo ($report->hw_catalogue) == "Flammable"  ? "selected" : '' ?> >Flammable</option>
			                            	<option value="Toxic" <?php echo ($report->hw_catalogue == "Toxic" ) ? "selected" : '' ?> >Toxic</option>
			                            	<option value="Corrosive" <?php echo ($report->hw_catalogue == "Corrosive") ? "selected" : '' ?> >Corrosive</option>
			                            	<option value="Oxidizing" <?php echo ($report->hw_catalogue == "Oxidizing") ? "selected" : '' ?> >Oxidizing</option>
			                            	<option value="Reducing" <?php echo ($report->hw_catalogue == "Reducing") ? "selected" : '' ?> >Reducing</option>
			                        	</select>
			                        	</td>
			                        	<td>
			                        	<select class="form-control required-input hw_nature" name="hw_nature[]" id="hw_nature" data-parsley-required="true">
											<option value="">Select HW Nature</option>
			                            	<option value="Liquid" <?php echo ($report->hw_nature == "Liquid") ? "selected" : '' ?>>Liquid</option>
			                            	<option value="Solid" <?php echo ($report->hw_nature == "Solid") ? "selected" : '' ?>>Solid</option>
			                        	</select>	
                        				</td>
										<td><input type="text" class="form-control required-input bottle_number" name="bottle_number[]" id="bottle_number" value=<?php echo ($report->report_bottle_num) ? $report->report_bottle_num : "" ?> ></td>
										<td><input type="text" class="form-control required-input sticker_number" name="sticker_number[]" id="sticker_number" value=<?php echo ($report->report_sticker_num) ? $report->report_sticker_num : "" ?> ></td>
										<td><input type="number" step="any" class="form-control required-input remainig_qty" name="remainig_qty[]" id="remainig_qty" min="0" value=<?php echo ($report->report_remain_waste) ? $report->report_remain_waste : "0" ?> ></td>
										<td>Kg.</td>
										<td><input type="number" step="any" class="form-control required-input qty_kg" name="qty_kg[]" id="qty_kg" min="0" value=<?php echo ($report->report_quantity) ? $report->report_quantity : "0" ?> ></td>
										<td>Kg.</td>
										<td></td>
									</tr>
								<?php } 
									}else {	?>
										<tr id="tr-chem-field0">
										<td>
										<select class="form-control required-input hw_number" name="hw_number[]" id="hw_number" data-parsley-required="true">
											<option value="">Select HW Class</option>
			                            	<option value="A101"  >A101 - Cyanide</option>
											<option value="B201"  >B201 - Sulfuring Acid</option>
											<option value="B202"  >B202 - Hydrochloric Acid</option>
											<option value="B203"  >B203 - Nitric Acid</option>
											<option value="B204"  >B204 - Phosphoric Acid</option>
											<option value="B205"  >B205 - Hydrofluoric Acid</option>
											<option value="B206"  >B206 - Mixture, Hydrochloric & Sulfuric Acid</option>
											<option value="B207"  >B207 - Other Inorganic Acid</option>
											<option value="B208"  >B208 - Organic Acid</option>
											<option value="B299"  >B299 - Other Acid Wastes</option>
											<option value="C301"  >C301 - Caustic Soda</option>
											<option value="C302"  >C302 - Potash</option>
											<option value="C304"  >C304 - Ammonium Hydroxide</option>
											<option value="C399"  >C399 - Other Alkali Wastes</option>
											<option value="D401"  >D401 - Selenium and its compounds</option>
											<option value="D402"  >D402 - Arsenic and its compounds</option>
											<option value="D403"  >D403 - Barium and its compounds</option>
											<option value="D404"  >D404 - Cadmium and its compounds</option>
											<option value="D405"  >D405 - Chromium and its compounds</option>
											<option value="D406"  >D406 - Lead and its compounds</option>
											<option value="D407"  >D407 - Mercury and its compounds</option>
											<option value="D408"  >D408 - Fluoride and its compounds</option>
											<option value="D499"  >D499 - Other wastes with Inorganic chemicals</option>
											<option value="E501"  >E501 - Oxidizing Agents</option>
											<option value="E502"  >E502 - Reducing Agents</option>
											<option value="E503"  >E503 - Explosive and Unstable Chemicals</option>
											<option value="E599"  >E599 - Highly Reactive Chemicals</option>
											<option value="F601"  >F601 - Solvent based dyes</option>
											<option value="F699"  >F699 - Other mixed dyes</option>
											<option value="G703"  >G703 - Halogenated Organic Solvents</option>
			                        	</select>
			                        	</td>
			                        	<td>
			                        	<select class="form-control required-input hw_catalog" name="hw_catalog[]" id="hw_catalog" data-parsley-required="true">
											<option value="">Select HW Catalogue</option>
			                            	<option value="Flammable"  >Flammable</option>
			                            	<option value="Toxic"  >Toxic</option>
			                            	<option value="Corrosive"  >Corrosive</option>
			                            	<option value="Oxidizing"  >Oxidizing</option>
			                            	<option value="Reducing"  >Reducing</option>
			                        	</select>
			                        	</td>
			                        	<td>
			                        	<select class="form-control required-input hw_nature" name="hw_nature[]" id="hw_nature" data-parsley-required="true">
											<option value="">Select HW Nature</option>
			                            	<option value="Liquid" >Liquid</option>
			                            	<option value="Solid" >Solid</option>
			                        	</select>	
                        				</td>
										<td><input type="text" class="form-control required-input bottle_number" name="bottle_number[]" id="bottle_number" value= ></td>
										<td><input type="text" class="form-control required-input sticker_number" name="sticker_number[]" id="sticker_number" value= ></td>
										<td><input type="number" step="any" class="form-control required-input remainig_qty" name="remainig_qty[]" id="remainig_qty" min="0" value="0" ></td>
										<td>Kg.</td>
										<td><input type="number" step="any" class="form-control required-input qty_kg" name="qty_kg[]" id="qty_kg" min="0" value="0" ></td>
										<td>Kg.</td>
										<td></td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<button type="button" class="btn btn-primary btn-add-chem-waste my-3">Add Chemical Waste</button>

			<div class="row">
				<div class="col-md-9" >
				</div>
				<div class="col-md-3">
					<button type="button" class='btn btn-primary confirm-submit-btn'>Submit</button>
				</div>
			</div>
				<div class="modal fade modal-fade-in-scale-up" id="confirm-submit-modal" aria-hidden="true" aria-labelledby="exampleModalTitle"
				role="dialog" tabindex="-1">
				<div class="modal-dialog modal-simple">
					<div class="modal-content">
						<div class="modal-header bgc-primary">
							<h5 class="modal-title">Are you sure you want to submit?</h5>
						</div>
						<div class="modal-body">
							<p>You will not be able to edit this report while it's in Pending status.</p>
						</div>
						<div class="modal-footer">
							<button type="button" class='btn btn-primary no-btn'>No</button>
							<button type="button" class='btn btn-primary yes-btn'>Yes</button>
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>

<script>
	var chem_field = 1;
	$(document).ready(function() {
		$('#make-report a').removeClass('nav-color');
		$('#make-report a').addClass('nav-active');
		$.ajax({
			url: "<?=base_url()?>ajax/get-college",
			type: 'POST',
			success: function (data) {
				var college_select = $('#college');
				var department_select = $('#department');
				var building_select = $('#building');
				$.each(JSON.parse(data), function (val, text) {
					if(val == "college_name") {
						college_select.append($('<option></option>').attr("value", text)
																.attr("selected","selected")
																.text(text));
					}

					if(val == "building_name") {
						building_select.append($('<option></option>').attr("value", text)
																.attr("selected","selected")
																.text(text));
					}

					if(val == "departments") {
						$.each(text, function(index, value) {
							if(text.length > 1) {
								department_select.append($('<option></option>').attr("value", value)	
																			.text(value));
							}else{
								department_select.append($('<option></option>').attr("value", value)
																			.attr("selected","selected")	
																			.text(value));
							}
						});
					}
					

				});
			}
		 });

		$(document).on('click', '.btn-add-chem-waste', function() {
					$('.tbody-chem-fields').append('<tr id="tr-chem-field'+chem_field+'"> <td> <select class="form-control required-input hw_number" name="hw_number[]" id="hw_number" data-parsley-required="true">'+
											'<option value="">Select HW</option>'+
			                            	'<option value="A101">A101 - Cyanide</option>' + 
											'<option value="B201">B201 - Sulfuring Acid</option>' + 
											'<option value="B202">B202 - Hydrochloric Acid</option>' + 
											'<option value="B203">B203 - Nitric Acid</option>' + 
											'<option value="B204">B204 - Phosphoric Acid</option>' + 
											'<option value="B205">B205 - Hydrofluoric Acid</option>' + 
											'<option value="B206">B206 - Mixture, Hydrochloric & Sulfuric Acid</option>' + 
											'<option value="B207">B207 - Other Inorganic Acid</option>' + 
											'<option value="B208">B208 - Organic Acid</option>' + 
											'<option value="B299">B299 - Other Acid Wastes</option>' + 
											'<option value="C301">C301 - Caustic Soda</option>' + 
											'<option value="C302">C302 - Potash</option>' + 
											'<option value="C304">C304 - Ammonium Hydroxide</option>' + 
											'<option value="C399">C399 - Other Alkali Wastes</option>' + 
											'<option value="D401">D401 - Selenium and its compounds</option>' + 
											'<option value="D402">D402 - Arsenic and its compounds</option>' + 
											'<option value="D403">D403 - Barium and its compounds</option>' + 
											'<option value="D404">D404 - Cadmium and its compounds</option>' + 
											'<option value="D405">D405 - Chromium and its compounds</option>' + 
											'<option value="D406">D406 - Lead and its compounds</option>' + 
											'<option value="D407">D407 - Mercury and its compounds</option>' + 
											'<option value="D408">D408 - Fluoride and its compounds</option>' + 
											'<option value="D499">D499 - Other wastes with Inorganic chemicals</option>' + 
											'<option value="E501">E501 - Oxidizing Agents</option>' + 
											'<option value="E502">E502 - Reducing Agents</option>' + 
											'<option value="E503">E503 - Explosive and Unstable Chemicals</option>' + 
											'<option value="E599">E599 - Highly Reactive Chemicals</option>' + 
											'<option value="F601">F601 - Solvent based dyes</option>' + 
											'<option value="F699">F699 - Other mixed dyes</option>' + 
											'<option value="G703">G703 - Halogenated Organic Solvents</option>' + 
			                        	'</select> </td>'+
			                        	'<td><select class="form-control required-input hw_catalog" name="hw_catalog[]" id="hw_catalog" data-parsley-required="true">' +
											'<option value="">Select HW Catalogue</option>' +
			                            	'<option value="Flammable">Flammable</option>' +
			                            	'<option value="Toxic">Toxic</option>' +
			                            	'<option value="Corrosive">Corrosive</option>' +
			                            	'<option value="Oxidizing">Oxidizing</option>' +
			                            	'<option value="Reducing">Reducing</option>' +
			                        	'</select></td><td><select class="form-control required-input hw_nature" name="hw_nature[]" id="hw_nature" data-parsley-required="true">' + 
											'<option value="">Select HW Nature</option>' +
			                            	'<option value="Liquid">Liquid</option>' + 
			                            	'<option value="Solid">Solid</option>' +
			                        	'</select></td>' +
										'<td><input type="text" class="form-control required-input bottle_number" name="bottle_number[]" id="bottle_number"></td>'+
										'<td><input type="text" class="form-control required-input sticker_number" name="sticker_number[]" id="sticker_number"></td>'+
										'<td><input type="number" class="form-control required-input remainig_qty" name="remainig_qty[]" id="remainig_qty" step="any" min="0" value="0"></td>'+
										'<td>Kg.</td>'+
										'<td><input type="number" class="form-control required-input qty_kg" name="qty_kg[]" id="qty_kg" step="any" min="0" value="0"></td>'+
										'<td>Kg.</td>'+
									'<td><button type="button" class="btn btn-danger btn-delete-field" data-id="'+chem_field+'">Delete</button></td></tr>');
					chem_field++;
		});

		$(document).on('click', '.btn-delete-field', function() {
			var field_no = $(this).attr('data-id');
			// alert(field_no);
			$('#tr-chem-field'+field_no).remove();
		});

		$(document).on('click', '.confirm-submit-btn', function() {
			$('#confirm-submit-modal').modal('show');
		});

		$(document).on('click', '.yes-btn', function() {
			$('#form-addadmin').submit();
		});

		$(document).on('click', '.no-btn', function() {
			$('#confirm-submit-modal').modal('hide');
		});


	});
</script>