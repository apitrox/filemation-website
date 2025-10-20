<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(ROOTPATH . '/application/third_party/phpass/PasswordHash.php');

define('PHPASS_HASH_STRENGTH', 8);
define('PHPASS_HASH_PORTABLE', FALSE);

define('STATUS_ACTIVATED', '1');
define('STATUS_NOT_ACTIVATED', '0');

class Auth_lib
{
	private $ci;
	
	public function __construct()
	{
		$this->ci =& get_instance();
	}
	
	//  This method will check if the user is logged into filemation. It will secure each page it is called from.
	//  @Return: true if logged in, if not logged in redirect to login page
	public function Secure()
	{
		$logged_in = $this->IsLoggedIn();
		$stay_logged_in = $this->GetStayLoggedIn(); // if this value is 'true' do not log user out, else do log user out.
		
		if( !$logged_in && empty($_SERVER['HTTP_X_REQUESTED_WITH']) && ($stay_logged_in != 1) )
		{
			header('Location: /auth/login');
			exit;
		}
		 elseif(!$logged_in && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && ($stay_logged_in != 1) )
		{             
			// if user is not logged in, and it is an XHRRequest Server call return HTTP 302 error.
			// returning a 302 xhr request will redirect any ajax call to the login screen.
			show_error('XHRRequest denied, user is not logged in', 302);

		}
		 else
		{
			// set user last activity to present time
			$this->ci->session->set_userdata('last_activity', time());
		}
		
		return TRUE;
	}
	
	//  This method will check if a user is logged in to the application for use. It will check to see if it has the required session data set.
	//  @Return: true=user is logged in, false=user is not logged into filemation
	public function IsLoggedIn()
	{
		$session = $this->ci->session->all_userdata();
//		echo "<pre>"; print_r($session); echo "</pre>";
		if( isset($session['status']) && $session['status'] == TRUE )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		
		return FALSE;
	}
	
	//  This method will return the logged in user's user ID
	//  @Return:	the primary user key ID
	public function GetUserId()
	{
		$account_id = $this->ci->session->userdata('user_id');
		return $account_id;
	}
	
	//  This method will return the logged in user's account ID
	//  @Return:	the primary account key ID
	public function GetAccountId()
	{
		$account_id = $this->ci->session->userdata('account_id');
		return $account_id;
	}
	
	//  This method will return the logged in user's account name
	//  @Return:	the primary account name
	public function GetAccountName()
	{
		$account_name = $this->ci->session->userdata('account_name');
		return $account_name;
	}
	
	//  This method will return the logged in user's full name
	//  @Return:	the user's first and last name, full name.
	public function GetUserFullName()
	{
		$user_full_name = $this->ci->session->userdata('full_name');
		return $user_full_name;
	}
	
	//  This method will return the logged in user's email address or login email
	//  @Return:	the user's email address
	public function GetEmail()
	{
		$email = $this->ci->session->userdata('email');
		return $email;
	}
	
	//  This method will return if the current user selected to 'stay logged in' or not.
	//  @Return:	the user's stay logged in value.
	public function GetStayLoggedIn()
	{
		$stay_logged_in = $this->ci->session->userdata('stay_logged_in');
		return $stay_logged_in;
	}
	
	//  This method will encrypt a given value and return it encrypted
	//  @Param 1:	required, the non hashed string to encrypt and check against the hashed value
	//  @Param 2:	required, the hashed value to check the non hashed string against
	//  @Return:	result array
	public function CheckHashValue($non_hashed_value, $hashed_value)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages0=TRUE for STARTING and ENDING messages only
		$messages1 = FALSE ;  //  set $messages1=TRUE for high level messages that are outside of any loop structure

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 2 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($non_hashed_value) );   $err_msg = "The \$non_hashed_value is empty or invalid. \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($hashed_value) );   $err_msg = "The \$hashed_value is empty or invalid. \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
		
		$match = $hasher->CheckPassword($non_hashed_value, $hashed_value);
		
		
		// if we get here the method has completed successfully, wrap up and return results array
		$results_array['Result'] = TRUE;
		$results_array['Match'] = $match;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
		
	}
	
	//  This method will encrypt a given value and retrun it
	public function GetHash($non_hashed_value)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages0=TRUE for STARTING and ENDING messages only
		$messages1 = FALSE ;  //  set $messages1=TRUE for high level messages that are outside of any loop structure

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 1 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($non_hashed_value) );   $err_msg = "The \$non_hashed_value is empty or invalid. \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
		
		$hash = $hasher->HashPassword($non_hashed_value);
		
		
		
		// if we get here the method has completed successfully, wrap up and return results array
		$results_array['Result'] = TRUE;
		$results_array['Hash'] = $hash;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}
	
	//  This method will send a user a confirmation email to confirm the email provided does belong to them and is a real email address.
	//  @Param 1:	required, the first name of the user we are sending a confirmation email too.
	//  @Param 2:	required, the last name of the user we are sending a confirmation email too.
	//  @Param 3:	required, the email address to send the confirmation email too.
	//  @Param 4:
	//  @Return:	result array
	public function SendConfirmationEmail($user_first_name, $user_last_name, $user_email, $confirmation_key)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages0=TRUE for STARTING and ENDING messages only
		$messages1 = FALSE ;  //  set $messages1=TRUE for high level messages that are outside of any loop structure

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 4 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($user_first_name) );   $err_msg = "The \$user_first_name is empty or invalid. \n\$user_first_name: $user_first_name \n\func_get_args(): " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($user_last_name) );   $err_msg = "The \$user_last_name is empty or invalid. \n\$user_last_name: $user_last_name \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($user_email) );   $err_msg = "The \$user_email is empty or invalid. \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( strpos($user_email, '@') == FALSE );   $err_msg = "The user email addres is not a valid email address. \n\$user_email: $user_email. \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$this->ci->load->library('email');
		
		$user_fullname = $user_first_name . ' ' . $user_last_name;
		$subject = "Filemation - email confirmation.";
		$msg = "";
		$msg .= "$user_fullname, congratulations you have successfully registered a Filemation account.\n ";
		$msg .= "The next step is to confirm your email address. Please click on the link below, or paste into a browser, to confirm your email address. \n";
		$msg .= "\n\n";
		$msg .= "https://dev.filemation.com/auth/confirm?=$confirmation_key";
		
		$this->ci->email->initialize(array('mailtype' => 'html'));
		
		$this->ci->email->from('NoReply@filemation.com', $user_fullname);
		$this->ci->email->to($user_email);
		$this->ci->email->bcc('corey@afcamail.com');

		$this->ci->email->subject($subject);
		$this->ci->email->message($msg);

		$this->ci->email->send();
		
		// if we get here the method has completed successfully, wrap up and return results array
		$results_array['Result'] = TRUE;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}

}

/* End of file auth_lib.php */
/* Location: ./application/libraries/auth_lib.php */