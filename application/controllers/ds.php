<?php if( !defined('BASEPATH') ) die('No direct script access');

/*
 * Filemation
 */

class Ds extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->auth_lib->Secure();
	}
	
	
	//  This method authorizes a data storage account with the filemation application. This method only authorizes oAuth2.0 protocals.
	//  Request Data: GET[code, state]
	public function AuthorizeDataStorageAccount()
	{
		$account_id = $this->auth_lib->GetAccountId();
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty, false, or invalid"; $user_err_msg = "The account primary key is invalid."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		// first we need to get the account data storage provider so we can detemine which url to redirect to or which api call to make.
		
		// get the account record
		$result = $this->Accounts_model->GetAccount($account_id);
		$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Accounts_model->GetAccount() \n\$result: " . print_r($result, TRUE);   $user_err_msg = "There was an error while retrieving the account information."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $user_err_msg = "There was an error while retrieving the account information."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($result['Row']) );   $err_msg = "The account record row did not return. \$result[Row] is not set or empty. \n\$result: " . print_r($result, TRUE) ; $user_err_msg = "There was an error while retrieving the account information."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$account = ( isset($result['Result']) && $result['Result'] == TRUE ) ? $result['Row'] : FALSE;
		$error = ( !is_object($account) );   $err_msg = "The account was not found in the database. \$account is not an object. \n\$account_id: $account_id \n" . $result['Result_Message']; $user_err_msg = "The account was not found."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$data_storage_provider = $account->Data_Storage; // set the data storage provider
		$error = ( (strtoupper($data_storage_provider) != 'BOX') && (strtoupper($data_storage_provider) != 'DROPBOX') && (strtoupper($data_storage_provider) != 'GOOGLE DRIVE') && (strtoupper($data_storage_provider) != 'MICROSOFT ONEDRIVE') && (strtoupper($data_storage_provider) != 'AMAZON') );   $err_msg = "The account data storage provider is invalid. \$data_storage_provider is not one of the acceptable data storage providers. \n\$data_storage_provider: $data_storage_provider \n\$account_id: $account_id \n" . $result['Result_Message']; $user_err_msg = "The data storage provider is not an acceptable value. Select a data storage provider, and try again."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		if( strtoupper($data_storage_provider) == "BOX" )
		{
			// 1.	Redirect the user to the data storage authorize url (Ex: https://www.box.com/api/oauth2/authorize) with the oAuth client id, client secret, and redirect uri.
			//		The user has been redirected away from the filemation application to enter in their file storage credentials. After the proper credentials for their file storage account
			//		have been entered they will click authorize. Once the file storage server authorizes their request it will redirect them back to the redirect URI, we sent with the redirect,
			//		with a "code" and "state" name value pairs.
			//		code => 	Authorization code
			//		state =>	CSRF security_token
			// 2.	If an error has not been returned, we now post to the file storage server to receive the access token and the refresh token. (Ex: https://www.box.com/api/oauth2/token)
			//		access token =>   The access token is what’s needed to sign your API requests to Box.

			$config = array();
			$config['Client_Id'] = $this->config->item('Data_Storage_Box_Client_Id'); 
			$config['Client_Secret'] = $this->config->item('Data_Storage_Box_Client_Secret');
			$config['Redirect_Uri'] = $this->config->item('Data_Storage_Box_Redirect_Uri');
			$this->load->library('box_api_lib', $config);

			$result = $this->Data_storage_model->BoxGetAuthUrl();
		
		}
		else if( strtoupper($data_storage_provider) == "DROPBOX" )
		{
			// 1.	Redirect the user to the data storage authorize url (Ex: https://www.dropbox.com/1/oauth2/authorize) with the oAuth client id, client secret, and redirect uri.
			//		The user has been redirected away from the filemation application to enter in their file storage credentials. After the proper credentials for their file storage account
			//		have been entered they will click authorize. Once the file storage server authorizes their request it will redirect them back to the redirect URI, we sent with the redirect,
			//		with a "code" and "state" name value pairs.
			//		code => 	Authorization code
			//		state =>	CSRF security_token
			// 2.	If an error has not been returned, we now post to the file storage server to receive the access token and the refresh token. (Ex: https://www.box.com/api/oauth2/token)
			//		access token =>   The access token is what’s needed to sign your API requests to Box.

			$config = array();
			$config['Client_Id'] = $this->config->item('Data_Storage_Dropbox_Client_Id'); 
			$config['Client_Secret'] = $this->config->item('Data_Storage_Dropbox_Client_Secret');
			$config['Redirect_Uri'] = $this->config->item('Data_Storage_Dropbox_Redirect_Uri');
			$this->load->library('dropbox_api_lib', $config);
			
			$result = $this->Data_storage_model->DropboxGetAuthUrl();
			
		}
		else if( strtoupper($data_storage_provider) == "GOOGLE DRIVE" )
		{
			// ** google drive get auth url goes here			
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
	
	
	//  This method makes the call to the data storage provider to get the required api tokens using the recently aquired authorize code
	//  Request Data: Get[code, state]
	public function GetDataStorageAuthTokens()
	{
		
		//	Box authorize errors
		//	---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		//	invalid_request			The request is missing a required parameter, includes an invalid parameter value, includes a parameter more than once, or is otherwise malformed.
		//	unsupported_response_type	The authorization server does not support obtaining an authorization code using this method.
		//							Check the value of the code param in your request.
		//	access_denied				The resource owner or authorization server denied the request.
		//	server_error				The device the user is trying to log in from is not authorized to access the user’s account.
		//	temporarily_unavailable		Your device is being rate limited, you need to either decrease your rate of authorization requests, or wait a bit.
		
		
		$code = $this->input->get('code');
		$state = $this->input->get('state');
		$error = $this->input->get('error');
		$error_description = $this->input->get('error_description');
		
		$account_id = $this->auth_lib->GetAccountId();
		
		$referrer = $this->agent->referrer();
		
		// Box
		// ==================
		if( preg_match('/app.box.com/', $referrer) != FALSE )
		{
			if( $code != FALSE )
			{
				$return = $this->Data_storage_model->BoxGetAndUpdateAccountAuthTokens($account_id, $code);
				$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->BoxGetAndUpdateAccountAuthTokens() \$return: \n" . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				
				$error = ( $error == TRUE ) ? TRUE : FALSE;
				$return_message = ($error == FALSE ) ? "Data storage authorized and granted successfully!" : "There was an error while getting the data storage tokens.";
				
			}
			else
			{
				$error = TRUE;
				$return_message = "There was an error when authorizing your data storage account with Filemation.<br/><br/>" . $error_description;
			}
		}
		// Dropbox
		// ===================
		else if( preg_match('/dropbox.com/', $referrer) != FALSE )
		{
			if( $code != FALSE )
			{
				$return = $this->Data_storage_model->DropboxGetAndUpdateAccountAuthTokens($account_id, $code);
				$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->DropboxGetAndUpdateAccountAuthTokens() \$return: \n" . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				
				$error = ( $error == TRUE ) ? TRUE : FALSE;
				$return_message = ($error == FALSE ) ? "Data storage authorized and granted successfully!" : "There was an error while getting the data storage tokens.";
			}
			else
			{
				$error = TRUE;
				$return_message = "There was an error when authorizing your data storage account with Filemation.<br/><br/>" . $error_description;
			}
		}
		// Google Drive
		// ====================
		else if( preg_match('/google.com/', $referrer) != FALSE )
		{
			
		}
		// Microsoft One Drive
		// ====================
		else if( preg_match('/live.com/', $referrer) != FALSE )
		{
			
		}
		else if( preg_match('/filemation.com/', $referrer) != FALSE )
		{
			redirect(base_url());
		}
		else
		{
			// no domain recognized there, and this is a real error. what to do?
			$error = TRUE;
			$return_message = "We do not recognize the domain referred to filemation. <br/><br/><span style='font-size: 12px !important;'>Referrer: $referrer</span>";
		}
		
		
		$view_data = array();
		$view_data['error'] = $error;
		$view_data['return_message'] = $return_message;
		
		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('ds/data_storage_auth_result', $view_data);
		$this->load->view('footer');
		
	}
	
	public function DataStorageHooks()
	{
		
	}
	
}