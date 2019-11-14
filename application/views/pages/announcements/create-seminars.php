<div class="page-body">
	<div class="container">
		<div class="col-md-12">
		<div class="announcement-title my-4">
			<h3>Seminars</h3>
		</div>
		<div class="section-body">
			<div class="form-group">
				<button type="button" id="btn-add-announcement" class="btn btn-primary">Add Seminar</button>
			</div>
			<div class="table-responsive">
			<table id="table-announcement" class="table table-hover dt-responsive" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="hidden">ID</th>
						<th>Title</th>
						<th>Description</th>
						<th>Date Created</th>
						<th>Date Modified</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th class="hidden">ID</th>
						<th>Title</th>
						<th>Description</th>
						<th>Date Created</th>
						<th>Date Modified</th>
						<th>Actions</th>
					</tr>
				</tfoot>
			</table>
			</div>
		</div>
		</div>
	</div>
</div>


<!-- Add Announcement Modal -->
	<div class="modal fade modal-fade-in-scale-up" id="add-announcement-modal" aria-hidden="true" aria-labelledby="exampleModalTitle"
	 role="dialog" tabindex="-1">
		<div class="modal-dialog modal-simple">
			<div class="modal-content">
				<div class="modal-header bgc-primary">
					<h4 class="modal-title white mt-15">Add New Announcement</h4>
					<button type="button" class="close white" data-dismiss="modal" aria-label="Close">
			       	 	<span aria-hidden="true">×</span>
			        </button>
				</div>
				<div class="modal-body mt-15">
					<form id="form-addadmin" method="post">
						<div class="form-group">
							<div class="label-input">Title <span class="required">*</span></div>
							<input type="text" class="form-control required-input" name="announcement-title" id="announcement-title">
						</div>
						<div class="form-group">
							<div class="label-input">Description <span class="required">*</span></div>
							<textarea class="form-control announcement-description required-input" id="announcement-description" name="announcement-description"></textarea>
						</div>
					</form>
					<div class="message"></div>
				</div>
				<div class="modal-footer">
						<!-- <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button> -->
						<button type="button" class="btn btn-primary btn-confirm-announcement">Confirm</button>
				</div>
			</div>
		</div>
	</div>
	<!-- End Add Account Modal -->


<script>
	var announcements;
	$(document).ready(function() {
			announcements = $("#table-announcement").DataTable({
				ajax: {
					url: "<?=base_url()?>ajax/get-announcement",
					dataSrc: '',
					type: "POST",
					data: {
						id: 3
					}
				},
				responsive:true,
				"order": [[ 4, "desc" ]],
				columns: [
				{ data: 'annc_id' },
				{ data: 'title'},
				{ data: 'description' },
				{ data: 'created_at' },
				{ data: 'updated_at'},
				{ defaultContent: "<button class='btn btn-info btn-sm btn-edit'>Edit</button> <button class='btn btn-danger btn-sm btn-delete'>Delete</button>"}
				],
				columnDefs: [
				{ className: "hidden", "targets": [0]},
				]
		});

		$(document).on('click', '#btn-confirm-add-announcement', function() {
			if(validate.standard('.required-input') == 0){
				$.ajax({
	                url: '<?=base_url()?>ajax/add-new-announcement',
	                type: 'POST',
	                data: {
	                	title: $('#announcement-title').val(),
	                	description: $('#announcement-description').val(),
	                	announcement_type_id: 3
	                },
	                success:function(data) {
	                	alert("Seminar Announcement Successfully Added!");
	                	location.reload();
	                }
	            });
			}
		});


		$(document).on('click', '#btn-confirm-edit-announcement', function() {
			var id = $(this).attr('data-id');
			if(validate.standard('.required-input') == 0){
				$.ajax({
	                url: '<?=base_url()?>ajax/update-announcement',
	                type: 'POST',
	                data: {
	                	title: $('#announcement-title').val(),
	                	description: $('#announcement-description').val(),
	                	id: id
	                },
	                success:function(data) {
	                	alert("Seminar Announcement Successfully Updated!");
	                	location.reload();
	                }
	            });
			}
		});


		$(document).on('click', '.btn-edit', function() {
			$('.validate_error_message').remove();
			$('.required-input').removeClass('err_inputs');
			$('.btn-confirm-announcement').attr('id', 'btn-confirm-edit-announcement');
			var id = $(this).closest('tr').find('td').eq(0).text();
			$('#btn-confirm-edit-announcement').attr('data-id', id);
			$.ajax({
                url: '<?=base_url()?>ajax/get-specific-announcement',
                type: 'POST',
                data: {
                	id: id
                },
                success:function(data) {
                	var result = JSON.parse(data);
                	$('#add-announcement-modal').modal('show');
                	$('#announcement-title').val(result[0].title);
                	$('#announcement-description').val(result[0].description);
                }
            });
		});


		$(document).on('click', '#btn-add-announcement', function() {
			$('#announcement-title').val("");
			$('.btn-confirm-announcement').attr('id', 'btn-confirm-add-announcement');
            $('#announcement-description').val("");
			$('#add-announcement-modal').modal('show');
		});

		$(document).on('click', '.btn-delete', function() {
			var id = $(this).closest('tr').find('td').eq(0).text();
			var r = confirm("Are you sure you want to delete this announcement?");
			if (r == true) {
			  $.ajax({
	                url: '<?=base_url()?>ajax/delete-announcement',
	                type: 'POST',
	                data: {
	                	id: id,
	                },
	                success:function(data) {
	                	$('#add-announcement-modal').modal('hide');
	                	alert("Announcement Successfully Deleted!");
	                	announcements.ajax.reload();
	                }
	            });
			} else {
				return false;
			}
		});
	});
</script>