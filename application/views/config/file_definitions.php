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
					<span>File Definitions</span>
					<button id="Config_New_File_Definition" class="btn btn-primary btn-sm new_button pull-right" type="button"><i class="fa fa-plus"></i> New File Definition</button>
					<input type="text" id="Config_File_Definitions_Search" class="form-control grid_row_search_input input-sm" placeholder="Search file definitions" />
				</div>	
				<div class="panel-body p-0">
					<table id="Config_File_Definitions_Grid" class="table table-striped" cellspacing="0" width="100%">
						<thead>
						    <tr>
							   <th>File Definition</th>
						    </tr>
						</thead>
						<tbody>
						</tbody>
					 </table>
				</div>
			</div>
			<div>
				<div id="Config_File_Definitions_Grid_Custom_Page_Length" class="pull-left"></div>
				<div id="Config_File_Definitions_Grid_Custom_Pagination" class="pull-right"></div>
			</div>
		</div>

		<div class="col-md-6 pl-0 pr-0">
			<div id="Config_File_Definition_Container" class="panel panel-default">
				<div class="panel-heading hidden" id="Config_File_Definition_Header">
					<span>File Definition</span>
				</div>
				<div class="panel-body">
					
						<div id="Config_File_Definition_Wrapper">
							<div id="Config_File_Definition_Placeholder" class="alert alert-info mb-0">
								<p><i class="fa fa-info-circle"></i> To edit an existing <strong>File Definition</strong> click on a file definition name to the left.<p>
								
								<p><i class="fa fa-info-circle"></i> To create a <strong>New File Definition</strong> click on the <i>New File Definition</i> button.
									
							</div>
							<div id="Config_File_Definition" class="row hidden">
								<form id="Config_File_Definition_Form" class="">
									<div class="form-group">
										<label for="File_Def_Name" class="col-sm-3 control-label font-normal font-12 text-darkgray text-right">Name: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="File Definition Name" data-content="The value to label or identify the file definition."></i></label>
										<div class="col-sm-9">
											<input type="text" class="form-control input-sm required" id="File_Def_Name" name="File_Def_Name" placeholder="" data-err-msg="The File Definition name is required." value="">
											<div class="mt-10">
												<input type="hidden" name="Definition_Starts_Filename" value="0" />
												<input type="checkbox" name="Definition_Starts_Filename" id="Definition_Starts_Filename" data-val-title="" value="1"/> <label for="Definition_Starts_Filename" class="font-normal text-muted font-12">Use as beginning of filename <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="bottom" data-content="Use the file definition name, above, at the beginning of the filename when renaming a file."></i></label>
											</div>
										</div>
										<div class="clear"></div>
									</div>
									<div class="form-group clear">
										<label for="Default_Destination_Path" class="col-sm-3 control-label font-normal text-darkgray font-12 text-right">Def. Dest. Folder: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="Default Destination Folder" data-content="The path to move too when filing a file or document."></i></label>
										<div class="col-sm-9">
											<div class="input-group">
												<span class="input-group-btn">
													<button id="Select_Default_Destination_Path" class="btn btn-default btn-sm" type="button"><i class="fa fa-folder"></i></button>
												</span>
												<input type="text" id="Default_Destination_Path_Name" name="Default_Destination_Path_Name" class="form-control input-sm" data-toggle="tooltip" data-placement="top" data-err-msg="A default destination folder is required." placeholder="The folder in which to file these documents" value="">
												<input type="hidden" id="Default_Destination_Path" name="Default_Destination_Path" value="" />
											</div>
											<div class="mt-10">
												<input type="hidden" name="Is_Destination_Path_Selectable" value="0" />
												<input type="checkbox" name="Is_Destination_Path_Selectable" id="Is_Destination_Path_Selectable" value="1"/> <label for="Is_Destination_Path_Selectable" class="font-normal text-muted font-12">User Can Change Source Folder <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="bottom" data-content="If this is enabled, regular users will be able to change the destination folder when filing files or documents."></i></label>
											</div>
										</div>
										<div class="clear"></div>
									</div>
									<hr/>
									<div class="form-group clear">
										<label for="Min_Pages" class="col-sm-3 control-label font-normal text-darkgray font-12 text-right">Min Pages: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="Minimum Pages" data-content="The minimum page count a <strong>document</strong> must be to be filed or renamed as this file definition."></i></label>
										<div class="col-sm-9">
											<input type="text" class="form-control input-sm input_3" id="Min_Pages" name="Min_Pages" size="2" placeholder="" value="">
										</div>
										<div class="clear"></div>
									</div>
									<div class="form-group clear">
										<label for="Max_Pages" class="col-sm-3 control-label font-normal text-darkgray font-12 text-right">Max Pages: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="Maximum Pages" data-content="The maximum page count a <strong>document</strong> must be to be filed or renamed as this file definition."></i></label>
										<div class="col-sm-9">
											<input type="text" class="form-control input-sm input_3" id="Max_Pages" name="Max_Pages" size="2" placeholder="" value="">
										</div>
										<div class="clear"></div>
									</div>
									<div class="form-group clear">
										<label for="Criteria_Pages" class="col-sm-3 control-label font-normal text-darkgray font-12 text-right">Criteria Separator: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="Criteria Separator" data-content="The character to separate the parts of the filename when a file is renamed."></i></label>
										<div class="col-sm-9">
											<select id="Criteria_Separator" name="Criteria_Separator" data-err-msg="The Criteria Separator name is required." class="selectpicker required">
												<option value="">&nbsp;</option>
												<?php if( count($criteria_separators_ref_array) > 0 ): ?>
													<?php foreach($criteria_separators_ref_array as $option): ?>
														<option value="<?php echo $option['Criteria_Separator_Chars']; ?>" data-subtext="<?php echo $option['Criteria_Separator_Chars']; ?>"><?php echo $option['Criteria_Separator_Name']; ?></option>
													<?php endforeach; ?>
												<?php endif; ?>
											</select>
										</div>
										<div class="clear"></div>
									</div>
									<hr/>
									<div class="form-group clear">
										<label for="Update_Modified_Date" class="col-sm-4 control-label font-normal text-darkgray font-12 text-right">Update Modified Date: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="Update Modified Date" data-content="When a file is renamed or filed, update the modified date with the data storage provider to a specified date."></i></label>
										<div class="col-sm-8">
											<input type="hidden" name="Update_Modified_Date" value="0" />
											<input type="checkbox" id="Update_Modified_Date" name="Update_Modified_Date" value="1" />
										</div>
										<div class="clear"></div>
									</div>
									<div class="form-group clear">
										<label for="Update_Created_Date" class="col-sm-4 control-label font-normal text-darkgray font-12 text-right">Update Created Date: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="Update Created Date" data-content="When a file is renamed or filed, update the created date with the data storage provider to a specified date."></i></label>
										<div class="col-sm-8">
											<input type="hidden" name="Update_Created_Date" value="0" />
											<input type="checkbox" id="Update_Created_Date" name="Update_Created_Date" value="1">
										</div>
										<div class="clear"></div>
									</div>
									<hr/>
									<div class="form-group clear">
										<div class="col-sm-8">
											<input type="hidden" id="File_Definition_Id" name="File_Definition_Id" value="" />
											<button type="submit" id="Config_Save_File_Definition" class="btn btn-primary">Save File Definition</button>
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
		$('#Select_Default_Destination_Path').fancybox({
			type: 'ajax',
			href: '/modal/SelectDataStorageFolder/?input=Config_File_Definition_Data_Storage_Default_Destination_Path',
			padding: 0,
			closeClick: false,
			closeBtn: false,
			helpers : {
				overlay : {
					opacity: 0.5
				}
		}});
	});
	$('#Default_Destination_Path_Name').on('click', function(event){
		event.preventDefault();
		$.fancybox({
			type: 'ajax',
			href: '/modal/SelectDataStorageFolder/?input=Config_File_Definition_Data_Storage_Default_Destination_Path',
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
</script>