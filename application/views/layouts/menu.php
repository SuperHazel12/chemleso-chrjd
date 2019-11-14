<body>
<div class="nav-top container-fluid">
	<div class="row" >
		<img style="margin-left: 1em;" class="nav-logo" src="<?=base_url()?>assets/img/logos/ust.png">
		<img class="nav-logo mx-3" src="<?=base_url()?>assets/img/logos/leso.png">
		<div class="col col-md-8 ">
			<div class="div-nav-heading" >
				<span class="nav-heading-top">
					UNIVERSITY OF SANTO TOMAS
				</span>
			</div>
			<div class="div-nav-heading" >
				<span class="nav-title">
					<b>Chemical Waste Management System</b>
				</span>
			</div>
			<div class="div-nav-heading" >
				<span class="nav-heading-bottom">
					LABORATORY EQUIPMENTS AND SUPPLIES OFFICE
				</span>
			</div>
			
		</div>
	</div>

	<div class="row" >
		<div class="col col-md-8"> 
			
		</div>	
	</div>
	
</div>
<nav class="navbar navbar-expand-sm navbar-dark bg-custom">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarsExample03">
		<ul class="navbar-nav mr-auto">
			<li id="home" class="nav-item">
				<a class="nav-link nav-color" href="<?=base_url()?>home">Home <span class="sr-only">(current)</span></a>
			</li>
			<?php $position_id = $this->session->userdata('position_Id');
			 	if ($position_id == 1) { ?>
				<li id="make-report" class="nav-item">
					<a class="nav-link nav-color" href="<?=base_url()?>make-report">Make Waste Report</a>
				</li>
				<li id="submitted-reports" class="nav-item">
					<a class="nav-link nav-color" href="<?=base_url()?>submitted-reports">Submitted Reports</a>
				</li>
				<li id="archive-reports" class="nav-item">
					<a class="nav-link nav-color" href="<?=base_url()?>archive-reports">Archived Reports</a>
				</li>	
			<?php } elseif ($position_id == 3) { ?>
				<li id="account-management" class="nav-item">
					<a class="nav-link nav-color" href="<?=base_url()?>account-management">Account Management</a>
				</li>
			<?php } elseif ( $position_id == 2) { ?>
				<li id="submitted-reports" class="nav-item">
					<a class="nav-link nav-color" href="<?=base_url()?>submitted-reports">Submitted Reports</a>
				</li>
				<li id="compiled-reports" class="nav-item">
					<a class="nav-link nav-color" href="<?=base_url()?>compiled-reports">Compiled Reports</a>
				</li>
				<li id="announcements" class="nav-item dropdown">
					<a class="nav-link nav-color dropdown-toggle nav-home-announcements" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Make Announcements
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="<?=base_url()?>announcement/create-distributions">Distribution of Glasswares</a>
						<a class="dropdown-item" href="<?=base_url()?>announcement/create-reminders">Reminders</a>
						<a class="dropdown-item" href="<?=base_url()?>announcement/create-seminars">Seminars</a>
						<a class="dropdown-item" href="<?=base_url()?>announcement/create-deadlines">Deadlines</a>
						<!-- <div class="dropdown-divider"></div> -->
					</div>
				</li>
				<li id="archive-reports" class="nav-item">
					<a class="nav-link nav-color" href="<?=base_url()?>archive-reports">Archived Reports</a>
				</li>	
			<?php } ?>
		</ul>
		<?php if($this->session->userdata('position_Id') == 1) {  ?>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a class="nav-link nav-color dropdown-toggle nav-notif" data-toggle="dropdown"><font color="red"><span class="label label-pill label-danger count" style="border-radius:10px;"></span></font> <span class="glyphicon glyphicon-envelope" style="font-size:18px;"></span>Notification</a>
					<ul class="dropdown-menu" id="notification"></ul>
				</li>
			</ul>
		<?php } ?>


		<ul class="navbar-nav">	
			<li class="nav-item dropdown">
				<a class="nav-link nav-color dropdown-toggle nav-user" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?= $this->session->userdata('username'); ?>
				</a>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="<?=base_url()?>change-password">Change Password</a>
					<a class="dropdown-item" href="<?=base_url()?>logout">Sign Out</a>
					<!-- <div class="dropdown-divider"></div> -->
				</div>
			</li>
		</ul>
	</div>
</nav>