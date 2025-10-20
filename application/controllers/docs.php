<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
* Filemation
*
*/

class Docs extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		//echo "<pre>"; print_r($this->session->all_userdata()); echo "</pre>";
		
		$this->auth_lib->Secure();
	}

	function index()
	{

	}

	// This method controls the document filing page.
	function Filer()
	{
		
		$this->Accounts_model->ValidateAccount();
		
		$this->output->cache(0); // clear any cache
		
		$account_id = $this->auth_lib->GetAccountId();
		
		// get the user's account record
		$account_result = $this->Accounts_model->GetAccount($account_id);
		$account = ( isset($account_result['Result']) && $account_result['Result'] == TRUE ) ? $account_result['Row'] : FALSE;
		$default_source_location = $this->session->userdata('default_source_location');
		
		// get the data storage provider from the account. if the data storage provider value is empty then we have to redirect the user to the page to set the data storage provider
		// and authorize their data storage account with filemation. we do this check above, we are doing it again.
		$data_storage = ( isset($account->Data_Storage) ) ? $account->Data_Storage : '';
		if( empty($data_storage) )
		{
			header('Location: ' . base_url() . 'config/setupaccount/');
			exit;
		}
		
		
		// get default source location folder name per the data storage provider set for the account.
		$default_source_location_name = "";
		if( strtoupper($data_storage) == "BOX" )
		{
			if( $default_source_location != '' && $default_source_location != NULL )
			{
				$result = $this->Data_storage_model->BoxGetFolderDetails($account_id, $default_source_location);
				$default_source_location_name = ( isset($result['Result']) && $result['Result'] == TRUE ) ? $result['Data']['Name'] : '';
			}
		}
		elseif( strtoupper($data_storage) == "DROPBOX" )
		{
			$default_source_location_name = $default_source_location;
		}
		
		
		// the to be filed files list from the remote server
		$files_list_result = $this->Docs_model->GetToBeFiledFilesForAccount($account_id, $default_source_location);
		$files_list_array = ( isset($files_list_result['Result']) && $files_list_result['Result'] == TRUE ) ? $files_list_result['Data'] : array();
		
		// the available file definitions for the user's account
		$file_definitions_result = $this->File_definitions_model->GetAllFileDefinitionsForAccount($account_id);
		$file_definitions_array = ( isset($file_definitions_result['Result']) && $file_definitions_result['Result'] == TRUE ) ? $file_definitions_result['Data'] : array();
		
		$view_data = array();
		$view_data['account_id'] = $account_id;
		$view_data['files_list_array'] = $files_list_array;
		$view_data['file_definitions_array'] = $file_definitions_array;
		$view_data['default_source_location'] = $default_source_location;
		$view_data['default_source_location_name'] = $default_source_location_name;
		
		
		// Load Template Views
		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('docs/filer', $view_data);
		$this->load->view('footer');
	}
	

	// This method controls performing various actions on the given "to be filed" PDF document. Such as "Delete","Rotate","Split","Merge","OCR".
	// Request Data: GET[]
	function ModifyFile()
	{
		//  Request POST Data
		//  Data Storage File = this is the primary key for the file on the data storage provider; instead of an integer it can be the filename depending on the file data storage provider.
		//  Data Storage Folder = this is the primary key for the folder on the data storage provider; instead of an integer it can be the string representing the path on the data storage provider.
		//  Filename = this is the filename of the file we are modifying.
		//  Action = the modify *action* we are taking with the file. Delete, Rotate, Split, Merge, or OCR
		
		$account_id = $this->auth_lib->GetAccountId(); // this is the account primary key ID.
		$action = $this->input->post('Action'); // this is a string that will determine the action to take with the file. Such as "Delete","Rotate","Split","Merge","OCR"
		$data_storage_file_id = $this->input->post('Data_Storage_File'); // this can be either a primary key ID or a filename depending on the data storage provider.
		$data_storage_folder_id = $this->input->post('Data_Storage_Folder'); // this can be either a primary key ID or a string representing the data storage provider path.
		$filename = $this->input->post('Filename'); // this is the filename of the file we are modifying.
		
		$return = $this->Docs_model->ModifyFile($account_id, $data_storage_file_id, $filename, $data_storage_folder_id, $action);
		$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Docs_model->ModifyFile() \n\$return: " . print_r($return, TRUE);  $user_err_msg = "The file action was unable to finish. Please try again.";  $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ;  $user_err_msg = "The file action was unable to finish. Please try again."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$json_response = $return;
		
		if( $this->input->get('callback') != FALSE )
		{
			echo $this->input->get('callback') . '(' . json_encode($json_response) . ')';
		}
		else
		{
			echo json_encode($json_response);
		}
	}
	
	//  This method controls previewing a document. Documents are previewed in different way, depending on the data storage provider, and then the document type.
	//  Request Data: GET[aid, filename]
	function PreviewDocument()
	{
		// load includes
		$this->load->helper('pdf_helper');
		
		$account_id = $this->auth_lib->GetAccountId();
		$data_storage_file_id = $this->input->get('file_id');
		$filename = $this->input->get('filename');
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty, false, or invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($data_storage_file_id) );   $err_msg = "\$data_storage_file_id is empty, false, or invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($filename) );   $err_msg = "\$filename is empty, false, or invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		// download the file from the remote file server. convert the to a viewable pdf if it is not already, and then get the pdf page count.
		$result = $this->Docs_model->DownloadFileFromFileServer($account_id, $data_storage_file_id, $filename);
		$result['Error_Message'] = ( isset($result['Error_Log_Id']) ) ? "Error ID: " . $result['Error_Log_Id'] . " Error: The file could not be loaded in the viewer." : ""; // set the error_message. this will be displayed to the end user if the [Result] is false.
		
		// for tablet and mobile devices html content is returned. if the html content exists, we are going to set it in a flash session variable to be used.
		if( isset($result['Is_HTML']) && $result['Is_HTML'] == TRUE )
		{
			$path = $this->config->item('FILES_CONVERTED_PATH');
			$html_filename = random_string('unique'). '_' . date('m-d-Y_H-i-s', time()) . ".txt";
			$html_path_filename = $path . DIRECTORY_SEPARATOR . $html_filename;
			$file = fopen($html_path_filename, 'w+');
			fwrite($file, $result['HTML_Content']);
			fclose($file);
			
			$result['HTML_Filename'] = $html_filename;
			$result['HTML_Path_Filename'] = $html_path_filename;
		}
		
		$json_response = $result;
		
		if( $this->input->get('callback') != FALSE )
		{
			echo $this->input->get('callback') . '(' . json_encode($json_response) . ')';
		}
		else
		{
			echo json_encode($json_response);
		}		
	}

	// This method will file a document stored in the "tobefiled/" directory. When a document is filed it is
	// renamed according to the Filing Criteria provided and then moved to the "documents/" directory
	// Request Data: POST[Aid, Filename, File_Criteria*......]
	function FileDocument()
	{

		// load includes
		
		// validate post data
		$account_id = $this->auth_lib->GetAccountId();
		$user_id = $this->auth_lib->GetUserId();
		$filename = $this->input->post('Filename');
		$data_storage_file_id = $this->input->post('Data_Storage_File_Id');
		$source_path = $this->input->post('Source_Path');
		$destination_path = $this->input->post('Destination_Path');
		$file_definition_id = $this->input->post('File_Definition_Id');
		$file_criteria = $this->input->post('File_Criteria');
		$file_action = $this->input->post('File_Action');
		$filename_exists_solution = $this->input->post('Filename_Exists_Solution');
		$conflicting_file_id = $this->input->post('Conflicting_File_Id');
		
		// create RenameAndFileDocument() array
		$file_doc_values_array = array();
		$file_doc_values_array['Account_Id'] = $account_id;
		$file_doc_values_array['User_Id'] = $user_id;
		$file_doc_values_array['Filename'] = $filename;
		$file_doc_values_array['Data_Storage_File_Id'] = $data_storage_file_id;
		$file_doc_values_array['File_Definition_Id'] = $file_definition_id;
		$file_doc_values_array['File_Criteria'] = $file_criteria;
		$file_doc_values_array['Source_Path'] = $source_path;
		$file_doc_values_array['Destination_Path'] = $destination_path;
		$file_doc_values_array['File_Action'] = $file_action;
		$file_doc_values_array['Filename_Exists_Solution'] = $filename_exists_solution;
		$file_doc_values_array['Conflicting_File_Id'] = $conflicting_file_id;
		
		// call Rename And File Document
		$return = $this->Docs_model->RenameAndFileDocument($file_doc_values_array);
		
		// handle errors accordingly.
		$err_type = ( isset($return['Error_Type']) ) ? $return['Error_Type'] : '';
		$err_status = ( isset($return['Error_Status']) ) ? $return['Error_Status'] : '';
		$err_code = ( isset($return['Error_Code']) ) ? $return['Error_Code'] : '';
		$conflicting_file_id = ( isset($return['Conflicting_File_Id']) ) ? $return['Conflicting_File_Id'] : $conflicting_file_id;
		$error_message = ""; // set the default error message to empty string.
		
		if( strtolower($err_code) == 'item_name_in_use' )
		{
			// if the data storage file id is the same value as the conflicting file id do not proceed with prompting the user with a list of options to take with the duplicate filename.
			// instead notify the user they are trying to save the same file over itself.
			
			if( $data_storage_file_id == $conflicting_file_id )
			{
				$error_message = "It appears you are trying to save the same file over itself. You can not complete this action. Either change the file criteria, or select a different file to file and rename.";
				$return['Prompt_Filename_Exists'] = FALSE;
			}
			else
			{
				$error_message = "The filename is already in use. How do you want to handle this?  Error ID: " . $return['Error_Log_Id'];
				$return['Prompt_Filename_Exists'] = TRUE;
			}
		}
		
		$return['Error_Message'] = ( !isset($error_message) && isset($return['Error_Log_Id']) ) ? "Error ID: " . $return['Error_Log_Id'] . " Error: There was an error when renaming and filing the document." : $error_message; // set the error_message. this will be displayed to the end user if the [Result] is false.
		$json_response = $return;
		
		if( $this->input->get('callback') != FALSE )
		{
			echo $this->input->get('callback') . '(' . json_encode($json_response) . ')';
		}
		else
		{
			echo json_encode($json_response);
		}
	}
	
	
	// This method controls viewing a document saved on the server disk.
	// Request Data: GET[file_name, office_code, and dir [optional/ input or output default=input]
	function ViewDocument()
	{
		$this->load->helper('pdf_helper');
		
		// flush ob
		ob_start();

		// validate data
		$filename = $this->input->get('filename');		
		$filename_decoded = urldecode($filename);
		$is_html = $this->input->get('is_html');
		$html_filename = $this->input->get('html_filename');
		$html_path_filename = $this->input->get('html_path_filename');
		
		if( $is_html == 1 )
		{
			$html_content = file_get_contents($html_path_filename);
			echo $html_content;
			unlink($html_path_filename);
			exit;
		}
		else
		{
			$file_converted_path = $this->config->item('FILES_CONVERTED_PATH');
			$path_filename = $file_converted_path . DIRECTORY_SEPARATOR . $filename_decoded;


			// lets check if the file exists in the source directory/subdirectory
			if( !file_exists($path_filename) )
			{
				echo "ERROR: File does not exist, <br/> Filename: $path_filename";
				exit;
			}

			$rawfile = file_get_contents($path_filename);

			header("Content-type: Application/pdf");
			header('Cache-Control: must-revalidate');
			echo $rawfile;
			exit;
		}
	}
	
	// This method will get an account's data storage 'to be filed' files listing and return them in a json object.
	// Request Data: GET[source_folder]
	function GetToBeFiledFiles()
	{
		//  Request Data
		//  data_storage_folder_id	= the data storage folder id
		
		$account_id = $this->auth_lib->GetAccountId();
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty, false, or invalid \n\$account_id: $account_id"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$source_folder = $this->input->get('source_folder');
				
		// get the user's account record
		$account_result = $this->Accounts_model->GetAccount($account_id);
		$account = ( isset($account_result['Result']) && $account_result['Result'] == TRUE ) ? $account_result['Row'] : FALSE;
		$source_location = ( is_object($account) && empty($source_folder) ) ? $account->Default_Source_Location : $source_folder;
		
		// the to be filed files list from the remote server
		$result = $this->Docs_model->GetToBeFiledFilesForAccount($account_id, $source_location);
		$files_list_array = ( isset($files_list_result['Result']) && $files_list_result['Result'] == TRUE ) ? $files_list_result['Data'] : array(); 
		
		$json_response = $result;
		
		if( $this->input->get('callback') != FALSE )
		{
			echo $this->input->get('callback') . '(' . json_encode($json_response) . ')';
		}
		else
		{
			echo json_encode($json_response);
		}
	}
	
	//  This method controls the default view for the pdf viewer on the file interface. This page gets called via the src attribute in the iframe.
	//  Request Data: GET[page]
	public function FilerDefaultView()
	{
		//  Request Data   GET
		//  page	->	a assigned name to determine what view to load and be printed to the screen
		//			LOADER = The 'in' loading state page 
		//			DEFAULT = The default frame page
		
		$page = $this->input->get('page');
		
		$this->load->library('parser');
		
		$html = "";
		$html .= $this->parser->parse('head', array());
		
		if( strtoupper($page) == "LOADER" )
		{
			$view_file = "docs/loader_filer_frame";
		}
		elseif( strtoupper($page) == "ERROR" )
		{
			$view_file = "docs/error_filer_frame";
		}
		else
		{
			$view_file = "docs/default_filer_frame";
		}
		
		$html .= $this->parser->parse($view_file, array());
		
		echo $html;
		exit;
	}
	
}

/* End of file docs.php */
/* Location: ./application/controllers/docs.php */