<script type="text/javascript" src="/assets/js/filer.js?ver=<?php echo random_string('unique'); ?>"></script>
<!-- Page -->
<div class="container">
	<div class="row file_wrapper">

		<div id="Filer_Left_Col" class="col-xs-12 col-sm-12 col-lg-4 filer_left_col">

			<div id="Document_Controls" class="panel panel-default filer_document_controls">
				<div class="panel-heading">
					 <h2 class="panel-title"><strong>File Description</strong></h2>
				</div>
				<div class="panel-body filer_document_controls_body">

					<form id="Document_Controls_Form" onsubmit="">
						<!-- start Document Controls -->            
						<div >
							<!-- start Step 1 File Definitions -->
							<div id="File_Definitions_Wrapper" class="file_definition document_control hidden">
								<?php if( count($file_definitions_array) > 0 ): ?>
									<select id="File_Definition_Id" name="File_Definition_Id" class="form-control selectpicker" onchange="LoadFileCriteria(this.value);">
										<option value="">&nbsp;</option>
										<?php foreach($file_definitions_array as $row): ?>
											<option value="<?php echo $row['File_Definition_Id']; ?>"><?php echo $row['File_Def_Name']; ?></option>
										<?php endforeach; ?>
									</select>
								<?php else: ?>
								<span>No file definitions exist for your account.<br/><a href="/config/filedefinitions">Create file definitions</a>.</span>
								<?php endif; ?>
							</div>
							<!-- end Step 1 File Definitions -->
							<!-- start Document Control Destination -->
							<div id="Document_Controls_Destination">
								<input type="hidden" name="" id="" value="" />
							</div>
							<!-- end Document Control Destination -->
							<!-- start Document Control Action Buttons -->
							<div id="Document_Controls_Action_Buttons" class="file_actions hidden">
								<button type="Submit" class="btn btn-primary" id="Rename_And_File_Document" onclick="return false;">File and Rename</button>
								<button type="Submit" class="btn btn-info" id="Rename_Document" onclick="return false;">Rename</button>
								<button class="btn btn-default" id="Reset_File_Criteria" onclick="ResetFileCriteriaForm('Document_Controls_Form'); return false;">Reset</button>
							</div>
							<!-- end Document Control Action Buttons -->
						</div>			
						<!-- end Document Controls -->				 
					</form>

				</div>
			</div>



			<!-- start To Be Filed List -->
			<div class="files_to_be_filed">
				<div class="panel panel-white">
					<div class="panel-heading">
						<h2 class="panel-title"><strong>File List</strong></h2>
					</div>
					<div class="files_to_be_filed_header">
						<span class="files_to_be_filed_header_icon"><a  href="/modal/SelectDataStorageFolder/?input=To_Be_Filed_Source_Folder" class="modalbox"><span class="folder_closed_icon filer_tooltip" data-placement="top" title="Select default source folder"></span></a></span>
						<span id="To_Be_Filed_Source_Folder" class="to_be_filed_label cursor-pointer hover-underline"><a href="/modal/SelectDataStorageFolder/?input=To_Be_Filed_Source_Folder" class="modalbox text-black filer_tooltip" data-placement="top" title="Select default source folder"><?php echo $default_source_location_name; ?></a></span>
						<span class="to_be_filed_button_group">
							<div class="btn-group  btn-group-xs">
								<div class="btn-group  btn-group-xs">
									<button type="button" class="btn btn-default dropdown-toggle to_be_filed_files filer_tooltip" data-toggle="dropdown" title="Alphabetic listing">
										<span id="To_Be_Filed_Alpha_Sort_Text" class="selection">ALL</span>&nbsp;&nbsp;<span class="caret"></span>
									</button>
									<ul id="" class="dropdown-menu to_be_filed_alpha_sort" role="menu">
										<li><a>ALL</a></li>
										<li><a rel="1-9">1-9</a></li>
										<li><a rel="A">A</a></li>
										<li><a rel="B">B</a></li>
										<li><a rel="C">C</a></li>
										<li><a rel="D">D</a></li>
										<li><a rel="E">E</a></li>
										<li><a rel="F">F</a></li>
										<li><a rel="G">G</a></li>
										<li><a rel="H">H</a></li>
										<li><a rel="I">I</a></li>
										<li><a rel="J">J</a></li>
										<li><a rel="K">K</a></li>
										<li><a rel="L">L</a></li>
										<li><a rel="M">M</a></li>
										<li><a rel="N">N</a></li>
										<li><a rel="O">O</a></li>
										<li><a rel="P">P</a></li>
										<li><a rel="Q">Q</a></li>
										<li><a rel="R">R</a></li>
										<li><a rel="S">S</a></li>
										<li><a rel="T">T</a></li>
										<li><a rel="U">U</a></li>
										<li><a rel="V">V</a></li>
										<li><a rel="W">W</a></li>
										<li><a rel="X">X</a></li>
										<li><a rel="Y">Y</a></li>
										<li><a rel="Z">Z</a></li>
									</ul>
								</div>
								<button type="button" id="To_Be_Filed_Sort" class="btn btn-default filer_tooltip" title="Sort"><span class="fa fa-sort"></span></button>
								<button type="button" id="To_Be_Filed_Refresh" class="btn btn-default filer_tooltip" title="Refresh"><span class="fa fa-rotate-right"></span></button>
							</div>
						</span>
					</div>
					<div id="To_Be_Filed_File_Grid" class="panel-body to_be_filed_file_grid">
						<div class="loader"><img src="/assets/imgs/loader108.gif" /></div>
					</div>
				</div>





			</div>
			<!-- end To Be Filed List -->				 
		</div>
		<div class="col-xs-12 col-sm-12 col-lg-8 filer_right_col pr-0">
			<!-- start Document View -->
			<div class="modify_doc_wrapper hidden">
				<div class="page_cnt">
					<i class="fa fa-file-text-o"></i><span id="Page_Number_Label">?</span>
				</div>
				<div class="dropdown">
					<div class="btn-group">
						<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
							Actions <span class="caret"></span>
						</button>
						<ul class="dropdown-menu dropdown-menu-right" role="menu">
							<!-- <li rel="Split"><a href="#" onclick="ModifyFile('Split');">Split</a></li> -->
							<!-- <li rel="Merge"><a href="#" onclick="ModifyFile('Merge');">Merge</a></li> -->
							<li id="Rotate_Data_Storage_Item" rel="Rotate"><a href="#" id="Rotate_Data_Storage_File" onclick="ModifyFile('Rotate');">Rotate</a></li>
							<!-- <li rel="OCR"><a href="#" onclick="ModifyFile('OCR');">OCR</a></li> -->
							<li id="Data_Storage_Divider_Item" class="divider"></li>
							<li id="Delete_Data_Storage_Item" rel="Delete"><a href="#" id="Delete_Data_Storage_File" onclick="ModifyFile('Delete');">Delete</a></li>
						</ul>
					</div>
				</div>
				<div class="clear"></div>
			</div>

			<div>
				<iframe id="View_PDF_File" class="pdf_viewer_frame" src="/docs/FilerDefaultView/" height="650px">
					<div class="notification note-attention">
					  <p>[Your browser does not support or has been configured not to display inline frames.]</p>
					</div>
				</iframe>
				<input type="hidden" name="Account_Id" id="Account_Id" value="<?php echo $account_id; ?>" /> <!-- THIS IS TEMPORARY AND WILL INSTEAD BE PART OF THE USER JS OBJECT --> 
			</div>
			<!-- end Document View -->
		</div>

	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->

<script type="text/javascript">
	globalSourcePathId = '<?php echo $default_source_location; ?>';
</script>