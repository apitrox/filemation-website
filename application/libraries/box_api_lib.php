<?php 

/*
 * Filemation
 * 
 * Box API v2
 * 
 * Resources
 * --------------------------------
 * /folders
 * /folders/{id}/items
 * /folders/{id}/collaborations
 * /files
 * /files/{id}/content
 * /files/{id}/versions
 * /shared_items
 * /comments
 * /collaborations
 * /search
 * /events
 * /users
 * /tokens
 */

class Box_api_lib {

	public $client_id 		= '';
	public $client_secret 	= '';
	public $api_key		= '';
	public $view_api_key	= '';
	public $redirect_uri	= '';
	public $access_token	= '';
	public $refresh_token	= '';
	public $authorize_url 	= 'https://www.box.com/api/oauth2/authorize';
	public $token_url	 	= 'https://www.box.com/api/oauth2/token';
	public $api_url 		= 'https://api.box.com/2.0';
	public $upload_url 		= 'https://upload.box.com/api/2.0';
	public $view_url		= 'https://view-api.box.com';
	private $ci;
	
	public function __construct($config)
	{
		$this->ci =& get_instance();
		
		//	the config array expects at least 3 parameters with a max of 6 parameters
		//	config[Client_Id]		= the box api client id used to atuhorize the account, get new tokens, and destroy tokens
		//   config[Client_Secret]	= the box api client secret used to authorize the account, get new tokens, and destroy tokens
		//	config[Redirect_Uri]	= the secure url to redirect to when authorizing an account. the url will gather the data returned from box to get the new tokens
		//	config[Access_Token]	= the box api access token used to make the box api calls
		//   config[Refresh_Token]	= the box api refresh token used to get a new access token
		
		$client_id = ( isset($config['Client_Id']) ) ? $config['Client_Id'] : '';
		$client_secret = ( isset($config['Client_Secret']) ) ? $config['Client_Secret'] : '';
		$api_key = ( isset($config['API_Key']) ) ? $config['API_Key'] : '';
		$view_api_key = ( isset($config['View_API_Key']) ) ? $config['View_API_Key'] : '';
		$redirect_uri = ( isset($config['Redirect_Uri']) ) ? $config['Redirect_Uri'] : '';
		
		$access_token = ( isset($config['Access_Token']) ) ? $config['Access_Token'] : '';
		$refresh_token = ( isset($config['Refresh_Token']) ) ? $config['Refresh_Token'] : '';
		
		
		$this->client_id = $client_id;
		$this->client_secret = $client_secret;
		$this->api_key = $api_key;
		$this->view_api_key = $view_api_key;
		$this->redirect_uri = $redirect_uri;
		$this->access_token = $access_token;
		$this->refresh_token = $refresh_token;
	}
	
	
	//  This method constructs the url to get the box auth code and security state
	//  @Param 1:	required, the url to redirect the url back to the filemation after authorizing
	//  @Return:	result array
	public function GetAuthUrl()
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 0 ;
		$error = ( func_num_args() < $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$url = $this->authorize_url . '?' . http_build_query(array('response_type' => 'code', 'client_id' => $this->client_id, 'redirect_uri' => $this->redirect_uri));
		
		$results_array['Result'] = TRUE;
		$results_array['Auth_Url'] = $url;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}

	//  This method will try to get a new box access token, and box refresh token from the authorization code provided during granting filemation access to an user's box account
	//  @Param 1:	required, the box authorization code returned from the box user granting permissions process
	//  @Return:	result array
	public function GetTokens($code)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 1 ;
		$error = ( func_num_args() < $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		$url = $this->token_url;

		$params = array(
					'grant_type' => 'authorization_code',
					'code' => $code, 
					'client_id' => $this->client_id, 
					'client_secret' => $this->client_secret
				);
		
		$result = json_decode($this->post($url, $params), true);
		$error = ( isset($result['error']) );   $err_msg = "Getting the box api access tokens failed. \n\$code = $code \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$access_token = $result['access_token'];
		$expires_in = $result['expires_in'];
		$refresh_token = $result['refresh_token'];
		$token_type = $result['token_type'];
		
		$this->SetTokens($access_token, $refresh_token);
		
		$results_array['Result'] = TRUE;
		$results_array['Access_Token'] = $access_token;
		$results_array['Access_Token_Life'] = $expires_in;
		$results_array['Refresh_Token'] = $refresh_token;
		$results_array['Access_Token_Type'] = $token_type;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}
	
	//  This method will try to get a new access token from box using a valid refresh token.
	//  @Return:	result array
	public function GetNewAccessToken()
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 0 ;
		$error = ( func_num_args() < $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		$url = $this->token_url;
		
		// we have already provided the refresh_token value in the __construct $config when we loaded the library
		
		$params = array(
					'grant_type' => 'refresh_token', 
					'refresh_token' => $this->refresh_token, 
					'client_id' => $this->client_id, 
					'client_secret' => $this->client_secret
			   );
		
		$result = json_decode($this->Post($url, $params), true);
		$error = ( isset($result['error']) && isset($result['error_description']) );   $err_msg = "Getting the box api access tokens failed. \n\$this->refresh_token = " . $this->refresh_token . " \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		$access_token = $result['access_token'];
		$expires_in = $result['expires_in'];
		$refresh_token = $result['refresh_token'];
		$token_type = $result['token_type'];
		
		// update our access token, and refresh token class variables with our new access and refresh tokens
		$this->SetTokens($access_token, $refresh_token);
		
		$results_array['Result'] = TRUE;
		$results_array['Access_Token'] = $access_token;
		$results_array['Access_Token_Life'] = $expires_in;
		$results_array['Refresh_Token'] = $refresh_token;
		$results_array['Access_Token_Type'] = $token_type;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}
	
	//  This method gets the details about a given box folder and returns it.
	//  @Param 1:	required, the box folder id
	//  @Return:	result array
	public function GetFolderDetails($folder_id)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 1 ;
		$error = ( func_num_args() < $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		// the folder ID can equal 0. empty() will evaluate 0 as false.
		$error = ( $folder_id == "" && (int)$folder_id != 0 );   $err_msg = "\$folder_id is empty or invalid. \n\$folder_id: $folder_id \nfunc_get_args(): " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		$url = $this->BuildUrl("/folders/$folder_id");
		$error = ( empty($url) );   $err_msg = "The url needed to make the api call is empty. \$url is empty. \n\$folder_id: $folder_id \nfunc_get_args(): " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$result =  json_decode($this->Get($url),true);
		$error = ( isset($result['type']) && $result['type'] == 'error' );   $err_msg = "The call to get the folder details returned an error. \n\$result: " . print_r($result, TRUE);   $err_type = ( isset($result['type']) ) ? $result['type'] : 'none';  $err_status = ( isset($result['status']) ) ? $result['status'] : 'none';  $err_code = ( isset($result['code']) ) ? $result['code'] : '';  $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ return array('Result' => FALSE, 'Error_Type' => $err_type, 'Error_Status' => $err_status, 'Error_Code' => $err_code, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		// preset and clean data before we return it
		$type = ( isset($result['type']) ) ? $result['type'] : '';
		$id = ( isset($result['id']) ) ? $result['id'] : '';
		$sequence_id = ( isset($result['sequence_id']) ) ? $result['sequence_id'] : '';
		$etag = ( isset($result['etag']) ) ? $result['etag'] : '';
		$name = ( isset($result['name']) ) ? $result['name'] : '';
		$created_at = ( isset($result['created_at']) ) ? $result['created_at'] : '';
		$modified_at = ( isset($result['modified_at']) ) ? $result['modified_at'] : '';
		$description = ( isset($result['description']) ) ? $result['description'] : '';
		$size = ( isset($result['size']) ) ? $result['size'] : '';
		$path_collection_array = ( isset($result['path_collection']) ) ? $result['path_collection']['entries'] : '';
		$path_collection = array();
		if( is_array($path_collection_array) && ( count($path_collection_array) > 0 ) )
		{
			foreach($path_collection_array as $entry)
			{
				$path_collection[] = array('Type' => $entry['type'], 'Id' => $entry['id'], 'Sequence_Id' => $entry['sequence_id'], 'Etag' => $entry['etag'], 'Name' => $entry['name']);
			}
		}
		
		$created_by = ( isset($result['created_by']) ) ? $result['created_by'] : '';
		$created_by = ( isset($created_by['type']) && isset($created_by['id']) && isset($created_by['name']) && isset($created_by['login']) ) ? array('Type' => $created_by['type'], 'Id' => $created_by['id'], 'Name' => $created_by['name'], 'Login' => $created_by['login']) : array();
		$modified_by = ( isset($result['modified_by']) ) ? $result['modified_by'] : '';
		$modified_by = ( isset($modified_by['type']) && isset($modified_by['id']) && isset($modified_by['name']) && isset($modified_by['login']) ) ? array('Type' => $modified_by['type'], 'Id' => $modified_by['id'], 'Name' => $modified_by['name'], 'Login' => $modified_by['login']) : array();
		$trashed_at = ( isset($result['trashed_at']) ) ? $result['trashed_at'] : '';
		$purged_at = ( isset($result['purged_at']) ) ? $result['purged_at'] : '';
		$content_created_at = ( isset($result['content_created_at']) ) ? $result['content_created_at'] : '';
		$content_modified_at = ( isset($result['content_modified_at']) ) ? $result['content_modified_at'] : '';
		$owned_by = ( isset($result['owned_by']) ) ? $result['owned_by'] : '';
		$owned_by = ( isset($owned_by['type']) && isset($owned_by['id']) && isset($owned_by['name']) && isset($owned_by['login']) ) ? array('Type' => $owned_by['type'], 'Id' => $owned_by['id'], 'Name' => $owned_by['name'], 'Login' => $owned_by['login']) : array();
		$shared_link = ( isset($result['shared_link']) ) ? $result['shared_link'] : '';
		$folder_upload_email = ( isset($result['folder_upload_email']) ) ? $result['folder_upload_email'] : '';
		$parent_array = ( isset($result['parent']) ) ? $result['parent'] : '';
		$parent = ( is_array($parent_array) ) ? array('Type' => $parent_array['type'], 'Id' => $parent_array['id'], 'Sequence_Id' => $parent_array['sequence_id'], 'Etag' => $parent_array['etag'], 'Name' => $parent_array['name']) : array();
		$item_status = ( isset($result['item_status']) ) ? $result['item_status'] : '';
		$item_collection_array = ( isset($result['item_collection']) ) ? $result['item_collection']['entries'] : '';
		$item_collection = array();
		if( is_array($item_collection_array) && (count($item_collection_array) > 0) )
		{
			foreach($item_collection_array as $row)
			{
				unset($row_type);
				unset($row_id);
				unset($row_sequence_id);
				unset($row_etag);
				unset($row_sha1);
				unset($row_name);
				$row_type = ( isset($row['type']) ) ? $row['type'] : '';
				$row_id = ( isset($row['id']) ) ? $row['id'] : '';
				$row_sequence_id = ( isset($row['sequence_id']) ) ? $row['sequence_id'] : '';
				$row_etag = ( isset($row['etag']) ) ? $row['etag'] : '';
				$row_sha1 = ( isset($row['sha1']) ) ? $row['sha1'] : '';
				$row_name = ( isset($row['name']) ) ? $row['name'] : '';

				$item_collection[] = array('Type' => $row_type, 'Id' => $row_id, 'Sequence_Id' => $row_sequence_id, 'Etag' => $row_etag, 'Sha1' => $row_sha1, 'Name' => $row_name);
			}
		}
		
		// now lets get the path collections set it in a readable full path 'pwd' string
		$full_folder_path = "/";
		if( count($path_collection) > 0 )
		{
			foreach($path_collection as $path)
			{
				unset($folder_name);
				$folder_name = $path['Name'];
				$full_folder_path .= "$folder_name/";
			}
		}
		$full_folder_path .= $name;
		
		// set the array
		$data = array();
		$data['Type'] = $type;
		$data['Id'] = $id;
		$data['Sequence_Id'] = $sequence_id;
		$data['Etag'] = $etag;
		$data['Name'] = $name;
		$data['Created_At'] = $created_at;
		$data['Modified_At'] = $modified_at;
		$data['Descriptoin'] = $description;
		$data['Size'] = $size;
		$data['Path_Collection'] = $path_collection;
		$data['Full_Folder_Path'] = $full_folder_path;
		$data['Created_By'] = $created_by;
		$data['Modified_By'] = $modified_by;
		$data['Trashed_At'] = $trashed_at;
		$data['Purged_At'] = $purged_at;
		$data['Content_Created_At'] = $content_created_at;
		$data['Content_Modified_At'] = $content_modified_at;
		$data['Owned_By'] = $owned_by;
		$data['Shared_Link'] = $shared_link;
		$data['Folder_Upload_Email'] = $folder_upload_email;
		$data['Parent'] = $parent;
		$data['Item_Status'] = $item_status;
		$data['Item_Collection'] = $item_collection;
		
		
		$results_array['Result'] = TRUE;
		$results_array['Data'] = $data;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");
		
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array, FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
		
	}
	
	//  This method will get information about the given file. 
	//  @Param 1:	required, the file id to identify which file to information about
	//  @Return:	result array
	public function GetFileDetails($file_id)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 1 ;
		$error = ( func_num_args() < $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		// the folder ID can equal 0. empty() will evaluate 0 as false.
		$error = ( $file_id == '' );   $err_msg = "\$file_id is empty or invalid. \n\$file_id: $file_id \nfunc_get_args(): " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$params = array();
		
		$url = $this->BuildUrl("/files/$file_id", $params);
		
		$result = json_decode($this->Get($url), true);
		$error = ( isset($result['type']) && $result['type'] == 'error' );   $err_msg = "Getting the file detail information failed. \n\$file_id: $file_id \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( isset($result['type']) && $result['type'] != 'file' );   $err_msg = "The type of box object returned is not a 'file'. \n\$file_id: $file_id \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		
		$return_data = array();
		$return_data['Type'] = ( isset($result['type']) ) ? $result['type'] : '';
		$return_data['Id'] = ( isset($result['id']) ) ? $result['id'] : '';
		$return_data['Sequence_Id'] = ( isset($result['sequence_id']) ) ? $result['sequence_id'] : '';
		$return_data['Etag'] = ( isset($result['etag']) ) ? $result['etag'] : '';
		$return_data['Sha1'] = ( isset($result['sha1']) ) ? $result['sha1'] : '';
		$return_data['Name'] = ( isset($result['name']) ) ? $result['name'] : '';
		$return_data['Description'] = ( isset($result['description']) ) ? $result['description'] : '';
		$return_data['Size'] = ( isset($result['size']) ) ? $result['size'] : '';
		$path_collection_array = ( isset($result['path_collection']) ) ? $result['path_collection']['entries'] : '';
		$path_collection = array();
		if( is_array($path_collection_array) && ( count($path_collection_array) > 0 ) )
		{
			foreach($path_collection_array as $entry)
			{
				$path_collection[] = array('Type' => $entry['type'], 'Id' => $entry['id'], 'Sequence_Id' => $entry['sequence_id'], 'Etag' => $entry['etag'], 'Name' => $entry['name']);
			}
		}
		$return_data['Path_Collection'] = $path_collection;		
		$return_data['Created_At'] = ( isset($result['created_at']) ) ? $result['created_at'] : '';
		$return_data['Modified_At'] = ( isset($result['modified_at']) ) ? $result['modified_at'] : '';
		$return_data['Trashed_At'] = ( isset($result['trashed_at']) ) ? $result['trashed_at'] : '';
		$return_data['Purged_At'] = ( isset($result['purged_at']) ) ? $result['purged_at'] : '';
		$return_data['Content_Created_At'] = ( isset($result['content_created_at']) ) ? $result['content_created_at'] : '';
		$return_data['Content_Modified_At'] = ( isset($result['content_modified_at']) ) ? $result['content_modified_at'] : '';
		$return_data['Created_By'] = ( isset($result['created_by']) && isset($result['created_by']['type']) && isset($result['created_by']['id']) && isset($result['created_by']['name']) && isset($result['created_by']['login']) ) ? array('Type' => $result['created_by']['type'], 'Id' => $result['created_by']['id'], 'Name' => $result['created_by']['name'], 'Login' => $result['created_by']['login']) : array();
		$return_data['Modified_By'] = ( isset($result['modified_by']) && isset($result['modified_by']['type']) && isset($result['modified_by']['id']) && isset($result['modified_by']['name']) && isset($result['modified_by']['login']) ) ? array('Type' => $result['modified_by']['type'], 'Id' => $result['modified_by']['id'], 'Name' => $result['modified_by']['name'], 'Login' => $result['modified_by']['login']) : array();
		$return_data['Owned_By'] = ( isset($result['owned_by']) && isset($result['owned_by']['type']) && isset($result['owned_by']['id']) && isset($result['owned_by']['name']) && isset($result['owned_by']['login']) ) ? array('Type' => $result['owned_by']['type'], 'Id' => $result['owned_by']['id'], 'Name' => $result['owned_by']['name'], 'Login' => $result['owned_by']['login']) : array();
		$return_data['Shared_Link'] = ( isset($result['shared_link']) ) ? $result['shared_link'] : '';
		$return_data['Parent'] = ( isset($result['parent']) && isset($result['parent']['type']) && isset($result['parent']['id']) && isset($result['parent']['sequence_id']) && isset($result['parent']['etag']) && isset($result['parent']['name']) ) ? array('Type' => $result['parent']['type'], 'Id' => $result['parent']['id'], 'Sequence_Id' => $result['parent']['sequence_id'], 'Etag' => $result['parent']['etag'], 'Name' => $result['parent']['name']) : array();
		$return_data['Item_Status'] = ( isset($result['item_status']) ) ? $result['item_status'] : '';

		
		
		
		$results_array['Result'] = TRUE;
		$results_array['Data'] = $return_data;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");
		
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array, FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}
	
	
	//  This method will get the tags assigned to a given file. 
	//  @Param 1:	required, the file id to identify which file to information about
	//  @Return:	result array, if successfull an array in the result array named ['Data'] will return an array of tags (Receipt, Date, etc..)
	public function GetFileTags($file_id)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 1 ;
		$error = ( func_num_args() < $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		// the folder ID can equal 0. empty() will evaluate 0 as false.
		$error = ( $file_id == '' );   $err_msg = "\$file_id is empty or invalid. \n\$file_id: $file_id \nfunc_get_args(): " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$params = array('fields' => 'tags,name');
		
		$url = $this->BuildUrl("/files/$file_id", $params);
		
		$result = json_decode($this->Get($url), true);
		$error = ( isset($result['type']) && $result['type'] == 'error' );   $err_msg = "The file information tags post call failed. \n\$file_id: $file_id \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !isset($result['tags']) );   $err_msg = "The file tags did not return. \n\$file_id: $file_id \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !isset($result['name']) );   $err_msg = "The file name did not return. \n\$file_id: $file_id \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$filename = $result['name'];
		$tags = $result['tags'];		
		
		
		$results_array['Result'] = TRUE;
		$results_array['Filename'] = $filename;
		$results_array['Tags'] = $tags;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");
		
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array, FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}
	

	//  This method will get all box files in a given folder
	//  @Param 1:	required, the folder id to identify the folder
	//  @Return:	result array
	public function GetFilesInFolder($folder_id)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 1 ;
		$error = ( func_num_args() < $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		// the folder ID can equal 0. empty() will evaluate 0 as false.
		$error = ( $folder_id == '' );   $err_msg = "\$folder_id is empty or invalid. \n\$folder_id: $folder_id \nfunc_get_args(): " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		$url = $this->BuildUrl("/folders/$folder_id/items");
		
		$result = json_decode($this->Get($url), true);
		$error = ( isset($result['type']) && $result['type'] == 'error' );   $err_msg = "Getting the files in the folder failed. \n\$folder_id: $folder_id \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		$return_data = array();
		if( isset($result['entries']) && (count($result['entries']) > 0) )
		{
			foreach($result['entries'] as $item)
			{
				$array = '';
				if( strtolower($item['type']) == 'file')
				{
					$array = array();
					$array['Type'] = ( isset($item['type']) ) ? $item['type'] : '';
					$array['Id'] = ( isset($item['id']) ) ? $item['id'] : '';
					$array['Sequence_Id'] = ( isset($item['sequence_id']) ) ? $item['sequence_id'] : '';
					$array['Etag'] = ( isset($item['etag']) ) ? $item['etag'] : '';
					$array['Sha1'] = ( isset($item['sha1']) ) ? $item['sha1'] : '';
					$array['Name'] = ( isset($item['name']) ) ? $item['name'] : '';
					
					$return_data[] = $array;
				}
			}
		}
		
		$results_array['Result'] = TRUE;
		$results_array['Data'] = $return_data;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");
		
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array, FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}
	
	
	//  This method will get all box folders in a given folder
	//  @Param 1:	required, the folder id to identify the folder
	//  @Return:	result array
	public function GetFoldersInFolder($folder_id)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 1 ;
		$error = ( func_num_args() < $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		// the folder ID can equal 0 and empty() evalutes 0 as FALSE
		$error = ( !is_numeric($folder_id) );   $err_msg = "\$folder_id is empty or invalid. \n\$folder_id: $folder_id \nfunc_get_args(): " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		$url = $this->BuildUrl("/folders/$folder_id/items");
		$result = json_decode($this->Get($url), true);
		$error = ( isset($result['type']) && $result['type'] == 'error' );   $err_msg = "Getting the folders in a folder failed. \n\$folder_id: $folder_id \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$return_data = array();
		if( isset($result['entries']) && ( count($result['entries']) > 0) )
		{
			foreach($result['entries'] as $item)
			{
				$array = '';
				if( strtolower($item['type']) == 'folder')
				{
					$array = array();
					$array['Type'] = ( isset($item['type']) ) ? $item['type'] : '';
					$array['Id'] = ( isset($item['id']) ) ? $item['id'] : '';
					$array['Sequence_Id'] = ( isset($item['sequence_id']) ) ? $item['sequence_id'] : '';
					$array['Etag'] = ( isset($item['etag']) ) ? $item['etag'] : '';
					$array['Sha1'] = ( isset($item['sha1']) ) ? $item['sha1'] : '';
					$array['Name'] = ( isset($item['name']) ) ? $item['name'] : '';					
					
					$return_data[] = $array;
				}
			}
		}
		
		$results_array['Result'] = TRUE;
		$results_array['Data'] = $return_data;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array, FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}

	//  This method will get a box file download url and return it.
	//  @Param 1:	requried, the box file id to get download url for
	//  @Return:	result array
	public function GetFileDownloadUrl($file_id)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages0=TRUE for STARTING and ENDING messages only
		$messages1 = FALSE ;  //  set $messages1=TRUE for high level messages that are outside of any loop structure

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 1 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($file_id) );   $err_msg = "The box file id is empty. \n\$file_id: $file_id \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$url = $this->BuildUrl("/files/$file_id/content");
		
		$result = $this->Download($url);
		$result_data = ( isset($result['Data']) && !empty($result['Data']) ) ? json_decode($result['Data']) : "";
		$error = ( isset($result_data->type) && strtolower($result_data->type) == "error" );   $err_msg = "Getting the file download url failed. \n\$file_id: $file_id \n\$result: " . print_r($result_data, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		// The above $result returns a header, but it only returns a json object if there is an error such as the file does not exist. We must figure out how to parse the json object with the headers being returned
		
		// the download url is located in the response header. we need to parse the header returned
		$headers = ( isset($result['Headers']) ) ? $result['Headers'] : array();
		$download_url = ( isset($headers['location']) ) ? $headers['location'] : '';
		
		
		// if we get here the method has completed successfully, wrap up and return results array
		$results_array['Result'] = TRUE;
		$results_array['Download_Url'] = $download_url;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
		
	}
	
	//  This method is used to get a document id for a given file from the box view api. The box view api document id can then be used to generate a viewing session. A viewing session is a url 
	//  that can be used to view a box remove file.
	public function GetDocIdFromViewAPI($file_download_url)
	{
		
		$params = array();
		
		//$url = $this->BuildUrl('/1/documents', array(), $this->view_url);
		
		$url = $this->view_url . '/1/documents';
		
		$params = array('url' => $file_download_url);
		
		$curl_headers = array('Authorization: Token ' . $this->view_api_key);
		
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $curl_headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		$data = curl_exec($ch);
		curl_close($ch);
		
		$return = json_decode($data);
		
		return $return;
	}
	
	//  This method is used to get a document id for a given file from the box view api. The box view api document id can then be used to generate a viewing session. A viewing session is a url 
	//  that can be used to view a box remove file.
	public function GetViewingSessionForDocID($doc_id)
	{
		
		// Only documents with a status of 'done' can have a viewing session created for them
		
		
		$params = array();
		
		$url = $this->view_url . '/1/sessions';
		
		$params = json_encode(array('document_id' => $doc_id));
		
		$curl_headers = array('Authorization: Token ' . $this->view_api_key, 'Content-Type: application/json'); //
		
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $curl_headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		$data = curl_exec($ch);
		curl_close($ch);
		
		
		$return = json_decode($data);
		
		return $return;
	}
	

	//  This method will upload a file to box with the data attributes provided in the api call
	//  @Param 1:	required, the filename and local path of the file we want to upload to box.
	//  @Param 2:	required, the box folder id of the parent folder to upload the file to. This is known as 'parent_id' in the box api.
	//  @Param 3:	required, the file attribute data for the file
	//  @Result:	result array
	public function UploadFile($path_filename, $folder_id, $file_data = array() )
	{
		//	$file_data options
		//	Content_Created_At 	-->  The time this file was created on the user’s machine. See here for more details.  The timestamp time will be reset to 00:00:00 even if it is provided. Type: timestamp
		//						IE: January 1, 2014
		//	Content_Modified_At --> 	The time this file was last modified on the user’s machine. See here for more details. The timestamp time will be reset to 00:00:00 even if it is provided. Type: timestamp
		//						IE: January 2, 2014
		
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages0=TRUE for STARTING and ENDING messages only
		$messages1 = FALSE ;  //  set $messages1=TRUE for high level messages that are outside of any loop structure

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 2 ;
		$error = ( func_num_args() < $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($path_filename) );   $err_msg = "The path and filename to the file is empty. \$path_filename is empty. \n\$path_filename: $path_filename \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( file_exists($path_filename) == FALSE );   $err_msg = "The file provided does not exist. \$path_filename does not exist on the local server. \n\$path_filename: $path_filename \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($folder_id) );   $err_msg = "The folder id is empty. \$folder_id is empty. \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( strlen($folder_id) < 6 );   $err_msg = "The folder id is not a valid length. \$folder_id is an invalid length. \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		// we don't validate the $file_data variable because it is not required. the file can be uploaded with out any type of file data
		
		$content_created_at = ( is_array($file_data) && isset($file_data['Content_Created_At']) ) ? $file_data['Content_Created_At'] : '';
		$content_modified_at = ( is_array($file_data) && isset($file_data['Content_Modified_At']) ) ? $file_data['Content_Modified_At'] : '';
		
		$url = $this->upload_url . '/files/content';
		
		$params = array();
		$params['filename'] = curl_file_create($path_filename);
		$params['parent_id'] = $folder_id;
		$params['access_token'] = $this->access_token;
		if( !empty($content_created_at) )
		{
			$params['content_created_at'] = $content_created_at;
		}
		if( !empty($content_modified_at) )
		{
			$params['content_modified_at'] = $content_modified_at;
		}
		
		$result = json_decode($this->post($url, $params), true);
		$error = ( isset($result['type']) &&  strtolower($result['type']) == 'error' );   $err_msg = "The box call to upload a file to box failed. \n\$path_filename: $path_filename \n\$folder_id: $folder_id \n\$file_data: " . print_r($file_data, TRUE) . " \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		// upload call successfull. get the file id from the response so we can return it.
		$file_id = ( isset($result['entries']) && isset($result['entries'][0]) && isset($result['entries'][0]['id']) ) ? $result['entries'][0]['id'] : '';
		
		
		// if we get here the method has completed successfully, wrap up and return results array
		$results_array['Result'] = TRUE;
		$results_array['New_File_Id'] = $file_id;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}

	//  This method will update information about a given box file.
	//  @Param 1:	required, the box id to the file
	//  @Param 2:	required, an array of information to update about a file. Example of file information to upate is listed below.
	//  @Result:	result array
	public function UpdateFileInformation($file_id, $file_data = array() )
	{
		
		// file data
		// name				The new name fo rthe file. Type: string
		// description			The new description for the file. Type: string
		// parent				The parent folder of this file. Type: object
		// id				The ID of the parent folder. Type: string
		// shared_link			An object representing this item’s shared link and associated permissions. Type: object
		// access				The level of access required for this shared link. Can be open, company, collaborators. Type: string
		// unshared_at			The day that this link should be disabled at. Timestamps are rounded off to the given day. Type: timestamp
		// permissions			The set of permissions that apply to this link. Type: object
		// permissions.download 	Whether this link allows downloads. Type: boolean
		// permissions.preview 	Whether this link allows previews. Type: boolean
		// tags				All tags attached to this file. To add/remove a tag to/from a file, you can first get the file’s current tags 
		//					(be sure to specify ?fields=tags, since the tags field is not returned by default); then modify the list as required; and finally, set the file’s entire list of tags. Type: array of strings
		
		
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages0=TRUE for STARTING and ENDING messages only
		$messages1 = FALSE ;  //  set $messages1=TRUE for high level messages that are outside of any loop structure

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 2 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($file_id) );   $err_msg = "The box file id is empty. \n\$file_id: $file_id \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($file_data) && !isset($file_data['tags']));   $err_msg = "The file data array is empty. \$file_data is empty. \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !is_array($file_data) );   $err_msg = "The file data array is not an array. \$file_data is not an array. \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		
		if( isset($file_data['tags']) )
		{
			$file_data['fields'] = "tags";
		}
		
		$url = $this->BuildUrl("/files/$file_id");
	
		$result = json_decode($this->Put($url, $file_data), true);
		$error = ( isset($result['type']) &&  strtolower($result['type']) == 'error' );   $err_msg = "The box call to update the file information failed. \n\$file_id: $file_id \n\$file_data: " . print_r($file_data, TRUE) . " \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		// if we get here the method has completed successfully, wrap up and return results array
		$results_array['Result'] = TRUE;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}
	
	//  This method copies an existing box file to a different box location in the box account
	//  @Param 1:	required, the box file primary key id
	//  @Param 2:	required, the folder id we want to copy the existing file too. This is the location we are copying the file too.
	//  @Param 3:	required, the copied file filename. either the existing filename or a new filename
	//  @Return:	result array
	public function CopyFile($file_id, $folder_id, $new_filename)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on e, cho for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages0=TRUE for STARTING and ENDING messages only
		$messages1 = FALSE ;  //  set $messages1=TRUE for high level messages that are outside of any loop structure

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 3 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($file_id) );   $err_msg = "The box file id is empty or invalid. \n\$file_id: $file_id \n\$folder_id: $folder_id \n\$new_filename: $new_filename \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($folder_id) && $folder_id != 0 );   $err_msg = "The box folder id is empty or invalid. \n\$file_id: $file_id \n\$folder_id: $folder_id \n\$new_filename: $new_filename \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($new_filename) );   $err_msg = "The new filename is empty or invalid. \n\$file_id: $file_id \n\$folder_id: $folder_id \n\$new_filename: $new_filename  \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		// build the parameters needed to copy a box file to a new destination folder
		$params = array();
		$params['parent'] = array();
		$params['parent']['id'] = $folder_id;
		$params['name'] = $new_filename;
		
		// build the url to make the api curl call
		$url = $this->BuildUrl("/files/$file_id/copy");
		
		// make the api curl call. it is returned in a json object so we need to decode it into an assoc. array
		$result = json_decode($this->Post($url, $params, true), true);
		$error = ( isset($result['type']) &&  strtolower($result['type']) == 'error' );   $err_msg = "The box call to copy the file failed. \n\$file_id: $file_id \n\$folder_id: $folder_id  \n\$new_filename: $new_filename \n\$result: " . print_r($result, TRUE);   $err_type = ( isset($result['type']) ) ? $result['type'] : 'none';   $err_status = ( isset($result['status']) ) ? $result['status'] : '';   $err_code = ( isset($result['code']) ) ? $result['code'] : '';   $conflicting_file_id = ( isset($result['context_info']) && isset($result['context_info']['conflicts']) && isset($result['context_info']['conflicts']['id']) ) ? $result['context_info']['conflicts']['id'] : ''; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Error_Type' => $err_type, 'Error_Status' => $err_status, 'Error_Code' => $err_code, 'Conflicting_File_Id' => $conflicting_file_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !isset($result['id']) );   $err_msg = "The new copied file id does not exist in the call response. \n\$file_id: $file_id \n\$folder_id: $folder_id  \n\$new_filename: $new_filename \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$new_file_id = $result['id'];
		
		// if we get here the method has completed successfully, wrap up and return results array
		$results_array['Result'] = TRUE;
		$results_array['New_File_Id'] = $new_file_id;
		$results_array['Folder_Id'] = $folder_id;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}
	
	
	//  This method delets a given file from the box account
	//  @Param 1:	required, the box file id
	//  @Return:	result array
	public function DeleteFile($file_id)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on e, cho for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages0=TRUE for STARTING and ENDING messages only
		$messages1 = FALSE ;  //  set $messages1=TRUE for high level messages that are outside of any loop structure

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 1 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($file_id) );   $err_msg = "The box file id is empty or invalid. \n\$file_id: $file_id \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$url = $this->BuildUrl("/files/$file_id");
		$result = json_decode($this->delete($url),true);
		$error = ( isset($result['type']) &&  strtolower($result['type']) == 'error' );   $err_msg = "The box call to delete the file failed. \n\$file_id: $file_id \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		// if we get here the method has completed successfully, wrap up and return results array
		$results_array['Result'] = TRUE;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}

	
	private function SetTokens($access_token, $refresh_token)
	{
		if( !empty($access_token ) )
		{
			$this->access_token = $access_token;
		}
		
		if( !empty($refresh_token) )
		{
			$this->refresh_token = $refresh_token;
		}
	}

	/* Builds the URL for the call */
	private function BuildUrl($api_func, array $opts = array(), $base_url= NULL)
	{
		$url = $this->api_url;
		if( !empty($base_url) )
		{
			$url = $base_url;
		}
		
		$opts = $this->SetOpts($opts);
		$base = $url . $api_func . '?';
		$query_string = http_build_query($opts);
		$base = $base . $query_string;
		return $base;
	}

	/* Sets the required before biulding the query */
	private function SetOpts(array $opts)
	{
		if(!array_key_exists('access_token', $opts))
		{
			$opts['access_token'] = $this->access_token;
		}
		return $opts;
	}

	private function ParseResult($res)
	{
		$xml = simplexml_load_string($res);
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);
		return $array;
	}
	
	private function Get($url, $header = false)
	{
		
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);	
		if( $header )
		{
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_VERBOSE, true);
		}
		$data = curl_exec($ch);
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);
		
		return $data;
	}

	private static function Post($url, $params, $json_encode_params = false)
	{
		if( $json_encode_params )
		{
			$params = json_encode($params);
		}
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	private static function Put($url, array $params = array())
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	private static function Delete($url, $params = '')
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	private function Download($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);	
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		$data = curl_exec($ch);
		
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		$header_info = curl_getinfo($ch);
 
		$header_size = $header_info['header_size'];

		$body = trim(mb_substr($data, $header_size));
		$response_header = explode("\n",trim(mb_substr($data, 0, $header_size)));
		unset($response_header[0]);
		
		$headers = array();
		foreach($response_header as $line)
		{
			list($key, $val) = explode(':', $line, 2);
			$headers[strtolower($key)] = trim($val);
		}
		
		curl_close($ch);
		
		$return = array('Data' => $body, 'Headers' => $headers);
		
		return $return;
	}
	
}
