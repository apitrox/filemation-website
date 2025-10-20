/*
 * Doc Filer
 *
 * File Documents external javascript sheet
 * 
 */

// =================================
// Before DOM Loads
// =================================



// This javascript function will reset the file definition value to default
function ResetDocumentControls()
{
	$('#File_Definition_Id').val('');
	$('#Document_Controls_Action_Buttons').removeClass('hidden').addClass('hidden');
	ResetFileCriteria();
}

// This javascript function will hide all file criteria wrappers that contain our inputs to gather document information
function ResetFileCriteria()
{
	$('.file_criteria').each(function(index, item){
		$(this).remove();
	});
}

// This javascript function will hide and show the loader div
// @Return:		VOID, simply hide or show the ViewFrame Class and Mask/Unmask the whole Document view area
function ToggleLoader() {
	if( $('#Loader').hasClass('hidden') ) {
		$('#Loader').removeClass('hidden');
	} else {
		$('#Loader').removeClass('hidden').addClass('hidden');
	}
}

// This javascript function will hide and show the "document view" loader div
// @Return:		VOID, simply hide or show the ViewFrame Class and Mask/Unmask the whole Document view area
function ToggleDocumentViewLoader() {
	if( $('#View_PDF_File').hasClass('hidden') ) {
		$('#Document_Wrapper').unmask();
		$('#View_PDF_File').removeClass('hidden');
		$('#Loader').removeClass('hidden').addClass('hidden');
	} else {
		$('#View_PDF_File').addClass('hidden');
		$('#Loader').removeClass('hidden');
		$('#Document_Wrapper').mask('Loading...');
	}
}


// This javascript function will store the document name object into a global array to be used through out all javascript functions
function CreateDocumentNameObject(document_name_object) {
	globalDocumentNameObject = document_name_object;
}

//  This javascript function gets all the file criteria for the given file definition. Next it creates all the needed file criteria html elements to file a documents.
//  @Param 1:	required, file definition primary key ID
function LoadFileCriteria(file_definition_id)
{
	ResetFileCriteria(); // remove any file criteria elements if they exist
	
	if( file_definition_id == '' )
	{
		return false;
	}
	
	$.ajax({
		url: '/json/GetAllFileCriteriaForFileDefinition/',
		data: {'file_definition_id': file_definition_id},
		type: 'GET',
		dataType: 'json',
		error: function(xhr, status){
			
		},
		success: function(response){
			if( typeof response.Result != 'undefined' && response.Result == true )
			{
				var data = response.Data;
				$(data).each(function(index, item){
					// file criteria
					var criteria_type_id = item.Criteria_Type_id;
					var criteria_required = item.Criteria_Required;
					var criteria_min_len = item.Criteria_Min_Len;
					var criteria_max_len = item.Criteria_Max_Len;
					var criteria_recall_name = item.Criteria_Recall_Name;
					var criteria_decimals = item.Criteria_Decimals;
					var criteria_dec_point = item.Criteria_Dec_Point;
					var criteria_thousands_sep = item.Criteria_Thousands_Sep;
					var criteria_currency_symbol = item.Criteria_Currency_Symbol;
					var criteria_php_date_format_str = item.Criteria_Php_Date_Format_Str;
					
					// criteria type
					var criteria_type_name = item.Criteria_Type_Name;
					var is_date = item.Is_Date;
					var is_recallable = item.Is_Recallable;
					var is_decimals = item.Is_Decimals;
					var is_thousands_separator = item.Is_Thousands_Separator;
					var is_currency_symbol = item.Is_Currency_Symbol;
					
					// is file required?
					var required_class = ( criteria_required == 1 ) ? 'required' : '';
					// is criteria type a date? use datpicker class
					var datepicker_class = ( criteria_type_name == 'Date' ) ? 'datepicker' : '';
					var datepicker_attributes = ( criteria_type_name == 'Date' ) ? 'data-date="12-02-2012" data-date-format="dd-mm-yyyy"' : '';
					// do we use the input-control icon in the textfield?
					var input_control_addon = ( criteria_type_name == 'Date' ) ? 'input-group' : '';
					
					// set tooltip title
					var title_attr;
					var len_title_str = (criteria_min_len != null && criteria_max_len != null) ? 'Min ' + criteria_min_len + ' characters.' : '';
					len_title_str = ( criteria_max_len != null ) ? len_title_str + ' Max ' + criteria_max_len + ' characters.' : len_title_str;
					
					if( criteria_type_name == 'Text' )
					{
						
						title_attr = "This field is required.";
					}
					else if( criteria_type_name == 'Date' )
					{
						title_attr = "Select or type in a full month day year date.";
					}
					else if( criteria_type_name == 'Currency' )
					{
						title_attr = "Type in a currency amount.";
					}
					else if( criteria_type_name == 'Name' )
					{
						title_attr = "This field is required.";
					}
					else if( criteria_type_name == 'Number' )
					{
						title_attr = "Type in a number.";
					}
					title_attr = title_attr + '<br/>' + len_title_str;
					
					
					var wrapper = $('<div/>');
					$(wrapper).addClass('file_criteria document_control');
					var label = $('<h5/>');
					$(label).text(item.Criteria_Name);
					var textfield = $('<input/>');
					$(textfield).attr({
						id: 'File_Criteria_' + item.File_Criteria_Id,
						name: 'File_Criteria[' + item.File_Criteria_Id + ']',
						'data-min-length': criteria_min_len,
						'maxlength': criteria_max_len,
						'data-toggle': 'tooltip',
						title: title_attr, 
						'data-placement': 'right', 
						'data-trigger': 'focus'
					});
					if( criteria_type_name == 'Number' || criteria_type_name == 'Text' )
					{
						$(textfield).attr({'type': criteria_type_name.toLowerCase()});
					}
					$(textfield).addClass('form-control file_criteria_form ' + datepicker_class + ' ' + input_control_addon + ' ' + required_class);
					
					if( criteria_type_name == 'Currency' )
					{
						$(textfield).blur(function(event){
							var currency_symbol = ( criteria_currency_symbol != null ) ? criteria_currency_symbol : '';
							var decimals = ( is_decimals ) ? 2 : 0;
							var new_value = FormatNumber(this.value, 0, decimals, true);
							this.value = currency_symbol + new_value;
						});
					}
					
					if( criteria_type_name == 'Date' )
					{
						$(textfield).keydown(function(event){
							ValidateDateTextfield(event);
						});
						$(textfield).blur(function(event){
							this.value = FormatDate(this.value, criteria_php_date_format_str);
						});
						
						var span = $('<span/>');
						$(span).addClass('input-group-addon').text('@');
					}
				
					$(wrapper).append(label);
					if( criteria_type_name == 'Date' )
					{
//						$(wrapper).append(span);
					}
					$(wrapper).append(textfield);
					$(wrapper).insertBefore('#Document_Controls_Action_Buttons');
					
					// set our new element tooltip, and datepickers
					$(textfield).tooltip({html: true});
					var datepicker = $('.datepicker').datepicker({
						format: criteria_php_date_format_str
					}).on('changeDate', function(ev){
						ResetTextfield(this);
					});
				});
				
				// show document controls action buttons
				$('#Document_Controls_Action_Buttons').removeClass('hidden');
			}
		}
	});
}

// This javascript function will "Rename and File Document". When a user clicks the button [Rename and File] it will rename and file the document
// It is the main purpose of the filing program.
function RenameAndFileDocument() {	 
	
	// rename and attach file
	var account_id = $('#Account_Id').val();
	var file_name = globalOpenedFile;
	var page_count = $('#Page_Number_Label').html();
	var naming_form_params = $('#Document_Controls_Form').serialize();
	var params = naming_form_params + '&Aid=' + account_id + '&File_Name=' + file_name;
	
	// validate form
	if( ValidateFilerCriteria('Document_Controls_Form') == true ) { return false };
	
	// toggle whole page masking
	$('body').mask('Filing Document..');
	
	$.ajax({  
		url: "/docs/FileDocument",  
		type: "POST",
		cache: false,  
		data: params,
		dataType: "json",
		success: function(json) {   
			if(json.Result == false) {
				$('body').unmask();
				DocumentErrorPrompt(json.Result_Message);
				
			} else if(json.Result == true) {
				document.location.reload();
			}
		},
		error: function(xhr) {

		},
		complete: function(xhr, status) {}
	});
}


// This javascript function will retrieve the documents to be filed grid html
// @Param 1:	required, office code
// @Return:		VOID, instead populate grid html
function GetDocumentsToBeFiledGrid(office_code)
{
	ToggleLoader(); // LOADER
	
	$.ajax({
		url: "/documents/GetDocumentsToBeFiledGridAjax/",
		data: { "office_code": office_code },
		type: "GET",
		dataType: "html",
		success: function(response){				
			$('#List_Area_Div').html(response);
		},
		error: function(xhr, status){
		
		},
		complete: function(xhr, status){				
			ToggleLoader(); // LOADER
		}
	});
}

// This javascript function rewrites the preventDefault() javascript method
// @Param 1: 	required, Action Event. e.g. submit, a, etc..
function ie8SafePreventEvent(e)
{
	if(e.preventDefault){ e.preventDefault()}
	else{e.stop()};

	e.returnValue = false;
	e.stopPropagation();        
}

// This javascript function will strip a string of un-wanted characters then return it.
// @Param 1:	required, string to clean up
// @Return:	cleaned string
function CleanString(str)
{
	//\ / : * ? " < > | '
	return str.replace(/[\\\/\:\*\?\"\<\>\|\']/g, "");
}

// This javascript function will trim whitespace or unwanted space around a string and then return it.
// @Param 1:	required, string to trim
// @Return:	trimed string
function Trim(str)
{
	return str.replace(/^\s+|\s+$/g, '');
}

/***********************************/
/*	Open/View Documents Functions  */
/***********************************/

// This javascript function handles different element routines when opening and closing documents
function CloseDocuments()
{
	$("#View_PDF_File").attr("src","/docs/FilerDefaultView/");
	$("#Page_Number_Label").html("");
	$("#Modify_Doc").attr("disabled","disabled");
	$("#Modify_Doc_Button").attr("disabled", "disabled");
	globalOpenedFile = "";
}

// This javascript function will open a pdf document in the document management view area (iFrame)
// @Param 1:	required, Filename we are opening
// @Param 2:	required, The link DOM object itself (this scope)
function OpenFile(filename, file_link_el)
{
	ResetDocumentControls();
	ToggleDocumentViewLoader(); // document view loader
	$(".filename").css("font-weight","normal");
	$(".filename").closest("td").css('background-color', '#FFFFFF');
	$(file_link_el).css("font-weight","bold");
	$(file_link_el).closest("td").css('background-color', '#E3E3E3');
	$('input:radio').each(function(i, item){ // reset radio inputs
			$(this).removeAttr('checked');
	});
	var account_id = $('#Account_Id').val();
	
	$('body').mask('');
	
	// handle drafts which first need to be converted to pdf, then viewed.
	globalOpenedFile = filename; // lets set global open filed variable
	
	$.ajax({  
		url: "/docs/GetDocumentAndPDFPageCount/",  
		type: "GET",
		cache: false,
		data: { "aid": account_id, "filename": encodeURI(filename) },
		dataType: 'json',
		success: function(response){
			if( typeof response.Result != 'undefined' && response.Result == true )
			{
				var page_count = response.Page_Count;
				var res_filename = encodeURI(response.Filename);
				var page_number_label_text = filename + ' - ' + page_count + ' pages';
				
				$("#Page_Number_Label").html(page_number_label_text);				
				$('#View_PDF_File').attr('src', '/docs/ViewDocument/?filename=' + res_filename );
				$('#View_PDF_File').css('border', '1px solid #333333');
				
				$("#Modify_Doc").removeAttr("disabled");
				$("#Modify_Doc_Button").removeAttr("disabled");
				$('#File_Definitions_Wrapper').removeClass('hidden'); // show Step 1: File Definitions
				
			}
			else
			{
				
			}
		},
		error: function(xhr){
			//AjaxError(xhr);
		},
		complete: function(xhr, status){
			$('body').unmask();
			ToggleDocumentViewLoader(); // document view loader
		}
	});
	
	
}

// This javascript method handles the document actions.
// @Return:		VOID
function ModifyDoc() {
	var action = $("#Actions_DD").val();
	var office_code = $('#Office_Code').val();
	var file_name = encodeURIComponent(globalOpenedFile);
	var mask_message = '';
	
	// mask page
	if(action == 'Rotate_180') {
		mask_message = 'Rotating document..';
	} else if(action == 'Split_Pages') {
		mask_message = 'Splitting multi-page document..'
	} else if(action == 'Delete') {
		mask_message = 'Deleting document..';
	}
	
	switch (action) {
		case "Rotate_180":
			break;
		case "Split_Pages":
			if( $("#Page_Number_Label").html() == "1" ) {
				alert('Document has only 1 page.');
				$.sticky("<div class='notification note-info'><p>Document has only \"1\" page.</p></div>");
				return;
			}
			break;
		case "Delete":
			if( confirm("Are you sure you wish to delete this file?") == false) {
				return;
			}
			
			break;
		default:
			ToggleLoader(); // LOADER
			return;
			break;
	}
	
	$.blockUI({ message: "<p style='padding: 50px;'><span style='float: left; width: auto;'><img src='/images/ajax-loader2.gif' alt='' width='24' /></span><span style='font-size: 18px;'>" + mask_message + "</span></p>" });

	$.ajax({  
		url: "/documents/DoDocumentAction/",
		type: "POST",
		cache: false,  
		data: {"office_code": office_code, "file_name": file_name, "action": action },
		dataType: "json",
		success: function(json){    

			if(typeof json.Result != 'undefined' && json.Result == true) {
				GetDocumentsToBeFiledGrid( $('#Office_Code').val() );
				CloseDocuments();
				location.reload();
			} else {
				//DocumentErrorPrompt(json.Result_Message);
				DisplayErrorDialog(json.Result_Message);
			}	
			
					
			
		},
		complete: function(xhr, status){
			$.unblockUI(); // LOADER		
			$("#Actions_DD").val(''); // reset actions dropdown
		}
	});
	
}

// This javascript function will open a modal dialog when there is an error with filing a document
// @Param 1:	required, the error to display to in the modal dialog
// @Return:		VOID, instead open modal dialog window display error message
function DocumentErrorPrompt(error_message) {
	
	if(error_message == "") {
		return false;
	}
	
	$.fancybox({
		'hideOnContentClick': false,
		'autoScale': true,
		'type': 'ajax',
		'href': '/box/DocumentErrorAlert/?error_message=' + error_message,
		'showCloseButton': false
    });

}


// =================================
// After DOM Loads
// =================================

$(function(){
	CloseDocuments();
});
$(function(){
	$('#Rename_And_File_Document').on('click', function(event){
		RenameAndFileDocument();
	});
});
