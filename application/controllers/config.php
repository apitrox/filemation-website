<?php if( !defined('BASEPATH') ) die('No direct script access');

class Config extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->auth_lib->Secure();
	}
	
	public function Index()
	{
		$this->Accounts_model->ValidateAccount();
		header('Location: /config/account');
		exit;
	}
	
	// =======================================
	// View methods
	// =======================================
	
	//  This method controls the account configuration page
	public function Account()
	{
		$this->Accounts_model->ValidateAccount();
		$this->load->model('Data_storage_providers_model');
		
		$account_id = $this->auth_lib->GetAccountId();
		
		// get the user's account record
		$account_result = $this->Accounts_model->GetAccount($account_id);
		$account = ( isset($account_result['Result']) && $account_result['Result'] == TRUE ) ? $account_result['Row'] : FALSE;
		
		$data_storage = $account->Data_Storage; // the data storage provider
		$access_token = $account->Access_Token; // the data file storage access token
		$refresh_token = $account->Refresh_Token; // the data file storage refresh token
		$default_source_location = $account->Default_Source_Location;
		$default_source_location_name = "";
		
		$account_is_authorized = ( !empty($data_storage) && !empty($access_token) && !empty($refresh_token) ) ? true : false;
		
		if( !empty($default_source_location) )
		{
			$result = $this->Data_storage_model->BoxGetFolderDetails($account_id, $default_source_location);
			$default_source_location_name = ( isset($result['Result']) && $result['Result'] == TRUE ) ? $result['Data']['Name'] : '';
		}
		
		// get data storage providers
		$result = $this->Data_storage_providers_model->GetAllDataStorageProviders();
		$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_strorage_providers_model->GetAllDataStorageProviders() \$return: \n" . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$data_storage_providers_array = $result['Data'];
		
		
		$view_data = array();
		$view_data['account'] = $account;
		$view_data['account_is_authorized'] = $account_is_authorized;
		$view_data['data_storage_providers_array'] = $data_storage_providers_array;
		$view_data['default_source_location_name'] = $default_source_location_name;
		
		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('header_configuration', array('page'=>'Account'));
		$this->load->view('config/account', $view_data);
		$this->load->view('footer');
	}
	
	//  This method controls the file definitions configuration page
	public function FileDefinitions()
	{
		$this->Accounts_model->ValidateAccount();
		$this->load->model('Criteria_separators_ref_model');
		
		$account_id = $this->auth_lib->GetAccountId();
		
		// get the criteria separators ref records
		$criteria_separators_ref_result = $this->Criteria_separators_ref_model->GetAllCriteriaSeparators();
		$criteria_separators_ref_array = ( $criteria_separators_ref_result['Result'] == TRUE ) ? $criteria_separators_ref_result['Data'] : array();
		
		$view_data = array();
		$view_data['account_id'] = $account_id;
		$view_data['criteria_separators_ref_array'] = $criteria_separators_ref_array;
		
		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('header_configuration', array('page'=>'File Definitions'));
		$this->load->view('config/file_definitions', $view_data);
		$this->load->view('footer');
	}
	
	//  This method controls the file criteria configuration page
	public function FileCriteria()
	{
		$this->Accounts_model->ValidateAccount();
		$this->load->model('Criteria_types_ref_model');
		$this->load->model('Date_formats_ref_model');
		
		$account_id = $this->auth_lib->GetAccountId();
		
		$result = $this->Criteria_types_ref_model->GetAllCriteriaTypes();
		$criteria_types_array = ( isset($result['Result']) && $result['Result'] == TRUE ) ? $result['Data'] : array(); 
		
		$result = $this->File_definitions_model->GetAllFileDefinitionsForAccount($account_id);
		$file_definitions_array = ( isset($result['Result']) && $result['Result'] == TRUE ) ? $result['Data'] : array(); 
		
		$result = $this->Date_formats_ref_model->GetAllDateFormats();
		$date_formats_array = ( isset($result['Result']) && $result['Result'] == TRUE ) ? $result['Data'] : array();
		
		$view_data = array();
		$view_data['account_id'] = $account_id;
		$view_data['criteria_types_array'] = $criteria_types_array;
		$view_data['file_definitions_array'] = $file_definitions_array;
		$view_data['date_formats_array'] = $date_formats_array;
		
		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('header_configuration', array('page'=>'File Criteria'));
		$this->load->view('config/file_criteria', $view_data);
		$this->load->view('footer');
	}
	
	//  This method controls the users configuration page.
	public function Users()
	{
		$this->Accounts_model->ValidateAccount();
		$account_id = $this->auth_lib->GetAccountId();
		
		$view_data = array();
		$view_data['account_id'] = $account_id;
		
		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('header_configuration', array('page'=>'Users'));
		$this->load->view('config/users', $view_data);
		$this->load->view('footer');
	}
	
	// This method controls the tools configuration page.
	// Note: This page might not be in the production version, OR the tools will be part of a separate app that is for filemation employees or filemation administrators.
	public function Tools()
	{
		$this->Accounts_model->ValidateAccount();
		$this->load->model('Criteria_separators_ref_model');
		
		$account_id = $this->auth_lib->GetAccountId();
		
		// get the criteria separators ref records
		$criteria_separators_ref_result = $this->Criteria_separators_ref_model->GetAllCriteriaSeparators();
		$criteria_separators_ref_array = ( $criteria_separators_ref_result['Result'] == TRUE ) ? $criteria_separators_ref_result['Data'] : array();
		
		// get all file definitions associated to this account to be used as a dropdown in the view.
		$result = $this->File_definitions_model->GetAllFileDefinitionsForAccount($account_id);
		$file_definitions_array = ( isset($result['Result']) && $result['Result'] == TRUE ) ? $result['Data'] : array(); 
		
		$view_data = array();
		$view_data['account_id'] = $account_id;
		$view_data['criteria_separators_ref_array'] = $criteria_separators_ref_array;
		$view_data['file_definitions_array'] = $file_definitions_array;
		
		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('header_configuration', array('page'=>'Tools'));
		$this->load->view('config/tools', $view_data);
		$this->load->view('footer');
	}
	
	//  This method controls setting up the account user configuration page. This is the first page the end user sees when first logging into the application.
	//  This page is also displayed if the account data storage value is not set. 
	public function SetupAccount()
	{
		$this->load->model('Data_storage_providers_model');
		
		$account_id = $this->auth_lib->GetAccountId();
		
		// get the account record
		$result = $this->Accounts_model->GetAccount($account_id);
		$account = ( isset($result['Result']) && $result['Result'] == TRUE ) ? $result['Row'] : FALSE;		
		
		// get data storage providers
		$result = $this->Data_storage_providers_model->GetAllDataStorageProviders();
		$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_strorage_providers_model->GetAllDataStorageProviders() \$return: \n" . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$data_storage_providers_array = $result['Data'];
		
		$view_data = array();
		$view_data['account'] = $account;
		$view_data['account_id'] = $account_id;
		$view_data['data_storage_providers_array'] = $data_storage_providers_array;
		
		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('config/setup_account', $view_data);
		$this->load->view('footer');
	}
	
	// =======================================
	// Action methods
	// =======================================
	
	
}