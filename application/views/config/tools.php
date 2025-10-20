<style>
	body {
		background-color: #FFFFFF !important;
	}
</style>
<div class="container_account mt-20">
	<div class="">
		
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li class="active"><a href="#Update_File_Tags" role="tab" data-toggle="tab">Update Filenames & Tags</a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div class="tab-pane active" id="Update_File_Tags">				
				<div class="row mt-20">
					<div class="ml-15">
						<form id="Config_Update_File_Tags" class="">
							<div class="form-group">
								<label for="File_Storage" class="control-label font-normal text-muted">Select folder containing files to update:</label>
								<div id="Default_Source_Location_Edit_Wrapper" class="">
									<div class="input-group">
										<span class="input-group-btn">
											<button id="Select_Folder" class="btn btn-default btn-sm" type="button"><i class="fa fa-folder"></i></button>
										</span>
										<input id="Folder_Name" name="Folder_Name" type="text" class="form-control input-sm" value="All Files" style="width: 300px !important; ">
									</div>
									<input type="hidden" name="Folder_Id" id="Folder_Id" value="0" />
								</div>
							</div>
							<hr/>
							<div class="form-group">
								<input type="radio" id="File_Definition_1st_Criteria_Of_Name" name="File_Definition_To_Use" value="File_Definition_1st_Criteria_Of_Name" onclick="ResetProcessFileDefinitionsSelections();"> <label for="File_Definition_1st_Criteria_Of_Name" class="control-label font-normal text-muted">Process all files using the 1st criteria of the name as the file definition.</label>&nbsp;&nbsp;
								<label for="File_Definition_To_Use_Criteria_Separator" class="control-label font-normal text-muted ml-20">Criteria Separator</label>
								<select id="File_Definition_To_Use_Criteria_Separator" name="File_Definition_To_Use_Criteria_Separator" class="">
									<option value=""></option>
									<?php foreach($criteria_separators_ref_array as $criteria_sep): ?>
										<option value="<?php echo $criteria_sep['Criteria_Separator_Chars']; ?>"><?php echo $criteria_sep['Criteria_Separator_Name']; ?></option>
									<?php endforeach; ?>
								</select>
								<br/>								
								<input type="radio" id="Process_All_Files_Using_This_File_Definition" name="File_Definition_To_Use" value="Use_This_File_Definition" onclick="ResetProcessFileDefinitionsSelections();"> <label for="Process_All_Files_Using_This_File_Definition" class="control-label font-normal text-muted">Process all files using this file definition</label>
								<select id="File_Definition_Id" name="File_Definition_Id">
									<option value=""></option>
									<?php foreach($file_definitions_array as $file_def): ?>
										<option value="<?php echo $file_def['File_Definition_Id']; ?>"><?php echo $file_def['File_Def_Name']; ?></option>
									<?php endforeach; ?>
								</select>
								<br/>
								<input type="radio" id="Use_The_ID_Tag_As_File_Definition" name="File_Definition_To_Use" value="Use_The_ID_Tag_As_File_Definition" onclick="ResetProcessFileDefinitionsSelections();"> <label for="Use_The_ID_Tag_As_File_Definition" class="control-label font-normal text-muted">Process all files using the ID tag as the file definition</label>
							</div>
							<hr/>
							<div class="form-group">
								<input type="radio" id="Replace_All_Existing" name="Existing_Tags" value="Replace_All_Existing"> <label for="Replace_All_Existing" class="control-label font-normal text-muted">Replace all existing tags with new tags</label><br/>
								<input type="radio" id="Leave_Existing_Tags" name="Existing_Tags" value="Leave_Existing_Tags"> <label for="Leave_Existing_Tags" class="control-label font-normal text-muted">Leave existing tags and add any new tags</label><br/>
								<input type="radio" id="Remote_All_Tags" name="Existing_Tags" value="Remove_All_Tags"> <label for="Remove_All_Tags" class="control-label font-normal text-muted">Remove all tags</label>
							</div>
							<hr/>
							<div class="form-group">
								<input type="radio" id="Process_In_Order_By_Filename" name="Process_Order" value="Process_In_Order_By_Filename" onclick="ResetProcessOrderSelections();"> <label for="Process_In_Order_By_Filename" class="control-label font-normal text-muted">Process in order by filename</label>
								<select id="Process_In_Order_By_Filename_Order" name="Process_In_Order_By_Filename_Order">
									<option value=""></option>
									<option value="A_Z">A-Z</option>
									<option value="Z_A">Z-A</option>
								</select>
								<br/>
								<input type="radio" id="Process_In_Order_Using_File_Criteria_As_A_Date" name="Process_Order" value="Process_In_Order_Using_File_Criteria_As_A_Date" onclick="ResetProcessOrderSelections();"> <label for="Process_In_Order_Using_File_Criteria_As_A_Date" class="control-label font-normal text-muted">Process in order using last file criteria as a date.</label>
								<select id="Process_In_Order_Using_File_Criteria_As_A_Date_Order" name="Process_In_Order_Using_File_Criteria_As_A_Date_Order">
									<option value=""></option>
									<option value="Earliest_Latest">Earliest -> Latest</option>
									<option value="Latest_Earliest">Latest -> Earliest</option>
								</select>&nbsp;&nbsp;
								<label for="Process_In_Order_Using_File_Criteria_As_A_Date_Criteria_Separator" class="control-label font-normal text-muted ml-20">Criteria separator</label>
								<select id="Process_In_Order_Using_File_Criteria_As_A_Date_Criteria_Separator" name="Process_In_Order_Using_File_Criteria_As_A_Date_Criteria_Separator">
									<option value=""></option>
									<?php foreach($criteria_separators_ref_array as $criteria_sep): ?>
										<option value="<?php echo $criteria_sep['Criteria_Separator_Chars']; ?>"><?php echo $criteria_sep['Criteria_Separator_Name']; ?></option>
									<?php endforeach; ?>
								</select><br/>
								<input type="radio" id="No_Sort" name="Process_Order" value="No_Sort" onclick="ResetProcessOrderSelections();"> <label for="No_Sort" class="control-label font-normal text-muted">No sort (as-is)</label>
							</div>
							<div>
								<hr/>
								<button id="Config_Update_Box_File_Tags" type="submit" data-loading-state="Saving.." class="btn btn-primary btn-sm">Update box file tags</button>
							</div>
						</form>
					</div>
					
				</div>
				
			</div>
		</div>
		
	</div>
</div>
<script type="text/javascript">
	
	function ValidateUpdateFilesForm()
	{
		var error = false;
		var error_msg = "";
		var separator = "";
		var border_color = "#A94442";
		
		// file definitions to use radio selections
		if( $('input[name="File_Definition_To_Use"]').is(':checked') == false )
		{
			error = true;
			error_msg = error_msg + "You must select how to get the File Definition.";
		}
		// existing tags radio selections
		if( $('input[name="Existing_Tags"]').is(':checked') == false )
		{
			separator = ( error_msg != "" ) ? "<br/><br/>" : "";
			error = true;
			error_msg = error_msg + separator + "You must select how to handle the tags.";
		}
		// process order radio selections
		if( $('input[name="Process_Order"]').is(':checked') == false )
		{
			separator = ( error_msg != "" ) ? "<br/><br/>" : "";
			error = true;
			error_msg = error_msg + separator + "You must select in what order to process the files.";
		}
		
		// criteria separator required if File_Definition_1st_Criteria_Of_Name is checked.
		if( $('#File_Definition_1st_Criteria_Of_Name').is(':checked') && $('#File_Definition_To_Use_Criteria_Separator').val() == "" )
		{
			error = true;
			separator = ( error_msg != "" ) ? "<br/><br/>" : "";
			error_msg = error_msg + separator + "You have selected <strong>Process all files using the 1st criteria of the name as the file definition</strong> so you must provide a <i>'Criteria Separator'</i>.";
			$('#File_Definition_To_Use_Criteria_Separator').css({'border': '2px solid ' + border_color});
			$('#File_Definition_To_Use_Criteria_Separator').change(function(event){
				$('#File_Definition_To_Use_Criteria_Separator').css({'border': '1px solid #CCCCCC'});
			});
		}
		
		// file definition required if Process_All_Files_Using_This_File_Definition is checked.
		if( $('#Process_All_Files_Using_This_File_Definition').is(':checked') && $('#File_Definition_Id').val() == "" )
		{
			error = true;
			separator = ( error_msg != "" ) ? "<br/><br/>" : "";
			error_msg = error_msg + separator + "You have selected <strong>Process all files using this file definition</strong> so you must provide a <i>'File Definition'</i>.";
			$('#File_Definition_Id').css({'border': '2px solid ' + border_color});
			$('#File_Definition_Id').change(function(event){
				$('#File_Definition_Id').css({'border': '1px solid #CCCCCC'});
			});
		}
		
		// process by filename order required if Process in order by filename is checked.
		if( $('#Process_In_Order_By_Filename').is(':checked') && $('#Process_In_Order_By_Filename_Order').val() == "" )
		{
			error = true;
			separator = ( error_msg != "" ) ? "<br/><br/>" : "";
			error_msg = error_msg + separator + "You have selected <strong>Process in order by filename</strong> so you must provide a <i>'Filename Order'</i>.";
			$('#Process_In_Order_By_Filename_Order').css({'border': '2px solid ' + border_color});
			$('#Process_In_Order_By_Filename_Order').change(function(event){
				$('#Process_In_Order_By_Filename_Order').css({'border': '1px solid #CCCCCC'});
			});
		}
		
		// date order required if Process in order using last file criteria as a date is checked.
		if( $('#Process_In_Order_Using_File_Criteria_As_A_Date').is(':checked') && $('#Process_In_Order_Using_File_Criteria_As_A_Date_Order').val() == "" )
		{
			error = true;
			separator = ( error_msg != "" ) ? "<br/><br/>" : "";
			error_msg = error_msg + separator + "You have selected <strong>Process in order using last file criteria as a date</strong> so you must provide a <i>'Date Order'</i>.";
			$('#Process_In_Order_Using_File_Criteria_As_A_Date_Order').css({'border': '2px solid ' + border_color});
			$('#Process_In_Order_Using_File_Criteria_As_A_Date_Order').change(function(event){
				$('#Process_In_Order_Using_File_Criteria_As_A_Date_Order').css({'border': '1px solid #CCCCCC'});
			});
		}
		
		// criteria separator required if Process in order using last file criteria as a date is checked.
		if( $('#Process_In_Order_Using_File_Criteria_As_A_Date').is(':checked') && $('#Process_In_Order_Using_File_Criteria_As_A_Date_Criteria_Separator').val() == "" )
		{
			error = true;
			separator = ( error_msg != "" ) ? "<br/><br/>" : "";
			error_msg = error_msg + separator + "You have selected <strong>Process in order using last file criteria as a date</strong> so you must provide a <i>'Criteria Separator'</i>.";
			$('#Process_In_Order_Using_File_Criteria_As_A_Date_Criteria_Separator').css({'border': '2px solid ' + border_color});
			$('#Process_In_Order_Using_File_Criteria_As_A_Date_Criteria_Separator').change(function(event){
				$('#Process_In_Order_Using_File_Criteria_As_A_Date_Criteria_Separator').css({'border': '1px solid #CCCCCC'});
			});
		}
		
		
		
		if( error && error_msg.trim() != '')
		{
			notif({
				type: "error",
				msg: error_msg,
				position: "center",
				multiline: true,
				opacity: 0.9
			});
		}
		
		return error;
	}
	
	//  This function resets the dropdown selections when a new process file definitions radio input is checked.
	function ResetProcessFileDefinitionsSelections()
	{
		$('#File_Definition_To_Use_Criteria_Separator').val('');
		$('#File_Definition_Id').val('');
	}
	
	//  This function resets the dropdown selections when a new process order radio input is checked.
	function ResetProcessOrderSelections()
	{
		$('#Process_In_Order_By_Filename_Order').val('');
		$('#Process_In_Order_Using_File_Criteria_As_A_Date_Order').val('');
		$('#Process_In_Order_Using_File_Criteria_As_A_Date_Criteria_Separator').val('');
	}
	
	$(function(){
		$('#Select_Folder').fancybox({
			type: 'ajax',
			href: '/modal/SelectDataStorageFolder/?input=Config_Select_Folder',
			padding: 0,
			closeClick: false,
			closeBtn: false,
			helpers : {
				overlay : {
					opacity: 0.5
				}
		}});
		$('#Folder_Name').fancybox({
			type: 'ajax',
			href: '/modal/SelectDataStorageFolder/?input=Config_Select_Folder',
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
		$('#Config_Update_File_Tags').submit(function(event){
			event.preventDefault();
			$('#Config_Update_Box_File_Tags').button('loading');
			
			if( ValidateUpdateFilesForm() )
			{	
				$('#Config_Update_Box_File_Tags').button('reset');
				return false;
			}
			
			$('body').mask('Updating filenames & tags');
			
			var params = $('#Config_Update_File_Tags').serialize();
			
			$.ajax({
				url: '/data/UpdateBoxFileTags',
				data: params,
				type: 'POST',
				dataType: 'json',
				success: function(response){
					if( typeof response.Result != 'undefined' && response.Result == true )
					{
						//document.location.reload();
						$('body').unmask();
					}
					else
					{
						$('body').unmask();
						var error_message = ( typeof response.Result_Message != "undefined" ) ? response.Result_Message: "There was an error and the result message did not return.";
						$().Notification(error_message, {type: 'error'})
					}					
				},
				error: function(xhr){
					AjaxError(xhr);
				},
				complete: function(res){
					$('body').unmask();
					$('#Config_Update_Box_File_Tags').button('reset');
				}
			});
			
		});
	});
</script>