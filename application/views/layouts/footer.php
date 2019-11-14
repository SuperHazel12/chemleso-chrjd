		<footer class="footer">
			<div class="container text-center">
				<span class="footer-copyright">Copyright &copy; <?= date('Y') ?> UST LESO. All Rights Reserved.</span>
			</div>
		</footer>

		<?php if($this->session->userdata('position_Id') == 1) {  ?>
		<script>
			$(document).ready(function(){
 
				function load_unseen_notification(view = '')
				{
					$.ajax({
						url:"<?=base_url()?>ajax/fetch-report-records",
						method:"POST",
						data:{view:view},
						success:function(data)
						{
							// console.log("data: " + data);

							var result = JSON.parse(data);

							// console.log("notification: " + result.notification);
							// console.log('unseen: ' + result.unseen_notification);

							$('#notification').html(result.notification);
							if(result.unseen_notification > 0)
							{
								$('.count').html(result.unseen_notification);
							}
						},
						error:function(req, status, error)
						{
							console.log("req: " + req);
							console.log("status: " + status);
							console.log("error: " + error);
						}
					});
				}

				load_unseen_notification();


				$(document).on('click', '.dropdown-toggle', function(){
					$('.count').html('');
					load_unseen_notification('yes');
				});

				setInterval(function(){ 
					load_unseen_notification();
				}, 5000);

			});
		</script>
		<?php } ?>

	</body>
	</html>