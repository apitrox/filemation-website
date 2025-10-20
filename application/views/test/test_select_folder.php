<style type="text/css">
	
	.data_storage_wrapper {
		width: 500px;
		margin: auto;
	}
		.data_storage_master_folder {
			margin: 40px 100px 40px 100px;
		}
		
		.data_storage_master_folder ul li {
			/*background: url(/assets/imgs/loader24.gif) no-repeat 0px 0px transparent;*/
			list-style-type: none;
			margin: 0;
			padding: 3px 0px 1px 24px;
			vertical-align: middle;
		}
		
		.data_storage_master_folder ul li.loader {
			background: none !important;
			list-style-type: none;
		}
			.data_storage_master_folder ul > ul {
				margin: 0px 0px 0px 40px;
			}
		
		.data_storage_master_folder ul li:before {
			content: "\f000";
			font-family: FontAwesome;
			font-style: normal;
			font-weight: normal;
			text-decoration: inherit;
		 /*--adjust as necessary--*/
			color: #000;
			font-size: 18px;
			padding-right: 0.5em;
			position: absolute;
			top: 10px;
			left: 0;
		 }
	
		 .data_storage_folder_selected {
			 background-color: #CCE0FF;
		 }
			
</style>

<div class="data_storage_wrapper">
	<div class="data_storage_master_folder">
		<ul id="Master_Folder"><li class="loader"><img src="/assets/imgs/loader.gif"/></li></ul>
	</div>
</div>

<script type="text/javascript">
	
	///////////// TEMPORARY
	// this will be set on every page of the application
	// this will contain all of the user's session data in a javascript object to be referrenced later
	user_session = {
					account_id: 1000000033
				}
	
	master_folder = [];
	
	
	StartDataStorageFolders();
	
	
	function StartDataStorageFolders()
	{
		$.ajax({
			url: '/json/DataStorageGetAllFoldersInRoot',
			data: { 'aid': user_session.account_id},
			type: 'GET',
			dataType: 'json',
			error: function(xhr, status){
				// handle error processing
			},
			success: function(response){

				if( typeof response.Result != 'undefined' && response.Result == true )
				{
					$('#Master_Folder').empty();
					
					var data = response.Data;
					$(data).each(function(index, item){

						var folder_obj = item;
						
						master_folder[item.Id] = folder_obj;
						
						var id = 'Data_Storage_Folder_' + item.Id;
						var data_data_storage_folder_id = item.Id;
						var li = $('<li/>');
						$(li).attr({'id': id, 'data-data-storage-folder-id': data_data_storage_folder_id})
						$(li).css({'cursor': 'pointer'});
						
						
						var div_wrapper = $('<div/>');
						$(div_wrapper).attr('data-data-storage-folder-id', item.Id);
						$(div_wrapper).click(function(event){
							$('.data_storage_folder_selected').each(function(index, item){
								$(this).removeClass('data_storage_folder_selected');
							});
							$(this).addClass('data_storage_folder_selected');
						});
						
						var folder_icon = $('<i/>').addClass('fa fa-folder fa-lg');
						$(folder_icon).click(function(event){
							$(div_wrapper).removeClass('data_storage_folder_selected');
							CreateDataStorageSlaveFolderElements(data_data_storage_folder_id, folder_icon);
						});
						
						var span = $('<span/>').text(item.Name);
						$(span).css({'margin-left': '10px'});
						
						$(div_wrapper).append(folder_icon);
						$(div_wrapper).append(span);
						$(li).append(div_wrapper);
						$('#Master_Folder').append(li);
						
					});
				}
				else
				{

				}
			}

		});
		
	}
	
	function CreateDataStorageSlaveFolderElements(data_storage_folder_id, folder_icon_el)
	{
		// check if we have already looked for the folders
		var exists = false;
		$('#Data_Storage_Folder_' + data_storage_folder_id).find('ul').each(function(index, item){
			exists = true;
		});

		// if we have not already searched for the folders then lets proceed and look if any folders exist.
		// if they exist create them in the hierarchy
		if( !exists )
		{	
			$(folder_icon_el).removeClass('fa-folder').addClass('fa-refresh fa-spin');
			$.ajax({
				url: '/json/DataStorageGetAllFoldersInFolder',
				data: { 'aid': user_session.account_id, 'data_storage_folder_id': data_storage_folder_id},
				type: 'GET',
				dataType: 'json',
				error: function(xhr, status){
					// handle error processing
				},
				success: function(response){

					if( typeof response.Result != 'undefined' && response.Result == true )
					{
						$(folder_icon_el).removeClass('fa-refresh fa-spin').addClass('fa-folder-open');
						
						var ul_id = 'Wrapper_Data_Storage_Folder_' + data_storage_folder_id;
						var ul = $('<ul/>');
						$(ul).attr({'id': ul_id});
						$(ul).css({'background-color': '#FFFFFF !important'})
						

						var data = response.Data;
						$(data).each(function(index, item){

							var folder_obj = item;

							master_folder[item.Id] = folder_obj;

							var this_data_data_storage_folder_id = item.Id;
							
							var div_wrapper = $('<div/>');
							$(div_wrapper).attr('data-data-storage-folder-id', item.Id);
							$(div_wrapper).click(function(event){
								$('.data_storage_folder_selected').each(function(index, item){
									$(this).removeClass('data_storage_folder_selected');
								});
								$(this).addClass('data_storage_folder_selected');
							});
							
							var folder_icon = $('<i/>').addClass('fa fa-folder fa-lg');
							$(folder_icon).click(function(event){
								$(div_wrapper).removeClass('data_storage_folder_selected');
								CreateDataStorageSlaveFolderElements(this_data_data_storage_folder_id, folder_icon);
							});
							
							var span = $('<span/>').text(item.Name);
							$(span).css({'margin-left': '10px'});
							
							var li_id = 'Data_Storage_Folder_' + item.Id;
							var li = $('<li/>');
							$(li).attr({'id': li_id, 'data-data-storage-folder-id': this_data_data_storage_folder_id})
							$(li).css({'cursor': 'pointer'});
							
							$(div_wrapper).append(folder_icon);
							$(div_wrapper).append(span);
							$(li).append(div_wrapper);
							$(ul).append(li);

						});

						$('#Data_Storage_Folder_' + data_storage_folder_id).append(ul);
						
					}
					else
					{
						if( $('#Wrapper_Data_Storage_Folder_' + data_storage_folder_id).is(':visible') )
						{
							$('#Wrapper_Data_Storage_Folder_' + data_storage_folder_id).hide();
						}
						else
						{
							$('#Wrapper_Data_Storage_Folder_' + data_storage_folder_id).show();
						}
					}
				}

			});
		
		}
		else
		{
		
		}
		
		
		
	}
	
	
</script>