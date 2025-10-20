<div class="container">
	<div id="Content" class="content-section">
		<div class="row">
			
			<ul id="Tabs" class="nav nav-pills" data-tabs="tabs">
				<li class="active"><a href="#Users" data-toggle="tab">Users</a></li>
				<li><a href="#User_Groups" data-toggle="tab">User Groups</a></li>
				<li><a href="#File_Groups" data-toggle="tab">File Groups</a></li>
				<li><a href="#Access_By_User" data-toggle="tab">Access by User</a></li>
				<li><a href="#Access_By_User_Group" data-toggle="tab">Access by User Group</a></li>
				<li><a href="#Access_By_File_Group" data-toggle="tab">Access by File Group</a></li>
				<li class="dropdown" style="float: right;">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					  <span class="glyphicon glyphicon-plus"></span><!--<span class="caret">--></span>
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="#" data-toggle="modal" data-target="#New_User">New User</a></li>
						<li><a href="#" data-toggle="modal" data-target="#New_User_Group">New User Group</a></li>
						<li><a href="#" data-toggle="modal" data-target="#New_File_Group">New File Group</a></li>
					</ul>
				</li>
			</ul>
			<div id="Tab_Content" class="tab-content">
				<!-- Users Tab -->
				<div class="tab-pane active" id="Users">			    
					<div class="mt-20">
						<!-- Users -->
						<div class="col-md-6 pl-0 ml-0">
							<div class="panel panel-default">
								<div class="panel-heading">
									<span>Users</span>
								</div>	
								<div class="panel-body">
									<table id="Users_Grid" class="table table-striped table-bordered " data-link="row" cellspacing="0" width="100%">
										<thead>
										    <tr>
											   <th>Name</th>
											   <th>Title</th>
											   <th></th>
											   <th></th>
										    </tr>
										</thead>
										<tbody>
											<?php if( $user_records_result->num_rows() > 0 ): ?>
												<?php foreach( $user_records_result->result_object() as $key => $row): ?>
													<tr>
														<td>
															<a href="#" class="" rel="<?php echo $row->User_Id; ?>" onclick="ShowUserRoles(<?php echo $row->User_Id; ?>, '<?php echo $row->User_First_Name; ?> <?php echo $row->User_Last_Name; ?>');"><span data-name="Users_<?php echo $key; ?>" data-table="users" data-field="User_First_Name" data-key="<?php echo $row->User_Id; ?>" id="Users_First_<?php echo $row->User_Id; ?>" class="Users_<?php echo $row->User_Id; ?>"><?php echo $row->User_First_Name; ?></span></a>
															<a href="#" class="" rel="<?php echo $row->User_Id; ?>" onclick="ShowUserRoles(<?php echo $row->User_Id; ?>, '<?php echo $row->User_First_Name; ?><?php echo $row->User_Last_Name; ?>');"><span data-name="Users_<?php echo $key; ?>" data-table="users" data-field="User_Last_Name" data-key="<?php echo $row->User_Id; ?>" id="Users_Last_<?php echo $row->User_Id; ?>" class="Users_<?php echo $row->User_Id; ?>"><?php echo $row->User_Last_Name; ?></span></a>
														</td>
														<td>
															<span data-name="Users_<?php echo $key; ?>" data-table="users" data-field="User_Title" data-key="<?php echo $row->User_Id; ?>" id="Users_Title_<?php echo $row->User_Id; ?>" class="Users_<?php echo $row->User_Id; ?>"><?php echo $row->User_Title; ?></span>
														</td>
														<td>
															<button type="button" class="btn btn-primary btn-xs inline_edit" id="Users_<?php echo $key; ?>_Save" rel="Users_<?php echo $row->User_Id; ?>" data-name="Users_<?php echo $row->User_Id; ?>" data-table="users" data-key-name="User_Id" data-key-value="<?php echo $row->User_Id; ?>" data-replace="Save" title="Edit" onclick="CreateInlineEdit(this);"><span class="glyphicon glyphicon-pencil"></span></button>
														</td>
														<td>
															<button type="button" class="btn btn-danger btn-xs inline_edit delete" id="Users_<?php echo $row->User_Id; ?>_Delete" data-name="Users_<?php echo $row->User_Id; ?>_Delete" data-table="users" data-key-name="User_Id" data-key-value="<?php echo $row->User_Id; ?>" title="Delete" onclick="DeleteRow(this)"><span class="glyphicon glyphicon-trash"></span></button>
														</td>
													</tr>
												<?php endforeach; ?>
											<?php endif; ?>
										</tbody>
									 </table>
								</div>
							</div>
						</div>
						<!-- End Users -->
						<!-- Roles -->
						<div class="col-md-6 col-md-offset-0">
							<div id="User_Roles_Wrapper" class="panel panel-default">
								<div class="panel-heading">
									<span>User Groups</span><span id="User_Roles_Header"></span>
								</div>
								<div class="panel-body">
									<form id="User_Roles_Form">
										<div id="User_Roles">
											<div class="alert alert-info mn-0">
												<strong>Click</strong> on a user's name in the user's table to the left, to view and select the user's user groups.
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!-- End Roles -->
					</div>
				</div>
				<!-- End Users Tab -->
				<!-- Start User Groups Tab -->
				<div class="tab-pane" id="User_Groups">
					<div class="mt-20">
						<!-- Roles -->
						<div class="col-md-6 pl-0 ml-0">
							<div class="panel panel-default">
								<div class="panel-heading">
									<span>User Groups</span>
								</div>	
								<div class="panel-body">
									<table id="Roles_Grid" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
										    <tr>
											   <th>User Group</th>
											   <th></th>
											   <th></th>
										    </tr>
										</thead>
										<tbody>
											<?php if( $roles_records_result->num_rows() > 0 ): ?>
												<?php foreach( $roles_records_result->result_object() as $row): ?>
													<tr>
														<td><a href="#" class="" rel="<?php echo $row->Role_Id; ?>" onclick="ShowRoleFileGroups(<?php echo $row->Role_Id; ?>, '<?php echo $row->Role_Name; ?>')"><span data-name="User_Groups_<?php echo $row->Role_Id; ?>" data-table="roles" data-field="Role_Name" data-key="<?php echo $row->Role_Id; ?>" id="User_Groups_<?php echo $row->Role_Id; ?>" class="User_Groups_<?php echo $row->Role_Id; ?>"><?php echo $row->Role_Name; ?></span></a></td>
														<td>
															<button type="button" class="btn btn-primary btn-xs inline_edit" id="User_Groups_<?php echo $row->Role_Id; ?>_Save" rel="User_Groups_<?php echo $row->Role_Id; ?>" data-name="User_Groups_<?php echo $row->Role_Id; ?>" data-table="roles" data-key-name="Role_Id" data-key-value="<?php echo $row->Role_Id; ?>" data-replace="Save" title="Edit" onclick="CreateInlineEdit(this);"><span class="glyphicon glyphicon-pencil"></span></button>
														</td>
														<td>
															<button type="button" class="btn btn-danger btn-xs inline_edit" id="User_Groups_<?php echo $row->Role_Id; ?>_Delete" data-name="User_Groups_<?php echo $row->Role_Id; ?>_Delete" data-table="roles" data-key-name="Role_Id" data-key-value="<?php echo $row->Role_Id; ?>" title="Delete" onclick="DeleteRow(this)"><span class="glyphicon glyphicon-trash"></span></button>
														</td>
													</tr>
												<?php endforeach; ?>
											<?php endif; ?>
										</tbody>
									 </table>
								</div>
							</div>
						</div>
						<!-- End Roles -->
						<!-- File Groups -->
						<div class="col-md-6">
							<div id="Role_File_Groups_Wrapper" class="panel panel-default">
								<div class="panel-heading">
									<span>File Groups</span><span id="Role_File_Groups_Header"></span>
								</div>
								<div class="panel-body">
									<form id="Role_File_Groups_Form">
										<div id="Role_File_Groups">
											<div class="alert alert-info mn-0">
												<strong>Click</strong> on a user group's name in the user group's table to the left, to view and select the user groups's file groups.
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!-- End File Groups -->
					</div>
				</div>
				<!-- End User Groups Tab -->
				<!-- Start File Groups Tab -->
				<div class="tab-pane" id="File_Groups">
					<div class="mt-20">
						<div id="File_Groups_Wrapper" class="panel panel-default">
							<div class="panel-heading">
								<span>File Groups</span><span id="File_Groups_Header"></span>
							</div>
							<div class="panel-body">
								<form id="File_Groups_Form">
									<div id="File_Groups">

										<table id="File_Groups_Grid" class="table table-striped table-bordered" cellspacing="0" width="100%">
											<thead>
											   <tr>
												<?php if( count($file_groups_list_array) > 0 && isset($file_groups_list_array[0]) ): ?>
													<?php foreach( $file_groups_list_array[0] as $key => $row ): ?>
														<?php if( $key == 'File_Group_Id' ){ continue; }?>
														<th><?php echo $key; ?></th>
													<?php endforeach; ?>
												<?php endif; ?>
												<th></th>
												<th></th>
											   </tr>
											</thead>
											<tbody>
												<?php if( count($file_groups_list_array) > 0 ): ?>
													<?php foreach( $file_groups_list_array as $key => $row): ?>
														<tr>
															<td>
																<span data-name="File_Groups_<?php echo $row['File_Group_Id']; ?>" data-table="roles" data-field="File_Group_Name" data-key="<?php echo $row['File_Group_Id']; ?>" id="File_Groups_<?php echo $row['File_Group_Id']; ?>" class="File_Groups_<?php echo $row['File_Group_Id']; ?>"><?php echo $row['File Group']; ?></span>
															</td>
															<td>
																<button type="button" class="btn btn-primary btn-xs inline_edit" id="File_Groups_<?php echo $row['File_Group_Id']; ?>_Save" rel="File_Groups_<?php echo $row['File_Group_Id']; ?>" data-name="File_Groups_<?php echo $row['File_Group_Id']; ?>" data-table="file_groups" data-key-name="File_Group_Id" data-key-value="<?php echo $row['File_Group_Id']; ?>" data-replace="Save" title="Edit" onclick="CreateInlineEdit(this);"><span class="glyphicon glyphicon-pencil"></span></button>
															</td>
															<td>
																<button type="button" class="btn btn-danger btn-xs inline_edit" id="File_Groups_<?php echo $row['File_Group_Id']; ?>_Delete" data-name="File_Groups_<?php echo $row['File_Group_Id']; ?>_Delete" data-table="file_groups" data-key-name="File_Group_Id" data-key-value="<?php echo $row['File_Group_Id']; ?>" title="Delete" onclick="DeleteRow(this)"><span class="glyphicon glyphicon-trash"></span></button>
															</td>
														</tr>
													<?php endforeach; ?>
												<?php endif; ?>
											</tbody>
										 </table>

									</div>
								</form>
							</div>
						</div>
					</div>
					
				</div>
				<!-- End File Groups Tab -->
				<!-- Start Access by User Tab -->
				<div class="tab-pane" id="Access_By_User">
					<div class="mt-20">
						<div id="Access_By_User_Wrapper" class="panel panel-default">
							<div class="panel-heading">
								<span>Access by User</span><span id="Access_By_User_Header"></span>
							</div>
							<div class="panel-body">
								<form id="Access_By_User_Form">
									<table id="Access_By_User_Grid" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
										   <tr>
											<?php if( count($access_by_user_list_array) > 0 && isset($access_by_user_list_array[0]) ): ?>
												<?php foreach( $access_by_user_list_array[0] as $key => $row ): ?>
													<th><?php echo $key; ?></th>
												<?php endforeach; ?>
											<?php endif; ?>
										   </tr>
										</thead>
										<tbody>
											<?php if( count($access_by_user_list_array) > 0 ): ?>
												<?php foreach( $access_by_user_list_array as $key => $row): ?>
													<tr>
														<td><?php echo $row['First']; ?></td>
														<td><?php echo $row['Last']; ?></td>
														<td><?php echo $row['Title']; ?></td>
														<td><?php echo $row['File Group']; ?></td>
														<td><?php echo $row['Permission']; ?></td>
														<td><?php echo $row['by User Group']; ?></td>
													</tr>
												<?php endforeach; ?>
											<?php endif; ?>
										</tbody>
									 </table>
								</form>
							</div>
						</div>
					</div>
					
				</div>
				<!-- End File Groups Tab -->
				<!-- Start Access by User Group Tab -->
				<div class="tab-pane" id="Access_By_User_Group">
					<div class="mt-20">
						<div id="Access_By_User_Group_Wrapper" class="panel panel-default">
							<div class="panel-heading">
								<span>Access by User Group</span><span id="Access_By_User_Group_Header"></span>
							</div>
							<div class="panel-body">
								<form id="Access_By_User_Form">
									<div id="">

										<table id="Access_By_User_Group_Grid" class="table table-striped table-bordered" cellspacing="0" width="100%">
											<thead>
											   <tr>
												<?php if( count($access_by_user_groups_list_array) > 0 && isset($access_by_user_groups_list_array[0]) ): ?>
													<?php foreach( $access_by_user_groups_list_array[0] as $key => $row ): ?>
														<th><?php echo $key; ?></th>
													<?php endforeach; ?>
												<?php endif; ?>
											   </tr>
											</thead>
											<tbody>
												<?php if( count($access_by_user_groups_list_array) > 0 ): ?>
													<?php foreach( $access_by_user_groups_list_array as $row): ?>
														<tr>
															<td><?php echo $row['User Group']; ?></td>
															<td><?php echo $row['File Group']; ?></td>
															<td><?php echo $row['Permissions']; ?></td>
															<td><?php echo $row['Permission Description']; ?></td>
														</tr>
													<?php endforeach; ?>
												<?php endif; ?>
											</tbody>
										 </table>

									</div>
								</form>
							</div>
						</div>
					</div>
					
				</div>
				<!-- End Access By User Group Tab -->
				<!-- Start Access by File Group Tab -->
				<div class="tab-pane" id="Access_By_File_Group">
					<div class="mt-20">
						<div id="Access_By_File_Group_Wrapper" class="panel panel-default">
							<div class="panel-heading">
								<span>Access by File Group</span><span id="Access_By_File_Group_Header"></span>
							</div>
							<div class="panel-body">
								<form id="Access_By_User_Form">
									<div id="">

										<table id="Access_By_File_Group_Grid" class="table table-striped table-bordered" cellspacing="0" width="100%">
											<thead>
											   <tr>
												<?php if( count($access_by_file_groups_list_array) > 0 && isset($access_by_file_groups_list_array[0]) ): ?>
													<?php foreach( $access_by_file_groups_list_array[0] as $key => $row ): ?>
														<th><?php echo $key; ?></th>
													<?php endforeach; ?>
												<?php endif; ?>
											   </tr>
											</thead>
											<tbody>
												<?php if( count($access_by_file_groups_list_array) > 0 ): ?>
													<?php foreach( $access_by_file_groups_list_array as $row): ?>
														<tr>
															<td><?php echo $row['File Group']; ?></td>
															<td><?php echo $row['Permission']; ?></td>
															<td><?php echo $row['First']; ?></td>
															<td><?php echo $row['Last']; ?></td>
															<td><?php echo $row['Title']; ?></td>
															<td><?php echo $row['via User Group']; ?></td>
														</tr>
													<?php endforeach; ?>
												<?php endif; ?>
											</tbody>
										 </table>

									</div>
								</form>
							</div>
						</div>
					</div>
					
				</div>
				<!-- End Access By File Group Tab -->
			</div> 
		</div>
		
    </div>
</div>
<!-- Start New User -->
<div class="modal fade" id="New_User" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">New User</h4>
      </div>
      <div class="modal-body">
        
	   <form id="New_User_Form" class="form-horizontal" role="form">
		<div class="form-group" id="Control_User_First_Name">
		  <label for="User_First_Name" class="col-sm-2 control-label">First Name: </label>
		  <div class="col-sm-10">
		    <input type="text" class="form-control required " id="User_First_Name" name="User_First_Name" placeholder="User First Name" autofocus required>
		  </div>
		</div>
		<div class="form-group" id="Control_User_Last_Name">
		  <label for="User_Last_Name" class="col-sm-2 control-label">Last Name: </label>
		  <div class="col-sm-10">
		    <input type="text" class="form-control required" id="User_Last_Name" name="User_Last_Name" placeholder="User Last Name" required>
		  </div>
		</div>
		<div class="form-group" id="Control_User_Title">
		  <label for="User_Title" class="col-sm-2 control-label">User Title: </label>
		  <div class="col-sm-10">
		    <input type="text" class="form-control required" id="User_Title" name="User_Title" placeholder="User Title" required>
		  </div>
		</div>
	   </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="ResetForm('New_User_Form')">Close</button>
        <button type="button" class="btn btn-primary" id="Save_New_User">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- End New User -->
<!-- Start New User Group -->
<div class="modal fade" id="New_User_Group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">New User Group</h4>
      </div>
      <div class="modal-body">
        
	   <form id="New_User_Group_Form" class="form-horizontal" role="form">
		<div class="form-group">
		  <label for="Role_Name" class="col-sm-2 control-label">Role Name: </label>
		  <div class="col-sm-10">
		    <input type="text" class="form-control required" id="Role_Name" name="Role_Name" placeholder="Role Name" autofocus required>
		  </div>
		</div>
	   </form>
		 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="ResetForm('New_User_Group_Form')">Close</button>
        <button type="button" class="btn btn-primary" id="Save_New_User_Group">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- End New User Group -->
<!-- Start New File Group -->
<div class="modal fade" id="New_File_Group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">New File Group</h4>
      </div>
      <div class="modal-body">
        
	   <form id="New_File_Group_Form" class="form-horizontal" role="form">
		<div class="form-group">
		  <label for="File_Group_Name" class="col-sm-2 control-label">File Group Name: </label>
		  <div class="col-sm-10">
		    <input type="text" class="form-control required" id="File_Group_Name" name="File_Group_Name" placeholder="File Group Name">
		  </div>
		</div>
	   </form>
		 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="ResetForm('New_File_Group_Form')">Close</button>
        <button type="button" class="btn btn-primary" id="Save_New_File_Group">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- End New File Group -->