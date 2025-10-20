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
					<span>File Criteria</span>
					<button id="Config_New_File_Criteria" class="btn btn-primary btn-sm new_button pull-right hidden" type="button"><i class="fa fa-plus"></i> New File Criteria</button>
					<select id="Config_File_Definition_Id" name="File_Definition_Id" class="form-control input-sm new_button pull-right mr-10" style="width: 200px;">
						<option value=""></option> 
						<?php if( is_array($file_definitions_array) && count($file_definitions_array) > 0 ): ?>
							<?php foreach($file_definitions_array as $option): ?>
								<option value="<?php echo $option['File_Definition_Id']; ?>"><?php echo $option['File_Def_Name']; ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>	
				<div class="panel-body p-0">
					<table id="Config_File_Criteria_Grid" class="table table-striped" cellspacing="0" width="100%">
						<thead>
						    <tr>
							   <th>File Criteria</th>
						    </tr>
						</thead>
						<tbody>
						</tbody>
					 </table>
				</div>
			</div>
		</div>

		<div class="col-md-6 pl-0 pr-0">
			<div id="Config_File_Criteria_Container" class="panel panel-default">
				<div class="panel-heading hidden" id="Config_File_Criteria_Header">
					<span>File Criteria</span>
				</div>
				<div class="panel-body">
					
						<div id="Config_File_Criteria_Wrapper">
							<div id="Config_File_Criteria_Placeholder" class="alert alert-info mb-0">
								<h3 class="mt-0 pt-0">Select a File Definition</h3>
								<strong>Click</strong> on a file criteria's name to edit a file criteria.<br/>
								<strong>Click</strong> the "New File Criteria" button to the left to create a new file criteria record.
							</div>
							<div id="Config_File_Criteria" class="row hidden">
								<form id="Config_File_Criteria_Form" class="mt-0">
									<div class="form-group">
										<label for="Criteria_Name" class="col-sm-3 control-label font-normal font-12 text-darkgray text-right">Name: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="File Criteria Name" data-content="The label to identify the file criteria."></i></label>
										<div class="col-sm-9">
											<input type="text" class="form-control input-sm required" id="Criteria_Name" name="Criteria_Name" placeholder="" data-err-msg="The File Criteria name is required." value="">
										</div>
										<div class="clear"></div>
									</div>
									<div class="form-group clear">
										<label for="Criteria_Type_Id" class="col-sm-3 control-label font-normal text-darkgray font-12 text-right">Type: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="File Criteria Value Type" data-content="The type of value that is allowed to be entered for this file criteria."></i></label>
										<div class="col-sm-9">
											<select id="Criteria_Type_Id" name="Criteria_Type_Id" class="form-control input-sm required" data-err-msg="The Criteria Type is required.">
												<option value=""></option>
												<?php if( is_array($criteria_types_array) && count($criteria_types_array) > 0 ): ?>
													<?php foreach($criteria_types_array as $option): ?>
														<option value="<?php echo $option['Criteria_Type_Id']; ?>"><?php echo $option['Criteria_Type_Name']; ?></option>
													<?php endforeach; ?>
												<?php endif; ?>
											</select>
										</div>
										<div class="clear"></div>
									</div>
									<hr/>
									<div class="form-group clear">
										<label for="Criteria_Required" class="col-sm-6 control-label font-normal text-darkgray font-12 text-left">Is the User Required to enter a value: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="Required?" data-content="When renaming the document, is this file criteria required"></i></label>
										<div class="col-sm-6">
											<input type="hidden" name="Criteria_Required" value="0" />
											<input type="checkbox" id="Criteria_Required" name="Criteria_Required" value="1" />
										</div>
										<div class="clear"></div>
									</div>
									
									<div class="form-group clear">
										<label for="Criteria_Min_Len" class="col-sm-5 control-label font-normal text-darkgray font-12 text-right">Minimum number of characters: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="Minimum number of characters" data-content="The minimum number of characters allowed for this file criteria value."></i></label>
										<div class="col-sm-7">
											<input type="text" class="form-control input-sm input_3" id="Criteria_Min_Len" name="Criteria_Min_Len" data-err-msg="Minimum number of characters is required." size="2" placeholder="" value="">
										</div>
										<div class="clear"></div>
									</div>
									<div class="form-group clear">
										<label for="Criteria_Max_Len" class="col-sm-5 control-label font-normal text-darkgray font-12 text-right">Maximum number of characters: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="Maximum number of characters" data-content="The maximum number of characters allowed for this file criteria value."></i></label>
										<div class="col-sm-7">
											<input type="text" class="form-control input-sm input_3" id="Criteria_Max_Len" name="Criteria_Max_Len" data-err-msg="Maximum number of characters is required." size="2" placeholder="" value="">
										</div>
										<div class="clear"></div>
									</div>
									<div class="form-group clear">
										<label for="Criteria_Default_Value" class="col-sm-3 control-label font-normal text-darkgray font-12 text-right">Default Value: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="Default Value" data-content="The default value for this file criteria. It will appear when the file criteria is loaded for the file definition selected."></i></label>
										<div class="col-sm-9">
											<input type="text" class="form-control input-sm" id="Criteria_Default_Value" name="Criteria_Default_Value" size="2" placeholder="" data-err-msg="" value="">
										</div>
										<div class="clear"></div>
									</div>
									<div class="form-group clear">
										<label for="Criteria_Tooltip" class="col-sm-3 control-label font-normal text-darkgray font-12 text-right">Tooltip: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="Tooltip" data-content="The tooltip that describes the file criteria, and is displayed when the file criteria is selected."></i></label>
										<div class="col-sm-9">
											<input type="text" class="form-control input-sm" id="Criteria_Tooltip" name="Criteria_Tooltip" size="2" placeholder="" data-err-msg="" value="">
										</div>
										<div class="clear"></div>
									</div>
									<hr/>
									<div class="form-group clear">
										<label for="Criteria_Recall_Name" class="col-sm-3 control-label font-normal text-darkgray font-12 text-right">Recall Value: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="Recall Value" data-content="If this is selected, the value entered for this file criteria will be saved, and will display if it matches the value being typed into the file criteria."></i></label>
										<div class="col-sm-9">
											<input type="hidden" name="Criteria_Recall_Name" value="0" />
											<input type="checkbox" id="Criteria_Recall_Name" name="Criteria_Recall_Name" value="1" />
										</div>
										<div class="clear"></div>
									</div>
									<div class="form-group clear">
										<label for="Criteria_Prefix" class="col-sm-3 control-label font-normal text-darkgray font-12 text-right">Prefix: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="Prefix" data-content="A value that will be concatenated <i>before</i> the file criteria value when renaming a file."></i></label>
										<div class="col-sm-9">
											<input type="text" class="form-control input-sm" id="Criteria_Prefix" name="Criteria_Prefix" placeholder="" data-err-msg="" value="">
										</div>
										<div class="clear"></div>
									</div>
									<div class="form-group clear">
										<label for="Criteria_Suffix" class="col-sm-3 control-label font-normal text-darkgray font-12 text-right">Suffix: <i class="fa fa-question-circle text-primary cursor-pointer po" data-toggle="popover" data-container="body" data-placement="right" title="Suffix" data-content="A value that will be concatenated <i>after</i> the file criteria value when renaming a file."></i></label>
										<div class="col-sm-9">
											<input type="text" class="form-control input-sm" id="Criteria_Suffix" name="Criteria_Suffix" placeholder="" data-err-msg="" value="">
										</div>
										<div class="clear"></div>
									</div>
									<div class="criteria_type criteria_type_ruler hide"><hr/></div>
									<div class="form-group clear criteria_type type_number type_currency hide">
										<label for="Criteria_Decimals" class="col-sm-3 control-label font-normal text-darkgray font-12 text-right">Decimals: <i class="fa fa-question-circle text-primary"></i></label>
										<div class="col-sm-9">
											<input type="text" class="form-control input-sm input_3" id="Criteria_Decimals" name="Criteria_Decimals" placeholder="" data-err-msg="" value="">
										</div>
										<div class="clear"></div>
									</div>
									<div class="form-group clear criteria_type type_number type_currency hide">
										<label for="Criteria_Dec_Point" class="col-sm-3 control-label font-normal text-darkgray font-12 text-right">Dec. Point: <i class="fa fa-question-circle text-primary"></i></label>
										<div class="col-sm-9">
											<input type="text" class="form-control input-sm input_3" id="Criteria_Dec_Point" name="Criteria_Dec_Point" placeholder="" data-err-msg="" value="">
										</div>
										<div class="clear"></div>
									</div>
									<div class="form-group clear criteria_type type_number type_currency hide">
										<label for="Criteria_Thousands_Sep" class="col-sm-3 control-label font-normal text-darkgray font-12 text-right">Thousands Sep: <i class="fa fa-question-circle text-primary"></i></label>
										<div class="col-sm-9">
											<input type="text" class="form-control input-sm input_3" id="Criteria_Thousands_Sep" name="Criteria_Thousands_Sep" placeholder="" data-err-msg="" value="">
										</div>
										<div class="clear"></div>
									</div>
									<div class="form-group clear criteria_type type_currency hide">
										<label for="Criteria_Currency_Symbol" class="col-sm-3 control-label font-normal text-darkgray font-12 text-right">Currency Symbol: <i class="fa fa-question-circle text-primary"></i></label>
										<div class="col-sm-9">
											<input type="text" class="form-control input-sm input_3" id="Criteria_Currency_Symbol" name="Criteria_Currency_Symbol" placeholder="" data-err-msg="" value="">
										</div>
										<div class="clear"></div>
									</div>
									<div class="form-group clear criteria_type type_date hide">
										<label for="Days_Back" class="col-sm-3 control-label font-normal text-darkgray font-12 text-right">Days Back: <i class="fa fa-question-circle text-primary"></i></label>
										<div class="col-sm-1">
											<input type="text" class="form-control input-sm input_3" id="Days_Back" name="Days_Back" placeholder="" data-err-msg="" value="">
										</div>
										<span class="pull-left text-center ml-20 text-muted"> OR </span>
										<label for="Date_Back" class="pull-left control-label font-normal text-darkgray font-12 ml-10">Date Back: <i class="fa fa-question-circle text-primary"></i></label>
										<div class="col-sm-1">
											<input type="text" class="form-control input-sm input_10 datepicker" id="Date_Back" name="Date_Back" placeholder="" data-err-msg="" value="">
										</div>
										<div class="clear"></div>
									</div>
									<div class="form-group clear criteria_type type_date hide">
										<label for="Days_Forward" class="col-sm-3 control-label font-normal text-darkgray font-12 text-right">Days Forward: <i class="fa fa-question-circle text-primary"></i></label>
										<div class="col-sm-1">
											<input type="text" class="form-control input-sm input_3" id="Days_Forward" name="Days_Forward" placeholder="" data-err-msg="" value="">
										</div>
										<span class="pull-left text-center ml-20 text-muted"> OR </span>
										<label for="Date_Forward" class="pull-left control-label font-normal text-darkgray font-12 ml-10">Date Forward: <i class="fa fa-question-circle text-primary"></i></label>
										<div class="col-sm-1">
											<input type="text" class="form-control input-sm input_10 datepicker" id="Date_Forward" name="Date_Forward" placeholder="" data-err-msg="" value="">
										</div>
										<div class="clear"></div>
									</div>
									<div class="form-group clear criteria_type type_date hide">
										<label for="Criteria_Date_Format" class="col-sm-3 control-label font-normal text-darkgray font-12 text-right">Date Format: <i class="fa fa-question-circle text-primary"></i></label>
										<div class="col-sm-9">
											<select id="Criteria_Date_Format" name="Criteria_Date_Format" class="form-control">
												<?php if( count($date_formats_array) > 0 ): ?>
													<?php foreach($date_formats_array as $option): ?>
														<option value="<?php echo $option['Php_Date_Format_Str']; ?>|<?php echo $option['JavaScript_Date_Format_Str']; ?>"><?php echo $option['Date_Format_Desc']; ?></option>
													<?php endforeach; ?>
												<?php endif; ?>
											</select>
										</div>
										<div class="clear"></div>
									</div>
									<hr/>
									<div class="form-group clear">
										<div class="col-sm-8">
											<input type="hidden" id="File_Criteria_Id" name="File_Criteria_Id" value="" />
											<button type="submit" id="Config_Save_File_Criteria" class="btn btn-primary">Save File Criteria</button>
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
	document.getElementById('Config_File_Definition_Id').value = ""; // reset the file definition dropdown to the default empty value.
</script>