<?php if( !defined('BASEPATH') ) die('No direct script access.');

/*
 * Filemation
 * 
 * This is the batch controller file for any batch type jobs
 */

class Batch extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	//  This method will search files in a given directory on the local server drive, and if they contain a valid date upload the to box and change the bx modified and created datetime
	//  with the date value found in the name
	public function UpdateBoxFilesOriginalDates()
	{
		$files_path = $this->config->item('CUSTOM_UPDATE_FILES_BATCH_PATH');
		
		$files_array = glob($files_path . '*');		
		
		echo "<pre>"; print_r($files_array);
	}
	
	public function UploadFilesToBoxAndCreateTags()
	{
		$test = TRUE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		$this->load->model('Batch_model');
		
		$result = $this->Batch_model->BoxUploadFilesAndAddTags();
	
		echo "<pre>"; print_r($result);
		
		//  this is the ending for a method in the batch controller
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>> \n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a");  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  ENDING  >>>";   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
	}
	
	
}