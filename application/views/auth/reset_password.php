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
						<?php if( $reset_pass_email_sent  == 'true' ): ?>
							<h3>Reset password email sent.</h3>
							<p>You should receive an email shortly instructing you how to reset your password.</p> 
						<?php else: ?>
							<form id="Register_Account_101_Form" action="/auth/dosendresetpasswordemail" role="form" method="POST">
								<h3 class="text-center">Forgot your password?</h3>
								<div class="form-group text-center mt-10">
									<span>We'll send you instructions to reset your password.</span>
								</div>
								<div class="form-group mt-20">
									<input type="email" id="Email_Address" name="Email_Address" placeholder="Email Address" data-err-msg="The Email Address is required." class="form-control required input-lg" value="<?php echo ( isset($form_data['Email_Address']) ) ? $form_data['Email_Address'] : ''; ?>">
								</div>
								<div class="form-group">
									<button type="submit" id="Register_Account" class="btn btn-primary btn-lg" data-loading-state="Loading.." >Reset password</button>
								</div>
							</form>
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