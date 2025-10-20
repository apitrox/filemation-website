<style>body {background-color: #FFFFFF;}</style>
<div class="container">
	<div id="Content" class="content-section">
		<div class="row">
			<div class="mt-20">
				
				<ul class="nav nav-tabs" role="tablist">
					<li class="active"><a href="#Security" role="tab" data-toggle="tab">Security</a></li>
				</ul>
				
				<div class="tab-content">
					<div class="tab-pane active" id="Security">				
						<div class="row mt-20 ml-5">
							<a href="#" id="Account_Change_Password_Link">Change password</a>
							<div id="Account_Change_Password_Edit" class="hidden mb-20">
								<h4>Change your Filemation password</h4>
								<form id="Account_Change_Password_Form">
									<div class="form-group clear">
										<label for="Current_Password" class="col-sm-2 control-label font-normal text-darkgray font-12 text-left ml-0 pl-0">Current Password:</label>
										<div class="col-sm-4">
											<input type="password" id="Current_Password" name="Current_Password" class="form-control input-sm required" data-err-msg="The current password is required." value="" />
										</div>
										<div class="clear"></div>
									</div>
									<div class="form-group clear">
										<label for="New_Password" class="col-sm-2 control-label font-normal text-darkgray font-12 text-left ml-0 pl-0">New Password:</label>
										<div class="col-sm-4">
											<input type="password" id="New_Password" name="New_Password" class="form-control input-sm required" data-err-msg="The new password is required." value="" />
										</div>
										<div class="clear"></div>
									</div>
									<div class="form-group clear">
										<label for="Confirm_New_Password" class="col-sm-2 control-label font-normal text-darkgray font-12 text-left ml-0 pl-0">Confirm Password:</label>
										<div class="col-sm-4">
											<input type="password" id="Confirm_New_Password" name="Confirm_New_Password" class="form-control input-sm required" data-err-msg="The confirm password is required." value="" />
										</div>
										<div class="clear"></div>
									</div>
									<hr/>
									<button id="Account_Save_Change_Password" class="btn btn-primary btn-sm" data-loading-state="Updating Password..">Update Password</button>
									<button id="Account_Cancel_Change_Password" class="btn btn-default btn-sm">Cancel</button>
								</form>
							</div>
							<!-- <br/><a id="Account_Reset_Password_Link" href="#">Forgot your password?</a> -->
							<div id="Account_Reset_Password_Edit" class="hidden">
								<hr/>
								<h4>Reset your Filemation password</h4>
								<p>Enter your email address to reset your password. You may need to check your spam folder or unblock no-reply@dropbox.com.</p>
								<form id="Account_Reset_Password_Form">
									<div class="col-sm-4 ml-0 pl-0">
										<input type="text" id="Email_Address" name="Email_Address" class="form-control input-sm " data-err-msg="The email address is required." placeholder="The email address you use to login to filemation with." value="<?php echo $user->User_Email; ?>" />
									</div>
									<div class="clear"></div>
									<hr/>
									<button id="Account_Save_Reset_Password" class="btn btn-primary btn-sm" data-loading-state="Resetting Password..">Reset Password</button>
									<button id="Account_Cancel_Reset_Password" class="btn btn-default btn-sm">Cancel</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				
				
				
		</div>
	</div>
</div>
<script type="text/javascript">
	
</script>