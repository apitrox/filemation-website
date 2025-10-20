<?php if( !defined('BASEPATH') ) die('No direct script access.');

class File_criteria_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	//  This method will update an existing file criteria record
	//  @Param 1:	required, account primary key ID
	//  @Param 2:	required, file definition primary key ID
	//  @Param 3:	required, file criteria primary key ID
	//  @Return:	result array
	public function DeleteFileCriteria($account_id, $file_definition_id, $file_criteria_id)
	{
		
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 3 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty, and invalid. \n\$account_id: $account_id \n\func_get_args(): " . print_r(func_get_args(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !is_numeric($account_id) );   $err_msg = "\$account_id is not a numeric value. \n\$account_id: $account_id \n\func_get_args(): " . print_r(func_get_args(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		$error = ( empty($file_definition_id) );   $err_msg = "\$file_definition_id is empty and invalid. \n\$file_definition_id: $file_definition_id  \n\func_get_args(): " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !is_numeric($file_definition_id) );   $err_msg = "\$file_definition_id is not a numeric value. \n\$file_definition_id: $file_definition_id \n\func_get_args(): " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($file_criteria_id) );   $err_msg = "\$file_criteria_id, is empty and invalid. \$file_criteria_id: $file_criteria_id \n\func_get_args(): " . print_r(func_get_args(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !is_numeric($file_criteria_id) );   $err_msg = "\$file_criteria_id, is not numeric. \$file_criteria_id: $file_criteria_id \n\func_get_args(): " . print_r(func_get_args(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		$this->db->where('Account_Id', $account_id);
		$this->db->where('File_Definition_Id', $file_definition_id);
		$this->db->where('File_Criteria_Id', $file_criteria_id);
		$result = $this->db->delete('file_criteria');
		$sql_stmt = $this->db->last_query() ;
		$error = ( is_null($result) || ($result == FALSE) );   $err_msg = "Deleting the file criteria record failed. \$result returned false. \n\$account_id: $account_id \n\$file_criteria_id: $file_criteria_id \n\$file_definition_id: $file_definition_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		$results_array['Result'] = TRUE;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date( "n-j-Y h:i:s A");
		
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		return $results_array;
	}
	
	
	//  This method will retrieve a single file criteria record from the database by the given file criteria primary key ID
	//  @Param 1:	required, the primary account key ID we want to get the file criteria record for
	//  @Param 2:	required, the primary file criteria key id
	//  @Param 3:	required, the primary file definition key id
	//  @Return:	result array
	public function GetFileCriteria($account_id, $file_criteria_id, $file_definition_id)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 3 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty or invalid. \n\$account_id: $account_id \n\func_get_args(): " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($file_criteria_id) );   $err_msg = "\$file_criteria_id is empty or invalid. \n\$file_criteria_id: $file_criteria_id \n\func_get_args(): " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($file_definition_id) );   $err_msg = "\$file_definition_id is empty or invalid. \n\$file_definition_id: $file_definition_id \n\func_get_args(): " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		$this->db->where('Account_Id', $account_id);
		$this->db->where('File_Definition_Id', $file_definition_id);
		$this->db->where('File_Criteria_Id', $file_criteria_id);
		$result = $this->db->get('file_criteria');
		$sql_stmt = $this->db->last_query() ;
		$error = ( is_null($result) || ($result == FALSE) );   $err_msg = "Selecting the file criteria record failed. \$result returned false. \n\$account_id: $account_id \n\$file_criteria_id: $file_criteria_id \n\$file_definition_id: $file_definition_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $result->num_rows() == 0 );   $err_msg = "The query returned zero file criteria records. \n\$result returned false. \n\$account_id: $account_id \n\$file_criteria_id: $file_criteria_id \n\$file_definition_id: $file_definition_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $result->num_rows() > 1 );   $err_msg = "The query returned more than 1 file criteria records \n\$result returned false. \n\$account_id: $account_id \n\$file_criteria_id: $file_criteria_id \n\$file_definition_id: $file_definition_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$row = $result->row();
		
		$results_array['Result'] = TRUE;
		$results_array['Row'] = $row;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date( "n-j-Y h:i:s A");
		
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		return $results_array;
	}
	
	
	//  This method will retrieve all the file criteria from the database for a given account.
	//  @Param 1:	required, primary file definition key ID we want to get file definition records for
	//  @Return:	result array
	public function GetAllFileCriteriaForFileDefinition($file_definition_id)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 1 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($file_definition_id) );   $err_msg = "\$file_definition_id is empty or invalid. \n\$file_definition_id: $file_definition_id \n\func_num_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$this->db->where('file_criteria.File_Definition_Id', $file_definition_id);
		$this->db->order_by('file_criteria.Criteria_Order', 'ASC');
		$this->db->join('file_definitions', 'file_criteria.File_Definition_Id = file_definitions.File_Definition_Id');
		$this->db->join('criteria_types_ref', 'file_criteria.Criteria_Type_Id = criteria_types_ref.Criteria_Type_Id');
		$result = $this->db->get('file_criteria');
		
		$error = ( is_null($result) || $result == FALSE );   $err_msg = "The file criteria failed to retrieve. \n\$result returned false. \n\$file_definition_id: $file_definition_id";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$data = array();
		if( $result->num_rows() > 0 )
		{
			$data = $result->result_array();
		}
		
		$results_array['Result'] = TRUE;
		$results_array['Data'] = $data;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date( "n-j-Y h:i:s A");
		
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		return $results_array;
	}
	
	//  This method will retrieve all the file definitions from the database for a given account, and to be formatted to be used in the filer UI.
	//  @Param 1:	required, primary file definition key ID we want to get file definition records for
	//  @Return:	result array
	public function GetAllFileCriteriaForFilerUI($account_id, $file_definition_id)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 2 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty or invalid. \n\$account_id: $account_id \n\func_num_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	
		$error = ( empty($file_definition_id) );   $err_msg = "\$file_definition_id is empty or invalid. \n\$file_definition_id: $file_definition_id \n\func_num_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		// get the account record
		$result = $this->Accounts_model->GetAccount($account_id);
		$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Accounts_model->GetAccount() \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$account = ( isset($result['Result']) && $result['Result'] == TRUE ) ? $result['Row'] : FALSE;
		$error = ( !is_object($account) );   $err_msg = "The account was not found in the database. \$account is not an object. \n\$account_id: $account_id \n" . $result['Result_Message'];   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$data_storage = $account->Data_Storage; // set the data storage provider for the account. This will be used to determine the "default" root destination path if the existing value is invalid.
		
		$result = $this->GetAllFileCriteriaForFileDefinition($file_definition_id);
		$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Accounts_model->GetAccount() \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !isset($result['Data']) );   $err_msg = "The file criteria data did not return. It is not set. \$result[Data] is not set. \n\$file_definition_id: $file_definition_id \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$file_criteria_data = $result['Data']; // set the file criteria array data.
		
		// we need to iterate through any file criteria and format the data to be used in the doc filer user interface.
		
		$default_destination_path = ""; // set the default destination path to an empty string.
		$destination_path_exists = true; // by default we set the destination path exists to true, untill we prove it does not exist.
		$data = array();
		if( count($file_criteria_data) > 0 )
		{
			foreach($file_criteria_data as $row)
			{
				$fcrow = $row;
				if( is_null($fcrow['Default_Destination_Path']) || $fcrow['Default_Destination_Path'] == "" )
				{
					
					// depending on the data storage provider we set different root path values.
					if( strtoupper($data_storage) == "BOX" )
					{
						$fcrow['Default_Destination_Path'] = 0;
					}
					else if( strtoupper($data_storage) == "DROPBOX" )
					{
						$fcrow['Default_Destination_Path'] = "/";
					}
					else if( strtoupper($data_storage) == "GOOGLE DRIVE" )
					{
						
					}
					else if( strtoupper($data_storage) == "MICROSOFT ONEDRIVE" )
					{
						
					}
					
					$destination_path_exists = false; // set the destination path exists to false because there was no value selected for the default destination path and we set it to the root folder.
				}
				
				
				$default_destination_path = $fcrow['Default_Destination_Path']; // set the default destination path to be returned at the end of the method.
				
				$data[] = $fcrow;
			}
		}
		
		
		//  This method is called only to get file criteria in the filer UI, so it is safe to make data storage calls in this method.
		//  We need to check if the file definition "default destination path" exists in the data storage account. If it does not exist set the default destination path back to the 
		//  rooter folder depending on which data storage provider the account uses, and set the $destination_path_exists to false so the end user is notified the destination path 
		//  did not exist.
		if( $destination_path_exists == TRUE && (count($data) > 0) )
		{
			if( strtoupper($data_storage) == "BOX" )
			{
				if( !empty($default_destination_path) )
				{
					$result = $this->Data_storage_model->BoxGetFolderDetails($account_id, $default_destination_path);				
					if( $result['Result'] == FALSE && isset($result['Error_Type']) && strtoupper($result['Error_Type']) == 'ERROR' && isset($result['Error_Code']) && strtoupper($result['Error_Code']) == 'NOT_FOUND' )
					{
						$destination_path_exists = false; // set the destination path exists to false because box says it does not exist;
						$default_destination_path = 0; // set the default destination path to the box root folder id.
					}
				}
			}
			else if( strtoupper($data_storage) == "DROPBOX" )
			{	
				
			}
			else if( strtoupper($data_storage) == "GOOGLE DRIVE" )
			{
				
			}
			else if( strtoupper($data_storage) == "MICROSOFT ONEDRIVE" )
			{
				
			}
		}
		
		$results_array['Result'] = TRUE;
		$results_array['Data'] = $data;
		$results_array['File_Definition_Id'] = $file_definition_id;
		$results_array['Destination_Path_Exists'] = $destination_path_exists;
		$results_array['Default_Destination_Path'] = $default_destination_path;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date( "n-j-Y h:i:s A");
		
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		return $results_array;
	}
	
	
	//  This method will create a new file criteria record
	//  @Param 1:	required, the file criteria data array
	//  @Return:	result array
	public function NewFileCriteria($file_criteria_array)
	{
		// Request Data: POST
		// Account_Id					= the primary account key id for this file criteria record
		// File_Definition_Id			= the primary file definition key id for this file criteria record
		// Criteria_Name				= the criteria name or label for the file criteria record
		// Criteria_Required			= 1=if a file criteria is required to file and rename a file 0= not required
		// Criteria_Min_Len				= the minimum length of characters for a file criteria to file and rename a file
		// Criteria_Max_Len				= the maximum length of characters for a file criteria to file and rename a file
		// Criteria_Default_Value		= the default value for a file criteria 
		// Criteria_Tooltip				= the tooltip message that displays when focused on a file criteria textfield
		// Criteria_Recall_Name			= 1=the value entered in for the file criteria will be saved and will be displayed later if the value being typed matches the saved recall names
		// Criteria_Prefix				= the string or characters attached to the beginning of the file criteria value/term when renaming a file
		// Criteria_Suffix				= the string or characters attached to the end of the file criteria value/term when renaming a file
		// Criteria_Decimals			= if the file criteria is a criteria type 'number' or alike, this is how many decimals the value should be formatted to
		// Criteria_Dec_Point			= the character used for a decimal point (.)
		// Criteria_Thousands_Sep		= the character used for signaling thousands length (,)
		// Criteria_Currency_Symbol		= the character used to signla it is a currency value ($)
		// Days_Back					= how many days, for a date criteria type, is the datepicker allowed to go back
		// Date_Back					= what is the exact date, for a date criteria type, the datepicker allowed to go back
		// Days_Forward				= how many days, for a date criteria type, is the datepicker allowed to go forward
		// Date_Forward				= the exact date, for a date criteria type, the datepicker is allowed to go forward 
		
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 1 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($file_criteria_array) );   $err_msg = "\$file_criteria_array is empty or invalid. \n\$file_criteria_array: " . print_r($file_criteria_array, TRUE) . " \n\func_get_args(): " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($file_criteria_array['Account_Id']) );   $err_msg = "\$account_id is empty, false, or invalid"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($file_criteria_array['File_Definition_Id']) );   $err_msg = "\$file_definition_id is empty, and invalid. \n\$file_criteria_array: " . print_r($file_criteria_array, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($file_criteria_array['Criteria_Type_Id']) );   $err_msg = "\$criteria_type_id is empty, and invalid. \n\$file_criteria_array: " . print_r($file_criteria_array, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($file_criteria_array['Criteria_Name']) );   $err_msg = "\$criteria_name is empty, and invalid. \n\$file_criteria_array: " . print_r($file_criteria_array, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $file_criteria_array['Criteria_Required'] === '' );   $err_msg = "\$criteria_required is empty, and invalid. \n\$file_criteria_array: " . print_r($file_criteria_array, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $file_criteria_array['Criteria_Min_Len'] != '' && !is_numeric($file_criteria_array['Criteria_Min_Len']) );   $err_msg = "\$criteria_min_len is not empty and is not a numeric value. \n\$file_criteria_array: " . print_r($file_criteria_array, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $file_criteria_array['Criteria_Max_Len'] != '' && !is_numeric($file_criteria_array['Criteria_Max_Len']) );   $err_msg = "\$criteria_max_len is not empty, and is not a numeric value. \n\$file_criteria_array: " . print_r($file_criteria_array, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $file_criteria_array['Criteria_Default_Value'] == FALSE && $file_criteria_array['Criteria_Default_Value'] != 0 );   $err_msg = "\$criteria_default_value does not exist. \$criteria_default_value is false. \n\$file_criteria_array: " . print_r($file_criteria_array, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $file_criteria_array['Criteria_Recall_Name'] === '' );   $err_msg = "\$criteria_recall_name is empty, and invalid. \n\$file_criteria_array: " . print_r($file_criteria_array, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$account_id = $file_criteria_array['Account_Id'];
		$file_definition_id = $file_criteria_array['File_Definition_Id'];
		$criteria_type_id = $file_criteria_array['Criteria_Type_Id'];
		$criteria_name = $file_criteria_array['Criteria_Name'];
		$criteria_required = $file_criteria_array['Criteria_Required'];
		$criteria_min_len = ( !empty($file_criteria_array['Criteria_Min_Len']) ) ? $file_criteria_array['Criteria_Min_Len'] : NULL;
		$criteria_max_len = ( !empty($file_criteria_array['Criteria_Max_Len']) ) ? $file_criteria_array['Criteria_Max_Len'] : NULL;
		$criteria_default_value = $file_criteria_array['Criteria_Default_Value'];
		$criteria_tooltip = $file_criteria_array['Criteria_Tooltip'];
		$criteria_recall_name = $file_criteria_array['Criteria_Recall_Name'];
		$criteria_prefix = $file_criteria_array['Criteria_Prefix'];
		$criteria_suffix = $file_criteria_array['Criteria_Suffix'];
		$criteria_decimals = $file_criteria_array['Criteria_Decimals'];
		
		$criteria_dec_point = ( isset($file_criteria_array['Criteria_Dec_Point']) && !empty($file_criteria_array['Criteria_Dec_Point']) ) ? $file_criteria_array['Criteria_Dec_Point'] : NULL;
		$criteria_thousands_sep = ( isset($file_criteria_array['Criteria_Thousands_Sep']) && !empty($file_criteria_array['Criteria_Thousands_Sep']) ) ? $file_criteria_array['Criteria_Thousands_Sep'] : NULL;
		$criteria_currency_symbol = ( isset($file_criteria_array['Criteria_Currency_Symbol']) && !empty($file_criteria_array['Criteria_Currency_Symbol']) ) ? $file_criteria_array['Criteria_Currency_Symbol'] : NULL;
		$days_back = ( isset($file_criteria_array['Days_Back']) && !empty($file_criteria_array['Days_Back']) ) ? $file_criteria_array['Days_Back'] : NULL;
		$date_back = ( isset($file_criteria_array['Date_Back']) && !empty($file_criteria_array['Date_Back']) ) ? $file_criteria_array['Date_Back'] : NULL;
		$days_forward = ( isset($file_criteria_array['Days_Forward']) && !empty($file_criteria_array['Days_Forward']) ) ? $file_criteria_array['Days_Forward'] : NULL;
		$date_forward = ( isset($file_criteria_array['Date_Forward']) && !empty($file_criteria_array['Date_Forward']) ) ? $file_criteria_array['Date_Forward'] : NULL;
		$criteria_php_date_format_str = ( isset($file_criteria_array['Criteria_Php_Date_Format_Str']) && !empty($file_criteria_array['Criteria_Php_Date_Format_Str']) ) ? $file_criteria_array['Criteria_Php_Date_Format_Str'] : NULL;
		$criteria_javascript_date_format_str = ( isset($file_criteria_array['Criteria_JavaScript_Date_Format_Str']) && !empty($file_criteria_array['Criteria_JavaScript_Date_Format_Str']) ) ? $file_criteria_array['Criteria_JavaScript_Date_Format_Str'] : NULL;
		
		// format the date_forward and date_backward if they are provided and not empty
		$date_back = ( !is_null($date_back) ) ? FormatDateString($date_back, FALSE) : $date_back;
		$date_forward = ( !is_null($date_forward) ) ? FormatDateString($date_forward, FALSE) : $date_forward;
		
		
		// get the criteria sort value
		$this->db->select_max('Criteria_Order');
		$this->db->where('Account_Id', $account_id);
		$this->db->where('File_Definition_Id', $file_definition_id);
		$result = $this->db->get('file_criteria');
		if( $result->num_rows() == 0 )
		{
			$criteria_order = 100;
		}
		else
		{
			$criteria_order_row = $result->row();
			$criteria_order = $criteria_order_row->Criteria_Order+100;
		}
		
		
		// construct the data we want to update to the database
		$entry_rec = array();
		$entry_rec['Account_Id'] = $account_id;
		$entry_rec['File_Definition_Id'] = $file_definition_id;
		$entry_rec['Criteria_Type_Id'] = $criteria_type_id;
		$entry_rec['Criteria_Name'] = $criteria_name;
		$entry_rec['Criteria_Required'] = ( (int)$criteria_required == 1 ) ? 1 : 0;
		$entry_rec['Criteria_Min_Len'] = $criteria_min_len;
		$entry_rec['Criteria_Max_Len'] = $criteria_max_len;
		$entry_rec['Criteria_Default_Value'] = $criteria_default_value;
		$entry_rec['Criteria_Tooltip'] = $criteria_tooltip;
		$entry_rec['Criteria_Recall_Name'] = ( $criteria_recall_name == 1 ) ? 1 : 0;
		$entry_rec['Criteria_Prefix'] = $criteria_prefix;
		$entry_rec['Criteria_Suffix'] = $criteria_suffix;
		$entry_rec['Criteria_Decimals'] = $criteria_decimals;
		$entry_rec['Criteria_Dec_Point'] = $criteria_dec_point;
		$entry_rec['Criteria_Thousands_Sep'] = $criteria_thousands_sep;
		$entry_rec['Criteria_Currency_Symbol'] = $criteria_currency_symbol;
		$entry_rec['Criteria_Order'] = $criteria_order;
		$entry_rec['Days_Back'] = $days_back;
		$entry_rec['Date_Back'] = $date_back;
		$entry_rec['Days_Forward'] = $days_forward;
		$entry_rec['Date_Forward'] = $date_forward;
		$entry_rec['Criteria_Php_Date_Format_Str'] = $criteria_php_date_format_str;
		$entry_rec['Criteria_JavaScript_Date_Format_Str'] = $criteria_javascript_date_format_str;
		
		
		
		$result = $this->db->insert('file_criteria', $entry_rec);
		$sql_stmt = $this->db->last_query() ;
		$error = ( is_null($result) || ($result == FALSE) );   $err_msg = "Inserting the file criteria record failed. \$result returned false. \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$new_insert_id = $this->db->insert_id();
		$error = ( empty($new_insert_id) );   $err_msg = "The new insert id is empty or invalid. \n\$new_insert_id: $new_insert_id";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		$results_array['Result'] = TRUE;
		$results_array['New_File_Criteria_Id'] = $new_insert_id;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date( "n-j-Y h:i:s A");
		
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		return $results_array;
	}
	
	
	
	//  This method will update an existing file criteria record
	//  @Param 1:	required, the file criteria data array
	//  @Return:	result array
	public function SaveFileCriteria($account_id, $file_criteria_id, $file_criteria_array)
	{
		// Request Data: POST
		// Account_Id					= the primary account key id for this file criteria record
		// File_Definition_Id			= the primary file definition key id
		// Criteria_Name				= the criteria name or label for the file criteria record
		// Criteria_Required			= 1=if a file criteria is required to file and rename a file 0= not required
		// Criteria_Min_Len				= the minimum length of characters for a file criteria to file and rename a file
		// Criteria_Max_Len				= the maximum length of characters for a file criteria to file and rename a file
		// Criteria_Default_Value		= the default value for a file criteria 
		// Criteria_Tooltip				= the tooltip message that displays when focused on a file criteria textfield
		// Criteria_Recall_Name			= 1=the value entered in for the file criteria will be saved and will be displayed later if the value being typed matches the saved recall names
		// Criteria_Prefix				= the string or characters attached to the beginning of the file criteria value/term when renaming a file
		// Criteria_Suffix				= the string or characters attached to the end of the file criteria value/term when renaming a file
		// Criteria_Decimals			= if the file criteria is a criteria type 'number' or alike, this is how many decimals the value should be formatted to
		// Criteria_Dec_Point			= the character used for a decimal point (.)
		// Criteria_Thousands_Sep		= the character used for signaling thousands length (,)
		// Criteria_Currency_Symbol		= the character used to signla it is a currency value ($)
		// Days_Back					= how many days, for a date criteria type, is the datepicker allowed to go back
		// Date_Back					= what is the exact date, for a date criteria type, the datepicker allowed to go back
		// Days_Forward				= how many days, for a date criteria type, is the datepicker allowed to go forward
		// Date_Forward				= the exact date, for a date criteria type, the datepicker is allowed to go forward 
		
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 3 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty, and invalid. \n\$account_id: $account_id \n\func_get_args(): " . print_r(func_get_args(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($file_criteria_id) );   $err_msg = "\$file_criteria_id, and invalid. \$file_criteria_id: $file_criteria_id \n\func_get_args(): " . print_r(func_get_args(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($file_criteria_array) );   $err_msg = "\$file_def_data is empty or invalid. \n\$file_criteria_array:" . print_r($file_criteria_array, TRUE) . " \n\func_get_args(): " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($file_criteria_array['File_Definition_Id']) );   $err_msg = "\$file_definition_id is empty, and invalid. \n\$file_criteria_array: " . print_r($file_criteria_array, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($file_criteria_array['Criteria_Type_Id']) );   $err_msg = "\$criteria_type_id is empty, and invalid. \n\$file_criteria_array: " . print_r($file_criteria_array, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($file_criteria_array['Criteria_Name']) );   $err_msg = "\$criteria_name is empty, and invalid. \n\$file_criteria_array: " . print_r($file_criteria_array, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $file_criteria_array['Criteria_Required'] === '' );   $err_msg = "\$criteria_required is empty, and invalid. \n\$file_criteria_array: " . print_r($file_criteria_array, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $file_criteria_array['Criteria_Min_Len'] != '' && !is_numeric($file_criteria_array['Criteria_Min_Len']) );   $err_msg = "\$criteria_min_len is not empty and is not a numeric value. \n\$file_criteria_array: " . print_r($file_criteria_array, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $file_criteria_array['Criteria_Max_Len'] != '' && !is_numeric($file_criteria_array['Criteria_Max_Len']) );   $err_msg = "\$criteria_max_len is not empty, and is not a numeric value. \n\$file_criteria_array: " . print_r($file_criteria_array, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $file_criteria_array['Criteria_Default_Value'] == FALSE && $file_criteria_array['Criteria_Default_Value'] != 0 );   $err_msg = "\$criteria_default_value does not exist. \$criteria_default_value is false. \n\$file_criteria_array: " . print_r($file_criteria_array, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$file_definition_id = $file_criteria_array['File_Definition_Id'];
		$criteria_type_id = $file_criteria_array['Criteria_Type_Id'];
		$criteria_name = $file_criteria_array['Criteria_Name'];
		$criteria_required = $file_criteria_array['Criteria_Required'];
		$criteria_min_len = ( !empty($file_criteria_array['Criteria_Min_Len']) ) ? $file_criteria_array['Criteria_Min_Len'] : NULL;
		$criteria_max_len = ( !empty($file_criteria_array['Criteria_Max_Len']) ) ? $file_criteria_array['Criteria_Max_Len'] : NULL;
		$criteria_default_value = $file_criteria_array['Criteria_Default_Value'];
		$criteria_tooltip = $file_criteria_array['Criteria_Tooltip'];
		$criteria_recall_name = $file_criteria_array['Criteria_Recall_Name'];
		$criteria_prefix = $file_criteria_array['Criteria_Prefix'];
		$criteria_suffix = $file_criteria_array['Criteria_Suffix'];
		$criteria_decimals = $file_criteria_array['Criteria_Decimals'];
		
		$criteria_dec_point = ( isset($file_criteria_array['Criteria_Dec_Point']) && !empty($file_criteria_array['Criteria_Dec_Point']) ) ? $file_criteria_array['Criteria_Dec_Point'] : NULL;
		$criteria_thousands_sep = ( isset($file_criteria_array['Criteria_Thousands_Sep']) && !empty($file_criteria_array['Criteria_Thousands_Sep']) ) ? $file_criteria_array['Criteria_Thousands_Sep'] : NULL;
		$criteria_currency_symbol = ( isset($file_criteria_array['Criteria_Currency_Symbol']) && !empty($file_criteria_array['Criteria_Currency_Symbol']) ) ? $file_criteria_array['Criteria_Currency_Symbol'] : NULL;
		$days_back = ( isset($file_criteria_array['Days_Back']) && !empty($file_criteria_array['Days_Back']) ) ? $file_criteria_array['Days_Back'] : NULL;
		$date_back = ( isset($file_criteria_array['Date_Back']) && !empty($file_criteria_array['Date_Back']) ) ? $file_criteria_array['Date_Back'] : NULL;
		$days_forward = ( isset($file_criteria_array['Days_Forward']) && !empty($file_criteria_array['Days_Forward']) ) ? $file_criteria_array['Days_Forward'] : NULL;
		$date_forward = ( isset($file_criteria_array['Date_Forward']) && !empty($file_criteria_array['Date_Forward']) ) ? $file_criteria_array['Date_Forward'] : NULL;
		$criteria_php_date_format_str = ( isset($file_criteria_array['Criteria_Php_Date_Format_Str']) && !empty($file_criteria_array['Criteria_Php_Date_Format_Str']) ) ? $file_criteria_array['Criteria_Php_Date_Format_Str'] : NULL;
		$criteria_javascript_date_format_str = ( isset($file_criteria_array['Criteria_JavaScript_Date_Format_Str']) && !empty($file_criteria_array['Criteria_JavaScript_Date_Format_Str']) ) ? $file_criteria_array['Criteria_JavaScript_Date_Format_Str'] : NULL;
		
		// format the date_forward and date_backward if they are provided and not empty
		$date_back = ( !is_null($date_back) ) ? FormatDateString($date_back, FALSE) : $date_back;
		$date_forward = ( !is_null($date_forward) ) ? FormatDateString($date_forward, FALSE) : $date_forward;
		
		
		// construct the data we want to update to the database
		$entry_rec = array();
		$entry_rec['Account_Id'] = $account_id;
		$entry_rec['File_Definition_Id'] = $file_definition_id;
		$entry_rec['Criteria_Type_Id'] = $criteria_type_id;
		$entry_rec['Criteria_Name'] = $criteria_name;
		$entry_rec['Criteria_Required'] = ( (int)$criteria_required == 1 ) ? 1 : 0;
		$entry_rec['Criteria_Min_Len'] = $criteria_min_len;
		$entry_rec['Criteria_Max_Len'] = $criteria_max_len;
		$entry_rec['Criteria_Default_Value'] = $criteria_default_value;
		$entry_rec['Criteria_Tooltip'] = $criteria_tooltip;
		$entry_rec['Criteria_Recall_Name'] = ( $criteria_recall_name == 1 ) ? 1 : 0;
		$entry_rec['Criteria_Prefix'] = $criteria_prefix;
		$entry_rec['Criteria_Suffix'] = $criteria_suffix;
		$entry_rec['Criteria_Decimals'] = $criteria_decimals;
		$entry_rec['Criteria_Dec_Point'] = $criteria_dec_point;
		$entry_rec['Criteria_Thousands_Sep'] = $criteria_thousands_sep;
		$entry_rec['Criteria_Currency_Symbol'] = $criteria_currency_symbol;
		$entry_rec['Days_Back'] = $days_back;
		$entry_rec['Date_Back'] = $date_back;
		$entry_rec['Days_Forward'] = $days_forward;
		$entry_rec['Date_Forward'] = $date_forward;
		$entry_rec['Criteria_Php_Date_Format_Str'] = $criteria_php_date_format_str;
		$entry_rec['Criteria_JavaScript_Date_Format_Str'] = $criteria_javascript_date_format_str;
		
		
		$this->db->where('Account_Id', $account_id);
		$this->db->where('File_Criteria_Id', $file_criteria_id);
		$result = $this->db->update('file_criteria', $entry_rec);
		$sql_stmt = $this->db->last_query() ;
		$error = ( is_null($result) || ($result == FALSE) );   $err_msg = "Updating the file criteria record failed. \$result returned false. \n\$account_id: $account_id \n\$file_criteria_id: $file_criteria_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$results_array['Result'] = TRUE;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date( "n-j-Y h:i:s A");
		
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		return $results_array;
	}
	
	//  This method will individualy update the file criteria sort order
	//  @Param 1:	required, the primary account key ID
	//  @Param 2:	required, the primary file criteria key ID
	//  @Param 3:	required, the primary file definition key ID
	//  @Param 4:	required, the sort order direction
	//  @Return:	result array
	public function UpdateFileCriteriaSortOrder($account_id, $file_criteria_id, $file_definition_id, $sort_direction)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 4 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty, and invalid. \n\$account_id: $account_id \n\func_get_args(): " . print_r(func_get_args(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($file_criteria_id) );   $err_msg = "\$file_criteria_id, and invalid. \$file_criteria_id: $file_criteria_id \n\func_get_args(): " . print_r(func_get_args(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($sort_direction) );   $err_msg = "\$sort_direction, is empty or invalid. \$sort_direction: $sort_direction \n\func_get_args(): " . print_r(func_get_args(), TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	
		// get the total file criteria record count for the given account id 
		$this->db->where('Account_Id', $account_id);
		$this->db->where('File_Definition_Id', $file_definition_id);
		$num_rows = $this->db->count_all_results('file_criteria');
		
		// get the file criteria record
		$file_criteria_result = $this->GetFileCriteria($account_id, $file_criteria_id, $file_definition_id);
		$error = ( empty($file_criteria_result) || !isset($file_criteria_result['Result']) || !isset($file_criteria_result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->GetFileCriteria() \n\$file_criteria_result: " . print_r($file_criteria_result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($file_criteria_result['Result']) || ($file_criteria_result['Result'] !== TRUE) );   $err_msg = $file_criteria_result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$file_criteria = ( isset($file_criteria_result['Result']) && $file_criteria_result['Result'] == TRUE ) ? $file_criteria_result['Row'] : FALSE;
		$error = ( !is_object($file_criteria) );   $err_msg = "The account was not found in the database. \$file_criteria_id is not an object. \n\$account_id: $account_id \n" . $file_criteria_result['Result_Message'];   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		// set the result value to be set per different conditions through out the next blocks of condition code
		$this_criteria_order = $file_criteria->Criteria_Order;
		$new_criteria_order = "";
		$result_message = "";
//		echo $this_criteria_order . ' -- ' . ($num_rows*100);
		if( (int)$this_criteria_order != 100 && strtolower($sort_direction) == "up" )
		{
			$new_criteria_order = (int)$this_criteria_order-100;
			
			$this->db->where('Account_Id', $account_id);
			$this->db->where('File_Definition_Id', $file_definition_id);
			$this->db->where('Criteria_Order', $new_criteria_order);
			$result = $this->db->get('file_criteria');
			$sql_stmt = $this->db->last_query() ;
			$error = ( is_null($result) || ($result == FALSE) );   $err_msg = "Retieving the file criteria record with the new criteria order failed. \$result is false. \n\$account_id: $account_id \n\$file_criteria_id: $file_criteria_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( $result->num_rows() > 1 );   $err_msg = "More than one record was returned. \$result is false. \n\$account_id: $account_id \n\$file_criteria_id: $file_criteria_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( $result->num_rows() <= 0 );   $err_msg = "Zero or less than zero records were returned. \$result is false. \n\$account_id: $account_id \n\$file_criteria_id: $file_criteria_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			
			$row = $result->row();
			$previous_sort_file_criteria_id = $row->File_Criteria_Id;
			$previous_criteria_order = $row->Criteria_Order;
			$previous_new_criteria_order = $this_criteria_order;
			
			$this->db->set('Criteria_Order', $previous_new_criteria_order);
			$this->db->where('Account_Id', $account_id);
			$this->db->where('File_Definition_Id', $file_definition_id);
			$this->db->where('File_Criteria_Id', $previous_sort_file_criteria_id);
			$result = $this->db->update('file_criteria');
			$sql_stmt = $this->db->last_query() ;
			$error = ( is_null($result) || ($result == FALSE) );   $err_msg = "Updating the file criteria record failed. \$result is false. \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \n\$file_criteria_id: $file_criteria_id \n\$previous_sort_file_criteria_id: $previous_sort_file_criteria_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			
			
			// update the file criteria sort value
			$this->db->set('Criteria_Order', $new_criteria_order);
			$this->db->where('Account_Id', $account_id);
			$this->db->where('File_Definition_Id', $file_definition_id);
			$this->db->where('File_Criteria_Id', $file_criteria_id);
			$result = $this->db->update('file_criteria');
			$sql_stmt = $this->db->last_query() ;
			$error = ( is_null($result) || ($result == FALSE) );   $err_msg = "Updating the file criteria record failed. \$result is false. \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \n\$file_criteria_id: $file_criteria_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			

		}
		else if( (int)$this_criteria_order != ($num_rows*100) && strtolower($sort_direction) == "down" )
		{
			$new_criteria_order = (int)$this_criteria_order+100;
			
			$this->db->where('Account_Id', $account_id);
			$this->db->where('File_Definition_Id', $file_definition_id);
			$this->db->where('Criteria_Order', $new_criteria_order);
			$result = $this->db->get('file_criteria');
			$sql_stmt = $this->db->last_query() ;
			$error = ( is_null($result) || ($result == FALSE) );   $err_msg = "Retieving the file criteria record with the new criteria order failed. \$result is false. \n\$new_criteria_order: $new_criteria_order \n\$account_id: $account_id \n\$file_criteria_id: $file_criteria_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( $result->num_rows() > 1 );   $err_msg = "More than one record was returned. \$result is false. \n\$new_criteria_order: $new_criteria_order \n\$account_id: $account_id \n\$file_criteria_id: $file_criteria_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( $result->num_rows() <= 0 );   $err_msg = "Zero or less than zero records were returned. \$result is false. \n\$new_criteria_order: $new_criteria_order \n\$account_id: $account_id \n\$file_criteria_id: $file_criteria_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			
			$row = $result->row();
			$previous_sort_file_criteria_id = $row->File_Criteria_Id;
			$previous_criteria_order = $row->Criteria_Order;
			$previous_new_criteria_order = $this_criteria_order;
			
			$this->db->set('Criteria_Order', $previous_new_criteria_order);
			$this->db->where('Account_Id', $account_id);
			$this->db->where('File_Definition_Id', $file_definition_id);
			$this->db->where('File_Criteria_Id', $previous_sort_file_criteria_id);
			$result = $this->db->update('file_criteria');
			$sql_stmt = $this->db->last_query() ;
			$error = ( is_null($result) || ($result == FALSE) );   $err_msg = "Updating the file criteria record failed. \$result is false. \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \n\$file_criteria_id: $file_criteria_id \n\$previous_sort_file_criteria_id: $previous_sort_file_criteria_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

			
			// update the file criteria sort value
			$this->db->set('Criteria_Order', $new_criteria_order);
			$this->db->where('Account_Id', $account_id);
			$this->db->where('File_Definition_id', $file_definition_id);
			$this->db->where('File_Criteria_Id', $file_criteria_id);
			$result = $this->db->update('file_criteria');
			$sql_stmt = $this->db->last_query() ;
			$error = ( is_null($result) || ($result == FALSE) );   $err_msg = "Updating the file criteria record failed. \$result is false. \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \n\$file_criteria_id: $file_criteria_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			
			
		}
		else if( (int)$this_criteria_order == 100 )
		{
			$result_message = "The criteria order set for this file criteria is already the lowest sort order. ";
		}
		else if( (int)$this_criteria_order == ($num_rows*100) )
		{
			$result_message = "The criteria order set for this file criteria is already the highest sort order. ";
		}

		$results_array['Result'] = TRUE;
		$results_array['Old_Criteria_Order'] = $this_criteria_order;
		$results_array['New_Criteria_Order'] = $new_criteria_order;
		$results_array['Result_Message'] = $result_message . "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date( "n-j-Y h:i:s A");
		
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		return $results_array;
	}
	
}

