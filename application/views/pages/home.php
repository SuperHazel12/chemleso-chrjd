<div class="page-body">
	<div class="container">
		<div class="section-title">
			<h3>Announcement</h3>
			<div class="announce-images">
				<div class="row">
					<div class="col-md-3">
						<a href="<?=base_url()?>category/1">
							<img src="<?=base_url()?>assets/img/logos/distribution.png">
						</a>
						<div class="announcement-text">
							<a href="<?=base_url()?>category/1"><h5>Distribution of Glasswares</h5></a>
						</div>
					</div>
					<div class="col-md-3">
						<a href="<?=base_url()?>category/2">
							<img src="<?=base_url()?>assets/img/logos/reminders.png">
						</a>
						<div class="announcement-text">
							<a href="<?=base_url()?>category/2"><h5>Reminders</h5></a>
						</div>
					</div>
					<div class="col-md-3">
						<a href="<?=base_url()?>category/3">
							<img src="<?=base_url()?>assets/img/logos/seminar.png">
						</a>
						<div class="announcement-text">
							<a href="<?=base_url()?>category/3"><h5>Seminars</h5></a>
						</div>
					</div>
					<div class="col-md-3">
						<a href="<?=base_url()?>category/4">
							<img src="<?=base_url()?>assets/img/logos/deadline.png">
						</a>
						<div class="announcement-text">
							<a href="<?=base_url()?>category/4"><h5>Deadlines</h5></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('#home a').removeClass('nav-color');
		$('#home a').addClass('nav-active');
	});
</script>