<?php if( !defined('BASEPATH') ) die('No direct script access');

/*
 * Filemation
 */

class Criteria_separators_ref_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	//  This method will retrieve all the criteria separator records and return them in a readable array.
	//  @Return: result array
	public function GetAllCriteriaSeparators()
	{
		
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages0=TRUE for STARTING and ENDING messages only
		$messages1 = FALSE ;  //  set $messages1=TRUE for high level messages that are outside of any loop structure

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 0 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$this->db->order_by('Criteria_Separator_Order', 'ASC');
		$result = $this->db->get('criteria_separators_ref');
		$sql_stmt = $this->db->last_query() ;
		$error = ( is_null($result) || ($result == FALSE) );   $err_msg = "Retrieving all criteria separator ref records failed. \$result returned false. \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$data = ( $result->num_rows() > 0 ) ? $result->result_array() : array(); // we only return the array to work with in this method.
		
		
		// if we get here the method has completed successfully, wrap up and return results array
		$results_array['Result'] = TRUE;
		$results_array['Data'] = $data;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
		
		
	}
	
}