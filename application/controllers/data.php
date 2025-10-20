<?php if( !defined('BASEPATH') ) die('No direct script access');
/* 
 * Filemation
 */

class Data extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->auth_lib->Secure();
	}
	
	//  This method will get file definitions data for the filemation configuration grid
	//  Request Data: GET[]
	public function GetConfigFileDefinitionsGrid()
	{
		$account_id = $this->session->userdata('account_id');
		$get_data = $this->input->get();
		
		$result = $this->Grid_model->GetConfigFileDefinitionsData($account_id, $get_data);
		
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
	
	//  This method will get file definitions data for the filemation configuration grid
	//  Request Data: GET[]
	public function GetConfigFileCriteriaGrid()
	{
		$account_id = $this->session->userdata('account_id');
		$get_data = $this->input->get();
		
		$result = $this->Grid_model->GetConfigFileCriteriaData($account_id, $get_data);
		
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
	
	//  This method will get users data for the filemation configuration grid
	//  Request Data: GET[]
	public function GetConfigUsersGrid()
	{
		$account_id = $this->session->userdata('account_id');
		$get_data = $this->input->get();
		
		$result = $this->Grid_model->GetConfigUsersData($account_id, $get_data);
		
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
	
	//  This method will delete a given file definition record from the account
	//  Request Data: POST[File_Definition_Id]
	public function DeleteFileDefinition()
	{
		$account_id = $this->auth_lib->GetAccountId();
		$file_definition_id = $this->input->post('File_Definition_Id');
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty, false, or invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($file_definition_id) );   $err_msg = "\$file_definition_id is empty, false, or invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$result = $this ->File_definitions_model->DeleteFileDefinition($account_id, $file_definition_id);
		$result['Error_Message'] = ( $result['Result'] == FALSE && isset($result['Error_Log_Id']) ) ? "Error ID: " . $result['Error_Log_Id'] . " Message: The file definition did not delete." : 'The file definition did not delete.';
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
	
	//  This method will delete a given file criteria record from the account
	//  Request Data: POST[File_Definition_Id, File_Criteria_Id]
	public function DeleteFileCriteria()
	{
		$account_id = $this->auth_lib->GetAccountId();
		$file_definition_id = $this->input->post('File_Definition_Id');
		$file_criteria_id = $this->input->post('File_Criteria_Id');
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty, false, or invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Error_Message' => "Error ID: $err_log_id Message: The file criteria did not delete. The account ID is invalid.", 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($file_definition_id) );   $err_msg = "\$file_definition_id is empty, false, or invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Error_Message' => "Error ID: $err_log_id Message: The file definition did not delete. The file definition ID is invalid.", 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($file_criteria_id) );   $err_msg = "\$file_criteria_id is empty, false, or invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Error_Message' => "Error ID: $err_log_id Message: The file criteria did not delete. The file criteria ID is invalid.", 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$result = $this->File_criteria_model->DeleteFileCriteria($account_id, $file_definition_id, $file_criteria_id);
		$result['Error_Message'] = ( $result['Result'] == FALSE ) ? "Error ID: " . $result['Error_Log_Id'] . " Message: The file criteria did not delete." : '';
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
	
	//  This method will delete a given user record from the account
	//  Request Data: POST[User_Id]
	public function DeleteUser()
	{
		$account_id = $this->auth_lib->GetAccountId();
		$user_id = $this->input->post('User_Id');
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty, false, or invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($user_id) );   $err_msg = "\$user_id is empty, false, or invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$result = $this->Users_model->DeleteUser($account_id, $user_id);
		$result['Error_Message'] = ( $result['Result'] == FALSE ) ? "Error ID: " . $result['Error_Log_Id'] . " Message: The user did not delete." : '';
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
	
	//  This method will attempt to delete a data storage file from the data storage file server
	//  Request Data: GET[data_storage_file_id]
	public function DeleteDataStorageFile()
	{
		$account_id = $this->auth_lib->GetAccountId();
		$data_storage_file_id = $this->input->get('data_storage_file_id');
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty, false, or invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($data_storage_file_id) );   $err_msg = "\$data_storage_file_id is empty, false, or invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$result = $this->Data_storage_model->BoxDeleteFile($account_id, $data_storage_file_id);
		$result['Error_Message'] = ( $result['Result'] == FALSE && isset($result['Error_Log_Id']) ) ? "Error ID: " . $result['Error_Log_Id'] . " Message: The file did not delete." : 'The file did not delete.';
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
	
	
	//  This method will attempt to save a given account with data provided
	//  Request Data: POST[]
	public function SaveAccount()
	{
		// Request Data: POST
		// File_Storage		= the file storage provider name
		// Account_Name		= the account name for the company or invidual
		// Optimize_Scans		= if this account can optimize scans
		// Recall_Names_By_File_Definition = can values entered in for file criteria be saved for later reference by file definition?
		// Recall_Names_By_User	= can values entered in for file criteria be saved for later reference by user?
		
		$account_id = $this->auth_lib->GetAccountId();
		$data_storage_provider = $this->input->post('Data_Storage');
		$default_source_location = $this->input->post('Default_Source_Location');
		$default_source_location_name = $this->input->post('Default_Source_Location_Name');
		$account_name = $this->input->post('Account_Name');
		$optimize_scans = $this->input->post('Optimize_Scans');
		$recall_names_entire_account = $this->input->post('Recall_Names_Entire_Account');
		$recall_names_by_user = $this->input->post('Recall_Names_By_User');
		$recall_names_by_file_definition = $this->input->post('Recall_Names_By_File_Definition');
		$recall_names_by_file_criteria = $this->input->post('Recall_Names_By_File_Criteria');
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty, false, or invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		// because some of the above data can be present OR not present depending on what page it is called from
		
		$entry_rec = array();
		
		if( !empty($data_storage_provider) )
		{
			$entry_rec['Data_Storage'] = $data_storage_provider;
		}
		
		if( $default_source_location !== FALSE && $default_source_location != '' )
		{
			$entry_rec['Default_Source_Location'] = $default_source_location;
		}
		
		if( !empty($account_name) )
		{
			$entry_rec['Account_Name'] = $account_name;
		}
		
		if( $optimize_scans !== FALSE && $optimize_scans != '' )
		{
			$entry_rec['Optimize_Scans'] = $optimize_scans;
		}
		
		if( $recall_names_entire_account !== FALSE && $recall_names_entire_account != '' )
		{
			$entry_rec['Recall_Names_Entire_Account'] = $recall_names_entire_account;
		}
		
		if( $recall_names_by_user !== FALSE && $recall_names_by_user != '' )
		{
			$entry_rec['Recall_Names_By_User'] = $recall_names_by_user;
		}
		
		if( $recall_names_by_file_definition !== FALSE && $recall_names_by_file_definition != '' )
		{
			$entry_rec['Recall_Names_By_File_Definition'] = $recall_names_by_file_definition;
		}
		
		if( $recall_names_by_file_criteria !== FALSE && $recall_names_by_file_criteria != '' )
		{
			$entry_rec['Recall_Names_By_File_Criteria'] = $recall_names_by_file_criteria;
		}
		
		// save the account
		$result = $this->Accounts_model->SaveAccount($account_id, $entry_rec);
		
		// get the account record and bring it back to the interface
		$return = $this->Accounts_model->GetAccount($account_id);
		if( isset($return['Row']) && $return['Row'] != '' )
		{
			$return['Row']->Default_Source_Location_Name = $default_source_location_name;
		}
		
		if( !empty($default_source_location) && is_numeric($default_source_location)  )
		{
			$this->session->set_userdata('default_source_location', $return['Row']->Default_Source_Location);
		}
		
		if( !empty($account_name) && isset($return['Row']) && !empty($return['Row']) )
		{
			$this->session->set_userdata('account_name', $return['Row']->Account_Name);
		}
		
		$json_response = $return;	
		
		if( $this->input->get('callback') !== FALSE )
		{
			echo $this->input->get('callback') . '(' . json_encode($json_response) . ')';
		}
		else
		{
			echo json_encode($json_response);
		}
		
	}
	
	
	//  This method will attempt save a given file definition database record with the data provided
	//  Request Data: POST[]
	public function SaveFileDefinition()
	{
		// Request Data: POST
		// File_Definition_Id			= the primary file definition key id
		// File_Def_Name				= the name or label for the file definition
		// Definition_Starts_Filename		= is the file definition name the beginning term in the renamed file?
		// Default_Destination_Path		= the data storage default destination path to copy/file the file to on the remote data storage server
		// Is_Destination_Path_Selectable	= when using the file definition to rename and file a file, is a user able to change the data storage destination path?
		// Min_Pages					= the minimum pages allowed to rename and file a document with this file definition
		// Max_Pages					= the maximum pages allowed to rename and file a document with this file definition
		// Criteria_Separator			= the separator character to use between the 'file criteria' values when renaming the file
		// Update_Modified_Date			= update the modified date when filing this document?
		// Update_Created_Date			= update the created date when filing this document?
		
		
		$account_id = $this->auth_lib->GetAccountId();
		$file_definition_id = $this->input->post('File_Definition_Id');
		$file_def_name = $this->input->post('File_Def_Name');
		$definition_starts_filename = $this->input->post('Definition_Starts_Filename');
		$default_destination_path = $this->input->post('Default_Destination_Path');
		$is_destination_path_selectable = $this->input->post('Is_Destination_Path_Selectable');
		$min_pages = $this->input->post('Min_Pages');
		$max_pages = $this->input->post('Max_Pages');
		$criteria_separator = $this->input->post('Criteria_Separator');
		$update_modified_date = $this->input->post('Update_Modified_Date');
		$update_created_date = $this->input->post('Update_Created_Date');
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty, false, or invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($file_def_name) );   $err_msg = "\$file_def_name is empty, and invalid. \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $definition_starts_filename == '' );   $err_msg = "\$definition_starts_filename is empty, and invalid. \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
//		$error = ( $default_destination_path == '' );   $err_msg = "\$default_destination_path is empty, and invalid. \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $is_destination_path_selectable == '' );   $err_msg = "\$is_destination_path_selectable is empty, and invalid. \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $min_pages != '' && !is_numeric($min_pages) );   $err_msg = "\$min_pages is not a numeric value. \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $max_pages != '' && !is_numeric($max_pages) );   $err_msg = "\$max_pages is not a numeric value. \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($criteria_separator) );   $err_msg = "\$criteria_separator is empty, and invalid. \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $update_modified_date == '' );   $err_msg = "\$update_modified_date is empty, and invalid. \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $update_created_date == '');   $err_msg = "\$update_created_date is empty, and invalid. \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		// construct the data we want to update to the database
		$entry_rec = array();
		$entry_rec['File_Def_Name'] = $file_def_name;
		$entry_rec['Definition_Starts_Filename'] = ( $definition_starts_filename == 1 ) ? 1 : 0;
		$entry_rec['Default_Destination_Path'] = $default_destination_path;
		$entry_rec['Is_Destination_Path_Selectable'] = ( $is_destination_path_selectable == 1 ) ? 1 : 0;
		$entry_rec['Min_Pages'] = $min_pages;
		$entry_rec['Max_Pages'] = $max_pages;
		$entry_rec['Criteria_Separator'] = $criteria_separator;
		$entry_rec['Update_Modified_Date'] = $update_modified_date;
		$entry_rec['Update_Created_Date'] = $update_created_date;
		
		if( empty($file_definition_id) )
		{
			$entry_rec['Account_Id'] = $account_id; // add the account id because we are creating a 'new' file definition
			
			$return = $this->File_definitions_model->NewFileDefinition($entry_rec);
			$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->File_definitions_model->NewFileDefinition() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		}
		else
		{
			$return = $this->File_definitions_model->SaveFileDefinition($account_id, $file_definition_id, $entry_rec);
			$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->File_definitions_model->SaveFileDefinition() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		}
		
		$json_response = $return;
		
		if( $this->input->get('callback') != FALSE )
		{
			echo $this->input->get('callback') . '(' . json_ecnode($json_response) . ')';
		}
		else
		{
			echo json_encode($json_response);
		}
	}
	
	//  This method will attempt save a given file criteria database record with the data provided
	//  Request Data: POST[]
	public function SaveFileCriteria()
	{
		// Request Data: POST
		// File_Criteria_Id				= the primary file criteria key Id (this only exists if we are updating an existing file criteria record)
		// File_Definition_Id			= the primary file definition key id
		// Criteria_Name				= the criteria name or label for the file criteria record
		// Criteria_Required			= 1=if a file criteria is required to file and rename a file 0= not required
		// Criteria_Min_Len				= the minimum length of characters for a file criteria to file and rename a file
		// Criteria_Max_Len				= the maximum length of characters for a file criteria to file and rename a file
		// Criteria_Default_Value		= the default value for a file criteria 
		// Criteria_Tooltip				= the tooltip message that displays when focused on a file criteria textfield
		// Criteria_Recall_Name			= 1=the value entered in for the file criteria will be saved and will be displayed later if the value being typed matches the saved recall names
		// Criteria_Prefix				= the string or characters attached to the beginning of the file criteria value/term when renaming a file
		// Criteria_Suffix				= the string or characters attached to the end of the file criteria value/term when renaming a file
		// Criteria_Decimals			= if the file criteria is a criteria type 'number' or alike, this is how many decimals the value should be formatted to
		
		
		$account_id = $this->auth_lib->GetAccountId();
		$file_criteria_id = $this->input->post('File_Criteria_Id');
		$file_definition_id = $this->input->post('File_Definition_Id');
		$criteria_name = $this->input->post('Criteria_Name');
		$criteria_type_id = $this->input->post('Criteria_Type_Id');
		$criteria_required = $this->input->post('Criteria_Required');
		$criteria_min_len = $this->input->post('Criteria_Min_Len');
		$criteria_max_len = $this->input->post('Criteria_Max_Len');
		$criteria_default_value = $this->input->post('Criteria_Default_Value');
		$criteria_tooltip = $this->input->post('Criteria_Tooltip');
		$criteria_recall_name = $this->input->post('Criteria_Recall_Name');
		$criteria_prefix = $this->input->post('Criteria_Prefix');
		$criteria_suffix = $this->input->post('Criteria_Suffix');
		
		$criteria_decimals = $this->input->post('Criteria_Decimals');
		$criteria_dec_point = $this->input->post('Criteria_Dec_Point');
		$criteria_thousands_sep = $this->input->post('Criteria_Thousands_Sep');
		$criteria_currency_symbol = $this->input->post('Criteria_Currency_Symbol');
		$days_back = $this->input->post('Days_Back');
		$date_back = $this->input->post('Date_Back');
		$days_forward = $this->input->post('Days_Forward');
		$date_forward = $this->input->post('Date_Forward');
		$criteria_date_format = $this->input->post('Criteria_Date_Format');
		
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty, false, or invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($file_definition_id) );   $err_msg = "\$file_definition_id is empty, and invalid. \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($criteria_name) );   $err_msg = "\$criteria_name is empty, and invalid. \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($criteria_type_id) );   $err_msg = "\$criteria_type_id is empty, and invalid. \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $criteria_required == '' );   $err_msg = "\$criteria_required is empty, and invalid. \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $criteria_min_len != '' && !is_numeric($criteria_min_len) );   $err_msg = "\$criteria_min_len is not empty, and is not a numeric value. \n\$criteria_min_len: $criteria_min_len \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $criteria_max_len != '' && !is_numeric($criteria_max_len) );   $err_msg = "\$criteria_max_len is not empty, and is not a numeric value. \n\$criteria_max_len: $criteria_max_len \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $criteria_default_value == FALSE && $criteria_default_value != 0 );   $err_msg = "\$criteria_default_value does not exist. \$criteria_default_value is false. \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $criteria_recall_name == '' );   $err_msg = "\$criteria_tooltip is empty, and invalid. \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		// parse the criteria_php_date_format_sr and the criteria_javascript_date_format_sr
		$criteria_php_date_format_str = "";
		$criteria_javascript_date_format_str = "";
		if( !empty($criteria_date_format ) )
		{
			$criteria_date_format_parts = explode('|', $criteria_date_format);
			$criteria_php_date_format_str = ( isset($criteria_date_format_parts[0]) ) ? $criteria_date_format_parts[0] : '';
			$criteria_javascript_date_format_str = ( isset($criteria_date_format_parts[1]) ) ? $criteria_date_format_parts[1] : '';
			$error = ( empty($criteria_php_date_format_str) );   $err_msg = "The expected criteria php date format str is empty or invalid. \n\$criteria_php_date_format_str: $criteria_php_date_format_str \n\$criteria_date_format: $criteria_date_format \n\$criteria_date_format_parts: " . print_r($criteria_date_format_parts, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( empty($criteria_javascript_date_format_str) );   $err_msg = "The expected criteria javascript date format str is empty or invalid. \n\$criteria_javascript_date_format_str: $criteria_javascript_date_format_str \n\$criteria_date_format: $criteria_date_format \n\$criteria_date_format_parts: " . print_r($criteria_date_format_parts, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		}
		
		// construct the data we want to update to the database
		$entry_rec = array();
		$entry_rec['File_Definition_Id'] = $file_definition_id;
		$entry_rec['Criteria_Type_Id'] = $criteria_type_id;
		$entry_rec['Criteria_Name'] = $criteria_name;
		$entry_rec['Criteria_Required'] = ( (int)$criteria_required == 1 ) ? 1 : 0;
		$entry_rec['Criteria_Min_Len'] = ( $criteria_min_len != FALSE ) ? $criteria_min_len : 0;
		$entry_rec['Criteria_Max_Len'] = ( $criteria_max_len != FALSE ) ? $criteria_max_len : 0;
		$entry_rec['Criteria_Default_Value'] = $criteria_default_value;
		$entry_rec['Criteria_Tooltip'] = $criteria_tooltip;
		$entry_rec['Criteria_Recall_Name'] = ( $criteria_recall_name == 1 ) ? 1 : 0;
		$entry_rec['Criteria_Prefix'] = $criteria_prefix;
		$entry_rec['Criteria_Suffix'] = $criteria_suffix;
		$entry_rec['Criteria_Decimals'] = $criteria_decimals;
		$entry_rec['Criteria_Dec_Point'] = $criteria_dec_point;
		$entry_rec['Criteria_Thousands_Sep'] = $criteria_thousands_sep;
		$entry_rec['Criteria_Currency_Symbol'] = $criteria_currency_symbol;
		$entry_rec['Days_Back'] = $days_back;
		$entry_rec['Date_Back'] = $date_back;
		$entry_rec['Days_Forward'] = $days_forward;
		$entry_rec['Date_Forward'] = $date_forward;
		$entry_rec['Criteria_Php_Date_Format_Str'] = $criteria_php_date_format_str;
		$entry_rec['Criteria_JavaScript_Date_Format_Str'] = $criteria_javascript_date_format_str;
		
		
		if( empty($file_criteria_id) )
		{
			$entry_rec['Account_Id'] = $account_id; // add the account id because we are creating a 'new' file definition
			
			$return = $this->File_criteria_model->NewFileCriteria($entry_rec);
			$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->File_definitions_model->NewFileDefinition() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		}
		else
		{
			$return = $this->File_criteria_model->SaveFileCriteria($account_id, $file_criteria_id, $entry_rec);
			$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->File_definitions_model->SaveFileDefinition() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		}
		
		$json_response = $return;
		
		if( $this->input->get('callback') != FALSE )
		{
			echo $this->input->get('callback') . '(' . json_ecnode($json_response) . ')';
		}
		else
		{
			echo json_encode($json_response);
		}
	}
	
	//  This method will attempt save a given user database record with the data provided
	//  Request Data: POST[]
	public function SaveUser()
	{
		// Request Data: POST
		// User_Id		= the primary user key id (this is empty if we are creating a new user, else it should not be empty)
		// User_First_Name	= the user's first real name
		// User_Last_Name	= the user's last real name
		// User_Email		= the email the user uses to log in to the application
		// User_Password	= the password the user uses to log in to the application		
		
		$account_id = $this->auth_lib->GetAccountId();
		$user_id = $this->input->post('User_Id');
		$user_first_name = $this->input->post('User_First_Name');
		$user_last_name = $this->input->post('User_Last_Name');
		$user_email = $this->input->post('User_Email');
		$user_password = $this->input->post('User_Password');		
		$default_source_location = $this->input->post('Default_Source_Location');
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty, false, or invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($user_first_name) );   $err_msg = "\$user_first_name is empty, false, or invalid. \$user_first_name: $user_first_name \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($user_last_name) );   $err_msg = "\$user_last_name is empty, false, or invalid \$user_last_name: $user_last_name \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($user_email) );   $err_msg = "\$user_email is empty, false, or invalid \$user_email: $user_email \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		// first we need to check if the email is already in use.
		$return = $this->Users_model->CheckIfUserEmailExists($user_email);
		$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Users_model->NewUser() \n\$return: " . print_r($return, TRUE);   $user_err_msg = "There was an error while checking if the email address is being used."; $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $user_err_msg = "There was an error while checking if the email address is being used."; $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !isset($return['Exists']) );   $err_msg = "\$return[Exists] is not set and did not return. \n\$return: " . print_r($return, TRUE) ; $user_err_msg = "There was an error while checking if the email address is being used."; $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( $return['Exists'] == TRUE );   $err_msg = "The email exists." ; $user_err_msg = "The email already exists, please change the email address."; $notify = FALSE;   $severity = "WARNING";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		
		// construct the data we want to update to the database
		$entry_rec = array();
		$entry_rec['Account_Id'] = $account_id;
		$entry_rec['User_First_Name'] = $user_first_name;
		$entry_rec['User_Last_Name'] = $user_last_name;
		$entry_rec['User_Email'] = $user_email;
		$entry_rec['Default_Source_Location'] = $default_source_location;
		if( !empty($user_password) )
		{
			$entry_rec['User_Password'] = $user_password;
		}
		
		if( empty($user_id) )
		{
			$entry_rec['Account_Id'] = $account_id; // add the account id because we are creating a 'new' file definition
			
			$return = $this->Users_model->NewUser($entry_rec);
			$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Users_model->NewUser() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			
			$error = ( empty($return['New_User_Id']) );   $err_msg = "The new user id does not exist, or is empty. \n\$return: " . print_r($return, TRUE) ; $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			
			$new_user_id = $return['New_User_Id']; // set the new user id.
			
			// send the confirmation email for the primary user
			$result = $this->Users_model->SendUserConfirmationEmail($account_id, $new_user_id);
			$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Users_model->SendUserConfirmationEmail() \n\$return: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		}
		else
		{
			$return = $this->Users_model->SaveUser($account_id, $user_id, $entry_rec);
			$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Users_model->SaveUser() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		}
		
		$json_response = $return;
		
		if( $this->input->get('callback') != FALSE )
		{
			echo $this->input->get('callback') . '(' . json_ecnode($json_response) . ')';
		}
		else
		{
			echo json_encode($json_response);
		}
	}
	
	//  This method will save a given file definition default destination folder to the value provided.
	//  The method will print a json object no matter of failure or success.
	//  Request Data: POST[File_Definition_Id, Data_Storage_Folder_Id]
	public function SaveFileDefinitionDefaultDestinationFolder()
	{
		$account_id = $this->auth_lib->GetAccountId();
		$file_definition_id = $this->input->post('File_Definition_Id');
		$data_storage_folder_id = $this->input->post('Data_Storage_Folder_Id');
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty, false, or invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($file_definition_id) );   $err_msg = "\$file_definition_id is empty, and invalid. \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $data_storage_folder_id == '' ); /* can equal 0 */   $err_msg = "\$data_storage_folder_id is empty, and invalid \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( strlen($data_storage_folder_id) < 5 ); /* can equal 0 */   $err_msg = "\$data_storage_folder_id has a string length less than 5. \n\$_POST: " . print_r($this->input->post(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		// construct the data we want to update to the database
		$entry_rec = array();
		$entry_rec['Default_Destination_Path'] = $data_storage_folder_id;
		
		$return = $this->File_definitions_model->SaveFileDefinition($account_id, $file_definition_id, $entry_rec);
		$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->File_definitions_model->SaveFileDefinition() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	
		
		$json_response = $return;
		
		if( $this->input->get('callback') != FALSE )
		{
			echo $this->input->get('callback') . '(' . json_ecnode($json_response) . ')';
		}
		else
		{
			echo json_encode($json_response);
		}
		
	}
	
	//  This method will save a data to the session array
	//  Request Data: GET[file_criteria_id, sort_direction]
	public function UpdateFileCriteriaSort()
	{
		$file_criteria_id = $this->input->get('file_criteria_id');
		$file_definition_id = $this->input->get('file_definition_id');
		$sort_direction = $this->input->get('sort_direction');
		$account_id = $this->auth_lib->GetAccountId();
		
		$error = ( empty($file_criteria_id) );   $err_msg = "\$file_criteria_id is empty, false, or invalid. \n\$_GET: " . print_r($this->input->get(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($file_definition_id) );   $err_msg = "\$file_definition_id is empty, false, or invalid. \n\$_GET: " . print_r($this->input->get(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($sort_direction) );   $err_msg = "\$sort_direction is empty, and invalid. \n\$_GET: " . print_r($this->input->get(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$return = $this->File_criteria_model->UpdateFileCriteriaSortOrder($account_id, $file_criteria_id, $file_definition_id, $sort_direction);
		
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
	
	
	//  This method will save a data to the session array
	//  Request Data: GET[session_name, session_value]
	public function SaveSessionVar()
	{
		$session_name = $this->input->get('session_name');
		$session_value = $this->input->get('session_value');
		
		$error = ( empty($session_name) );   $err_msg = "\$session_name is empty, false, or invalid. \n\$_GET: " . print_r($this->input->get(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($session_value) );   $err_msg = "\$session_value is empty, and invalid. \n\$_GET: " . print_r($this->input->get(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		// resetting or saving the session userdata 'account_id' is not allowed
		$error = ( $session_name == 'account_id' );   $err_msg = "Setting or saving the session variable 'account_id' is not allowed. \n\$_GET: " . print_r($this->input->get(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$this->session->set_userdata($session_name, $session_value);
		
		$session_check = $this->session->userdata($session_name);
		
		print_r($this->session->all_userdata());
		
		$result = ( $session_check == $session_value ) ? TRUE : FALSE;
		
		$return = array('Result' => $result, 'Result_Message' => 'Executed Successfully!');
		
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
	
	//  This method controls the administration tool to update box file tags
	//  Request Data: POST[]
	public function UpdateBoxFileTags()
	{
		$tags = $this->input->post('Tags');
		$folder_name = $this->input->post('Folder_Name');
		$folder_id = $this->input->post('Folder_Id');
		$account_id = $this->auth_lib->GetAccountId();
		
		// file definition to use data
		$file_definition_to_use = $this->input->post('File_Definition_To_Use');
		$file_definition_to_use_criteria_separator = $this->input->post('File_Definition_To_Use_Criteria_Separator');
		$file_definition_id = $this->input->post('File_Definition_Id');
		
		// existing tags to use data
		$existing_tags = $this->input->post('Existing_Tags');
		
		// process order data
		$process_order = $this->input->post('Process_Order');
		$process_in_order_by_filename_order = $this->input->post('Process_In_Order_By_Filename_Order');
		$process_in_order_using_file_criteria_as_a_date_order = $this->input->post('Process_In_Order_Using_File_Criteria_As_A_Date_Order');
		$process_in_order_using_file_criteria_as_a_date_criteria_separator = $this->input->post('Process_In_Order_Using_File_Criteria_As_A_Date_Criteria_Separator');
		
		$this->load->model('Batch_model');
		
		// construct update files tags data array 
		$update_files_tags_data = array();
		$update_files_tags_data['Folder_Name'] = $folder_name;
		$update_files_tags_data['Folder_Id'] = $folder_id;
		$update_files_tags_data['File_Definition_To_Use'] = $file_definition_to_use;
		$update_files_tags_data['File_Definition_Id'] = $file_definition_id;
		$update_files_tags_data['File_Definition_To_Use_Criteria_Separator'] = $file_definition_to_use_criteria_separator;
		$update_files_tags_data['Existing_Tags'] = $existing_tags;
		$update_files_tags_data['Process_Order'] = $process_order;
		$update_files_tags_data['Process_In_Order_By_Filename_Order'] = $process_in_order_by_filename_order;
		$update_files_tags_data['Process_In_Order_Using_File_Criteria_As_A_Date_Order'] = $process_in_order_using_file_criteria_as_a_date_order;
		$update_files_tags_data['Process_In_Order_Using_File_Criteria_As_A_Date_Criteria_Separator'] = $process_in_order_using_file_criteria_as_a_date_criteria_separator;
		
		$return = $this->Batch_model->BoxUpdateFilesTags($account_id, $update_files_tags_data);
		
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
	
	
	
}
