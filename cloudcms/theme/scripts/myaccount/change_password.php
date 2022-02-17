<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<form action="" method="post">
					<div class="card">
						<div class="card-body">
							<?php
							$form = new Formr\Formr('bootstrap');
							
							
							// check if the form has been submitted
							if ($form->submitted())
							{
								if(strlen($_POST['password']) < 6){
									$form->error_message = "Password must be at least 6 characters";
								}
								else if($_POST['password'] != $_POST['retype_password']){
									$form->error_message = "Password and Retype Password must be the same";
								}
								else {
        							$item = new Admin($db);
    								$item->id = $_SESSION['login']['id'];
   									$item->password = $_POST['password'];
    								$item->last_upd_id = $_SESSION['login']['id'];
    								$response = $item->changePasswordAdmin();
    								
    								$redirect_link = 'https://'.$_SERVER['HTTP_HOST'];
									echo '<script type="text/javascript">window.location = "'.$redirect_link.'";</script>';
    							}
							}
							$form->messages();

							$form->password('password','Password','','','','','','');
							$form->password('retype_password','Retype Password','','','','','','');

							$form->input_submit();
							?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>