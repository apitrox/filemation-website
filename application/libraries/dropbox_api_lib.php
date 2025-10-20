<?php 
/*
 * Filemation
 * 
 * dropbox core api php class
 * 
 * this class uses oAuth 2.0 to authenticate the filemation accounts with their dropbox account.
 * 
 * == oauth 2.0 ==
 * /authorize
 * /token
 * /token_from_oauth1
 *
 * == Access tokens ==
 * /disable_access_token
 *
 * == Dropbox accounts ==
 * /account/info
 *
 * == Files and metadata ==
 * /files (GET)
 * /files_put
 * /metadata
 * /delta
 * /longpoll_delta
 * /revisions
 * /restore
 * /search
 * /shares
 * /media
 * /copy_ref
 * /thumbnails
 * /previews
 * /chunked_upload
 * /commit_chunked_upload
 * /shared_folders
 *
 *  == File operations ==
 * /fileops/copy
 * /fileops/create_folder
 * /fileops/delete
 * /fileops/move
 */

class Dropbox_api_lib {
	
	public $ci;
	public $client_id; // the dropbox app key
	public $client_secret; // the dropbox app secret
	public $redirect_uri; // the redirect url that is redirected back to filemation when a end user authorizes a dropbox account
	public $access_token; // the access token used to make each api call. dropbox does not have a refresh token instead, there is only one access token generated indefinitely.
	
	public $api_url = "https://api.dropbox.com/1"; // the dropbox api url
	public $api_authorize_url = "https://www.dropbox.com/1"; // the authorize api url
	public $api_content_url = "https://api-content.dropbox.com/1"; // the content api url
	
	
	public function __construct($config)
	{		
		$client_id = ( isset($config['Client_Id']) ) ? $config['Client_Id'] : '';
		$client_secret = ( isset($config['Client_Secret']) ) ? $config['Client_Secret'] : '';
		$redirect_uri = ( isset($config['Redirect_Uri']) ) ? $config['Redirect_Uri'] : '';
		
		$access_token = ( isset($config['Access_Token']) ) ? $config['Access_Token'] : '';
		
		$this->client_id = $client_id;
		$this->client_secret = $client_secret;
		$this->redirect_uri = $redirect_uri;
		$this->access_token = $access_token;
		
		$this->ci =& get_instance(); 
	}
	
	//  This method will download the file content
	public function DownloadFile($path_and_filename, $path_to_save)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = TRUE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 0 ;
		$error = ( func_num_args() < $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($path_and_filename) );   $err_msg = "\$path_and_filename is empty, null, or invalid. \n\$path_and_filename: $path_and_filename \n\func_get_args(): " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($path_to_save) );   $err_msg = "\$path_to_save is empty, null, or invalid. \n\$path_to_save: $path_to_save \n\func_get_args(): " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( file_exists($path_to_save) == FALSE );   $err_msg = "\$path_to_save does not exist on the local server. \n\$path_to_save: $path_to_save \n\func_get_args(): " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		// set the parameters used for the api call
		$params = array();
		$params['access_token'] = $this->access_token;
		
		$param_str = http_build_query($params); // build the query string for the GET call
		
		$url = $this->api_content_url . "/files/auto/$path_and_filename?$param_str";
		
		// make api call
		$result = $this->Download($url, $params);
		$data_error = ( !is_null(json_decode($result['Data'])) ) ? json_decode($result['Data']) : '';
		$error = ( $messages0 );   $err_msg = "The dropbox $url call. \n\$params: " . print_r($params, TRUE) . " \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( isset($data_error->error) );   $err_msg = "Downloading the file content failed. \n\$path_and_filename: $path_and_filename \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($result['Data']) );   $err_msg = "Downloading the dropbox file failed. \$result[Data] is not set, empty, or invalid.";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				
		$file_data = $result['Data']; // set the file contents as data
		
		// the api call is successfull lets format our filename )to save the file to
		$file_info = pathinfo(basename($path_and_filename));
		$error = ( !isset($file_info['extension']) || empty($file_info['extension']) );   $err_msg = "The file extension is not set, empty, or invalid. \$file_info[extension] is not set, empty, or invalid. \n\$file_info: " . print_r($file_info, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$file_extension = $file_info['extension']; // set the file extension string to be used in the new filename.
		
		$new_filename = random_string('unique') . '.' . $file_extension; // set the new filename to a random 'unique' string so it does not conflict with any other file being saved to the local disk at the same moment.
		$path_and_filename = $path_to_save . DIRECTORY_SEPARATOR . $new_filename; // set the full save path, and new filename.
		
		$save_result = file_put_contents($path_and_filename, $file_data);
		$error = ( $save_result == FALSE );   $err_msg = "Saving the file to the local server disk failed. \$save_result returned false. \n\$new_filename: $new_filename";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( file_exists($path_and_filename) == FALSE );   $err_msg = "Saving the file to the local server disk failed. \$save_result returned false. \n\$path_and_filename: $path_and_filename \n\$new_filename: $new_filename";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		$results_array['Result'] = TRUE;
		$results_array['Path_Filename'] = $path_and_filename;
		$results_array['Filename'] = $new_filename;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}
	
	
	//  This method will generate the dropbox authorize url we use to redirect the end user to dropbox to authorize their dropbox account for filemation use.
	//  @Return:	result array
	public function GetAuthUrl()
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 0 ;
		$error = ( func_num_args() < $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		$params = array();
		$params['client_id'] = $this->client_id;
		$params['response_type'] = "code";
		$params['redirect_uri'] = $this->redirect_uri;
		$params['force_reapprove'] = "true";
		$params['state'] = md5(uniqid(rand(), true));
		
		$param_str = http_build_query($params);
		
		$url = $this->api_authorize_url . '/oauth2/authorize?' . $param_str;
		
		$results_array['Result'] = TRUE;
		$results_array['Auth_Url'] = $url;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}
	
	
	//  This method will get the required tokens from dropbox using the 'code' value received from the authorization process request.
	//  @Param 1:	required, the authorization code value. The code value is returned from the authorization process. 
	//  @Return:	result array
	public function GetTokens($code)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = TRUE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 0 ;
		$error = ( func_num_args() < $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		$params = array();
		$params['client_id'] = $this->client_id;
		$params['client_secret'] = $this->client_secret;
		$params['redirect_uri'] = $this->redirect_uri;
		$params['code'] = $code;
		$params['grant_type'] = "authorization_code";
		
		$url = $this->api_url . '/oauth2/token';
		
		$result = json_decode($this->Post($url, $params));
		$error = ( $messages0 );   $err_msg = "The dropbox /oauth2/token/ call. \n\$params: " . print_r($params, TRUE) . " \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( isset($result->error) );   $err_msg = "Getting the dropbox tokens failed. \n\$code = $code \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		//  ** why does the above condition not work?
		
		$access_token = ( isset($result->access_token) ) ? $result->access_token : NULL;
		$token_type = ( isset($result->token_type) ) ? $result->token_type : NULL;
		$uid = ( isset($result->uid) ) ? $result->uid : NULL;
		$error = ( empty($access_token) );   $err_msg = "The dropbox access token is invalid. \$access_token is empty or null. \n\$access_token: $access_token \n\$code = $code \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		$results_array['Result'] = TRUE;
		$results_array['Access_Token'] = $access_token;
		$results_array['Access_Token_Type'] = $token_type;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}
	
	//  This method will get all files in a given dropbox folder. To get files in the root directory use "/" for the [folder_path] parameter value.
	//  @Param 1:	required, the folder path we want to get all folders in
	//  @Return:	result array
	public function GetFilesInFolder($folder_path)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 1 ;
		$error = ( func_num_args() < $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($folder_path) );   $err_msg = "The folder path is empty or invalid. \n\$folder_path: $folder_path";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		// set the parameters used to make the metadata call
		$params = array();
		$params['access_token'] = $this->access_token;
		$params['list'] = "true";
		
		$param_str = http_build_query($params); // built the parameters query string for the GET call
		
		$url = $this->api_url . "/metadata/auto/$folder_path?" . $param_str;
		
		$result = json_decode($this->Get($url, $params));
		$error = ( isset($result->error) );   $err_msg = "Getting contents or metadata for a given dropbox folder has failed. \n\$folder_path: $folder_path \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !isset($result->contents) );   $err_msg = "The contents object that lists our folders does not exist. \n\$folder_path: $folder_path \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$data = array();
		$contents_obj = $result->contents; // set the contents object or the folders listing object
		foreach($contents_obj as $item)
		{
			// only set directories/folders
			if( isset($item->is_dir) && ( $item->is_dir == 0 || empty($item->is_dir) ) )
			{
				unset($rev);
				unset($thumb_exists);
				unset($path);
				unset($name);
				unset($is_dir);
				unset($client_mtime);
				unset($icon);
				unset($bytes);
				unset($modified);
				unset($size);
				unset($root);
				unset($mime_type);
				unset($revision);

				$rev = ( isset($item->rev) ) ? $item->rev : '';
				$thumb_exists = ( isset($item->thumb_exists) ) ? $item->thumb_exists : '';
				$path = ( isset($item->path) ) ? $item->path : '';
				$name = ( !empty($path) ) ? basename($path) : '';
				$is_dir = ( isset($item->is_dir) ) ? $item->is_dir : '';
				$client_mtime = ( isset($item->client_mtime) ) ? $item->client_mtime : '';
				$icon = ( isset($item->icon) ) ? $item->icon : '';
				$bytes = ( isset($item->bytes) ) ? $item->bytes : '';
				$modified = ( isset($item->modified) ) ? $item->modified : '';
				$size = ( isset($item->size) ) ? $item->size : '';
				$root = ( isset($item->root) ) ? $item->root : '';
				$mime_type = ( isset($item->mime_type) ) ? $item->mime_type : '';
				$revision = ( isset($item->revision) ) ? $item->revision : '';

				$entry = array();
				$entry['Rev'] = $rev;
				$entry['Thumb_Exists'] = $thumb_exists;
				$entry['Path'] = $path;
				$entry['Name'] = $name;
				$entry['Is_Dir'] = $is_dir;
				$entry['Client_Mtime'] = $client_mtime;
				$entry['Icon'] = $icon;
				$entry['Bytes'] = $bytes;
				$entry['Modified'] = $modified;
				$entry['Size'] = $size;
				$entry['Root'] = $root;
				$entry['Mime_Type'] = $mime_type;
				$entry['Revision'] = $revision;

				$data[] = $entry;
			}
		}
		
		$results_array['Result'] = TRUE;
		$results_array['Data'] = $data;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}
	
	
	//  This method will get all folders or directories in a given folder or directory. To get directories/folders in the root directory use "/" for the [folder_path] parameter value.
	//  @Param 1:	required, the folder path we want to get all folders in
	//  @Return:	result array
	public function GetFoldersInFolder($folder_path)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 1 ;
		$error = ( func_num_args() < $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($folder_path) );   $err_msg = "The folder path is empty or invalid. \n\$folder_path: $folder_path";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		$params = array();
		$params['access_token'] = $this->access_token;
		$params['list'] = "true";
		
		$param_str = http_build_query($params);
		
		$url = $this->api_url . "/metadata/auto/$folder_path?" . $param_str;
		
		$result = json_decode($this->Get($url, $params));
		$error = ( isset($result->error) );   $err_msg = "Getting contents or metadata for a given dropbox folder has failed. \n\$folder_path: $folder_path \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !isset($result->contents) );   $err_msg = "The contents object that lists our folders does not exist. \n\$folder_path: $folder_path \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$data = array();
		$contents_obj = $result->contents; // set the contents object or the folders listing object
		foreach($contents_obj as $item)
		{
			// only set directories/folders
			if( isset($item->is_dir) && $item->is_dir == 1 )
			{
				unset($rev);
				unset($thumb_exists);
				unset($path);
				unset($name);
				unset($is_dir);
				unset($client_mtime);
				unset($icon);
				unset($bytes);
				unset($modified);
				unset($size);
				unset($root);
				unset($mime_type);
				unset($revision);

				$rev = ( isset($item->rev) ) ? $item->rev : '';
				$thumb_exists = ( isset($item->thumb_exists) ) ? $item->thumb_exists : '';
				$path = ( isset($item->path) ) ? $item->path : '';
				$name = ( !empty($path) ) ? basename($path) : '';
				$is_dir = ( isset($item->is_dir) ) ? $item->is_dir : '';
				$client_mtime = ( isset($item->client_mtime) ) ? $item->client_mtime : '';
				$icon = ( isset($item->icon) ) ? $item->icon : '';
				$bytes = ( isset($item->bytes) ) ? $item->bytes : '';
				$modified = ( isset($item->modified) ) ? $item->modified : '';
				$size = ( isset($item->size) ) ? $item->size : '';
				$root = ( isset($item->root) ) ? $item->root : '';
				$mime_type = ( isset($item->mime_type) ) ? $item->mime_type : '';
				$revision = ( isset($item->revision) ) ? $item->revision : '';

				$entry = array();
				$entry['Rev'] = $rev;
				$entry['Thumb_Exists'] = $thumb_exists;
				$entry['Path'] = $path;
				$entry['Name'] = $name;
				$entry['Is_Dir'] = $is_dir;
				$entry['Client_Mtime'] = $client_mtime;
				$entry['Icon'] = $icon;
				$entry['Bytes'] = $bytes;
				$entry['Modified'] = $modified;
				$entry['Size'] = $size;
				$entry['Root'] = $root;
				$entry['Mime_Type'] = $mime_type;
				$entry['Revision'] = $revision;

				$data[] = $entry;
			}
		}
		
		$results_array['Result'] = TRUE;
		$results_array['Data'] = $data;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}
	
	
	//  This method will get a preview link for a dropbox file.
	//  This method only converts these fiels types: .doc, .docx, .docm, .ppt, .pps, .ppsx, .ppsm, .pptx, .pptm, .xls, .xlsx, .xlsm, .rtf, .pdf
	//  @Param 1:	required, path and filename of the file we want to get a dropbox preview for.
	//  @Return:	result array
	public function GetFilePreview($path_and_filename)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 1 ;
		$error = ( func_num_args() < $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($path_and_filename) );   $err_msg = "The folder path is empty or invalid. \n\$path_and_filename: $path_and_filename";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		$params = array();
		$params['access_token'] = $this->access_token;
		
		$param_str = http_build_query($params);
		
		$url = $this->api_content_url . "/previews/auto/$path_and_filename?" . $param_str;
		
		//$result = json_decode($this->Get($url, $params));
		$result = $this->Download($url, $params);
		$error = ( isset($result->error) );   $err_msg = "Getting the preview for the file failed. \n\$path_and_filename: $path_and_filename \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !isset($result['Data']) );   $err_msg = "The contents object that lists our folders does not exist. \n\$path_and_filename: $path_and_filename \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		$data = $result['Data'];
		$headers = $result['Headers'];
	
		
		$results_array['Result'] = TRUE;
		$results_array['Data'] = $data;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}
	
	//  This method will attempt to move a file to a new folder location in a dropbox account.
	//  @Param 1:	required, dropbox path and filename of the file we want to move to the new location.
	//  @Param 2:	required, the dropbox path and filename we want to move the file to.
	//  @Return:	result array
	public function MoveFile($path_and_filename, $path_and_filename_to_move)
	{
		// Dropbox Core Api
		// URL STRUCTURE: https://api.dropbox.com/1/fileops/move
		// METHOD: POST
		// PARAMETERS: 
		// [root]		-	required | The root relative to which from_path and to_path are specified. Valid values are auto (recommended), sandbox, and dropbox.
		// [from_path] -	required | Specifies the file or folder to be moved from relative to root.
		// [to_path]	-	required | Specifies the destination path, including the new name for the file or folder, relative to root.
		// [locale]	-	optional | The metadata returned will have its size field translated based on the given locale.
		
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 2 ;
		$error = ( func_num_args() < $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($path_and_filename) );   $err_msg = "The folder path and filename we want to move is empty or invalid. \n\$path_and_filename: $path_and_filename";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($path_and_filename_to_move) );   $err_msg = "The folder path we are moving to is empty or invalid. \$path_and_filename_to_move is empty or invalid. \n\$path_and_filename_to_move: $path_and_filename_to_move";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$params = array();
		$params['access_token'] = $this->access_token;
		$params['root'] = "dropbox";
		$params['from_path'] = $path_and_filename;
		$params['to_path'] = $path_and_filename_to_move;
		
		$param_str = http_build_query($params);
		
		$url = $this->api_content_url . "/fileops/move/$path_and_filename?" . $param_str;
		
		//$result = json_decode($this->Get($url, $params));
		$result = json_decode($this->Post($url, $params));
		$error = ( isset($result->error) );   $err_msg = "Moving the dropbox file failed. \n\$path_and_filename: $path_and_filename \n\$path_and_filename_to_move: $path_and_filename_to_move \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		echo "<pre>"; print_r($result); echo "</pre>";
		
		$results_array['Result'] = TRUE;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}
	
	
	// =============================
	// Private
	// ==============================
	
	private function Get($url, $params, $header = false)
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
		
		// Check for errors and display the error message
		//$errno = curl_errno($ch);
		//$error_message = curl_strerror($errno);
		//echo "cURL error ({$errno}):\n {$error_message}";
		
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