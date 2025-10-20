<?php
class Test extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function TestJSDates()
	{
		$this->load->view('head');
		$this->load->view('test/test_js_dates');
		$this->load->view('footer');
	}
	
	public function TestBoxAuth()
	{
		
		// auth application to box request variables
		$code = $this->input->get('code');
		$state = $this->input->get('state');
		
		$this->load->library('box_api_lib');
		
//		
//		if( $code == FALSE && $state == FALSE )
//		{
//			$this->load->library('box_api_lib');
//		
//			$this->box_api_lib->GetCode();
//		}
//		else
//		{
//			$result = $this->box_api_lib->get_token($code, FALSE);
//			
//			echo "<pre>"; print_r($result);
//		}
		
		
		echo $this->box_api_lib->GetAuthCodeUrl();
		
		
		
	}
	
	
	public function TestBoxAPI()
	{
		$account_id = $this->auth_lib->GetAccountId();
		
		// get the account record
		$result = $this->Accounts_model->GetAccount($account_id);
		$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Accounts_model->GetAccount() \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$account = ( isset($result['Result']) && $result['Result'] == TRUE ) ? $result['Row'] : FALSE;
		$error = ( !is_object($account) );   $err_msg = "The account was not found in the database. \$account is not an object. \n\$account_id: $account_id \n" . $result['Result_Message'];   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$access_token = $account->Access_Token;
		$refresh_token = $account->Refresh_Token;
		
		// setup the box api class and call
		$config = array();
		$config['Client_Id'] = $this->config->item('Data_Storage_Box_Client_Id'); 
		$config['Client_Secret'] = $this->config->item('Data_Storage_Box_Client_Secret');
		$config['View_API_Key'] = $this->config->item('Data_Storage_Box_View_API_Key');
		$config['Api_Key'] = $this->config->item('Data_Storage_Box_API_Key');
		$config['Redirect_Uri'] = $this->config->item('Data_Storage_Box_Redirect_Uri');
		$config['Access_Token'] = $access_token;
		$config['Refresh_Token'] = $refresh_token;
		$this->load->library('box_api_lib', $config);
		
		$test_file_id = 18949715553;
		$file_id = 2114735242;
		$receipt_file_id = 19133868521;
		$to_be_filed_document_1_id = 18511404736;
		$document1_id = 18291769084;
		$copied_file_id = 18341036664;
		
		
		$to_be_filed_id = 2114743206;
		$filemation_test_id = 2114735242;
		$receipts_destination_id = 2114746510;
		$folder_does_not_exist_id = 1234567800;
		
		
		$new_file_name = "Receipt, $111.00, 7-18-2014, test.pdf";
		
		$filename_and_path = "/home/devfiles/filemation_batch_files/test_api_filename.pdf";
		
		$file_data = array();
//		$file_data['tags'] = array('testTag1', 'testTag2');
		$file_data['Name'] = "Rename Test Again.pdf";
		//$file_data['Content_Created_At'] = "2012-12-12T10:55:30-08:00"; //date( DATE_RFC3339, strtotime( date('m-d-Y h:i:s') ) );
		//$file_data['Content_Modified_At'] = "2012-12-12T10:55:30-08:00"; // date( DATE_RFC3339, strtotime( date('m-d-Y h:i:s') ) );
		
		
		echo date('H:i:s', time()); echo "<br/>";
//		$result = $this->box_api_lib->GetFoldersInFolder($filemation_test_id);
//		$result = $this->box_api_lib->GetFilesInFolder($to_be_filed_id);
//		$result = $this->box_api_lib->CopyFile($receipt_file_id, $receipts_destination_id, $new_file_name);
		//$result = $this->box_api_lib->DeleteFile($copied_file_id);
		//$result = $this->box_api_lib->GetFolderDetails($receipts_destination_id);
//		$result = $this->box_api_lib->UpdateFileInformation($test_file_id, $file_data);
		$result = $this->Data_storage_model->BoxUpdateFileInformation($account_id, $test_file_id, $file_data);
//		$result = $this->box_api_lib->UploadFile($filename_and_path, $receipts_destination_id, $file_data);
//		$result = $this->box_api_lib->GetFileTags($file_id);
//		$result = $this->Data_storage_model->BoxGetFileTags($account_id, $file_id);
		
//		echo "<pre> Line: " . __LINE__ . " Method: " . __METHOD__; print_r($result); exit;
//		$result = $this->Data_storage_model->BoxDownloadFile($account_id, $file_id);
		
		echo "<pre> Line: " . __LINE__ . " Method: " . __METHOD__; print_r($result); exit;
		
		
		// Test viewing session
		// -----------------------------------
		$result = $this->Data_storage_model->BoxGetDownloadUrl($account_id, $file_id);
		
		$download_url = $result['Download_Url'];
		
		$result = $this->box_api_lib->GetDocIdFromViewAPI($download_url);
		
		$document_id = $result->id;
		
		$result = $this->box_api_lib->GetViewingSessionForDocID($document_id);
		
		$session_id = $result->id;
		
		echo "<pre> RESULT: "; print_r($result); echo "</pre>";
		echo "<iframe src='https://view-api.box.com/view/$session_id'></iframe>";
		
//		echo "<pre>"; print_r($result);
	}
	
	public function TestDropboxAPI()
	{
		$account_id = $this->auth_lib->GetAccountId();
		
		$result = $this->Accounts_model->GetAccount($account_id);
		$account = $result['Row'];
		
		$access_token = $account->Access_Token;
		
		$config = array();
		$config['Client_Id'] = $this->config->item('Data_Storage_Dropbox_Client_Id');
		$config['Client_Secret'] = $this->config->item('Data_Storage_Dropbox_Client_Secret');
		$config['Redirect_Uri'] = $this->config->item('Data_Storage_Dropbox_Redirect_Uri');
		$config['Access_Token'] = $access_token;
		
		$this->load->library('dropbox_api_lib', $config);
		
		
		$download_path = $this->config->item('FILES_CONVERTED_PATH');
		
		
//		$result = $this->dropbox_api_lib->DownloadFile("== TO BE FILED ==/TestKeypad.pdf", $download_path);
//		$result = $this->dropbox_api_lib->GetFilePreview("== TO BE FILED ==/Folder_256.png");
		$result = $this->dropbox_api_lib->MoveFile("Receipts/Test.png", "== TO BE FILED ==/Folder_256(1).png");
		
		
		echo "<pre>"; print_r($result);
	}
	
	public function TestFolderInterface()
	{
		$test = $this->input->get('test');
		//$error = ( $test === FALSE );   $err_msg = "The request data \$test is invalid." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){  $error_view_data = array('error_message' => $err_msg, 'error_log_id' => $err_log_id);  $this->load->view('head'); $this->load->view('header'); $this->load->view('error', $error_view_data); $this->load->view('footer'); }

		
		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('test/test_select_folder');
		$this->load->view('footer');
	}
	
	public function TestModal()
	{
		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('test/test_modal');
	}
	
	public function TestBoxFilePicker()
	{
		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('test/test_box_file_picker');
		$this->load->view('footer');
	}
	
	public function TestAffixNav()
	{
		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('test/test_affix_nav');
		
	}
	
	public function TestAutoComplete()
	{
		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('test/test_ac');
	}
	
	public function TestTextFieldAllowedCharacters()
	{
		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('test/test_textfield_allowed_characters');
	}
	
	public function TestFlashSession()
	{
		$value = 'Test';
		
		//$result = $this->session->set_flashdata('Test', $value);
		
		$result = $this->session->flashdata('Test');
		
		echo $result;
	}
	
	public function TestSubNav()
	{
		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('test/test_sub_nav');
		$this->load->view('footer');
	}
	
	public function TestTooltip()
	{
		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('test/test_tooltips');
		$this->load->view('footer');
	}
	
	public function TestMask()
	{
		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('test/test_mask');
		$this->load->view('footer');
	}
	
	public function TestRegConfirmEmail()
	{
		$user_first_name = "Firstname";
		$user_last_name = "Lastname";
		$user_email = "corey@afcamail.com";
		$confirmation_key = "*SdkDI*90z,928dn";
		
		$result = $this->auth_lib->SendConfirmationEmail($user_first_name, $user_last_name, $user_email, $confirmation_key);
		
		echo "<pre>"; print_r($result);
		
	}
	
	public function TestServerVar()
	{
		
		$server = $_SERVER;
		echo '<pre>'; print_r($server);
		
	}
	
	public function TestFileInterface()
	{
		$view_data = array();
		$this->load->view('head');
		$this->load->view('test/test_filer_interface', $view_data);
	}
	
	public function TestJSON()
	{
		$string = "not a json object";
		$json_result = json_decode($string);
		
		if( empty($json_result) )
		{
			print "Is not a json object";
		}
		else
		{
			print "IS A JSON OBJECT";
		}
		echo "<br/>";
		
		
		$json_last_error = json_last_error();
	}
	
	public function TestRecallNames()
	{
		$view_data = array();
		
		
		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('test/test_recall_names', $view_data);
		$this->load->view('footer');
	}
	
	public function TestPopovers()
	{
		$view_data = array();
		
		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('test/test_popovers', $view_data);
		$this->load->view('footer');
	}
	
	public function TestPHP()
	{
		$string = "Receipt, $100.00, 08-12-2014(2)";
		
		$suffix = substr($string, -3, strlen($string));
		$suffix_1 = substr($suffix, 0, 1);
		$suffix_2 = substr($suffix, 1, 1);
		$suffix_3 = substr($suffix, 2, 3);
		
		echo $suffix_1;
		
		if( $suffix_1 == '(' && is_numeric($suffix_2) && $suffix_3 == ')')
		{
			echo "Has previous version";
		}
		
	}
	
	
	public function TestSession()
	{
		$sessionData = $this->session->all_userdata();
		
		echo "******* ALL USERDATA *********<br/>";
		echo "<pre>"; print_r($sessionData);
		
		$this->session->set_userdata('Test', '<h1>This is a test</h1>');
		
		$test = $this->session->userdata('Test');
		
		echo "******* SESSION [Test] ********<br/>";
		echo $test;
		
	}
	
	public function TestDevices()
	{
		$this->load->library('mobile_detect_lib');
		
		$mobile = $this->mobile_detect_lib->isMobile();
		$tablet = $this->mobile_detect_lib->isTablet();
		
		if( $mobile )
		{
			echo "Is mobile";
		}
		else if( $tablet )
		{
			echo "Is tablet";
		}
		else
		{
			echo "No mobile or tablet";
		}
	}
	
	public function TestValidDate()
	{
		$date = date('m-d-Y', time());
		
		$utime = strtotime($date, time());
		var_dump($utime);
		echo "<br/>";
		echo date('n-d-Y', $utime);
	}
	
	public function TestSortArray()
	{
		$array = array(1413349200, 1413522000);
		
		echo "Before Sort: " . print_r($array, TRUE);
		echo "<br/>---------------------------------<br/>";
		
		rsort($array, SORT_NUMERIC );
		
		echo "After Sort: " . print_r($array, TRUE);
	}
	
}
