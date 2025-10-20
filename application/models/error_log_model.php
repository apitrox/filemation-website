<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//  Beginning of file error_log_model.php
//  Location: ./application/models/error_log_model.php

class Error_log_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}



	// This method determines if it is an error and if so logs the error in the error log table
	// If the error is generated in a batch or non interactive mode
	// @Param 1:	  a logical condition, that if true means there is an error, if false then no error
	// @Param 2:	  if TRUE, then send a text message as additional notification of the error
	// @Param 3:	  the severity of the error, see severity listing below
	// @Param 4:	  the text of the error, what should be logged or displayed to the user
	// @Param 5:	  if TRUE, then the error will be displayed to the user, should only be used in non-batch controllers
	// @Param 6:	  the file::method where the error occurred
	// @Param 7:	  the line number on which the error occurred
	// @Return:		$error_log_id, will be NULL if no error occurred - this is the error logging method so if an error occurs likely nothing you will do with it
	public function NewErrorLogEntry3( $is_error = TRUE, $err_notify = TRUE, $err_severity = "", $err_msg = "None provided", $err_display = FALSE, $err_method = "", $err_line = 0 )
	{
		//    example of how to call this method from a controller, model or similar type of method:
		//    LogError( empty($var), 0, "ERROR", '$var is empty.', __METHOD__, __LINE__ ) ;
		//    the last two arguements provided should always be [__METHOD__] and [__LINE__]
		//    call this method and let it determine if an error occurred and if so to act on it appropriately.
		//    this method will always return to the calling method but returns

		//  This method is not intended to conform to some of the coging guidelines, because it is the error log model itself and would cause conflicts

		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }

		$new_error_log_id = NULL ;  // default, will return null if no error

		$error_log_id = "" ;   // initialize
		$err_notify = ( $err_notify === TRUE ) ? TRUE : FALSE ;   // be sure it is a valid value

		//  check for a valid err_severity value
		//  ERROR: invalid situation that should never occur, typically stops program execution, requires engineer's attention
		//  WARNING:  invalid situation that should not occur but program is able to continue, may or may not stop program execution but typically does not, requires engineer's attention
		//  NOTICE:  an unusual situation that should be reviewed at some time, not urgent, does not stop program execution
		//  MESSAGE:  this is typically used for testing purposes, used in place of echoing information out to the screen, used when echo is not appropriate (e.g. production or batch processing)
		$err_severity = strtoupper($err_severity) ;
		$err_severity_is_valid = ( !empty($err_severity) && (($err_severity === "ERROR") || ($err_severity === "WARNING") || ($err_severity === "NOTICE") || ($err_severity === "MESSAGE")) ) ? TRUE : FALSE ;


		$num_args_expected = 7 ;
		if ( (func_num_args() != $num_args_expected) )
		{
			$err_msg = "May have received an invalid number of arguments or missing values.  Expected: " . $num_args_expected . ".  Received: " . func_num_args() . "\nCalled from method: $err_method \nLine:  $err_line \nfunc_get_args(): ". print_r(func_get_args(),TRUE) ;
			$is_error = TRUE ;   // used later
			$err_notify = TRUE ;  //  send a text notification if we get an error in our error handling method
			$err_severity = "ERROR" ;
			$err_display = FALSE ;
			$err_method = __METHOD__ ;
			$err_line = __LINE__ ;
		}
		elseif ( $err_severity_is_valid !== TRUE )
		{
			$err_msg = "An invalid value has been provided for \n\$err_severity:  $err_severity \nCalled from method: $err_method \nLine:  $err_line \nfunc_get_args(): ". print_r(func_get_args(),TRUE) ;
			$is_error = TRUE ;   // used later
			$err_notify = TRUE ;  //  send a text notification if we get an error in our error handling method
			$err_severity = "ERROR" ;
			$err_display = FALSE ;
			$err_method = __METHOD__ ;
			$err_line = __LINE__ ;
		}
		elseif ( ($err_method == "") || empty($err_method) )
		{
			$err_msg = "An invalid value has been provided for \n\$err_method:  $err_method \nCalled from method: $err_method \nLine:  $err_line \nfunc_get_args(): ". print_r(func_get_args(),TRUE) ;
			$is_error = TRUE ;   // used later
			$err_notify = TRUE ;  //  send a text notification if we get an error in our error handling method
			$err_severity = "ERROR" ;
			$err_display = FALSE ;
			$err_method = __METHOD__ ;
			$err_line = __LINE__ ;
		}
		elseif ( ($err_line == 0) || empty($err_line) )
		{
			$err_msg = "An invalid value has been provided for \n\$err_line:  $err_line \nCalled from method: $err_method \nLine:  $err_line \nfunc_get_args(): ". print_r(func_get_args(),TRUE) ;
			$is_error = TRUE ;   // used later
			$err_notify = TRUE ;  //  send a text notification if we get an error in our error handling method
			$err_severity = "ERROR" ;
			$err_display = FALSE ;
			$err_method = __METHOD__ ;
			$err_line = __LINE__ ;
		}

		if ($err_severity === "MESSAGE")
		{
			//  if a MESSAGE, always log and never notify or display
			$is_error = TRUE ;
			$err_notify = FALSE ;
			$err_display = FALSE ;
		}

		if ( $is_error )
		{
			// replace newlines with HTML breaklines because newlines are not visible in the database table
			//  then clean up breaklines and remove duplicates, before saving it in the table
			$error_message = trim(str_replace("<pre>","",$err_msg)) ;
			$error_message = trim(str_replace("</pre>","",$error_message)) ;
			$error_message = trim(str_replace("<pre/>","",$error_message)) ;
			$error_message = trim(str_replace("<br>","<br />",$error_message)) ;
			$error_message = trim(str_replace("<BR>","<br />",$error_message)) ;
			$error_message = trim(str_replace("<BR />","<br />",$error_message)) ;
			$error_message = trim(str_replace("<br /><br />","<br />",$error_message)) ;
			$error_message = trim(str_replace(chr(9),"<br />",$error_message)) ;
			$error_message = trim(str_replace(chr(10),"<br />",$error_message)) ;
			$error_message = trim(str_replace(chr(11),"<br />",$error_message)) ;
			$error_message = trim(str_replace(chr(12),"<br />",$error_message)) ;
			$error_message = trim(str_replace(chr(13),"<br />",$error_message)) ;
			$error_message = trim(str_replace('\n',"<br />",$error_message)) ;
			$error_message = trim(str_replace('\t',"<br />",$error_message)) ;
			$error_message = trim(str_replace("\n","<br />",$error_message)) ;
			$error_message = trim(str_replace("\t","<br />",$error_message)) ;

			//  for some reason, the following seems to be necessary to remove duplicate breaklines
			$error_message = trim(str_replace("<br /><br />","~~",$error_message)) ;
			$error_message = trim(str_replace("~~","<br />",$error_message)) ;

			//  check again
			$error_message = trim(str_replace("<br /><br />","~~",$error_message)) ;
			$error_message = trim(str_replace("~~","<br />",$error_message)) ;

			//  and one more time to be sure we've removed all duplicates
			$error_message = trim(str_replace("<br /><br />","~~",$error_message)) ;
			$error_message = trim(str_replace("~~","<br />",$error_message)) ;

			//  if $error_message begins with a breakline "<br />", remove all
			while ( substr($error_message,0,6) == "<br />")
			{
				   $error_message = trim(substr($error_message,6)) ;
			}

			//  if $error_message ends with a breakline "<br />", remove all
			while ( substr($error_message,-6) == "<br />")
			{
				   $error_message = trim(substr($error_message,0,-6)) ;
			}

			unset($new_error_log_record) ;
			$new_error_log_record = array() ;
			$new_error_log_record['Error_Date'] = date("Y-m-d", time()) ;
			$new_error_log_record['Error_DateTime'] = date("Y-m-d H:i:s", time()) ;
//			$new_error_log_record['User_Code'] = $this->tank_auth->get_user_code() ;
			$new_error_log_record['Severity'] = strtoupper($err_severity) ;
			$new_error_log_record['Error_Message'] = $error_message ;
			$new_error_log_record['Method'] = trim($err_method) ;
			$new_error_log_record['Line_Num'] = intval($err_line) ;
			$result = $this->db->insert( 'error_log', $new_error_log_record ) ;

			//  Get the unique key, error_log_id, of the error_log record we just inserted
			$new_error_log_id = ( $result == FALSE) ? FALSE : $this->db->insert_id();

			if ( $err_notify === TRUE )
			{
//				// send a text that an error occured
//				$sms_address = '9139527686@messaging.sprintpcs.com, 2146736702@txt.att.net';
//				$from_name = "" ;
//				$text_msg = "LAMS ERROR notification.  " . date( "n-j-Y, g:i:s a" ) . "  Error_Log_Id: " . $new_error_log_id ;
//				$from_st_addr = '';
//				$from_phone = '';
//				$end_phase = '';
//
//				$sms_result = $this->sms_lib->SendSMSMessage($sms_address, $from_name, $text_msg, $from_st_addr, $from_phone, $end_phase);
//				if( $sms_result['Result'] !== TRUE )
//				{
//					//  no error checking, we are in the error routine, we may create and infinite loop
//				}
			}

			if ( $err_display === TRUE )
			{
				$json_result = array('Result' => FALSE, 'Error_Log_Id' => $new_error_log_id, 'Result_Message' => $error_message . '\nMethod: ' . $err_method . '\nLine: ' . $err_line . '\nTime: ' . date('n-j-Y h:i:s a', time()));
				if( $this->input->get('callback') != FALSE )
				{
					echo $this->input->get('callback') . '(' . json_encode($json_result) . ')';
					exit;
				}
				else
				{
					echo json_encode($json_result);
					exit;
				}
			}
		}

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date( "n-j-Y h:i:s A" ) . "\n-----------------------------------------------------\n"; }

		//  return the New_Error_Log_Id to the new event
		return $new_error_log_id ;
	}
	
	
	// This method determines if it is an error and if so logs the error in the error log table
	// If the error is generated in a batch or non interactive mode
	// @Param 1:	  a logical condition, that if true means there is an error, if false then no error
	// @Param 2:	  if TRUE, then send a text message as additional notification of the error
	// @Param 3:	  the severity of the error, see severity listing below
	// @Param 4:	  the text of the error, what should be logged or displayed to the user
	// @Param 5:	  if TRUE, then the error will be displayed to the user, should only be used in non-batch controllers
	// @Param 6:	  the file::method where the error occurred
	// @Param 7:	  the line number on which the error occurred
	// @Return:		$error_log_id, will be NULL if no error occurred - this is the error logging method so if an error occurs likely nothing you will do with it
	public function NewErrorLogEntry4( $is_error = TRUE, $err_notify = TRUE, $err_severity = "", $err_msg = "None provided", $user_err_msg = "An error occurred", $err_display = FALSE, $err_method = "", $err_line = 0 )
	{
		//    example of how to call this method from a controller, model or similar type of method:
		//    LogError( empty($var), 0, "ERROR", '$var is empty.', __METHOD__, __LINE__ ) ;
		//    the last two arguements provided should always be [__METHOD__] and [__LINE__]
		//    call this method and let it determine if an error occurred and if so to act on it appropriately.
		//    this method will always return to the calling method but returns

		//  This method is not intended to conform to some of the coging guidelines, because it is the error log model itself and would cause conflicts

		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }

		$new_error_log_id = NULL ;  // default, will return null if no error

		$error_log_id = "" ;   // initialize
		$err_notify = ( $err_notify === TRUE ) ? TRUE : FALSE ;   // be sure it is a valid value

		//  check for a valid err_severity value
		//  ERROR: invalid situation that should never occur, typically stops program execution, requires engineer's attention
		//  WARNING:  invalid situation that should not occur but program is able to continue, may or may not stop program execution but typically does not, requires engineer's attention
		//  NOTICE:  an unusual situation that should be reviewed at some time, not urgent, does not stop program execution
		//  MESSAGE:  this is typically used for testing purposes, used in place of echoing information out to the screen, used when echo is not appropriate (e.g. production or batch processing)
		$err_severity = strtoupper($err_severity) ;
		$err_severity_is_valid = ( !empty($err_severity) && (($err_severity === "ERROR") || ($err_severity === "WARNING") || ($err_severity === "NOTICE") || ($err_severity === "MESSAGE")) ) ? TRUE : FALSE ;


		$num_args_expected = 8 ;
		if ( (func_num_args() != $num_args_expected) )
		{
			$err_msg = "May have received an invalid number of arguments or missing values.  Expected: " . $num_args_expected . ".  Received: " . func_num_args() . "\nCalled from method: $err_method \nLine:  $err_line \nfunc_get_args(): ". print_r(func_get_args(),TRUE) ;
			$is_error = TRUE ;   // used later
			$err_notify = TRUE ;  //  send a text notification if we get an error in our error handling method
			$err_severity = "ERROR" ;
			$err_display = FALSE ;
			$err_method = __METHOD__ ;
			$err_line = __LINE__ ;
		}
		elseif ( $err_severity_is_valid !== TRUE )
		{
			$err_msg = "An invalid value has been provided for \n\$err_severity:  $err_severity \nCalled from method: $err_method \nLine:  $err_line \nfunc_get_args(): ". print_r(func_get_args(),TRUE) ;
			$is_error = TRUE ;   // used later
			$err_notify = TRUE ;  //  send a text notification if we get an error in our error handling method
			$err_severity = "ERROR" ;
			$err_display = FALSE ;
			$err_method = __METHOD__ ;
			$err_line = __LINE__ ;
		}
		elseif ( ($err_method == "") || empty($err_method) )
		{
			$err_msg = "An invalid value has been provided for \n\$err_method:  $err_method \nCalled from method: $err_method \nLine:  $err_line \nfunc_get_args(): ". print_r(func_get_args(),TRUE) ;
			$is_error = TRUE ;   // used later
			$err_notify = TRUE ;  //  send a text notification if we get an error in our error handling method
			$err_severity = "ERROR" ;
			$err_display = FALSE ;
			$err_method = __METHOD__ ;
			$err_line = __LINE__ ;
		}
		elseif ( ($err_line == 0) || empty($err_line) )
		{
			$err_msg = "An invalid value has been provided for \n\$err_line:  $err_line \nCalled from method: $err_method \nLine:  $err_line \nfunc_get_args(): ". print_r(func_get_args(),TRUE) ;
			$is_error = TRUE ;   // used later
			$err_notify = TRUE ;  //  send a text notification if we get an error in our error handling method
			$err_severity = "ERROR" ;
			$err_display = FALSE ;
			$err_method = __METHOD__ ;
			$err_line = __LINE__ ;
		}

		if ($err_severity === "MESSAGE")
		{
			//  if a MESSAGE, always log and never notify or display
			$is_error = TRUE ;
			$err_notify = FALSE ;
			$err_display = FALSE ;
		}

		if ( $is_error )
		{
			// replace newlines with HTML breaklines because newlines are not visible in the database table
			//  then clean up breaklines and remove duplicates, before saving it in the table
			$error_message = trim(str_replace("<pre>","",$err_msg)) ;
			$error_message = trim(str_replace("</pre>","",$error_message)) ;
			$error_message = trim(str_replace("<pre/>","",$error_message)) ;
			$error_message = trim(str_replace("<br>","<br />",$error_message)) ;
			$error_message = trim(str_replace("<BR>","<br />",$error_message)) ;
			$error_message = trim(str_replace("<BR />","<br />",$error_message)) ;
			$error_message = trim(str_replace("<br /><br />","<br />",$error_message)) ;
			$error_message = trim(str_replace(chr(9),"<br />",$error_message)) ;
			$error_message = trim(str_replace(chr(10),"<br />",$error_message)) ;
			$error_message = trim(str_replace(chr(11),"<br />",$error_message)) ;
			$error_message = trim(str_replace(chr(12),"<br />",$error_message)) ;
			$error_message = trim(str_replace(chr(13),"<br />",$error_message)) ;
			$error_message = trim(str_replace('\n',"<br />",$error_message)) ;
			$error_message = trim(str_replace('\t',"<br />",$error_message)) ;
			$error_message = trim(str_replace("\n","<br />",$error_message)) ;
			$error_message = trim(str_replace("\t","<br />",$error_message)) ;

			//  for some reason, the following seems to be necessary to remove duplicate breaklines
			$error_message = trim(str_replace("<br /><br />","~~",$error_message)) ;
			$error_message = trim(str_replace("~~","<br />",$error_message)) ;

			//  check again
			$error_message = trim(str_replace("<br /><br />","~~",$error_message)) ;
			$error_message = trim(str_replace("~~","<br />",$error_message)) ;

			//  and one more time to be sure we've removed all duplicates
			$error_message = trim(str_replace("<br /><br />","~~",$error_message)) ;
			$error_message = trim(str_replace("~~","<br />",$error_message)) ;

			//  if $error_message begins with a breakline "<br />", remove all
			while ( substr($error_message,0,6) == "<br />")
			{
				   $error_message = trim(substr($error_message,6)) ;
			}

			//  if $error_message ends with a breakline "<br />", remove all
			while ( substr($error_message,-6) == "<br />")
			{
				   $error_message = trim(substr($error_message,0,-6)) ;
			}

			unset($new_error_log_record) ;
			$new_error_log_record = array() ;
			$new_error_log_record['Error_Date'] = date("Y-m-d", time()) ;
			$new_error_log_record['Error_DateTime'] = date("Y-m-d H:i:s", time()) ;
//			$new_error_log_record['User_Code'] = $this->tank_auth->get_user_code() ;
			$new_error_log_record['Severity'] = strtoupper($err_severity) ;
			$new_error_log_record['Error_Message'] = $error_message ;
			$new_error_log_record['Method'] = trim($err_method) ;
			$new_error_log_record['Line_Num'] = intval($err_line) ;
			$result = $this->db->insert( 'error_log', $new_error_log_record ) ;

			//  Get the unique key, error_log_id, of the error_log record we just inserted
			$new_error_log_id = ( $result == FALSE) ? FALSE : $this->db->insert_id();

			if ( $err_notify === TRUE )
			{
//				// send a text that an error occured
//				$sms_address = '9139527686@messaging.sprintpcs.com, 2146736702@txt.att.net';
//				$from_name = "" ;
//				$text_msg = "LAMS ERROR notification.  " . date( "n-j-Y, g:i:s a" ) . "  Error_Log_Id: " . $new_error_log_id ;
//				$from_st_addr = '';
//				$from_phone = '';
//				$end_phase = '';
//
//				$sms_result = $this->sms_lib->SendSMSMessage($sms_address, $from_name, $text_msg, $from_st_addr, $from_phone, $end_phase);
//				if( $sms_result['Result'] !== TRUE )
//				{
//					//  no error checking, we are in the error routine, we may create and infinite loop
//				}
			}

			if ( $err_display === TRUE )
			{

				// replace newlines with HTML breaklines because newlines are not visible in the database table
				//  then clean up breaklines and remove duplicates, before saving it in the table
				$user_error_message = trim(str_replace("<pre>","",$user_err_msg)) ;
				$user_error_message = trim(str_replace("</pre>","",$user_error_message)) ;
				$user_error_message = trim(str_replace("<pre/>","",$user_error_message)) ;
				$user_error_message = trim(str_replace("<br>","<br />",$user_error_message)) ;
				$user_error_message = trim(str_replace("<BR>","<br />",$user_error_message)) ;
				$user_error_message = trim(str_replace("<BR />","<br />",$user_error_message)) ;
				$user_error_message = trim(str_replace("<br /><br />","<br />",$user_error_message)) ;
				$user_error_message = trim(str_replace(chr(9),"<br />",$user_error_message)) ;
				$user_error_message = trim(str_replace(chr(10),"<br />",$user_error_message)) ;
				$user_error_message = trim(str_replace(chr(11),"<br />",$user_error_message)) ;
				$user_error_message = trim(str_replace(chr(12),"<br />",$user_error_message)) ;
				$user_error_message = trim(str_replace(chr(13),"<br />",$user_error_message)) ;
				$user_error_message = trim(str_replace('\n',"<br />",$user_error_message)) ;
				$user_error_message = trim(str_replace('\t',"<br />",$user_error_message)) ;
				$user_error_message = trim(str_replace("\n","<br />",$user_error_message)) ;
				$user_error_message = trim(str_replace("\t","<br />",$user_error_message)) ;

				//  for some reason, the following seems to be necessary to remove duplicate breaklines
				$user_error_message = trim(str_replace("<br /><br />","~~",$user_error_message)) ;
				$user_error_message = trim(str_replace("~~","<br />",$user_error_message)) ;

				//  check again
				$user_error_message = trim(str_replace("<br /><br />","~~",$user_error_message)) ;
				$user_error_message = trim(str_replace("~~","<br />",$user_error_message)) ;

				//  and one more time to be sure we've removed all duplicates
				$user_error_message = trim(str_replace("<br /><br />","~~",$user_error_message)) ;
				$user_error_message = trim(str_replace("~~","<br />",$user_error_message)) ;

				//  if $error_message begins with a breakline "<br />", remove all
				while ( substr($error_message,0,6) == "<br />")
				{
					   $user_error_message = trim(substr($user_error_message,6)) ;
				}

				//  if $error_message ends with a breakline "<br />", remove all
				while ( substr($error_message,-6) == "<br />")
				{
					   $user_error_message = trim(substr($user_error_message,0,-6)) ;
				}

				$json_result = array('Result' => FALSE, 'Error_Log_Id' => $new_error_log_id, 'Result_Message' => $error_message . '\nMethod: ' . $err_method . '\nLine: ' . $err_line . '\nTime: ' . date('n-j-Y h:i:s a', time()), 'Error_Message' => $user_err_msg);
				if( $this->input->get('callback') != FALSE )
				{
					echo $this->input->get('callback') . '(' . json_encode($json_result) . ')';
					exit;
				}
				else
				{
					echo json_encode($json_result);
					exit;
				}
			}
		}

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date( "n-j-Y h:i:s A" ) . "\n-----------------------------------------------------\n"; }

		//  return the New_Error_Log_Id to the new event
		return $new_error_log_id ;
	}




	//  This model method evaluates a value as null, empty, false, and creates a new error log entry.
	//  @Param 1:	required, variable name
	//  @Param 2:	required, variable value
	//  @Param 3:	required, parent function name
	//  @Param 4:	required, parent line number
	//  @Return:	"false" if not null, empty or false, else "true" if null, empty or false
	public function EvalVar($var_name, $value, $function_name, $line_number)
	{
		$error = FALSE;

		if( is_null($value) )
		{
			$this->NewErrorLogEntry('ERROR: ' . $var_name . ' is null. \n Method: ' . $function_name . ' Line: ' . $line_number . ' At: ' . date('m-d-Y h:i:s'));
			$error = TRUE;
		}
		if( $value == '' )
		{
			$this->NewErrorLogEntry('ERROR: ' . $var_name . ' is empty. \n Method: ' . $function_name . ' Line: ' . $line_number . ' At: ' . date('m-d-Y h:i:s'));
			$error = TRUE;
		}

		return $error;
	}



}
//  End of file error_log_model.php
//  Location: ./application/models/error_log_model.php
