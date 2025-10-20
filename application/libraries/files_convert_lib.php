<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Files convert library
*/

class Files_convert_lib
{

	var $ci;

	public function __construct()
	{
		$this->ci =& get_instance();
	}




	// This library method will send a file to be converted to PDF; If it is converted it will
	// then be retreived from the conversion server and saved to disk. Then returned back with the converted path and file name.
	// If nothing specified for return, then a randomly created name will be used and a .pdf type document (initially only .pdf).
	// @Param 1:	required, filename to convert to PDF
	// @Param 2:	optional, the path and name of the resulting document (also specifies file type)  (initially not used)
	// @Return:    ASSOC Array, Result => false is failure, and Result => true, File_Name => {file_name} is conversion successufl.
	public function Convert2($filename, $doc_path_name = NULL)
	{
		//  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo
		$test = FALSE ;
		if(DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------"; }
		if(DEBUG && $test)  { echo "\nfunc_get_args(): ";  print_r(func_get_args(), FALSE);  echo "\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------\n"; }

		$ci =& get_instance();

		$num_args_expected = 2 ;
		$error = ( func_num_args() < $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($template_name) );   $err_msg = "\$template_name is empty.  func_get_args(): " . print_r(func_get_args(),TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($template_variables_array) );   $err_msg = "\$template_variables_array is empty.  func_get_args(): " . print_r(func_get_args(),TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( substr_count($template_name,".") !== 1 );   $err_msg = "\$template_name does not have a single period, either zero or more than one.  \$template_name:  $template_name"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		// initialize template data
		$new_file_name_bomb = explode('.', $template_name);
		$new_file_name = ( is_array($new_file_name_bomb) && isset($new_file_name_bomb[0]) ) ? $new_file_name_bomb[0] : '';
		$new_file_ext = ( is_array($new_file_name_bomb) && isset($new_file_name_bomb[1]) ) ? '.' . $new_file_name_bomb[1] : '';

		$error = ( empty($new_file_name) );   $err_msg = "\$new_file_name is empty.  func_get_args(): " . print_r(func_get_args(),TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($new_file_ext) );   $err_msg = "\$new_file_ext is empty.  func_get_args(): " . print_r(func_get_args(),TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}



		$max_retries = 3 ;  // this is how many times we can get an error and retry before logging an error and stopping execution
		$attempts_cnt = 1 ;   // this is a counter of how many times we erred
		$try_again = TRUE ;  // if we complete successfully, this will be set to FALSE at end of code in loop,  it either completes or exits with an error

		while ( $try_again === TRUE )
		{
			$return = $this->SendFileToBeConverted2($filename);
			$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid return array from \$this->SendFileToBeConverted2  \$return: \n" . print_r($return,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			if ( (empty($return['Result']) || ($return['Result'] !== TRUE)) && ($attempts_cnt <= $max_retries) )
			{
				$error = ( TRUE );   $err_msg = "\$this->SendFileToBeConverted2 returned a result of false.  Will retry.  This was attempt number $attempts_cnt."; $notify = FALSE;   $severity = "WARNING";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				 // if the command failed to execute properly, but we have not exceeded our max retries, try again
				$attempts_cnt++ ;  // increment counter of attempts
				continue;   //  go back to the top of the loop and try again, unless we have exceeded our max_retries
			}
			else
			{
				//  if we have exceeded our max retries, then check if we need to log an error and stop execution
				$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			}

			$return = $this->GetConvertedFile2($merged_doc_name);
			$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->GetConvertedFile2  \$return: \n" . print_r($return,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			if ( (empty($return['Result']) || ($return['Result'] !== TRUE)) && ($attempts_cnt <= $max_retries) )
			{
				$error = ( TRUE );   $err_msg = "\$this->GetConvertedFile2 returned a result of false.  Will retry.  This was attempt number $attempts_cnt."; $notify = FALSE;   $severity = "WARNING";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				 // if the command failed to execute properly, but we have not exceeded our max retries, try again
				$attempts_cnt++ ;  // increment counter of attempts
				continue;   //  go back to the top of the loop and try again, unless we have exceeded our max_retries
			}
			else
			{
				//  if we have exceeded our max retries, then check if we need to log an error and stop execution
				$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			}

			$converted_filename = $return['Filename'];

			//  if we get here, we completed this successfully and we do not need to try the loop again
			$try_again = FALSE ;
		}

		// if we get here the method has completed successfully, wrap up and return results array
		$results_array = array();
		$results_array['Result'] = TRUE;
		$results_array['File_Name'] = $converted_filename ;
		$results_array['File_Path_Name'] = "" ; // this is not currently use, will be used in the future
		$results_array['File_Type'] = ".pdf" ; // this is the only type this method currently returns
		$results_array['Result_Message'] = "Executed successfully.\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date( "n-j-Y, g:i:s a" ) ;

		if  (DEBUG && $test)  { echo "\n------------------------ RETURN/RESULTS ARRAY -----------------------------\n";   print_r($results_array,FALSE);  echo "\n-----------------------------------------------------\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------"; }

		if (DEBUG && $test)  { echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date( "n-j-Y, g:i:s a" ) . "\n-----------------------------------------------------"; }

		return $results_array ;
	}


	// This library method will convert a template with given variable data. Then send it to be converted; If it is converted it will
	// then be retreived from the conversion server and saved to the web server disk. Then returned back with the converted path file name.
	// @Param 1:	required, template name
	// @Param 2:	required, assoc array template variables array
	// @Return:		ASSOC Array, Result => false is failure, and Result => true, File_Name => {file_name} is conversion successufl.
	public function ConvertUnix2($template_name, $template_variables_array)
	{

		//  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo
		$test = FALSE ;
		if(DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------"; }
		if(DEBUG && $test)  { echo "\nfunc_get_args(): ";  print_r(func_get_args(), FALSE);  echo "\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------\n"; }

		$ci =& get_instance();
		$ci->load->config('documents');

		$num_args_expected = 2 ;
		$error = ( func_num_args() < $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($template_name) );   $err_msg = "\$template_name is empty.  func_get_args(): " . print_r(func_get_args(),TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($template_variables_array) );   $err_msg = "\$template_variables_array is empty.  func_get_args(): " . print_r(func_get_args(),TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( substr_count($template_name,".") !== 1 );   $err_msg = "\$template_name does not have a single period, either zero or more than one.  \$template_name:  $template_name"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		// initialize template data
		$new_file_name_bomb = explode('.', $template_name);
		$new_file_name = ( is_array($new_file_name_bomb) && isset($new_file_name_bomb[0]) ) ? $new_file_name_bomb[0] : '';
		$new_file_ext = ( is_array($new_file_name_bomb) && isset($new_file_name_bomb[1]) ) ? '.' . $new_file_name_bomb[1] : '';
		$error = ( empty($new_file_name) );   $err_msg = "\$new_file_name is empty.  \$template_name:  $template_name"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($new_file_ext) );   $err_msg = "\$new_file_ext is empty. .  \$template_name:  $template_name"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}


		// 1. merge document .. 2nd arg is the new output file name

		$return = $this->MergeTemplate2($template_name, $new_file_name, $new_file_ext, $template_variables_array, true);
		if(DEBUG && $test) { echo "---------------------------------------\n MergeTemplate():"; print_r($return);}
		$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->MergeTemplate \$return: \n" . print_r($return,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !isset($return['Filename']) || empty($return['Filename']) );   $err_msg = " \$return[Filename] is not set or empty. \$this->MergeTemplate \$return: \n" . print_r($return,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$merged_filename = $return['Filename']; // the finished merged document name without the path
		$merged_path_filename = $ci->config->item('DOC_TEMPLATES_OUTPUT_DIR') . DIRECTORY_SEPARATOR . $merged_filename;
		$error = (  file_exists($merged_path_filename) == FALSE );   $err_msg = " \$merged_filename does not exist. \nFilename: $merged_path_filename \$this->MergeTemplate \$return: \n" . print_r($return,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}


		// 2. send document to be converted

		$return = $this->ConvertDocumentToPdf2($merged_filename);
		if(DEBUG && $test) { echo "---------------------------------------\n ConvertDocumentToPdf():"; print_r($return);}
		$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->ConvertDocumentToPdf \$return: \n" . print_r($return,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !isset($return['Filename']) || empty($return['Filename']) );   $err_msg = " \$return[Filename] is not set or empty. \$this->ConvertDocumentToPdf \$return: \n" . print_r($return,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$converted_filename = $return['Filename']; // the finished converted document name without the path
		$converted_path_filename = $ci->config->item('DOC_CONVERTED_DIR') . DIRECTORY_SEPARATOR . $converted_filename;
		$error = (  file_exists($converted_path_filename) == FALSE );   $err_msg = " \$converted_filename does not exist. \nFilename: $converted_filename \$this->MergeTemplate \$return: \n" . print_r($return,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}


		// if we get here the method has completed successfully, wrap up and return results array
		$results_array = array();
		$results_array['Result'] = TRUE;
		$results_array['Filename'] = $converted_filename;
		$results_array['Result_Message'] = "Executed successfully.";

		if  (DEBUG && $test)  { echo "\n------------------------ RETURN/RESULTS ARRAY -----------------------------\n";   print_r($results_array,FALSE);  echo "\n-----------------------------------------------------\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------"; }

		if (DEBUG && $test)  { echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date( "n-j-Y, g:i:s a" ) . "\n-----------------------------------------------------"; }

		return $results_array ;
	}


	// This library method will convert any type of file to pdf by sending it to the conversion server. If it is converted it will
	// then be retreived from the conversion server and saved to the web server disk. Then returned back with the converted path file name.
	// @Param 1:	required, $draft_path_name
	// @Return:    ASSOC Array, Result => false is failure, and Result => true, File_Name => {file_name} if conversion successufl.
	public function ConvertDraft2($draft_path_name)
	{
		//  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo
		$test = FALSE ;
		if(DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------"; }
		if(DEBUG && $test)  { echo "\nfunc_get_args(): ";  print_r(func_get_args(), FALSE);  echo "\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------\n"; }

		$ci =& get_instance();

		$num_args_expected = 1 ;
		$error = ( func_num_args() < $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($template_name) );   $err_msg = "\$template_name is empty.  func_get_args(): " . print_r(func_get_args(),TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( file_exists($template_variables_array) === FALSE);   $err_msg = "\$template_variables_array is empty.  func_get_args(): " . print_r(func_get_args(),TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( substr_count($template_name,".") !== 1 );   $err_msg = "\$template_name does not have a single period, either zero or more than one.  \$template_name:  $template_name"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$this->CI->load->config('documents');

		if( is_null($draft_path_name) ) return array('Result' => FALSE, 'Result_Mesage' => 'ERROR: $draft_path_name is null (Method: ' . __METHOD__ . ' ine: ' . __LINE__ . ')');
		if( empty($draft_path_name) ) return array('Result' => FALSE, 'Result_Mesage' => 'ERROR: $draft_path_name is empty (Method: ' . __METHOD__ . ' ine: ' . __LINE__ . ')');

		$templates_output_dir = $this->CI->config->item('DOC_TEMPLATES_OUTPUT_DIR');
		$draft_file_name = basename($draft_path_name);
		$copy_result = copy($draft_path_name, $templates_output_dir . DIRECTORY_SEPARATOR . $draft_file_name);

		$send_doc_result = $this->SendFileToBeConverted($draft_file_name);
		if(DEBUG && $test) { echo "<pre>Send Doc Result:"; print_r( $send_doc_result); echo "</pre>"; }

		// 3. get converted document in pdf form [we pause, then continue to check and pause until we get it or time expires]
		$wait = 3 ;   //  time to wait (seconds) for first wait period
		$total_wait = 0 ;     //  initialize value
		$get_doc_result = array() ;
		$get_doc_result['Result'] = FALSE ;     //  initialize value
		while ( ( $get_doc_result['Result'] == FALSE ) && ( $total_wait < 30 ) )
		{
			sleep($wait);   //  snoring
			$total_wait = $total_wait + $wait ;     //  track total time waiting, avoid want infinite loop
			$get_doc_result = $this->GetConvertedFile($draft_file_name);
			$wait = 2 ;   //  time to wait for each consecutive wait period
		}

		if($get_doc_result['Result'] == TRUE)
		{
			$converted_file_name = $get_doc_result['File_Name'];
			return array('Result' => TRUE, 'File_Name' => $converted_file_name, 'Result_Message' => "Executed Successfully!");
		}
		 else
		{
			return array('Result' => FALSE, 'Result_Message' => $get_doc_result['Result_Message']);
		}

		// if we get here the method has completed successfully, wrap up and return results array
		$results_array = array();
		$results_array['Result'] = TRUE;
		$results_array['Result_Message'] = "Executed successfully.";

		if  (DEBUG && $test)  { echo "\n------------------------ RETURN/RESULTS ARRAY -----------------------------\n";   print_r($results_array,FALSE);  echo "\n-----------------------------------------------------\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------"; }

		if (DEBUG && $test)  { echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date( "n-j-Y, g:i:s a" ) . "\n-----------------------------------------------------"; }

		return $results_array;

	}


	// This library method will merge a odt document with a template using the provided variables in an assoc. array
	// @Param 1:	required, template to merge with [located in /home/imports/templates/ directory]
	// @Param 2:	required, the finished .odt document filename to save
	// @Param 3:	required, the file extension
	// @Param 4:	required, assoc. array of template variables and variable values
	// @Param 5:	optional, true=save file to disk, false=force download of file to user browser session, 2=return xml content
	// @Return:		VOID, instead prompt user to download merged .odt document
	public function MergeTemplate2($template, $output_file_name, $file_type_ext, $template_variables_array, $save_to_disk = true, $extended_template_dir = NULL)
	{
		//  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo
		$test = FALSE ;
		if(DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------"; }
		if(DEBUG && $test)  { echo "\nfunc_get_args(): ";  print_r(func_get_args(), FALSE);  echo "\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------\n"; }

		$ci =& get_instance();

		$num_args_expected = 5 ;
		$error = ( func_num_args() < $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($template) );   $err_msg = "\$template is empty.  func_get_args(): " . print_r(func_get_args(),TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($output_file_name) );   $err_msg = "\$output_file_name is empty.  func_get_args(): " . print_r(func_get_args(),TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($file_type_ext) );   $err_msg = "\$file_type_ext is empty.  func_get_args(): " . print_r(func_get_args(),TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($template_variables_array) );   $err_msg = "\$template_variables_array is empty.  func_get_args(): " . print_r(func_get_args(),TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( $save_to_disk == "" );   $err_msg = "\$save_to_disk is empty.  func_get_args(): " . print_r(func_get_args(),TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}


		$ci =& get_instance();
		$ci->load->library('document_template_lib');
		$ci->load->config('documents');

		// template variables array structure (multi demensional assoc. array)
		// Var_Name => "Title"  				<-- template variable name
		// Var_Value => "Corey's Title" 		<-- template variable value


		// set common data
		$today_date = date('m-d-Y_h-i-s', time()); // today's date formatted for filename
		$rand =  rand(1,999999999) .'_'. rand(1,999999999) . '_' . date('m-d-Y_h-i-s', time()); // random number and date/time to be used with unique filename
		$template_directory = $ci->config->item('DOC_TEMPLATES_DIR'); // create odf object and specify template we want to use

		$filename_odt = $template;
		$result = $ci->document_template_lib->OpenTemplate2($filename_odt, $template_variables_array, $extended_template_dir);
		$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$ci->document_template_lib->OpenTemplate2  \$return: \n" . print_r($result,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($result['XML_Content']) );   $err_msg = "\$result[XML_Content] is not set or empty." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		// set the xml content from the call above
		$xml_content = $result['XML_Content'];

		// populate template variables
		foreach($template_variables_array as $var_data)
		{
			unset($field_name);
			unset($field_value);
			unset($result);
			$field_name = ( isset($var_data['Field_Name']) ) ? $var_data['Field_Name'] : '';
			$field_value = ( isset($var_data['Field_Value']) ) ? $var_data['Field_Value'] : '';
			$result = $ci->document_template_lib->SetVar2($var_data['Field_Name'], $var_data['Field_Value']);
		}

		// force download of odt file, or save to disk
		$source_path = $ci->config->item('DOC_TEMPLATES_OUTPUT_DIR');
		$new_filename = $output_file_name . "_" . $rand . $file_type_ext;
		$source_path_file = $source_path . DIRECTORY_SEPARATOR . $new_filename;

		$results_array = array();

		$save_file_to_disk = 0 ;  // default to zero/false
		$return_file_contents = 0 ;  // default to zero/false
		$prompt_user_to_download_file = 0 ;  // default to zero/false

		if( $save_to_disk == TRUE )
		{
			$result = $ci->document_template_lib->SaveToDisk2($source_path_file);
			$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$ci->document_template_lib->SaveToDisk2  \$return: \n" . print_r($result,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			
			
			
			$save_file_to_disk = 1 ;
			$xml_content = "" ;
		}
		elseif( is_int($save_to_disk) && ($save_to_disk == 2) )
		{
			unset($xml_content);
			$xml_content = $ci->document_template_lib->GetXmlContent2();

			$return_file_contents = 1 ;
			$new_filename = "" ;
			$source_path_file = "" ;
		}
	 	else  // prompt user to download file
		{
			$ci->document_template_lib->ExportAsAttachedFile2($new_filename);

			$prompt_user_to_download_file = 1 ;  // set to 1/true
			$new_filename = "" ;
			$source_path_file = "" ;
			$xml_content = "" ;
		}


		// if we get here the method has completed successfully, wrap up and return results array
		$results_array = array();
		$results_array['Result'] = TRUE;
		$results_array['Save_File_To_Disk'] = $save_file_to_disk ;
		$results_array['Filename'] = $new_filename ;
		$results_array['Path_Filename'] = $source_path_file ;
		$results_array['Return_File_Contents'] = $return_file_contents ;
		$results_array['XML_Content'] = $xml_content ;
		$results_array['Prompt_User_To_Download_File'] = $prompt_user_to_download_file ;
		$results_array['Result_Message'] = "Executed successfully.\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date( "n-j-Y, g:i:s a" ) ;

		if  (DEBUG && $test)  { echo "\n------------------------ RETURN/RESULTS ARRAY -----------------------------\n";   print_r($results_array,FALSE);  echo "\n-----------------------------------------------------\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------"; }

		if (DEBUG && $test)  { echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date( "n-j-Y, g:i:s a" ) . "\n-----------------------------------------------------"; }

		return $results_array;
	}


	// This library method will send a merged template file to win.lamsonline.org to be converted to a pdf
	// @Param 1:	required, merged file name residing in the DOC_TEMPLATES_OUTPUT_DIR directory
	// @Param 2:	optional, what type of conversion. default is 'CONVERT' [CONVERT=regular conversion, SECURE=secure convert, add watermark]
	// @Return:		ASSOC ARRAY [Result = TRUE if success and returns merged {File_Name}, Result = FALSE if failure]
	public function SendFileToBeConverted2($merged_file_name, $type = 'CONVERT')
	{
		//  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo
		$test = FALSE ;
		if(DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------"; }
		if(DEBUG && $test)  { echo "\nfunc_get_args(): ";  print_r(func_get_args(), FALSE);  echo "\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------\n"; }

		$num_args_expected = 1 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($merged_file_name) );   $err_msg = "\$merged_file_name is empty.  func_get_args(): " . print_r(func_get_args(),TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($type) );   $err_msg = "\$type is empty.  func_get_args(): " . print_r(func_get_args(),TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$ci =& get_instance();
		$ci->load->config('documents');

		$win_imports_host = $ci->config->item('WIN_IMPORTS_HOST');
		$win_imports_user = $ci->config->item('WIN_IMPORTS_USER');
		$win_imports_pass = $ci->config->item('WIN_IMPORTS_PASSWORD');

		if( strtoupper($type) == 'CONVERT' )
		{
			$win_imports_input_source = $ci->config->item('WIN_IMPORTS_INPUT_DIR');
		}
		elseif( strtoupper($type) == 'SECURE' )
		{
			$win_imports_input_source = $ci->config->item('WIN_IMPORTS_SECURE_INPUT_DIR');
		}
		else
		{
			$win_imports_input_source = $ci->config->item('WIN_IMPORTS_INPUT_DIR');
		}

		$templates_source = $ci->config->item("DOC_TEMPLATES_DIR");
		$templates_output_source = $ci->config->item("DOC_TEMPLATES_OUTPUT_DIR");
		$templates_converted_source = $ci->config->item("DOC_CONVERTED_DIR");

		// local path and file to be put to win.lamsonline.org
		$local_path = $templates_output_source;
		$local_path_and_file = $local_path . DIRECTORY_SEPARATOR . $merged_file_name;
		$remote_path = $win_imports_input_source;
		$remote_path_and_file = $remote_path . DIRECTORY_SEPARATOR . $merged_file_name;

		$error = ( file_exists($local_path_and_file) === FALSE );   $err_msg = "The file does not exist on the local server. \$local_path_and_file: $local_path_and_file."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$max_retries = 5 ;  // this is how many times we can get an error and retry before logging an error and stopping execution
		$attempts_cnt = 1 ;   // this is a counter of how many times we erred
		$try_again = TRUE ;  // if we complete successfully, this will be set to FALSE at end of code in loop,  it either completes or exits with an error

		while ( $try_again === TRUE )
		{
			unset($ftp_connect) ;
			unset($ftp_login) ;
			unset($ftp_pasv) ;
			unset($remote_files_list) ;
			unset($ftp_put) ;
			unset($ftp_close) ;

			// connect to conversion/imports win.lamsonline server
			$ftp_connect = @ftp_connect($win_imports_host, 21, 90);
			if ( ($ftp_connect == FALSE) && ($attempts_cnt <= $max_retries) )
			{
				$error = ( TRUE );   $err_msg = "The ftp_connect erred. \$ftp_connect returned false.  Will retry.  This was attempt number $attempts_cnt."; $notify = FALSE;   $severity = "NOTICE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				 // if the command failed to execute properly, but we have not exceeded our max retries, try again
				$attempts_cnt++ ;  // increment counter of attempts
				$ftp_close = @ftp_close($ftp_connect);  // just in case a connection is open, try to close it
				continue;   //  go back to the top of the loop and try again, unless we have exceeded our max_retries
			}
			else
			{
				//  if we have exceeded our max retries, then check if we need to log an error and stop execution
				$error = ( $ftp_connect == FALSE );   $err_msg = "The ftp_connect erred. \$ftp_connect returned false."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			}

			$ftp_login = @ftp_login($ftp_connect, $win_imports_user, $win_imports_pass);
			if ( ($ftp_login == FALSE) && ($attempts_cnt <= $max_retries) )
			{
				$error = ( TRUE );   $err_msg = "The ftp_login erred. \$ftp_login returned false.  Will retry.  This was attempt number $attempts_cnt."; $notify = FALSE;   $severity = "NOTICE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				 // if the command failed to execute properly, but we have not exceeded our max retries, try again
				$attempts_cnt++ ;  // increment counter of attempts
				$ftp_close = @ftp_close($ftp_connect);  // just in case a connection is open, try to close it
				continue;   //  go back to the top of the loop and try again, unless we have exceeded our max_retries
			}
			else
			{
				//  if we have exceeded our max retries, then check if we need to log an error and stop execution
				$error = ( $ftp_login == FALSE );   $err_msg = "The ftp_login erred. \$ftp_login returned false."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			}

			$ftp_pasv = @ftp_pasv($ftp_connect, TRUE);
			if ( ($ftp_pasv == FALSE) && ($attempts_cnt <= $max_retries) )
			{
				$error = ( TRUE );   $err_msg = "The ftp_pasv erred. \$ftp_pasv returned false.  Will retry.  This was attempt number $attempts_cnt."; $notify = FALSE;   $severity = "NOTICE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				 // if the command failed to execute properly, but we have not exceeded our max retries, try again
				$attempts_cnt++ ;  // increment counter of attempts
				$ftp_close = @ftp_close($ftp_connect);  // just in case a connection is open, try to close it
				continue;   //  go back to the top of the loop and try again, unless we have exceeded our max_retries
			}
			else
			{
				//  if we have exceeded our max retries, then check if we need to log an error and stop execution
				$error = ( $ftp_pasv == FALSE );   $err_msg = "The ftp_pasv erred. \$ftp_pasv returned false."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			}

			$remote_files_list = @ftp_nlist($ftp_connect, $remote_path);
			if ( ($remote_files_list === FALSE) && ($attempts_cnt <= $max_retries) )
			{
				$error = ( TRUE );   $err_msg = "The ftp_nlist erred. \$ftp_nlist returned false.  Will retry.  This was attempt number $attempts_cnt."; $notify = FALSE;   $severity = "NOTICE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				 // if the command failed to execute properly, but we have not exceeded our max retries, try again
				$attempts_cnt++ ;  // increment counter of attempts
				$ftp_close = @ftp_close($ftp_connect);  // just in case a connection is open, try to close it
				continue;   //  go back to the top of the loop and try again, unless we have exceeded our max_retries
			}
			else
			{
				//  if we have exceeded our max retries, then check if we need to log an error and stop execution
				$error = ( $remote_files_list === FALSE );   $err_msg = "The ftp_nlist erred. \$ftp_nlist returned false."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			}

			// verify the file does NOT already exist in the destination location
//			$error = ( in_array($merged_file_name, $remote_files_list) == TRUE );   $err_msg = "It appears the file already exists on the ftp site.  \n\$remote_path_and_file:  $remote_path_and_file"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

			// send/put file to be converted
			$ftp_put = @ftp_put($ftp_connect, $remote_path_and_file, $local_path_and_file, FTP_BINARY, 0);
			if ( ($ftp_put === FALSE) && ($attempts_cnt <= $max_retries) )
			{
				$error = ( TRUE );   $err_msg = "Putting the file to the remote server failed. \$ftp_put returned false.  Will retry.  This was attempt number $attempts_cnt."; $notify = FALSE;   $severity = "NOTICE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				 // if the command failed to execute properly, but we have not exceeded our max retries, try again
				$attempts_cnt++ ;  // increment counter of attempts
				$ftp_close = @ftp_close($ftp_connect);  // just in case a connection is open, try to close it
				continue;   //  go back to the top of the loop and try again, unless we have exceeded our max_retries
			}
			else
			{
				//  if we have exceeded our max retries, then check if we need to log an error and stop execution
				$error = ( $ftp_put === FALSE );   $err_msg = "Putting the file to the remote server failed. \$ftp_put returned false."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			}

			// verify the ftp_put by confirming the file exists in the destination location
			$remote_files_list = @ftp_nlist($ftp_connect, $remote_path);
			if ( ($remote_files_list === FALSE) && ($attempts_cnt <= $max_retries) )
			{
				$error = ( TRUE );   $err_msg = "The ftp_nlist erred. \$ftp_nlist returned false.  Will retry.  This was attempt number $attempts_cnt."; $notify = FALSE;   $severity = "NOTICE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				 // if the command failed to execute properly, but we have not exceeded our max retries, try again
				$attempts_cnt++ ;  // increment counter of attempts
				$ftp_close = @ftp_close($ftp_connect);  // just in case a connection is open, try to close it
				continue;   //  go back to the top of the loop and try again, unless we have exceeded our max_retries
			}
			else
			{
				//  if we have exceeded our max retries, then check if we need to log an error and stop execution
				$error = ( $remote_files_list === FALSE );   $err_msg = "The ftp_nlist erred. \$ftp_nlist returned false."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			}

			// verify the file DOES exist in the destination location
			$error = ( in_array($merged_file_name, $remote_files_list) === FALSE );   $err_msg = "It appears the file does not exist on the ftp site.  \n\$remote_path_and_file:  $remote_path_and_file"; $notify = TRUE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			unset($remote_files_list) ;

			$ftp_close = @ftp_close($ftp_connect);
			// do not stop execution if the close fails, just log, so do not retry multiple times either
			$error = ( $ftp_close === FALSE );   $err_msg = "Closing the ftp_close failed. \$ftp_close returned false."; $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

			//  if we get here, we completed this successfully and we do not need to try the loop again
			$try_again = FALSE ;
		}


		// if we get here the method has completed successfully, wrap up and return results array
		$results_array = array();
		$results_array['Result'] = TRUE;
		$results_array['File_Name'] = $merged_file_name;
		$results_array['Local_Path_Filename'] = $local_path_and_file;
		$results_array['Remote_Path_Filename'] = $remote_path_and_file;
		$results_array['Result_Message'] = "Executed successfully.\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date( "n-j-Y, g:i:s a" ) ;

		if  (DEBUG && $test)  { echo "\n------------------------ RETURN/RESULTS ARRAY -----------------------------\n";   print_r($results_array,FALSE);  echo "\n-----------------------------------------------------\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------"; }

		if (DEBUG && $test)  { echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date( "n-j-Y, g:i:s a" ) . "\n-----------------------------------------------------"; }

		return $results_array;
	}


	// This library method will download a converted merged document from the conversion server win.lamsonline
	// @Param 1:	required, file name to be downloaded from conversion server
	// @Return:		ASSOC ARRAY [Result = TRUE if file exists on conversion server and downloaded correctly, {File_Name} return
	//				of downloaded file, Result = FALSE if failure]
	public function GetConvertedFile2($filename, $type = 'CONVERT')
	{
		//  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo
		$test = FALSE ;
		if(DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------"; }
		if(DEBUG && $test)  { echo "\nfunc_get_args(): ";  print_r(func_get_args(), FALSE);  echo "\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------\n"; }
		$num_args_expected = 1 ;
		$error = ( func_num_args() < $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($filename) );   $err_msg = "\$filename is empty.  func_get_args(): " . print_r(func_get_args(),TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($type) );   $err_msg = "\$type is empty.  func_get_args(): " . print_r(func_get_args(),TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$ci =& get_instance();
		$ci->load->config('documents');

		// set the windows ftp credentials and path to upload directory.
		// the upload directory depends on the type of document we want to convert.
		// CONVERT | SECURE
		$win_imports_host = $ci->config->item('WIN_IMPORTS_HOST');
		$win_imports_user = $ci->config->item('WIN_IMPORTS_USER');
		$win_imports_pass = $ci->config->item('WIN_IMPORTS_PASSWORD');

		if( strtoupper($type) == 'CONVERT' )
		{
			$win_imports_output_path = $ci->config->item('WIN_IMPORTS_OUTPUT_DIR');
		}
		elseif( strtoupper($type) == 'SECURE' )
		{
			$win_imports_output_path = $ci->config->item('WIN_IMPORTS_SECURE_OUTPUT_DIR');
		}
		else
		{
			$win_imports_output_path = $ci->config->item('WIN_IMPORTS_OUTPUT_DIR');
		}

		$templates_converted_path = $ci->config->item("DOC_CONVERTED_DIR"); // download directory

		// source path and file to be downloaded from win.lamsonline.org
		$filename_base = basename($filename, '.odt');
		$unique_postfix =  rand(1,999999999) . '_' . date('m-d-Y_h-i-s', time()); // random number and date/time to create a unique string
		$filename_pdf = "$filename_base.pdf";
		$local_filename_pdf = $filename_pdf;

		$local_path = $templates_converted_path;
		$local_path_and_file = $local_path . DIRECTORY_SEPARATOR . $local_filename_pdf;
		$remote_path = $win_imports_output_path;
		$remote_path_and_file = $remote_path . DIRECTORY_SEPARATOR . $filename_pdf;

		$error = ( file_exists($local_path_and_file) === TRUE );   $err_msg = "The file already exists on the local server. \n\$local_path_and_file: $local_path_and_file"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$max_retries = 5 ;  // this is how many times we can get an error and retry before logging an error and stopping execution
		$attempts_cnt = 1 ;   // this is a counter of how many times we erred
		$try_again = TRUE ;  // if we complete successfully, this will be set to FALSE at end of code in loop,  it either completes or exits with an error

		$retrieved_converted_file = FALSE;  // initialize with default value

		while ( $try_again === TRUE )
		{
			unset($ftp_connect) ;
			unset($ftp_login) ;
			unset($ftp_pasv) ;
			unset($remote_files_list) ;
			unset($ftp_put) ;
			unset($ftp_close) ;

			// connect to conversion/imports win.lamsonline server
			$ftp_connect = @ftp_connect($win_imports_host, 21, 90);
			if ( ($ftp_connect == FALSE) && ($attempts_cnt <= $max_retries) )
			{
				$error = ( TRUE );   $err_msg = "The ftp_connect erred. \$ftp_connect returned false.  Will retry.  This was attempt number $attempts_cnt."; $notify = FALSE;   $severity = "NOTICE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				 // if the command failed to execute properly, but we have not exceeded our max retries, try again
				$attempts_cnt++ ;  // increment counter of attempts
				$ftp_close = @ftp_close($ftp_connect);  // just in case a connection is open, try to close it
				continue;   //  go back to the top of the loop and try again, unless we have exceeded our max_retries
			}
			else
			{
				//  if we have exceeded our max retries, then check if we need to log an error and stop execution
				$error = ( $ftp_connect === FALSE );   $err_msg = "The ftp_connect erred. \$ftp_connect returned false."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			}

			$ftp_login = @ftp_login($ftp_connect, $win_imports_user, $win_imports_pass);
			if ( ($ftp_login == FALSE) && ($attempts_cnt <= $max_retries) )
			{
				$error = ( TRUE );   $err_msg = "The ftp_login erred. \$ftp_login returned false.  Will retry.  This was attempt number $attempts_cnt."; $notify = FALSE;   $severity = "NOTICE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				 // if the command failed to execute properly, but we have not exceeded our max retries, try again
				$attempts_cnt++ ;  // increment counter of attempts
				$ftp_close = @ftp_close($ftp_connect);  // just in case a connection is open, try to close it
				continue;   //  go back to the top of the loop and try again, unless we have exceeded our max_retries
			}
			else
			{
				//  if we have exceeded our max retries, then check if we need to log an error and stop execution
				$error = ( $ftp_login === FALSE );   $err_msg = "The ftp_login erred. \$ftp_login returned false."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			}

			$ftp_pasv = @ftp_pasv($ftp_connect, TRUE);
			if ( ($ftp_pasv == FALSE) && ($attempts_cnt <= $max_retries) )
			{
				$error = ( TRUE );   $err_msg = "The ftp_pasv erred. \$ftp_pasv returned false.  Will retry.  This was attempt number $attempts_cnt."; $notify = FALSE;   $severity = "NOTICE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				// if the command failed to execute properly, but we have not exceeded our max retries, try again
				$attempts_cnt++ ;  // increment counter of attempts
				$ftp_close = @ftp_close($ftp_connect);  // just in case a connection is open, try to close it
				continue;   //  go back to the top of the loop and try again, unless we have exceeded our max_retries
			}
			else
			{
				//  if we have exceeded our max retries, then check if we need to log an error and stop execution
				$error = ( $ftp_pasv === FALSE );   $err_msg = "The ftp_pasv erred. \$ftp_pasv returned false."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			}

			$max_wait_minutes = 2.5 ;   //  maximum time to wait to get file back, in minutes
			$total_wait_secs = 0 ;     //  number of seconds the process has been waiting, start at zero
			$pause_secs = 3 ;  // number of seconds to pause between each check
			$warning_secs = 10 ;  // number of seconds after which this becomes an unusually long time
			$retrieved_converted_file = FALSE ;     //  initialize value
			while ( ($retrieved_converted_file === FALSE) && ($total_wait_secs < ($max_wait_minutes*60)) )
			{
				sleep($pause_secs);   //  pause first to allow conversion program to convert the file, then we will pause again each time back around the loop if we fail
				$total_wait_secs += $pause_secs ;     //  track total time waiting, avoid want infinite loop

				unset($remote_files_list) ;
				$remote_files_list = @ftp_nlist($ftp_connect, $remote_path);
				if ( ($remote_files_list === FALSE) && ($attempts_cnt <= $max_retries) )
				{
					$error = ( TRUE );   $err_msg = "The ftp_nlist erred. \$ftp_nlist returned false.  Will retry.  This was attempt number $attempts_cnt."; $notify = FALSE;   $severity = "NOTICE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
					 // if the command failed to execute properly, but we have not exceeded our max retries, try again
					$attempts_cnt++ ;  // increment counter of attempts
					$ftp_close = @ftp_close($ftp_connect);  // just in case a connection is open, try to close it
					continue 2;   //  go back to the top of the main loop and try again, unless we have exceeded our max_retries
				}
				else
				{
					//  if we have exceeded our max retries, then check if we need to log an error and stop execution
					$error = ( $remote_files_list === FALSE );   $err_msg = "The ftp_nlist erred. \$ftp_nlist returned false."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				}

				//  if the file does not exist on the remote ftp site, assume it is not ready, wait and try again
				$retrieved_converted_file = ( in_array($filename_pdf, $remote_files_list) ) ? TRUE : FALSE;

				unset($remote_files_list) ;
			}
			$error = ( $retrieved_converted_file === FALSE );   $err_msg = "Unable to retrieve a document from the windows pdf converter. \n\$filename_pdf:  $filename_pdf \n\$total_wait_secs: $total_wait_secs"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

			// if we retrieved our file, but it took an unusually long time, log that as a warning
			$error = ( ($retrieved_converted_file == TRUE) && ($total_wait_secs > $warning_secs) );   $err_msg = "It took an unusually long time (longer than $warning_secs seconds) to retrieve the converted pdf file. \n\$filename_pdf:  $filename_pdf \n\$total_wait_secs: $total_wait_secs"; $notify = FALSE;   $severity = "WARNING";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

			$ftp_get = ftp_get($ftp_connect, $local_path_and_file, $remote_path_and_file, FTP_BINARY, 0);
			if ( ($ftp_get === FALSE) && ($attempts_cnt <= $max_retries) )
			{
				$error = ( TRUE );   $err_msg = "The ftp_get erred. \$ftp_get returned false.  Will retry.  This was attempt number $attempts_cnt."; $notify = FALSE;   $severity = "NOTICE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				 // if the command failed to execute properly, but we have not exceeded our max retries, try again
				$attempts_cnt++ ;  // increment counter of attempts
				$ftp_close = @ftp_close($ftp_connect);  // just in case a connection is open, try to close it
				continue;   //  go back to the top of the loop and try again, unless we have exceeded our max_retries
			}
			else
			{
				//  if we have exceeded our max retries, then check if we need to log an error and stop execution
				$error = ( $ftp_get === FALSE );   $err_msg = "The ftp_get erred. \$ftp_get returned false."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			}


			// we downloaded the file, now lets clean up the remote server and delete the remote source because it will never be used again
			$ftp_delete = ftp_delete($ftp_connect, $remote_path_and_file);
			if ( ($ftp_delete == FALSE) && ($attempts_cnt <= $max_retries) )
			{
				$error = ( TRUE );   $err_msg = "The ftp_delete erred. \$ftp_delete returned false.  Will retry.  This was attempt number $attempts_cnt."; $notify = FALSE;   $severity = "NOTICE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				 // if the command failed to execute properly, but we have not exceeded our max retries, try again
				$attempts_cnt++ ;  // increment counter of attempts
				$ftp_close = @ftp_close($ftp_connect);  // just in case a connection is open, try to close it
				continue;   //  go back to the top of the loop and try again, unless we have exceeded our max_retries
			}
			else
			{
				//  if we have exceeded our max retries, then check if we need to log an error and stop execution
				$error = ( $ftp_delete == FALSE );   $err_msg = "The ftp_delete erred. \$ftp_delete returned false."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			}

			// verify the ftp_delete by confirming the file exists in the destination location
			unset($remote_files_list) ;
			$remote_files_list = @ftp_nlist($ftp_connect, $remote_path);
			if ( ($remote_files_list === FALSE) && ($attempts_cnt <= $max_retries) )
			{
				$error = ( TRUE );   $err_msg = "The ftp_nlist erred. \$ftp_nlist returned false.  Will retry.  This was attempt number $attempts_cnt."; $notify = FALSE;   $severity = "NOTICE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				 // if the command failed to execute properly, but we have not exceeded our max retries, try again
				$attempts_cnt++ ;  // increment counter of attempts
				$ftp_close = @ftp_close($ftp_connect);  // just in case a connection is open, try to close it
				continue;   //  go back to the top of the loop and try again, unless we have exceeded our max_retries
			}
			else
			{
				//  if we have exceeded our max retries, then check if we need to log an error and stop execution
				$error = ( $remote_files_list === FALSE );   $err_msg = "The ftp_nlist erred. \$ftp_nlist returned false."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			}

			// verify the file DOES exist in the destination location
			$error = ( in_array($filename_pdf, $remote_files_list) == TRUE );   $err_msg = "It appears the file still exists on the ftp site.  \n\$remote_path_and_file:  $remote_path_and_file \n\$remote_files_list:  " . print_r($remote_files_list,TRUE); $notify = TRUE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			unset($remote_files_list) ;

			$ftp_close = @ftp_close($ftp_connect);
			// do not stop execution if the close fails, just log, so do not retry multiple times either
			$error = ( $ftp_close == FALSE );   $err_msg = "Closing the ftp_close failed. \$ftp_close returned false."; $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

			//  if we get here, we completed this successfully and we do not need to try the loop again
			$try_again = FALSE ;
		}

		if ($retrieved_converted_file == TRUE)
		{
			//  if we think we successfully retrieved the converted file, check to be sure
			$error = ( file_exists($local_path_and_file) == FALSE );   $err_msg = "The retrieved pdf converted file does not exist. \n\$local_path_and_file:  $local_path_and_file"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		}

		// if we get here the method has completed successfully, wrap up and return results array
		$results_array = array();
		$results_array['Result'] = TRUE;
		$results_array['Retrieved_Converted_File'] = $retrieved_converted_file ;
		$results_array['Filename'] = $filename_pdf;
		$results_array['Local_Path_Filename'] = $local_path_and_file;
		$results_array['Remote_Path_Filename'] = $remote_path_and_file;
		$results_array['Result_Message'] = "Executed successfully.\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date( "n-j-Y, g:i:s a" ) ;

		if  (DEBUG && $test)  { echo "\n------------------------ RETURN/RESULTS ARRAY -----------------------------\n";   print_r($results_array,FALSE);  echo "\n-----------------------------------------------------\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------"; }

		if (DEBUG && $test)  { echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date( "n-j-Y, g:i:s a" ) . "\n-----------------------------------------------------"; }

		return $results_array;
	}
	
	//  This method will convert the given file to an html. The HTML content will be returned.
	//  @Param 1:	required, the full path and filename of the file to convert to html.
	//  @Return:	result array
	public function ConvertFileToHTML($path_filename_to_convert)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages0=TRUE for STARTING and ENDING messages only
		$messages1 = FALSE ;  //  set $messages1=TRUE for high level messages that are outside of any loop structure

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 1 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($path_filename_to_convert) );   $err_msg = "\$path_filename_to_convert is empty or invalid. \n\$path_filename_to_convert: $path_filename_to_convert \n\func_num_args: " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		// load the cloud convert class with the AFCA key
		$this->ci->load->config('cloud_convert');
		$cloud_convert_config = array('API_Key' => $this->ci->config->item('Cloud_Convert_API_Key'));
		$this->ci->load->library('cloud_convert_lib', $cloud_convert_config);
		
		$file_info = pathinfo($path_filename_to_convert); // retrieve information about the file. filename, basename, directory, extension.
	
		$new_filename = $file_info['filename']; // the filename
		$input_format = $file_info['extension']; // because we are merging templates in this method we know the file extensions are 'odt' open office documents.
		$output_format = "html"; // we want to convert our template documents to HTML
		$return = $this->ci->cloud_convert_lib->CreateProcess($input_format, $output_format);
		if(DEBUG && $test) { echo "Cloud Convert Create Process: \n\$return:  "; print_r($return,FALSE); }
		$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->MergeTemplate \$return: \n" . print_r($return,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$return = $this->ci->cloud_convert_lib->Upload($path_filename_to_convert, $output_format);
		if(DEBUG && $test) { echo "Cloud Convert Upload: \n\$return:  "; print_r($return,FALSE); }
		$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->MergeTemplate \$return: \n" . print_r($return,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		// check if the file is converted, and if so download the file. It will check the status of the file conversion every second for the time limit given, and if the status returns
		// completed it will attempt to download the file.
		if( $this->ci->cloud_convert_lib->WaitForConversion(120) ) 
		{
			$return = $this->ci->cloud_convert_lib->DownloadStream();
			if(DEBUG && $test) { echo "Cloud Convert Download: \n\$return:  "; print_r($return,FALSE); }
			$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->MergeTemplate \$return: \n" . print_r($return,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
					
			$html_content = $return['File_Content'];
		}
		else
		{
			// *** this is where we could call the other method to convert files.
			
			// the file did not convert, return an error.
			$error = ( TRUE );   $err_msg = "The file conversion never completed after 120 seconds. "; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			
		}
		
		// if we get here the method has completed successfully, wrap up and return results array
		$results_array['Result'] = TRUE;
		$results_array['HTML_Content'] = $html_content;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
		
	}

	// This libray method will convert any document to a pdf
	// @Param 1:	required, filename to be converted to pdf
	// @Return: 	array with converted file name
	public function ConvertDocumentToPdf2($merged_filename)
	{
		//  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo
		$test = FALSE ;
		if(DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------\n"; }
		if(DEBUG && $test)  { echo "func_get_args(): \n";  print_r(func_get_args(), FALSE);  echo "\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------\n\n"; }

		$num_args_expected = 1 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($merged_filename) );   $err_msg = "\$merged_filename passed to this method is empty.  \$merged_filename:  $merged_filename"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$ci =& get_instance();
		$ci->load->config('documents');

		$templates_source = $ci->config->item("DOC_TEMPLATES_DIR");
		$templates_output_source = $ci->config->item("DOC_TEMPLATES_OUTPUT_DIR");
		$templates_converted_source = $ci->config->item("DOC_CONVERTED_DIR");

		$file_info = pathinfo($merged_filename);
		$filename_pdf = $file_info['filename'] . '.pdf';

		$template_file_path_and_name = $templates_output_source . DIRECTORY_SEPARATOR . $merged_filename; // the path and filename of the file we want to convert to pdf
		$output_file_path_and_name = $templates_converted_source . DIRECTORY_SEPARATOR . $filename_pdf; // the path and filename of the file after converted to pdf

		exec("/usr/bin/killall soffice.*", $sys_output);
		exec("/usr/bin/pkill -9 -f soffice.*", $sys_output);
		system("/usr/bin/unoconv -o $templates_converted_source $template_file_path_and_name", $sys_output);

		$results_array = array();
		$results_array['Result'] = TRUE;
		$results_array['Filename'] = $filename_pdf;
		$results_array['File_Path_Name'] = $output_file_path_and_name;
		$results_array['Result_Message'] = "Executed Successfully!";

		if  (DEBUG && $test)  { echo "\n------------------------ RETURN/RESULTS ARRAY -----------------------------\n";   print_r($results_array, FALSE);  echo "\n-----------------------------------------------------\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------\n"; }

		if (DEBUG && $test)  { echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date( "n-j-Y, g:i:s a" ) . "\n-----------------------------------------------------\n"; }

		return $results_array;

	}


	// This library method will convert any file document to a pdf.
	// This method passes the path and file name of the document file to be converted.
	// @Param 1:	required, file path and file name to be converted to pdf
	// @Return:	result array
	public function ConvertFileToPdf2($file_path_name)
	{
		//  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo
		$test = FALSE ;
		$messages0 = FALSE ;  //  set $messages0=TRUE for STARTING and ENDING messages only
		$messages1 = FALSE ;  //  set $messages1=TRUE for high level messages that are outside of any loop structure

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 1 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($file_path_name) );   $err_msg = "\$file_path_name is empty or invalid. \nfunc_get_args(): " . print_r(func_get_args(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !file_exists($file_path_name) );   $err_msg = "\$file_path_name does not exist on the local server. \n\$file_path_name: $file_path_name \nfunc_get_args(): " . print_r(func_get_args(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$ci =& get_instance();
		$ci->load->config('documents');
		
		$templates_converted_source = $ci->config->item("FILES_CONVERTED_PATH"); // set the local directory where the converted file will be saved.

		$file_info = pathinfo($file_path_name);
		$file_dir = $file_info['dirname'];
		$filename = $file_info['filename'];
		$basename = $file_info['basename'];
		$u_basename = FormatUnixFilename($basename);
		$file_name_pdf = $filename . '.pdf';

		$u_file_path_name = $file_dir . DIRECTORY_SEPARATOR . $u_basename ;

		$result = system("/usr/bin/unoconv -o $templates_converted_source/ $u_file_path_name", $result);
		$error = ( $result === FALSE );   $err_msg = "\$result is false. \n\$result: $result"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		// if we get here the method has completed successfully, wrap up and return results array
		$results_array['Result'] = TRUE;
		$results_array['Filename'] = $file_name_pdf;
		$results_array['Path_Filename'] = $templates_converted_source . DIRECTORY_SEPARATOR . $file_name_pdf;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}


	//  This library method will convert any file type to a pdf using the windows pdf conversion program
	//  @Param 1:	required, file path name of the file to convert
	//  @Result:	result array
	public function ConvertFileToPdfWindows2($file_path_name)
	{
		$test = false;

		$this->CI->load->config('documents');

		$templates_converted_source = $this->CI->config->item("DOC_CONVERTED_DIR");

		//  1. send file to windows to be converted
		$send_doc_result = $this->SendFileToBeConverted($file_path_name);
		if(DEBUG && $test) { echo "<pre>Send Doc Result:"; print_r( $send_doc_result); echo "</pre>"; }

		//  2. get converted document in pdf form [we pause, then continue to check and pause until we get it or time expires]
		$wait = 3 ;   //  time to wait (seconds) for first wait period
		$total_wait = 0 ;     //  initialize value
		$get_doc_result = array() ;
		$get_doc_result['Result'] = FALSE ;     //  initialize value
		$file_info = pathinfo($file_path_name);
		$file_name = isset($file_info['filename']) ? $file_info['filename'] . '.' . $file_info['extension'] : '';

		if( !empty($file_name) )
		{
			while ( ( $get_doc_result['Result'] == FALSE ) && ( $total_wait < 30 ) )
			{
				sleep($wait);   //  snoring
				$total_wait = $total_wait + $wait ;     //  track total time waiting, avoid want infinite loop
				$get_doc_result = $this->GetConvertedFile($file_name);
				$wait = 2 ;   //  time to wait for each consecutive wait period
			}
		}

		if($get_doc_result['Result'] == TRUE)
		{
			$converted_file_name = $get_doc_result['File_Name'];
			return array('Result' => TRUE, 'File_Name' => $converted_file_name, 'File_Path_Name' => $templates_converted_source . DIRECTORY_SEPARATOR . $converted_file_name);
		}
		 else
		{
			return array('Result' => FALSE, 'Result_Message' => $get_doc_result['Result_Message']);
		}

		return array('Result' => FALSE, 'Result_Message' => $get_doc_result['Result_Message']);
	}


	//  This library method will convert [doc, docx, rtf, txt] to a "secure" pdf and add a watermark using the Lams windows pdf conversion program
	//  @Param 1:	required, file path name of the file to convert
	//  @Param 2:	optional, TRUE=add lines numbers down the left side of the converted pdf file FALSE=do not add line numbers
	//  @Result:	result array
	public function ConvertFileToSecurePdfWindows2( $file_path_name, $add_line_numbers = FALSE )
	{
		$test = false;

		$this->CI->load->config('documents');

		$templates_converted_source = $this->CI->config->item("DOC_CONVERTED_DIR");

		//  1. send file to windows to be converted
		$send_doc_result = $this->SendFileToBeConverted($file_path_name);
		if(DEBUG && $test) { echo "<pre>Send Doc Result:"; print_r( $send_doc_result); echo "</pre>"; }

		//  2. get converted document in pdf form [we pause, then continue to check and pause until we get it or time expires]
		$wait = 3 ;   //  time to wait (seconds) for first wait period
		$total_wait = 0 ;     //  initialize value
		$get_doc_result = array() ;
		$get_doc_result['Result'] = FALSE ;     //  initialize value
		$file_info = pathinfo($file_path_name);
		$file_name = isset($file_info['filename']) ? $file_info['filename'] . '.' . $file_info['extension'] : '';

		if( !empty($file_name) )
		{
			while ( ( $get_doc_result['Result'] == FALSE ) && ( $total_wait < 30 ) )
			{
				sleep($wait);   //  snoring
				$total_wait = $total_wait + $wait ;     //  track total time waiting, avoid want infinite loop
				$get_doc_result = $this->GetConvertedFile($file_name);
				$wait = 2 ;   //  time to wait for each consecutive wait period
			}
		}

		if($get_doc_result['Result'] == TRUE)
		{
			if( $add_line_numbers == FALSE )
			{
				$converted_file_name = $get_doc_result['File_Name'];
				return array('Result' => TRUE, 'File_Name' => $converted_file_name, 'File_Path_Name' => $templates_converted_source . DIRECTORY_SEPARATOR . $converted_file_name, 'Result_Message' => 'Executed Successfully!');
			}
			else
			{
				unset($result);
				$result = $this->WriteTexLineFileAndExecute($templates_converted_source . DIRECTORY_SEPARATOR . $get_doc_result['File_Name']);
				return $result;
			}
		}
		 else
		{
			return array('Result' => FALSE, 'Result_Message' => $get_doc_result['Result_Message']);
		}

		return array('Result' => FALSE, 'Result_Message' => $get_doc_result['Result_Message']);
	}


	//  This method writes the LaTeX file needed to execute to add the line numbers to an existing PDF file. Once the file is written, and saved to disk
	//  we execute the the LaTeX file on the given existing PDF file. If successfull then the LaTeX file is deleted and the PDF is moved back to the
	//  viewing directory.
	//  @Param 1:	required, the file path and file name
	//  @Return:	result array
	public function WriteTexLineFileAndExecute2( $file_path_name )
	{
		$ci =& get_instance();
		$ci->load->config('documents');
		$ci->load->helper('string');

		$converted_source_path = $ci->config->item("DOC_CONVERTED_DIR");
		$templates_source_path = $ci->config->item("DOC_TEMPLATES_DIR");

		$file_info = pathinfo($file_path_name);
		$file_filename = $file_info['filename'];
		$file_basename = $file_info['basename'];

		// because of the characters used in the lams draft names we need to copy the pdf file to a useable name then copied back later
		unset($safe_pre);
		$safe_pre = md5(random_string('unique'));
		$safe_filename = "draft_$safe_pre.pdf";
		copy($file_path_name, $converted_source_path . DIRECTORY_SEPARATOR . $safe_filename);

		// decrypt the file because we won't be able to edit the document.. * this will be removed because the process has changed
		$safe_file_path_name = $converted_source_path . DIRECTORY_SEPARATOR . $safe_filename;
		$decrypt_filename = 'decrypt_' . $safe_pre . '.pdf';
		$decrypt_file_path_name = $converted_source_path . DIRECTORY_SEPARATOR . $decrypt_filename;
		$background_pdf_path_name = $templates_source_path . DIRECTORY_SEPARATOR . 'draft_watermark.pdf';
		//exec("/usr/local/bin/qpdf --password=RunsW1thW0lv3s@g@1n --decrypt $safe_file_path_name $decrypt_file_path_name", $qpdf_output);
		exec("/usr/local/bin/pdftk $safe_file_path_name background $background_pdf_path_name output $decrypt_file_path_name", $cmd_o);

		// LaTeX file contents. This Tex code is used to create the line numbers down the left side of the pdf on each page.
		// The line numbers are 1-66 for each page. The line numbers DO NOT match perfectly horizontally to each pdf text line.
		$tex_file_contents = "";
		$tex_file_contents .= "\documentclass{article} \n";
		$tex_file_contents .= "\usepackage{graphicx} \n";
		$tex_file_contents .= "\usepackage{pdfpages} \n";
		$tex_file_contents .= "\usepackage[top=0.9in, bottom=0in, left=0in, right=0in]{geometry} \n";
		$tex_file_contents .= "\usepackage{color} %%[usenames, dvipsnames] \n";
		$tex_file_contents .= "\usepackage{setspace} \n";
		//$tex_file_contents .= "\usepackage{anyfontsize} \n";
		$tex_file_contents .= "\\fontsize{24}{29} \n";
		$tex_file_contents .= "\setstretch{0.8} \n";
		$tex_file_contents .= "\n";
		$tex_file_contents .= "\makeatletter \n";
		$tex_file_contents .= " \\newsavebox{\@linebox} \n";
		$tex_file_contents .= " \savebox{\@linebox}[3em][t]{\parbox[t]{3em}{ \n";
		$tex_file_contents .= "   \@tempcnta\@ne\\relax \n";
		$tex_file_contents .= "   \loop{\color{red} \small\\the\@tempcnta} \\\ \n";
		$tex_file_contents .= "     \advance\@tempcnta by \@ne\ifnum\@tempcnta<65\\repeat}} \n";
		$tex_file_contents .= "\makeatother \n";
		$tex_file_contents .= "\n";
		$tex_file_contents .= "  \begin{document} \n";
		$tex_file_contents .= "  \makeatletter \n";
		$tex_file_contents .= "\n";
		$tex_file_contents .= "  \includepdf[pages=1-,pagecommand={\\thispagestyle{empty} \hspace{0.3in} \n";
		$tex_file_contents .= "  \usebox{\@linebox}},fitpaper]{" . $converted_source_path . DIRECTORY_SEPARATOR . $decrypt_filename . "} \n";
		$tex_file_contents .= "\n";
		$tex_file_contents .= " \makeatother \n";
		$tex_file_contents .= "\end{document} \n";


		$tex_filename = "lines_" . $safe_pre . ".tex"; // latex file name
		$handle = fopen($converted_source_path . DIRECTORY_SEPARATOR . $tex_filename, 'c+');
		fwrite($handle, $tex_file_contents);
		fclose($handle);

		$tex_path_file = $converted_source_path . DIRECTORY_SEPARATOR . $tex_filename;
		$lines_pdf_name = "lines_" . $safe_pre . ".pdf";
		$lines_pdf_path_name = $converted_source_path . DIRECTORY_SEPARATOR . $lines_pdf_name;
		exec("/usr/bin/pdflatex -aux-directory=$converted_source_path -output-directory=$converted_source_path $tex_path_file", $cmd_o);

		$encrypt_pdf_name = "encrypt_" . $safe_pre . ".pdf";
		$encrypt_pdf_path_name = $converted_source_path . DIRECTORY_SEPARATOR . $encrypt_pdf_name;
		exec("/usr/local/bin/qpdf --encrypt \"\" RunsW1thW0lv3s@g@1n 128 --print=none --use-aes=y --modify=none -- $lines_pdf_path_name $encrypt_pdf_path_name", $cmd_o);


		if( file_exists($file_path_name) == FALSE ) return array('Result' => FALSE, 'Result_Message' => 'ERROR: Final pdf file ($file_basename) does not exist. Method: ' . __METHOD__ . ' Line Number: ' . __LINE__);

		// general unused file cleanup
		//@unlink();

		return array('Result' => TRUE, 'File_Name' => $encrypt_pdf_name, 'File_Path_Name' => $encrypt_pdf_path_name, 'Result_Message' => 'Executed Successfully!');
	}

}
/* End of file files_convert_lib.php */
/* Location: ./application/libraries/files_convert_lib.php */
