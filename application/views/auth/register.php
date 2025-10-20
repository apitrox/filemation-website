<div class="container">
	<div class="content-section">
		<div class="row">
			
			<div class="register_wrapper">
				<div class="logo">
					<img src="/assets/imgs/fmloginlogo.png" />
				</div>
				<div class="register_container panel panel-default">
					<div class="">
						<div class="alert alert-danger alert-dismissable <?php echo ($register_error_message) ? "" : "hide"; ?>">
							<strong>ERROR!</strong> <?php echo $register_error_message; ?>
						</div>

					</div>
					<div>
						<form id="Register_Account_101_Form" action="/auth/registeraccount" role="form" method="POST">
							<div class="form-group">
								<label for="Account_Name" class="control-label">Account Name</label>
								<input type="text" id="Account_Name" name="Account_Name" placeholder="The name of the company or account holder." data-err-msg="The Account Name is required." class="form-control required" value="<?php echo ( isset($register_form_data['Account_Name']) ) ? $register_form_data['Account_Name'] : ''; ?>" />
							</div>
							<hr/>
							<h3>Primary User</h3>
							<span class="note">This will be the administrator for the account.</span>
							<div class="form-group mt-20">
								<label for="User_First_Name">First Name</label>
								<input type="text" id="User_First_Name" name="User_First_Name" placeholder="The first name of the primary user." data-err-msg="The User's First name is required." class="form-control required" value="<?php echo ( isset($register_form_data['User_First_Name']) ) ? $register_form_data['User_First_Name'] : ''; ?>">
							</div>
							<div class="form-group">
								<label for="User_Last_Name">Last Name</label>
								<input type="text" id="User_Last_Name" name="User_Last_Name" placeholder="The last name of the primary user." data-err-msg="The User's Last Name is required." class="form-control required" value="<?php echo ( isset($register_form_data['User_Last_Name']) ) ? $register_form_data['User_Last_Name'] : ''; ?>">
							</div>
							<div class="form-group">
								<label for="User_First_Name">Email</label><br/>
								<span class="note">This will be the log in ID. A verification email will be sent.
								<input type="email" id="User_Email" name="User_Email" placeholder="The primary email for this account, and the primary user's login email." data-err-msg="The User's Email is required." class="form-control required" value="<?php echo ( isset($register_form_data['User_Email']) ) ? $register_form_data['User_Email'] : ''; ?>">
								<span id="Email_Exists_Msg" class="text-danger"></span>
							</div>
							<div class="form-group">
								<label for="User_Password">Password</label>
								<input type="password" id="User_Password" name="User_Password" class="form-control required"  data-err-msg="The User's Password is required." placeholder="" value="<?php echo ( isset($register_form_data['User_Password']) ) ? $register_form_data['User_Password'] : ''; ?>">
							</div>
							<div class="form-group">
								<label for="User_Password">Confirm Password</label>
								<input type="password" id="User_Re_Password" name="User_Re_Password" class="form-control required"  data-err-msg="You must re type the User's Password." placeholder="">
							</div>
							
							<hr/>
							<div class="form-group">
								<button type="submit" id="Register_Account" class="btn btn-primary btn-lg" data-loading-state="Registering.." >Register</button>
								<!--<button type="reset" class="btn btn-default">Cancel</button>-->
							</div>
						</form>


					</div>
				</div>				
			</div>
			<div class="return_links_reg">
				<span><a href="/login">Already have an account?</a></span>
			</div>
			
		</div>
	</div>
</div>