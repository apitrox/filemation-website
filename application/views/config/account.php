<style>
	body {
		background-color: #FFFFFF !important;
	}
</style>
<div class="container_account mt-20">
	<div class="">
		
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li class="active"><a href="#Account_Sec" role="tab" data-toggle="tab">Account</a></li>
			<li><a href="#Data_Storage_Sec" role="tab" data-toggle="tab">Data Storage</a></li>
			<li><a href="#Recall_Names" role="tab" data-toggle="tab">Recall Names</a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div class="tab-pane active" id="Account_Sec">				
				<div class="row mt-20">
					<div class="col-md-4">
						<div id="Config_Account_Name_Values_Wrapper">
							<div class="form-group">
								<label for="Account_Number" class="control-label font-normal text-muted">Account Number</label>
								<span class="pull-right"><button id="Edit_Account_Name" class="btn btn-default btn-sm">Edit</button></span>
								<div class="">
									<?php echo $account->Account_Number; ?>
								</div>
							</div>
							<div class="form-group">
								<label for="Account_Name" class="control-label font-normal text-muted">Account Name</label>
								<div id="" class="">
									<span id="Config_Account_Name_Value"><?php echo $account->Account_Name; ?>
								</div>
							</div>
						</div>
						<form id="Config_Account_Name_Form" class="hidden">
							<div class="form-group">
								<label for="Account_Number" class="control-label font-normal text-muted">Account Number</label>
								<div class="">
									<?php echo $account->Account_Number; ?>
								</div>
							</div>
							<div class="form-group">
								<label for="Account_Name" class="control-label font-normal text-muted">Account Name</label>
								<div>
									<input type="text" id="Account_Name" name="Account_Name" class="form-control input-sm" value="<?php echo $account->Account_Name; ?>" />
								</div>
							</div>
							<div>
								<hr/>
								<button id="Edit_Account_Name_Save" type="submit" data-loading-state="Saving.." class="btn btn-primary btn-sm">Save Account</button>
								<button id="Edit_Account_Name_Cancel" type="cancel" class="btn btn-default btn-sm">Cancel</button>
							</div>
						</form>
					</div>
					<div class="col-md-4">
						<div id="Config_Account_Details_Values_Wrapper">
							<div class="form-group">
								<label class="control-label font-normal text-muted">File Storage</label>
								<span class="pull-right"><button id="Edit_Account_Details" class="btn btn-default btn-sm">Edit</button></span>
								<div class="">
									<?php echo $account->Data_Storage; ?>

								</div>
							</div>
							<div class="form-group">
								<label class="control-label font-normal text-muted">Default Source Folder</label>
								<div id="Account_Default_Source_Location_Name" class="">
									<?php echo $default_source_location_name; ?>									
								</div>
							</div>
							<div class="form-group">
								<label class="control-label font-normal text-muted">Optimize Scans</label>
								<div id="Config_Optimize_Scans_Value">
									<?php echo ( $account->Optimize_Scans == 1 ) ? 'Yes' : 'No'; ?>									
								</div>
							</div>
							<div class="form-group">
								<label class="control-label font-normal text-muted">Recall Names By Entire Account</label>
								<div id="Config_Recall_Names_Entire_Account_Value">
									<?php echo ( $account->Recall_Names_Entire_Account == 1 ) ? "Yes" : "No"; ?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label font-normal text-muted">Recall Names By User</label>
								<div id="Config_Recall_Names_By_User_Value">
									<?php echo ( $account->Recall_Names_By_User == 1 ) ? "Yes" : "No"; ?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label font-normal text-muted">Recall Names By File Definition</label>
								<div id="Config_Recall_Names_By_File_Definition_Value">
									<?php echo ( $account->Recall_Names_By_File_Definition == 1 ) ? "Yes" : "No"; ?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label font-normal text-muted">Recall Names By File Criteria</label>
								<div id="Config_Recall_Names_By_File_Criteria_Value">
									<?php echo ( $account->Recall_Names_By_File_Criteria == 1 ) ? "Yes" : "No"; ?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label font-normal text-muted">Maximum Files Per Month</label>
								<div class="">
									<?php echo number_format($account->Max_Files_Per_Month); ?>									
								</div>
							</div>
						</div>
						<form id="Config_Account_Details_Form" class="hidden">
							<div class="form-group">
								<label class="control-label font-normal text-muted">File Storage</label>
								<div class="">
									<?php echo $account->Data_Storage; ?>
								</div>
							</div>
							<div class="form-group">
								<label for="File_Storage" class="control-label font-normal text-muted">Default Source Folder</label>
								<div id="Account_Default_Source_Location_Name" class="">
									<?php echo $default_source_location_name; ?>
								</div>
							</div>
							<div class="form-group">
								<label for="Optimize_Scans" class="control-label font-normal text-muted">Optimize Scans</label>
								<div class="">
									<input type="hidden" id="Optimize_Scans_0" name="Optimize_Scans" value="0" />
									<input type="checkbox" id="Optimize_Scans" name="Optimize_Scans" value="1" <?php echo ($account->Optimize_Scans == 1) ? "checked" : "";?> />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label font-normal text-muted">Recall Names By Entire Account</label>
								<div id="Config_Recall_Names_Entire_Account_Value">
									<?php echo ( $account->Recall_Names_Entire_Account == 1 ) ? "Yes" : "No"; ?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label font-normal text-muted">Recall Names By User</label>
								<div id="Config_Recall_Names_By_User_Value">
									<?php echo ( $account->Recall_Names_By_User == 1 ) ? "Yes" : "No"; ?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label font-normal text-muted">Recall Names By File Definition</label>
								<div id="Config_Recall_Names_By_File_Definition_Value">
									<?php echo ( $account->Recall_Names_By_File_Definition == 1 ) ? "Yes" : "No"; ?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label font-normal text-muted">Recall Names By File Criteria</label>
								<div id="Config_Recall_Names_By_File_Criteria_Value">
									<?php echo ( $account->Recall_Names_By_File_Criteria == 1 ) ? "Yes" : "No"; ?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label font-normal text-muted">Maximum Files Per Month</label>
								<div class="">
									<?php echo number_format($account->Max_Files_Per_Month); ?>									
								</div>
							</div>
							<div>
								<hr/>
								<button id="Edit_Account_Details_Save" type="submit" data-loading-state="Saving.." class="btn btn-primary btn-sm">Save Account</button>
								<button id="Edit_Account_Details_Cancel" type="cancel" class="btn btn-default btn-sm">Cancel</button>
							</div>
						</form>
					</div>
				</div>
				
			</div>
			<div class="tab-pane" id="Data_Storage_Sec">
				
				<div class="row mt-20">
					<form id="Config_Account_Data_Storage_Form" class="">
						<div class="col-md-4">
							<div class="form-group">
								<label for="File_Storage" class="control-label font-normal text-muted">Data Storage</label>
								<span class="pull-right"><button id="Edit_Data_Storage" class="btn btn-default btn-sm" onclick="return false;">Edit</button></span>
								<div id="Data_Storage_Value_Wrapper" class="">
									<span id="Data_Storage_Value"><?php echo $account->Data_Storage; ?></span>
								</div>
								<div id="Data_Storage_Edit_Wrapper" class="hidden">
									<select id="Data_Storage" name="Data_Storage" class="form-control input-sm">
										<option value=""></option>
										<?php if( count($data_storage_providers_array) > 0 ):?>
											<?php foreach($data_storage_providers_array as $option): ?>
												<option value="<?php echo $option['Data_Storage_Name']; ?>" <?php echo (strtoupper($account->Data_Storage) == strtoupper($option['Data_Storage_Name'])) ? "selected='selected'" : ""; ?>><?php echo $option['Data_Storage_Name']; ?></option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="File_Storage" class="control-label font-normal text-muted">Default Source Folder</label>
								<div id="Default_Source_Location_Value_Wrapper" class="">
									<span id="Default_Source_Location_Value"><?php echo $default_source_location_name; ?></span>
								</div>
								<div id="Default_Source_Location_Edit_Wrapper" class="hidden">
									<div class="input-group">
										<span class="input-group-btn">
											<button id="Select_Default_Source_Location" class="btn btn-default btn-sm" type="button"><i class="fa fa-folder"></i></button>
										</span>
										<input id="Default_Source_Location_Name" name="Default_Source_Location_Name" type="text" class="form-control input-sm" value="<?php echo $default_source_location_name; ?>">
									</div>
									<input type="hidden" name="Default_Source_Location" id="Default_Source_Location" value="<?php echo $account->Default_Source_Location; ?>" />
								</div>
							</div>
							<div id="Data_Storage_Button_Wrapper" class="hidden">
								<hr/>
								<button id="Data_Storage_Edit_Save" type="submit" class="btn btn-primary btn-sm" data-loading-text="Saving..">Save Data Storage</button>
								<button id="Data_Storage_Edit_Cancel" type="cancel" class="btn btn-default btn-sm">Cancel</button>
							</div>
							<div id="" class="form-group <?php echo ( $account_is_authorized ) ? "" : "hidden"; ?>">
								<hr/>
								<p class="text-muted font-12"><span class="glyphicon glyphicon-ok text-success"></span> &nbsp;This account is authorized with <strong><?php echo $account->Data_Storage; ?></strong>.</p>
								<p class="text-muted font-12">
									<i class="fa fa-info-circle text-primary"></i> &nbsp;This account has already been authorized with a data storage account. You may Re authorize an account if the tokens are invalid. Or you may authorize
									a separate account with the same data storage provider.</p>
								<p>&nbsp;</p>
							</div>
							<div id="Data_Storage_Authorize_Wrapper" class="form-group mt-20 <?php ( empty($account->Data_Storage) ) ? "hidden" : ""; ?>">
								<label for="File_Storage" class="control-label font-normal text-muted">Authorize Data Storage</label>
								<button id="Authorize_Data_Storage" class="btn btn-primary" onclick="return false;">Authorize Data Storage</button>
							</div>
						</div>
						<div class="col-md-6"></div>
					</form>
				</div>
				
			</div>
			<div class="tab-pane" id="Recall_Names">
				<div class="row mt-20">
					<form id="Config_Account_Recall_Names_Form" class="">
						<div class="ml-10">
							<div class="form-group">
								<p class="">A <i>Recall Name</i> is a value that is saved when filing or renaming a file or document. How do you want to use <i>Recall Names</i>?</p>
								<input type="hidden" id="Account_Recall_Names_Entire_Account_0" name="Recall_Names_Entire_Account" value="0" />
								<input type="checkbox" id="Account_Recall_Names_Entire_Account_1" name="Recall_Names_Entire_Account" class="save_account_recall_names" value="1" onclick="RecallNamesEntireAccountSelected(); ValidateRecallNames(this);" <?php echo ( $account->Recall_Names_Entire_Account == 1 ) ? "checked='checked'" : ""; ?> /> <label for="Account_Recall_Names_Entire_Account_1" class="font-normal">Share recall names across entire account</label><br/>
								<input type="hidden" id="Account_Recall_Names_By_User_0" name="Recall_Names_By_User" value="0" />
								<input type="checkbox" id="Account_Recall_Names_By_User_1" name="Recall_Names_By_User" class="save_account_recall_names" value="1"  onclick="ValidateRecallNames(this);" <?php echo ( $account->Recall_Names_By_User == 1 ) ? "checked='checked'" : ""; ?> /> <label for="Account_Recall_Names_By_User_1" class="font-normal">Restrict recall names by user</label><br/>
								<input type="hidden" id="Account_Recall_Names_By_File_Definition_0" name="Recall_Names_By_File_Definition" value="0" />
								<input type="checkbox" id="Account_Recall_Names_By_File_Definition_1" name="Recall_Names_By_File_Definition" class="save_account_recall_names" onclick="ValidateRecallNames(this);" value="1"  <?php echo ( $account->Recall_Names_By_File_Definition == 1 ) ? "checked='checked'" : ""; ?> /> <label for="Account_Recall_Names_By_File_Definition_1" class="font-normal">Restrict recall names by file definition</label><br/>
								<input type="hidden" id="Account_Recall_Names_By_File_Criteria_0" name="Recall_Names_By_File_Criteria" value="0" />
								<input type="checkbox" id="Account_Recall_Names_By_File_Criteria_1" name="Recall_Names_By_File_Criteria" class="save_account_recall_names" onclick="ValidateRecallNames(this);" value="1"  <?php echo ( $account->Recall_Names_By_File_Criteria == 1 ) ? "checked='checked'" : ""; ?> /> <label for="Account_Recall_Names_By_File_Criteria_1" class="font-normal">Restrict recall names by file criteria</label><br/>
							</div>
							<div>
								<div class="alert alert-info col-md-8" role="alert">
									<strong>Warning!</strong> Checking and un-checking the recall names saves the recall names account settings.
								</div>
								<div class="clear"></div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		
	</div>
</div>
<script type="text/javascript">
	
	//  This method validates the recall names values
	//  @Param 1:	required, the checkbox element object.
	function ValidateRecallNames(chkbox_el)
	{
		var el_id = $(chkbox_el).attr('id'); // set the checkbox element's id attribute value.
		var params = $('#Config_Account_Recall_Names_Form').serialize();
		
		if( params == "Recall_Names_Entire_Account=0&Recall_Names_By_User=0&Recall_Names_By_File_Definition=0&Recall_Names_By_File_Criteria=0" )
		{
			notif({
				type: "error",
				msg: "You must select at least one recall name option.",
				position: "center",
				multiline: true,
				opacity: 0.9,
				fade: 1
			});
		}
		
		
		if( $('#Account_Recall_Names_By_User_1').is(':checked') == false && $('#Account_Recall_Names_By_File_Definition_1').is(':checked') == false && $('#Account_Recall_Names_By_File_Criteria_1').is(':checked') == false )
		{
			if( el_id != "Account_Recall_Names_Entire_Account_1" )
			{
				$('#Account_Recall_Names_Entire_Account_1').click();
			}
			else
			{
				//$('#Account_Recall_Names_By_File_Definition_1').click();
			}
		}
		
		if( $('#Account_Recall_Names_By_File_Definition_1').is(':checked') == false && $('#Account_Recall_Names_By_File_Criteria_1').is(':checked') )
		{
			if( el_id != "Account_Recall_Names_By_File_Criteria_1" )
			{
				$('#Account_Recall_Names_By_File_Criteria_1').click();
			}
		}
	}
	
	//  This javascript function will uncheck any other recall names checkboxes and make them non selectable.
	function RecallNamesEntireAccountSelected()
	{
		
		if( $('#Account_Recall_Names_Entire_Account_1').is(':checked') )
		{
			$('#Account_Recall_Names_By_User_1').removeAttr('checked');
			$('#Account_Recall_Names_By_File_Definition_1').removeAttr('checked');
			$('#Account_Recall_Names_By_File_Criteria_1').removeAttr('checked');

			$('#Account_Recall_Names_By_User_1').attr('disabled', 'disabled');
			$('#Account_Recall_Names_By_File_Definition_1').attr('disabled', 'disabled');
			$('#Account_Recall_Names_By_File_Criteria_1').attr('disabled', 'disabled');
		}
		else
		{
			$('#Account_Recall_Names_By_User_1').removeAttr('disabled');
			$('#Account_Recall_Names_By_File_Definition_1').removeAttr('disabled');
			$('#Account_Recall_Names_By_File_Criteria_1').removeAttr('disabled');
			
			$('#Account_Recall_Names_By_File_Definition_1').click();
		}
	}
	
	$(function(){
		$('#Select_Default_Source_Location').fancybox({
			type: 'ajax',
			href: '/modal/SelectDataStorageFolder/?input=Config_Account_Data_Storage_Default_Source_Location',
			padding: 0,
			closeClick: false,
			closeBtn: false,
			helpers : {
				overlay : {
					opacity: 0.5
				}
		}});
	});
	$(function(){
		$('#Default_Source_Location_Name').on('click', function(event){
			event.preventDefault();
			$.fancybox({
				type: 'ajax',
				href: '/modal/SelectDataStorageFolder/?input=Config_Account_Data_Storage_Default_Source_Location',
				padding: 0,
				closeClick: false,
				closeBtn: false,
				helpers : {
					overlay : {
						opacity: 0.5
					}
			}});
			return false;
		});
	});
	$(function(){
		// if the recall names entire account is selected for the recall names then make the other checkbox options non selectable.
		if( $('#Account_Recall_Names_Entire_Account_1').is(':checked') )
		{
			RecallNamesEntireAccountSelected();
		}
	});
</script>