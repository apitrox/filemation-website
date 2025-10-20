<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="$.fancybox.close();">&times;</button>
		<h4 class="modal-title" id="myModalLabel">The Filename Already Exists</h4>	
	</div>
	<form id="Filename_Exists_Select_Solution_Form">
		<div class="modal-body">
			<div>
				<input type="radio" id="Save_And_Replace" name="Filename_Exists_Solution" value="Save_And_Replace" class="required"> <label for="Save_And_Replace" class="font-normal">Save and replace existing file.</label><br/>
				<input type="radio" id="Save_New_Version" name="Filename_Exists_Solution" value="Save_As_New_Version" class="required"> <label for="Save_New_Version" class="font-normal">Save as a new version, keep existing file. (Prefix: ..(2)..)</label><br/>
				<!-- <input type="radio" id="Save_As_Two" name="Filename_Exists_Solution" value="Save_As_Two" class="required""> <label for="Save_As_Two" class="font-normal">Save as "...(2)...".</label> -->
			</div>
		</div>
		<div class="modal-footer">
			<input type="hidden" id="Rename_And_File_Action" name="Rename_And_File_Action" value="<?php echo $rename_and_file_action; ?>" />
			<input type="hidden" id="Conflicting_File_Id" name="Conflicting_File_Id" value="<?php echo $conflicting_file_id; ?>" />
			<button type="button" class="btn btn-default" data-dismiss="modal" onclick="$.fancybox.close();">Cancel</button>
			<button type="button" id="Save" class="btn btn-primary">Save</button>
		</div>
	</form>
</div>
<script>
 $(function(){
	$('#Save').on('click', function(event){
		
		if( ValidateForm('Filename_Exists_Select_Solution_Form') == true ) return false;
		
		var rename_and_file_action = $('#Rename_And_File_Action').val();
		var conflicting_file_id = $('#Conflicting_File_Id').val();
		var filename_exists_solution = $("input[name='Filename_Exists_Solution']:checked").val();
		
		$.fancybox.close();
		setTimeout(RenameAndFileDocument(rename_and_file_action, filename_exists_solution, conflicting_file_id), 1000);
		
	}) ;
 });
</script>