<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Filemation
 */


class Account extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->auth_lib->Secure();
	}

	public function index()
	{
		$account_id = $this->auth_lib->GetAccountId(); // set the account id for the current user.
		$user_id = $this->auth_lib->GetUserId(); // set the user id for the current user.
		
		$result = $this->Users_model->GetUser($account_id, $user_id);
		
		$user = $result['Row']; // set the user record row.
		
		$view_data = array();
		$view_data['user'] = $user;
		
		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('account/account', $view_data);
		$this->load->view('footer');
	}
	
	//  This method will change the current user's password.
	//  Request Data: POST[]
	public function ChangeUserPassword()
	{
		//	Request Post Data
		//	Current_Password = the user's current password to confirm it is the user who is changing the user account's password.
		//	New_Password = the new password to set for the user account.
		//	Confirm_Password = the new password typed again to confirm they typed the new password in correctly.
		
		$current_password = $this->input->post('Current_Password');
		$new_password = $this->input->post('New_Password');
		$confirm_new_password = $this->input->post('Confirm_New_Password');
		
		$error = ( empty($current_password) );   $err_msg = "\$current_password is not set, empty, or invalid. \n\$current_password: $current_password \n\$_GET: " . print_r($this->input->get(), TRUE);  $user_err_msg = "The current password is empty or invalid, and it is required."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($new_password) );   $err_msg = "\$new_password is not set, empty, or invalid. \n\$new_password: $new_password \n\$_GET: " . print_r($this->input->get(), TRUE);  $user_err_msg = "The new password is empty or invalid, and it is required."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($confirm_new_password) );   $err_msg = "\$current_password is not set, empty, or invalid. \n\$current_password: $current_password \n\$_GET: " . print_r($this->input->get(), TRUE);  $user_err_msg = "The confirmed new password is empty or invalid, and it is required."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		$account_id = $this->auth_lib->GetAccountId(); // set the current user's account primary ID.
		$user_id = $this->auth_lib->GetUserId(); // set the current user's primary ID.
		
		// attempt to change the current user's password.
		$return = $this->Users_model->ChangeUserPassword($account_id, $user_id, $current_password, $new_password, $confirm_new_password);
		$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Users_model->ChangeUserPassword() \$result: \n" . print_r($return, TRUE);  $user_err_msg = ( isset($return['Error_Message']) ) ? $return['Error_Message'] : "There was an error when updating your password. "; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE; $user_err_msg = ( isset($return['Error_Message']) ) ? $return['Error_Message'] : "There was an error when updating your password.";  $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				
		$json_response = $return; // success return response
		
		if( $this->input->get('callback') != FALSE )
		{
			echo $this->input->get('callback') . '(' . json_encode($json_response) . ')';
		}
		else
		{
			echo json_encode($json_response);
		}
		
	}
	
	//  This method will call the methods to reset a filemation user password. It will get the user's email address for the account, and send an email with instructions on how to reset the user's password.
	//  The email will contain a link for the user's to click or visit in a browser. When the user loads the page, it will generate a new random password, and email the user the new random password.
	//  Request Data: POST[]
	public function SendResetPasswordEmail()
	{
		//	Request Post Data
		//	Email_Address	= the user email address used to login to the account
		
		
		$email_address = $this->input->post('Email_Address');
		
		$form_data = array();
		$form_data['Email_Address'] = $email_address;
		$this->session->set_flashdata('form_data', $form_data);
		
		// Data validation
		// =================
		$error = false;
		$error_message = "";
		if( empty($email_address) )
		{
			$error = true;
			$error_message = "The email address is required to reset your password. The email address is empty.";
			$error = ( TRUE );   $err_msg = "The email address required to reset the user account password is empty, or invalid. \$email_address is empty, false, or invalid"; $notify = FALSE;   $severity = "WARNING";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		}
		if( filter_var($email_address, FILTER_VALIDATE_EMAIL ) == FALSE )
		{
			$error = true;
			$error_message = "The email address provided is not a valid email address. (Ex: corey@filemation.com)";
			$error = ( TRUE );   $err_msg = "The email address required to reset the user account password is empty, or invalid. \$email_address is empty, false, or invalid"; $notify = FALSE;   $severity = "WARNING";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		}
		
		// if an error exists we need to redirect back to the reset password ui and display our errors.
		if( $error )
		{
			$this->session->set_flashdata('reset_password_error_message', $error_message);
			header("Location: /reset");
			exit;
		}
		
		// check if the email address exists for any current registered users
		
		$result = $this->Users_model->CheckIfUserEmailExists($email_address);
		$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Users_model->CheckIfUserEmailExists() \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'There was an error when checking if the email address given exists for a current registered user.'); header('Location: /register'); exit; }
		$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'There was an error when checking if the email address given exists for a current registered user.'); header('Locatoin: /register'); exit; }
		if( $error ) // if the CheckIfUserEmailExists() call failed we need to redirect and display an error
		{
			$error_log_id = ( isset($return['Error_Log_Id']) ) ? "(" . $return['Error_Log_Id'] . ")": '';
			$error_message = "An error occurred when check if the account exists. Please try again. $error_log_id";
			$this->session->set_flashdata('reset_password_error_message', $error_message);
			header("Location: /reset");
			exit;
		}		
		if( isset($result['Exists']) && $result['Exists'] == FALSE )
		{
			
			$error_message = "The user account ($email_address) does not exist in our records. Please check the email address, and try again.";
			$this->session->set_flashdata('reset_password_error_message', $error_message);
			header("Location: /reset");
			exit;
		}
		
		// last we need to send the reset password email confirmation
		$return = $this->Auth_model->SendResetPasswordEmailConfirmation($email_address);
		$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Auth_model->RegisterNewAccount() \n\$return: " . print_r($return, TRUE);   $notify = TRUE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'When registering a new account there was an error.'); header('Location: /register'); exit; }
		$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = TRUE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'When registering a new account there was an error.'); header('Locatoin: /register'); exit; }
		if( $error )
		{
			$error_log_id = ( isset($return['Error_Log_Id']) ) ? "(" . $return['Error_Log_Id'] . ")": '';
			$error_message = "An error occurred while trying to reset your password. Please try to reset your account password again. $error_log_id";
			$this->session->set_flashdata('reset_password_error_message', $error_message);
			header("Location: /reset");
			exit;
		}
		
		// success.
		header("Location: /reset/?sent=true");
		exit;
	}
	
	//  This method confirms the reset password confirmation key, and if valid reset the password for the account the confirmation key is associated with.
	//  Request Data: GET[]
	public function ConfirmResetPassword()
	{
		//	Request Get Data
		//	con_key	=	a confirmation key value to reset the password
		
		$confirmation_key = $this->input->get('con_key');
		$error = ( empty($confirmation_key) );   $err_msg = "\$confirmation_key is empty, or invalid."; $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error_message = "";
		if( $error )
		{
			$error_message .= "The confirmation key is empty, or invalid.";
		}
		
		$return = $this->Auth_model->ResetPassword($confirmation_key);
		$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Auth_model->ResetPassword() \n\$return: " . print_r($return, TRUE);   $notify = TRUE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'When registering a new account there was an error.'); header('Location: /register'); exit; }
		$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = TRUE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'When registering a new account there was an error.'); header('Locatoin: /register'); exit; }
		$error = ( empty($return['New_Password']) );   $err_msg = "The new password did not return, is empty, or invalid. \n\$return: " . print_r($return, TRUE) ; $notify = TRUE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'When registering a new account there was an error.'); header('Locatoin: /register'); exit; }
		if( $error )
		{
			$error_log_id = ( isset($return['Error_Log_Id']) ) ? "(" . $return['Error_Log_Id'] . ")": '';
			$error_message = "An occurred when attempting to reset the account password. $error_log_id";
		}		
		
		$new_password = ( !isset($return['New_Password']) || empty($return['New_Password']) ) ? "" : $return['New_Password']; // set the new password value.
		
		$view_data = array();
		$view_data['reset_password_error_message'] = $error_message;
		$view_data['new_password'] = $new_password;
		
		$this->load->view('head_register');
		$this->load->view('auth/reset_password_confirmed', $view_data);
		$this->load->view('footer_small');
		
	}
	
	
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */