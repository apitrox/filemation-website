<div class="container">
	<div id="Content" class="content-section">
		<div class="row">
			
			<div class="login_wrapper">
				<div class="logo">
					
				</div>
				<div class="login_container panel panel-default">
					<div class="login_notifications">
						<div class="alert alert-danger alert-dismissable <?php echo ($login_creds_error) ? "" : "hide"; ?>">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<strong>Bad Credentials!</strong> The email and password provided are incorrect.
						</div>
					</div>
					<div class="login_form">
						<form id="Login_Form" action="/auth/LogAdminIn" class="form-horizontal" role="form" method="POST">
							<div class="form-group">
								<input type="text" class="form-control input-lg" id="Username" name="Username" placeholder="Username" required>
							</div>
							<div class="form-group">
								<input type="password" class="form-control input-lg" id="Password" name="Password" placeholder="Password" required>
							</div>
							<div class="form-group">
								<input type="hidden" id="Stay_Logged_In_0" name="Stay_Logged_In" value="0" />
								<input type="checkbox" id="Stay_Logged_In_1" name="Stay_Logged_In" value="1" />
								<label for="Stay_Logged_In_1">Stay logged in.</label>
							</div>
							<div class="form-group">
								<button type="submit" id="Login_Submit" class="btn btn-primary btn-lg" data-loading-state="Validating.." style="width: 100%;">Sign in</button>
							</div>
						</form>
					</div>
					
				</div>
			</div>
			<!-- <div class="login_actions">
				<div class="left">
					<span><i class="fa fa-plus text-muted"></i> <a href="/register">Create account</a></span>
				</div>
				<div class="right">
					<span><i class="fa fa-rotate-left text-muted"></i> <a href="/reset">Reset password</a></span>
				</div>
			</div> -->
			
		</div>
	</div>
</div>
<script>
$(function(){
	$('#Login_Form').submit(function(event){
		$('#Login_Submit').button('loading');
	});
});
</script>