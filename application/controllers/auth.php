<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Filemation
 * 
 */

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('auth_lib');
		$this->load->model('Auth_model');
		$this->lang->load('auth');

	}

	public function Index()
	{
		redirect('/auth/login/');
	}
	
	//  This method controls the interface that users are redirected to if they have not confirmed their account email address yet.
	public function Confirm()
	{
		$account_id = $this->auth_lib->GetAccountId(); // get the account id;
		$user_id = $this->auth_lib->GetUserId(); // get the current user's id to be used.
		$confirmation_key = $this->input->get('con_key'); // if the confirmation exists, or is not FALSE, then we try to validate the confirmation key and update the account.
		
		$return = $this->Accounts_model->IsUserEmailConfirmed($user_id, $confirmation_key);
		$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Accounts_model->IsUserEmailConfirmed() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'There was an error when checking if the email address given exists for a current registered user.'); header('Location: /register'); exit; }
		$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'There was an error when checking if the email address given exists for a current registered user.'); header('Locatoin: /register'); exit; }
		if( isset($return['Email_Confirmed']) && $return['Email_Confirmed'] == TRUE )
		{
			header("Location: " . base_url());
			exit;
		}
		
		
		$show_confirmation_message = false;
		$confirmation_result = false;
		if( !empty($confirmation_key) )
		{
			$return = $this->Users_model->ConfirmUserEmailAddress($confirmation_key);
			$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Users_model->ConfirmUserEmailAddress() \n\$result: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'There was an error when checking if the email address given exists for a current registered user.'); header('Location: /register'); exit; }
			$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'There was an error when checking if the email address given exists for a current registered user.'); header('Locatoin: /register'); exit; }
			
			$valid = ( $error == FALSE && $return['Valid'] == TRUE ) ? TRUE : FALSE; // set the confirmation validation result.
			$show_confirmation_message = true;  // show the confirmation result message, instead of the page to enter the confirmation code or resend the confirmation email.
			$confirmation_result = ( ($error) && ($valid == FALSE) )  ? FALSE : TRUE; // this is the value that is the final decision to show the confirmation success or error.
		}
		
		$view_data = array();
		$view_data['user_id'] = $user_id;
		$view_data['show_confirmation_message'] = $show_confirmation_message;
		$view_data['confirmation_result'] = $confirmation_result;
		
		$this->load->view('head');
//		$this->load->view('header');
		$this->load->view('auth/confirm', $view_data);
		$this->load->view('footer');
	}
	
	//  This method validates an email confirmation key. If it is valid, returns valid, or returns invalid. 
	//  This method will only be called by users who are logged into the filemation account.
	//  Request Data: POST[]
	public function ConfirmEmailConfirmationKey()
	{
		//  Request Post Data
		//  Con_Key	= the confirmation key  
		
		$account_id = $this->auth_lib->GetAccountId();
		$user_id = $this->auth_lib->GetUserId();
		$confirmation_key = $this->input->post('Con_Key');
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty or invalid. \n\$account_id: $account_id \func_get_args(): " . print_r(func_get_args(), TRUE);  $user_err_msg = "The account id is empty. Please resend the confirmation email, and click on the link provided or copy and paste the url into your browser."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'There was an error when checking if the email address given exists for a current registered user.'); header('Location: /register'); exit; }
		
		$error = ( empty($confirmation_key) );   $err_msg = "\$confirmation_key is empty or invalid. \n\$confirmation_key: $confirmation_key \func_get_args(): " . print_r(func_get_args(), TRUE);  $user_err_msg = "The user id is empty. Please resend the confirmation email, and click on the link provided or copy and paste the url into your browser."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'There was an error when checking if the email address given exists for a current registered user.'); header('Location: /register'); exit; }
		
		$error = ( empty($confirmation_key) );   $err_msg = "\$confirmation_key is empty or invalid. \n\$confirmation_key: $confirmation_key \func_get_args(): " . print_r(func_get_args(), TRUE);  $user_err_msg = "The confirmation key was empty. Please enter the confirmation key and try again, or resend the email and click on the link provided or copy and paste the url into your browser."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'There was an error when checking if the email address given exists for a current registered user.'); header('Location: /register'); exit; }
		
		$return = $this->Users_model->ConfirmUserEmailAddress($confirmation_key);
		$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Users_model->ConfirmUserEmailAddress() \n\$result: " . print_r($return, TRUE);   $user_err_msg = "Confirming your email address has failed. Please resend the confirmation email, and click on the link provided or copy and paste the url into your browser.";  $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'There was an error when checking if the email address given exists for a current registered user.'); header('Location: /register'); exit; }
		$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $user_err_msg = "Confirming your email address has failed. Please resend the confirmation email, and click on the link provided or copy and paste the url into your browser.";  $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'There was an error when checking if the email address given exists for a current registered user.'); header('Locatoin: /register'); exit; }
		
		$json_response = $return;
		
		if( $this->input->get('callback') != FALSE )
		{
			echo "(" . json_encode($json_response) . ")";
		}
		else
		{
			echo json_encode($json_response);
		}
	}

	//  This method controls the login page
	public function Login()
	{
		if( $this->auth_lib->IsLoggedIn() )
		{
			redirect('/docs/filer');
		}
		
		$login_creds_error = $this->session->flashdata('login_creds_error');
		
		$view_data = array();
		$view_data['login_creds_error'] = $login_creds_error;
		
		$this->load->view('head_login');
		$this->load->view('auth/login', $view_data);
		$this->load->view('footer_small');
	}
	
	//  This method controls the login page
	public function AdminLogin()
	{
		if( $this->auth_lib->IsLoggedIn() )
		{
			redirect('/admin/');
		}
		
		$login_creds_error = $this->session->flashdata('login_creds_error');
		
		$view_data = array();
		$view_data['login_creds_error'] = $login_creds_error;
		
		$this->load->view('head_login');
		$this->load->view('auth/admin_login', $view_data);
		$this->load->view('footer_small');
	}
	
	//  This method will destroy all the user's logged in sessions and redirect to the login page
	public function Logout()
	{
		$redirect = $this->input->get('redirect'); // set the redirect variable value.
		
		if( !session_id() ) session_start();
		if( session_id() ) session_destroy();

		$this->session->set_userdata(array('user_id' => '', 'email' => '', 'account_id' => '', 'status' => ''));
		
		$this->session->sess_destroy();
		
		if( strtolower($redirect) == "admin" )
		{
			redirect(base_url() . 'admin');
		}
		else
		{
			redirect(base_url() . 'auth/login');
		}
	}
	
	//  This method attempts to log a user in with a username(email) and password.
	//  Request Data: POST[Email, Password, Remember_User, Security_Code]
	public function LogUserIn()
	{
		$email = $this->input->post('Email');
		$password = $this->input->post('Password');
		$stay_logged_in = $this->input->post('Stay_Logged_In');
		
		$result = $this->Auth_model->LogUserIn($email, $password, $stay_logged_in);
		if( isset($result['Result']) && $result['Result'] == TRUE && $result['Logged_In'] == TRUE )
		{
			header('Location: /docs/filer');
			exit;
		}
		else
		{
			$this->session->sess_create();
			$this->session->set_flashdata('login_creds_error', TRUE);
			header('Location: /');
			exit;
		}
		
	}
	
	//  This method attempts to log a admin user in with a username and password.
	//  Request Data: POST[Username, Password, Remember_User, Security_Code]
	public function LogAdminIn()
	{
		$username = $this->input->post('Username');
		$password = $this->input->post('Password');
		$stay_logged_in = $this->input->post('Stay_Logged_In');
		
		$result = $this->Auth_model->LogAdminIn($username, $password, $stay_logged_in);
		if( isset($result['Result']) && $result['Result'] == TRUE && $result['Logged_In'] == TRUE )
		{
			header('Location: /admin/errorlogreport');
			exit;
		}
		else
		{
			$this->session->sess_create();
			$this->session->set_flashdata('login_creds_error', TRUE);
			header('Location: /admin');
			exit;
		}
		
	}
	
	//  This method controls the register page
	public function Register()
	{
		if( $this->auth_lib->IsLoggedIn() )
		{
			redirect('/docs/filer');
		}
		
		$register_error_message = $this->session->flashdata('register_error_message');
		$register_form_data = $this->session->flashdata('register_form_data');
		
		$view_data = array();
		$view_data['register_error_message'] = $register_error_message;
		$view_data['register_form_data'] = $register_form_data;
		
		$this->load->view('head_register');
		$this->load->view('auth/register', $view_data);
		$this->load->view('footer');
	}
	
	//  This method will create a new application account
	//  Request Data: POST[]
	public function RegisterAccount()
	{
		//	Request Data: POST
		//	Account_Name		= The account name to identify the account.
		//	User_First_Name	= The account primary user's first name.
		//	User_Last_Name		= The account primary user's last name.
		//	User_Email		= The account primary user's email address that is used to login to the primary user's account.
		//	User_Password		= The account primary user's login password.
		//	User_Re_Password	= The account primary user's login re password.
		
		$account_name = $this->input->post('Account_Name');
		$user_first_name = $this->input->post('User_First_Name');
		$user_last_name = $this->input->post('User_Last_Name');
		$user_email = $this->input->post('User_Email');
		$user_password = $this->input->post('User_Password');
		$user_re_password = $this->input->post('User_Re_Password');
		
		// before we validate our account and user registration data let's set it in a flash session array so if we redirect the end user back to the register page
		// we can display the data back in the register form fields for convienence. 
		$register_form_data = array();
		$register_form_data['Account_Name'] = $account_name;
		$register_form_data['User_First_Name'] = $user_first_name;
		$register_form_data['User_Last_Name'] = $user_last_name;
		$register_form_data['User_Email'] = $user_email;
		$register_form_data['User_Password'] = $user_password;
		$this->session->set_flashdata('register_form_data', $register_form_data);
		
		
		// set the error vairables
		$error = false; // if this equals true redirect to the register page and present the error message to the user
		$error_message = "<ul style='padding-left: 20px !important; margin-left: 0px !important;'>"; // this is the error message to present back to the user
		
		
		// data validation
		// ===============================
		if( empty($account_name) )
		{
			$error = true;
			$error_message .= "<li>The Account Name is required to register an account.</li>";
		}
		
		if( empty($user_first_name) )
		{
			$error = true;
			$error_message .= "<li>The User's First Name is required.</li>";
		}
		
		if( empty($user_last_name) )
		{
			$error = true;
			$error_message .= "<li>The User's Last Name is required.</li>";
		}
		
		if( empty($user_email) )
		{
			$error = true;
			$error_message .= "<li>The User's Email is required.</li>";
		}
		
		if( ( strpos($user_email, '@') == FALSE ) || ( strpos($user_email, '.') == FALSE ) )
		{
			$error = true;
			$error_message .= "<li>The Primary User's Email must be a valid email address.</li>";
		}
		
		if( empty($user_password) )
		{
			$error = true;
			$error_message .= "<li>The Primary User's Password is required.</li>";
		}
		
		if( empty($user_re_password) )
		{
			$error = true;
			$error_message .= "<li>You must re type the User's Password.</li>";
		}
		
		if( $user_password != $user_re_password )
		{
			$error = true;
			$error_message .= "<li>The passwords entered do not match.</li>";
		}
		
		if( $error )
		{
			$this->session->set_flashdata('register_error_message', $error_message);
			header("Location: /register");
			exit;
		}
		
		// check if the email address exists for any current registered users
		// ===================================================================
		$result = $this->Users_model->CheckIfUserEmailExists($user_email);
		$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Users_model->CheckIfUserEmailExists() \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'There was an error when checking if the email address given exists for a current registered user.'); header('Location: /register'); exit; }
		$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'There was an error when checking if the email address given exists for a current registered user.'); header('Locatoin: /register'); exit; }
		if( $error ) // if the CheckIfUserEmailExists() call failed we need to redirect and display an error
		{
			$error_message = "An error occurred while checking if the email address provided already exists. Please try to register the account again.";
			$this->session->set_flashdata('register_error_message', $error_message);
			header("Location: /register");
			exit;
		}		
		if( isset($result['Exists']) && $result['Exists'] == TRUE )
		{
			
			$error_message = "The primary user email address given '<i>$user_email</i>' already exists for a registered user. Please use a different email address or login <a href='/auth/login'>here</a> using account '<i>$user_email</i>'";
			$this->session->set_flashdata('register_error_message', $error_message);
			header("Location: /register");
			exit;
		}
		
		
		$account_rec = array();
		$account_rec['Account_Name'] = $account_name;
		$account_rec['User_First_Name'] = $user_first_name;
		$account_rec['User_Last_Name'] = $user_last_name;
		$account_rec['User_Email'] = $user_email;
		$account_rec['User_Password'] = $user_password;
		$account_rec['User_Re_Password'] = $user_re_password;
		$result = $this->Auth_model->RegisterNewAccount($account_rec);
		$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Auth_model->RegisterNewAccount() \n\$result: " . print_r($result, TRUE);   $notify = TRUE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'When registering a new account there was an error.'); header('Location: /register'); exit; }
		$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = TRUE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'When registering a new account there was an error.'); header('Locatoin: /register'); exit; }
		if( $error )
		{
			$error_message = "An error occurred while registering your new account. Please try to register the account again.";
			$this->session->set_flashdata('register_error_message', $error_message);
			header("Location: /register");
			exit;
		}
		
		
		// successfull account registration continue to filemation login.
		header('Location: ' . base_url());
		exit;		
	}
	 
	//  This method controls the reset password page for end user's who are not logged into filemation. They can supply their email and we will reset the password and send them an email.
	public function ResetPassword()
	{
		if( $this->auth_lib->IsLoggedIn() )
		{
			header("Location: " . base_url());
			exit;
		}

		$reset_pass_email_sent = $this->input->get('sent'); // if $_GET[sent] is set then the email has sent, and we display a success message isntead of the reset password form.
		$reset_password_error_message = $this->session->flashdata('reset_password_error_message'); // if any error messages exist when trying to send the reset password email, set them.
		$form_data = $this->session->flashdata('form_data'); // set any form data from previous reset password attempts.
		
		$view_data = array();
		$view_data['reset_password_error_message'] = $reset_password_error_message;
		$view_data['form_data'] = $form_data;
		$view_data['reset_pass_email_sent'] = $reset_pass_email_sent;
		
		$this->load->view('head_register');
		$this->load->view('auth/reset_password', $view_data);
		$this->load->view('footer_small');
	}
	
	//  This method will call the methods to reset a filemation user password. It will get the user's email address for the account, and send an email with instructions on how to reset the user's password.
	//  The email will contain a link for the user's to click or visit in a browser. When the user loads the page, it will generate a new random password, and email the user the new random password.
	//  Request Data: POST[]
	public function DoSendResetPasswordEmail()
	{
		//	Request Post Data
		//	Email Address	= the user email address used to login to the account
		
		
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
	public function DoConfirmResetPassword()
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
	
	//  This method will send the "email confirmation" email to the given user
	//  Request Data: GET[]
	public function SendEmailConfirmation()
	{
		//  Request GET Data
		//  user_id	=	the primary key id
		//  ** we might change the account id to be sent as a $_GET value instead so this method can be used by Filemation administrators as well.
		
		$account_id = $this->auth_lib->GetAccountId();
		$user_id = $this->input->get('user_id');
		$error = ( empty($user_id) );   $err_msg = "The user primary key id is empty, null, or invalid. \n\$_GET: " . print_r($this->input->get(), TRUE);  $user_err_msg = "The email confirmation email did not send. Please try again."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$return = $this->Users_model->SendUserConfirmationEmail($account_id, $user_id);
		$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Users_model->SendEmailConfirmation() \n\$return: " . print_r($return, TRUE);   $user_err_msg = "The email confirmation email did not send. Please try again."; $notify = TRUE;   $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'When registering a new account there was an error.'); header('Location: /register'); exit; }
		$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = TRUE;   $user_err_msg = "The email confirmation email did not send. Please try again."; $severity = "ERROR";   $stop = FALSE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry4(TRUE, $notify, $severity, $err_msg, $user_err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){ $this->session->set_flashdata('register_error_message', 'When registering a new account there was an error.'); header('Locatoin: /register'); exit; }
			
		$json_response = $return;
		
		if( $this->input->get('callback') != FALSE )
		{
			echo '(' . json_encode($json_response) . ')';
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
	
	public function HashPassword()
	{
		$pass = $this->input->get('pass');
		
		
		$hash = $this->auth_lib->GetHash($pass);
		
		echo "<pre>"; print_r($hash);
	}

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */