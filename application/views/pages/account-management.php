<div class="page-body">
	<div class="container">
		<div class="section-title">
			<h3>Account Management</h3>
		</div>
		<div class="section-body">
			<button type="button" class="btn btn-primary mb-3" id="btn-add-account">Add Account</button>
			<table id="users" class="table table-hover dt-responsive" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="hidden">ID</th>
						<th>Username</th>
						<th>Position</th>
						<th>College</th>
						<th>Date Created</th>
						<th>Date Modified</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th class="hidden">ID</th>
						<th>Username</th>
						<th>Position</th>
						<th>College</th>
						<th>Date Created</th>
						<th>Date Modified</th>
						<th>Actions</th>
					</tr>
				</tfoot>
			</table>

		</div>
	</div>
</div>

<!-- Add Account Modal -->
	<div class="modal fade modal-fade-in-scale-up" id="add-account-modal" aria-hidden="true" aria-labelledby="exampleModalTitle"
	 role="dialog" tabindex="-1">
		<div class="modal-dialog modal-simple">
			<div class="modal-content">
				<div class="modal-header bgc-primary">
					<h4 class="modal-title white mt-15">Add New Account</h4>
					<button type="button" class="close white" data-dismiss="modal" aria-label="Close">
			       	 	<span aria-hidden="true">×</span>
			        </button>
				</div>
				<div class="modal-body mt-15">
					<form id="form-addadmin" method="post">
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<div class="label-input">Username <span class="required">*</span></div>
									<input type="text" class="form-control form-input" id="username" name="username">
								</div>
								<div class="col-md-6">
									<div class="label-input">Password <span class="required">*</span></div>
									<input type="text" class="form-control form-input" id="pword" name="pword" readonly>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="label-input">Position <span class="required">*</span></div>
							<select class="form-control required-input" name="position" id="position" data-parsley-required="true">
                            	<option value="">Select Position</option>
                            	<option value="1">Staff</option>
                            	<option value="2">Admin</option>
                            	<option value="3">System Admin</option>
                        	</select>
						</div>
						<div class="form-group">
							<div class="label-input">College <span class="required">*</span></div>
							<select class="form-control required-input" name="college" id="college" data-parsley-required="true">
                            	<option value="" selected="selected">Select College</option>
                        	</select>
						</div>
					</form>
					<div class="message"></div>
				</div>
				<div class="modal-footer">
						<button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
						<button type="button" id="btn-confirm-add-account" class="btn btn-primary">Confirm</button>
				</div>
			</div>
		</div>
	</div>
	<!-- End Add Account Modal -->

<script>
	var users;
	$(document).ready(function() {
		$('#account-management a').removeClass('nav-color');
		$('#account-management a').addClass('nav-active');
			users = $("#users").DataTable({
				ajax: {
					url: "<?=base_url()?>ajax/get-all-users",
					dataSrc: ''
				},
				responsive:true,
				"order": [[ 5, "desc" ]],
				columns: [
				{ data: 'user_id'},
				{ data: 'username' },
				{ data: 'position' },
				{ data: 'college_id'},
				{ data: 'created_at'},
				{ data: 'updated_at' },
				{ defaultContent: "<button class='btn btn-danger btn-sm btn-delete'>Delete</button>"}
				],
				columnDefs: [
				{ className: "hidden", "targets": [0]},
				{ className: "acct-name", "targets": [1]},
				]
		});


		$.ajax({
			url: "<?=base_url()?>ajax/get-all-colleges",
			type: 'POST',
			success: function (data) {
				var college_select = $('#college');
				$.each(JSON.parse(data), function (val, text) {
					if(this.college_id !== '0') {
						college_select.append($('<option></option>').attr("value", this.college_id)
																	.text(this.college_name));
					}
				});

				college_select.append($('<option></option>').attr("value", '0')
															.text("N/A"));
			}
		 });

		$(document).on('click', '#btn-add-account', function() {
			$('#add-account-modal').modal('show');
			$.ajax({
                url: '<?=base_url()?>ajax/get-new-password',
                type: 'GET',
                success:function(data) {
                	var result = JSON.parse(data);
                	$('#pword').val(result.password);
                }
            });
		});

		$(document).on('click', '#btn-confirm-add-account', function() {
			$.ajax({
                url: '<?=base_url()?>ajax/add-new-account',
                type: 'POST',
                data: {
                	username: $('#username').val(),
                	password: $('#pword').val(),
                	position: $('#position').val(),
                	college:  $('#college').val()
                },
                success:function(data) {
                	$('#add-account-modal').modal('hide');
                	alert("Account Successfully Added!");
                	users.ajax.reload();
                }
            });
		});

		$(document).on('click', '.btn-delete', function() {
			var id = $(this).closest('tr').find('td').eq(0).text();
			$.ajax({
                url: '<?=base_url()?>ajax/delete-account',
                type: 'POST',
                data: {
                	id: id,
                },
                success:function(data) {
                	$('#add-account-modal').modal('hide');
                	alert("Account Successfully Deleted!");
                	users.ajax.reload();
                }
            });
		});

	});
</script>