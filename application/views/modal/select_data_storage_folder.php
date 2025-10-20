<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="$.fancybox.close();">&times;</button>
		<h4 class="modal-title" id="myModalLabel">Select Folder</h4>
	</div>
	<div class="modal-body">		
		<div class="alert alert-info" role="alert">
			<span class="fa fa-info"></span>&nbsp;&nbsp;<span>Click folder icon to open, folder name to select.</span>
		</div>
		<hr/>
		<div id="Select_Data_Storage_Folder_Err_Msg" class="alert alert-warning alert-dismissible hide" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<strong>Warning!</strong> To save, you must select a new folder.
		</div>		
		<div class="data_storage_wrapper">
			<div class="data_storage_master_folder">
				<ul id="Master_Folder"><li class="loader"><img src="/assets/imgs/loader108.gif"/></li></ul>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal" onclick="$.fancybox.close();">Close</button>
		<button type="button" id="Save_Folder_Selection" class="btn btn-primary">Select</button>
	</div>
</div>
<script type="text/javascript">
	master_folder = [];
	
	var input = '<?php echo $input; ?>';
	var folder_id;
	if( input == 'To_Be_Filed_Source_Folder' )
	{
		folder_id = ( typeof globalSourcePathId != 'undefined' ) ? globalSourcePathId : '';
	}
	else if( input == 'To_Be_Filed_Destination_Folder' )
	{
		folder_id = ( typeof globalDestinationPathId != 'undefined' ) ? globalDestinationPathId : '';
	}
	
	$(function(){		
		StartDataStorageFolders(folder_id);
	});
	$(function(){
		$('body').on('hidden.bs.modal', '.modal', function () {
			$(this).removeData('bs.modal');
		});
	});
	$(function(){
		$('#Save_Folder_Selection').off();
		$('#Save_Folder_Selection').on('click', function(event){
			var $data_storage_folder = $('.data_storage_folder_selected');
			var data_storage_folder_id = $($data_storage_folder).attr('data-data-storage-folder-id');
			var data_storage_folder_name = $($data_storage_folder).text();
			var data_storage_folder_full_path_label = $($data_storage_folder).attr('data-full-folder-path-label');
			console.log(data_storage_folder_full_path_label);
			if( typeof data_storage_folder_id == 'undefined' )
			{
				$('#Select_Data_Storage_Folder_Err_Msg').removeClass('hide');
				return false;
			}
			else
			{
				if( input == 'To_Be_Filed_Source_Folder' )
				{
					$('#' + input).text(data_storage_folder_name);
					$('#' + input).tooltip('destroy');
					$('#' + input).tooltip({
						placement: 'top',
						trigger: 'hover',
						title: data_storage_folder_full_path_label
					});
					
					globalSourcePathId = data_storage_folder_id;
					
					if( typeof GetDocumentsToBeFiledGrid == 'function' )
					{
						GetDocumentsToBeFiledGrid(); // refresh the grid
					}
					
					$.ajax({
						url: '/data/SaveSessionVar/',
						data: {session_name: 'default_source_location', session_value: data_storage_folder_id},
						type: 'GET',
						dataType: 'json',
						success: function(response){
							
						},
						error: function(xhr){
							AjaxError(xhr);
						}
					});
					
					$.fancybox.close();
				}
				else if( input == 'To_Be_Filed_Destination_Folder' )
				{
					$('#' + input).val(data_storage_folder_name);
					$('#' + input).tooltip('destroy');
					$('#' + input).tooltip({
						placement: 'top',
						trigger: 'hover',
						title: data_storage_folder_full_path_label
					});
					globalDestinationPathId = data_storage_folder_id;
					$.fancybox.close();
				}
				else if( input == 'Config_Account_Data_Storage_Default_Source_Location' )
				{
					$('#Default_Source_Location').val(data_storage_folder_id);
					$('#Default_Source_Location_Name').val(data_storage_folder_name);
					$('#Default_Source_Location_Name').tooltip('destroy');
					$('#Default_Source_Location_Name').tooltip({
						placement: 'top',
						trigger: 'hover',
						title: data_storage_folder_full_path_label
					});
					$.fancybox.close();
				}
				else if( input == 'Config_File_Definition_Data_Storage_Default_Destination_Path' )
				{
					$('#Default_Destination_Path').val(data_storage_folder_id);
					$('#Default_Destination_Path_Name').val(data_storage_folder_name);
					$('#Default_Destination_Path_Name').tooltip('destroy');
					$('#Default_Destination_Path_Name').tooltip({
						placement: 'top',
						trigger: 'hover',
						title: data_storage_folder_full_path_label
					});
					$.fancybox.close();
				}
				else if( input == 'Config_Select_Folder' )
				{
					$('#Folder_Id').val(data_storage_folder_id);
					$('#Folder_Name').val(data_storage_folder_name);
					$('#Folder_Name').tooltip('destroy');
					$('#Folder_Name').tooltip({
						placement: 'top',
						trigger: 'hover',
						title: data_storage_folder_full_path_label
					});
					$.fancybox.close();
				}
			}
			
		});
	});
</script>