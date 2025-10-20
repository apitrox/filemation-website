<?php if( !defined('BASEPATH') ) die('No direct script access.');

class Json extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->auth_lib->Secure();
	}
	
	public function index()
	{
		
	}
	
	//  This method controls retrieving the given account's to be filed files list on the remote file server and returns them in a json object
	//  Request Data: GET[aid]			
	public function GetAccountToBeFiledFiles()
	{
		// Request Data
		// aid	= account primary key id
		
		$account_id = $this->auth_lib->GetAccountId();
		
		$result = $this->Docs_model->GetToBeFiledFilesForAccount($account_id);
		
		// because this json object is going to be used with a 'dataTables' grid it must be wrapped in a 'data' object.
		$data = array();
		if( isset($result['Result']) && $result['Result'] == TRUE && isset($result['Data']) )
		{
			$records_total = count($result['Data']);
				   
			$data['draw'] = 1;
			$data['recordsTotal'] = $records_total;
			$data['recordsFiltered'] = $records_total;
			$data['data'] = $result['Data'];
		}
		
		$json_response = $data;
		
		if( $this->input->get('callback') != FALSE )
		{
			echo $this->input->get('callback') . '(' . json_encode($json_response) . ')';
		}
		else
		{
			echo json_encode($json_response);
		}
	}
	
	//  This method controls retrieving
	//  Request Data: GET[file_definition_id]
	public function GetAllFileCriteriaForFilerUI()
	{
		//  Request Data
		//  file_definition_id	= file definition primary key id	
		
		$account_id = $this->auth_lib->GetAccountId();
		$file_definition_id = $this->input->get('file_definition_id');
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty, false, or invalid \n\$account_id: $account_id"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($file_definition_id) );   $err_msg = "\$file_definition_id is empty, false, or invalid. \$_GET: " . print_r($_GET, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$result = $this->File_criteria_model->GetAllFileCriteriaForFilerUI($account_id, $file_definition_id);
		
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
	
	//  This method will get a file definition record data row
	//  Request Data: GET[file_definition_id]
	public function GetFileDefinition()
	{
		//	Request Data
		//	file_definition_id	= file definition primary key id
		
		$account_id = $this->session->userdata('account_id');
		$file_definition_id = $this->input->get('file_definition_id');
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty, false, or invalid. \n\$account_id: $account_id "; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($file_definition_id) );   $err_msg = "\$file_definition_id is empty, false, or invalid. \n\$file_definition_id: $file_definition_id \n\$_GET: " . print_r($_GET, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		$result = $this->File_definitions_model->GetFileDefinition($account_id, $file_definition_id);
		$default_destination_path = ( isset($result['Result']) && ( $result['Result'] == TRUE) && isset($result['Row']) ) ? $result['Row']->Default_Destination_Path : '';
		
		
		// we need to get the default destination path name and return it to the interface
		if( !empty($default_destination_path) )
		{
			$return = $this->Data_storage_model->BoxGetFolderDetails($account_id, $default_destination_path);
			$default_destination_path_name = ( isset($return['Result']) && $return['Result'] == TRUE ) ? $return['Data']['Name'] : '';
			$default_destination_full_path_name = ( isset($return['Result']) && $return['Result'] == TRUE ) ? $return['Data']['Full_Folder_Path'] : '';
			$result['Row']->Default_Destination_Path_Name = $default_destination_path_name;
			$result['Row']->Default_Destination_Full_Path_Name = $default_destination_full_path_name;
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
	
	//  This method will get a file criteria record data row
	//  Request Data: GET[file_criteria_id]
	public function GetFileCriteria()
	{
		//	Request Data
		//	file_criteria_id	= file criteria primary key id
		//	file_definition_id	= file definition primary key id
		
		$account_id = $this->session->userdata('account_id');
		$file_criteria_id = $this->input->get('file_criteria_id');
		$file_definition_id = $this->input->get('file_definition_id');
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty, false, or invalid. \n\$account_id: $account_id "; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($file_definition_id) );   $err_msg = "\$file_definition_id is empty, false, or invalid. \n\$file_definition_id: $file_definition_id \n\$_GET: " . print_r($_GET, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		$result = $this->File_criteria_model->GetFileCriteria($account_id, $file_criteria_id, $file_definition_id);
		
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
	
	//  This method will get a user record data row
	//  Request Data: GET[user_id]
	public function GetUser()
	{
		//	Request Data
		//	user_id = the primary user key id
		
		$account_id = $this->session->userdata('account_id');
		$user_id = $this->input->get('user_id');
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty, false, or invalid. \n\$account_id: $account_id "; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($user_id) );   $err_msg = "\$user_id is empty, false, or invalid. \n\$user_id: $user_id \n\$_GET: " . print_r($_GET, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		$result = $this->Users_model->GetUser($account_id, $user_id);
		
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
	
	public function GetDataStorageProviders()
	{
		
	}
	
	
	//  This method will get all the folders listed in a data storage folder via the account's data storage provider
	//  Request Data: GET[aid, data_storage_folder_id]
	public function DataStorageGetAllFoldersInRoot()
	{
		//  Request Data
		//  aid	= account primary key id
		//  data_storage_folder_id	= the data storage folder id
		
		$account_id = $this->input->get('aid');
		$data_storage_folder_id = $this->input->get('data_storage_folder_id');
		
		$error = ( empty($account_id) );   $err_msg = "\$aid is empty, false, or invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$result = $this->Data_storage_model->BoxGetAllFolders($account_id);
		$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->BoxCheckTokens() \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
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
	
	
	//  This method will get all the folders listed in a data storage folder via the account's data storage provider
	//  Request Data: GET[aid, data_storage_folder_id]
	public function DataStorageGetAllFoldersInFolder()
	{
		//  Request Data
		//  aid	= account primary key id
		//  data_storage_folder_id	= the data storage folder id
		
		$account_id = $this->input->get('aid');
		$data_storage_folder_id = $this->input->get('data_storage_folder_id');
		
		$error = ( empty($account_id) );   $err_msg = "\$aid is empty, false, or invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $data_storage_folder_id == '' );   $err_msg = "\$data_storage_folder_id is empty, and invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		$result = $this->Data_storage_model->BoxGetAllFoldersInFolder($account_id, $data_storage_folder_id);
		$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->BoxCheckTokens() \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
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

	//  This method will get details about the given folder in an account's data storage provider.
	//  Request Data: GET[aid, data_storage_folder_id]
	public function DataStorageGetFolderDetails()
	{
		//  Request Data
		//  aid	= account primary key id
		//  data_storage_folder_id	= the data storage folder id
		
		$account_id = $this->auth_lib->GetAccountId();
		$data_storage_folder_id = $this->input->get('data_storage_folder_id');
		
		$error = ( empty($account_id) );   $err_msg = "\$aid is empty, false, or invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $data_storage_folder_id === FALSE && $data_storage_folder_id != 0 );   $err_msg = "\$data_storage_folder_id is empty, and invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		$result = $this->Data_storage_model->BoxGetFolderDetails($account_id, $data_storage_folder_id);
		$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->BoxCheckTokens() \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		// because this could return a member of the array if it returns false, we want to use the result returned from the above $result call as the json object printed below.
		
		
		// get all the folder path collection or the full path of the folder and put it in a string
		
		
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
	
	//  This method will get all the recall name values for the given file criteria
	//  Request Data: GET[file_criteria_id]
	public function GetFileCriteriaRecallNames()
	{
		$account_id = $this->auth_lib->GetAccountId();
		$user_id = $this->auth_lib->GetUserId();
		
		$file_definition_id = $this->input->get('file_definition_id');
		$file_criteria_id = $this->input->get('file_criteria_id');
		$recall_name = $this->input->get('recall_name');
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty, false, or invalid \n\$account_id: $account_id"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($user_id) );   $err_msg = "\$user_id is empty, false, or invalid \n\$user_id: $user_id"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($file_definition_id) );   $err_msg = "\$file_definition_id is empty, false, or invalid \n\GET: " . print_r($this->input->get(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($file_criteria_id) );   $err_msg = "\$file_criteria_id is empty, and invalid \n\GET: " . print_r($this->input->get(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		$result = $this->Recall_names_model->GetRecallNames($account_id, $user_id, $file_definition_id, $file_criteria_id, $recall_name);
		$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Recal_names_model->GetRecallNames() \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !isset($result['Data']) );   $err_msg = "The data did not return in the GetRecallNames() call. \n\$account_id: $account_id \n\$user_id: $user_id \n\$file_definition_id: $file_definition_id \n\$file_criteria_id: $file_criteria_id \n\$recall_name: $recall_name \n\$return: " . print_r($result, TRUE) ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		// before we can return out recall name data to the end user UI we need to reformat the array being returned into the array result the interface is expecting.
		$data_result = $result['Data'];
		$data = array();
		foreach($data_result as $item)
		{
			$data[] = $item['Recall_Name']; // we only want to return a simple array with each value being a recall name.
		}
		
		$json_response = $data;
		
		if( $this->input->get('callback') != FALSE )
		{
			echo $this->input->get('callback') . '(' . json_encode($json_response) . ')';
		}
		else
		{
			echo json_encode($json_response);
		}
	}
	
	//  This method will check if a given email address exists in the account. If it exists in the account notify the end user the email already exists and they will need to select a different one.
	//  Request Data: GET[user_email]
	public function CheckIfEmailExists()
	{
		$user_email = $this->input->get('user_email');
		
		$error = ( empty($user_email) );   $err_msg = "\$user_email is empty. \$_GET: " . print_r($this->input->get(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( strpos($user_email, '@') == FALSE );   $err_msg = "The user email is not a valid email. \$user_email is not a valid email; it does not have a @ sign \n\$user_email: $user_email \n\$_GET: " . print_r($this->input->get(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( strpos($user_email, '.') == FALSE );   $err_msg = "The user email is not a valid email. \$user_email is not a valid email; it does not have a period (.) \n\$user_email: $user_email \n\$_GET: " . print_r($this->input->get(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$return = $this->Users_model->CheckIfUserEmailExists($user_email);
		
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