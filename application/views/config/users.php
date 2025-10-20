<style>
	body {
		background-color: #FFFFFF !important;
	}
</style>
<div class="container mt-20">
	<div class="row">
		<div class="col-md-6 pl-0 ml-0">
			<div class="panel panel-white">
				<div class="panel-heading mb-0">
					<span>Users</span>
					<button id="Config_New_User" class="btn btn-primary btn-sm new_button pull-right" type="button"><i class="fa fa-plus"></i> New User</button>
					<input type="text" id="Config_Users_Search" class="form-control grid_row_search_input input-sm" placeholder="Search users" />
				</div>	
				<div class="panel-body p-0">
					<table id="Config_Users_Grid" class="table table-striped" cellspacing="0" width="100%">
						<thead>
						    <tr>
							   <th>Users</th>
						    </tr>
						</thead>
						<tbody>
						</tbody>
					 </table>
				</div>
			</div>
		</div>

		<div class="col-md-6 pl-0 pr-0">
			<div id="Config_Users_Container" class="panel panel-default">
				<div class="panel-heading hidden" id="Config_Users_Header">
					<span>Users</span>
				</div>
				<div class="panel-body">
					
						<div id="Config_Users_Wrapper">
							<div id="Config_Users_Placeholder" class="alert alert-info mb-0">
								<strong>Click</strong> on a user's name to edit a user.<br/>
								<strong>Click</strong> the "New User" button to the left to create a new user record.
							</div>
							<div id="Config_Users" class="row hidden">
								<form id="Config_Users_Form" class="">
									<div class="form-group">
										<label for="User_First_Name" class="col-sm-3 control-label font-normal font-12 text-darkgray text-right">First Name: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="User First Name" data-content="The user's real first name."></i></label>
										<div class="col-sm-9">
											<input type="text" class="form-control input-sm required" id="User_First_Name" name="User_First_Name" placeholder="" data-err-msg="The First Name is required." value="">
										</div>
										<div class="clear"></div>
									</div>
									<div class="form-group">
										<label for="User_Last_Name" class="col-sm-3 control-label font-normal font-12 text-darkgray text-right">Last Name: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="User Last Name" data-content="The user's real last name."></i></label>
										<div class="col-sm-9">
											<input type="text" class="form-control input-sm required" id="User_Last_Name" name="User_Last_Name" placeholder="" data-err-msg="The Last Name is required." value="">
										</div>
										<div class="clear"></div>
									</div>
									<hr/>
									<div class="form-group">
										<label for="User_Email" class="col-sm-3 control-label font-normal font-12 text-darkgray text-right">Email: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="The User's Email Address" data-content="The user's real email address which after being confirmed, will be used for the user to log in to their Filemation account."></i></label>
										<div class="col-sm-9">
											<input type="text" class="form-control input-sm required" id="User_Email" name="User_Email" placeholder="" data-err-msg="The Email is required." value="">
											<span id="User_Email_Loader" style="position: absolute; right: 20px; top: 3px; display: none;"><img src="/assets/imgs/loader16horiz.GIF" width="16"></span>
											<span id="Email_Exists_Msg" class="text-danger font-12"></span>
										</div>
										<div class="clear"></div>
									</div>
									<div class="form-group">
										<label for="User_Password" class="col-sm-3 control-label font-normal font-12 text-darkgray text-right">Password: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="Password" data-content="The password the user uses to log in to their Filemation account."></i></label>
										<div class="col-sm-9">
											<input type="password" class="form-control input-sm required" id="User_Password" name="User_Password" placeholder="" data-err-msg="The Password is required." value="">
										</div>
										<div class="clear"></div>
									</div>
									<hr/>
									<div class="form-group">
										<label for="Default_Source_Location" class="col-sm-3 control-label font-normal font-12 text-darkgray text-right">Default Source Location: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="Default Source Location" data-content="If selected, this will be the default source location to a folder in the account's data storage provider. The <i>Default Source Location</i> is a folder in the account's data storage in which by default will be displayed in the files to be filed."></i></label>
										<div class="col-sm-9">
											<input type="text" class="form-control input-sm" id="Default_Source_Location" name="Default_Source_Location" placeholder="" data-err-msg="" value="">
										</div>
										<div class="clear"></div>
									</div>
									<hr/>
									<div class="form-group clear">
										<div class="col-sm-8">
											<input type="hidden" id="User_Id" name="User_Id" value="" />
											<button type="submit" id="Config_Save_User" class="btn btn-primary">Save User</button>
										</div>
									</div>									
								</form>
							</div>
						</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function(){
	$('#User_Email').blur(function(event){
		$('#User_Email_Loader').show();
		var user_email = this.value;
		
		$.get('/json/CheckIfEmailExists/', {'user_email': user_email}, function(response){
			
			if( typeof response.Result != 'undefined' && response.Result == true )
			{
				var user_email = ( typeof response.User_Email != 'undefined' ) ? response.User_Email : '';
				var exists = ( typeof response.Exists != 'undefined' ) ? response.Exists : false;
				var message = (exists) ? 'The email address "' + user_email + '" already exists, please use a different email address.' : '';
				$('#Email_Exists_Msg').html(message);
			}
			else
			{
				$('#Email_Exists_Msg').html('');
			}
			$('#User_Email_Loader').hide();
		}, 'json');

	});
	
});
</script>