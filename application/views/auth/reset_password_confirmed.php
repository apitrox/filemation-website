<div class="container">
	<div class="content-section">
		<div class="row">
			
			<div class="reset_password_wrapper">
				<div class="logo">
					<img src="/assets/imgs/fmloginlogo.png" />
				</div>
				<div class="reset_password_container panel panel-default">
					<div class="<?php echo ( empty($reset_password_error_message) ) ? 'hide' : '' ?>">
						<div class="alert alert-danger alert-dismissable">
							<strong>ERROR!</strong> <?php echo $reset_password_error_message; ?>
						</div>
					</div>
					<div>
						<?php if( !empty($reset_password_error_message) ): ?>
							<h3>Sorry, an error occurred.</h3>
							<p><?php echo $error_message; ?></p> 
						<?php else: ?>
							<h3>Password Reset.</h3><br/>
							<p>Your new account password is: <strong><?php echo $new_password; ?></strong></p>
							<p>You will receive an email with the new password for your records.</p>
						<?php endif; ?>
					</div>
				</div>
				
			</div>
			<div class="return_links">
				<a href="/login">Return to Log In</a>
			</div>
			
		</div>
	</div>
</div>