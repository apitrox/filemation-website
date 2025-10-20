<?php if( !defined('BASEPATH') ) die('No direct script access.');

/*
 * Filemation
 */

class Batch_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}


	// =======================================
	// Administration methods
	// =======================================


	//  This method will update add or update tags for all files in a folder for a box account.
	//  @Param 1:	required, the account primary key ID
	//  @Param 2:	required, the box folder id we want to get files from
	//  @Return:	result array
	public function BoxUpdateFilesTags($account_id, $update_files_tags_data)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 2 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($account_id) );   $err_msg = "The \$account_id is empty or invalid. \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($update_files_tags_data['Folder_Name']) );   $err_msg = "The \$update_files_tags_data[Folder_Name] is empty. \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( $update_files_tags_data['Folder_Id'] == '' );   $err_msg = "The \$update_files_tags_data[Folder_Id] is empty. \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($update_files_tags_data['File_Definition_To_Use']) );   $err_msg = "The \$update_files_tags_data[File_Definition_To_Use] is empty. \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( !isset($update_files_tags_data['File_Definition_Id'])  );   $err_msg = "The \$update_files_tags_data[File_Definition_Id] is empty. \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( !isset($update_files_tags_data['File_Definition_To_Use_Criteria_Separator']) );   $err_msg = "The \$update_files_tags_data[File_Definition_To_Use_Criteria_Separator] is empty. \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($update_files_tags_data['Existing_Tags']) );   $err_msg = "The \$update_files_tags_data[Existing_Tags] is empty. \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($update_files_tags_data['Process_Order']) );   $err_msg = "The \$update_files_tags_data[Process_Order] is empty. \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( !isset($update_files_tags_data['Process_In_Order_By_Filename_Order']) );   $err_msg = "The \$update_files_tags_data[Process_In_Order_By_Filename_Order] is empty. \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( !isset($update_files_tags_data['Process_In_Order_Using_File_Criteria_As_A_Date_Order']) );   $err_msg = "The \$update_files_tags_data[Process_In_Order_Using_File_Criteria_As_A_Date_Order] is empty. \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( !isset($update_files_tags_data['Process_In_Order_Using_File_Criteria_As_A_Date_Criteria_Separator']) );   $err_msg = "The \$update_files_tags_data[Process_In_Order_Using_File_Criteria_As_A_Date_Criteria_Separator] is empty. \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}


		// below is a list and description of all the arrays used in this process
		//  each element in each array correspondes to one file to update, unless it is a multi-dimensional array in which case it may be multiple items per file

		// an array containing all the original filenames
		unset( $orig_filename_array ) ;
		$orig_filename_array = array() ;

		// an array containing a flag, 1 or 0, indicating whether or not the file should be updated (a last step in the process)
		unset( $upate_file_array ) ;
		$upate_file_array = array() ;

		// an array containing the file defnition Id for each file
		unset( $file_definition_id_array ) ;
		$file_definition_id_array = array() ;

		// an array containing the file defnition name for each file
		unset( $file_definition_name_array ) ;
		$file_definition_name_array = array() ;

		// an array containing the date of each file as extracted from the name
		unset( $file_date_array ) ;
		$file_date_array = array() ;

		// a multi-dimensional array containing the value for each of the file parts for each file
		unset( $file_parts_array ) ;
		$file_parts_array = array() ;


		// set the local variables we will use to add or update tags for each files.
		$box_folder_name = $update_files_tags_data['Folder_Name'];
		$box_folder_id = $update_files_tags_data['Folder_Id'];
		$file_definition_to_use = $update_files_tags_data['File_Definition_To_Use'];
		$file_definition_id = $update_files_tags_data['File_Definition_Id'];
		$file_definition_to_use_criteria_separator = $update_files_tags_data['File_Definition_To_Use_Criteria_Separator'];
		$how_to_add_tags = $update_files_tags_data['Existing_Tags'];
		$process_order = $update_files_tags_data['Process_Order'];
		$process_in_order_by_filename_order = $update_files_tags_data['Process_In_Order_By_Filename_Order'];
		$process_in_order_using_file_criteria_as_a_date_order = $update_files_tags_data['Process_In_Order_Using_File_Criteria_As_A_Date_Order'];
		$process_in_order_using_file_criteria_as_a_date_criteria_separator = $update_files_tags_data['Process_In_Order_Using_File_Criteria_As_A_Date_Criteria_Separator'];

		// validate required values if they are needed by a the corresponding value.
		$error = ( strtoupper($file_definition_to_use) == "FILE_DEFINITION_1ST_CRITERIA_OF_NAME" && empty($file_definition_to_use_criteria_separator) );   $err_msg = "\$file_definition_to_use equals PROCESS_IN_ORDER_USING_FILE_CRITERIA_AS_A_DATE and \$file_definition_to_use_criteria_separator is empty and it is required. \n\$file_definition_to_use: $file_definition_to_use \n\$file_definition_to_use_criteria_separator: $file_definition_to_use_criteria_separator \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( strtoupper($file_definition_to_use) == "USE_THIS_FILE_DEFINITION" && empty($file_definition_id) );   $err_msg = "\$file_definition_to_use equals USE_THIS_FILE_DEFINITION and \$file_definition_id is empty and it is required. \n\$file_definition_to_use: $file_definition_to_use \n\$file_definition_id: $file_definition_id \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( strtoupper($process_order) == "PROCESS_IN_ORDER_BY_FILENAME" && empty($process_in_order_by_filename_order) );   $err_msg = "\$process_order equals PROCESS_IN_ORDER_BY_FILENAME and \$process_in_order_by_filename_order is empty and it is required. \n\$process_order: $process_order \n\$process_in_order_by_filename_order: $process_in_order_by_filename_order \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( strtoupper($process_order) == "PROCESS_IN_ORDER_USING_FILE_CRITERIA_AS_A_DATE" && (empty($process_in_order_using_file_criteria_as_a_date_criteria_separator) || empty($process_in_order_using_file_criteria_as_a_date_order) ) );   $err_msg = "\$process_in_order_using_file_criteria_as_a_date_order equals PROCESS_IN_ORDER_USING_FILE_CRITERIA_AS_A_DATE and \$process_in_order_using_file_criteria_as_a_date_criteria_separator is empty and it is required. \n\$process_in_order_using_file_criteria_as_a_date_order: $process_in_order_using_file_criteria_as_a_date_order \n\$process_in_order_using_file_criteria_as_a_date_criteria_separator: $process_in_order_using_file_criteria_as_a_date_criteria_separator \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}


		// if the file definition to use is "Use_This_File_Definition" then we will use the file definition id provided to add tags.
		if( strtoupper($file_definition_to_use) == "USE_THIS_FILE_DEFINITION" )
		{
			$this->db->where('Account_Id', $account_id);
			$this->db->where('File_Definition_Id', $file_definition_id);
			$query_result = $this->db->get('file_definitions');
			$sql_stmt = $this->db->last_query() ;
			$error = ( is_null($query_result) || $query_result == FALSE );   $err_msg = "The file definition failed to retrieve. \n\$query_result returned false. \n\$box_folder_id $box_folder_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( $query_result->num_rows() > 1 );   $err_msg = "More than one file definition record was found. \n\$box_folder_id $box_folder_id \n\$query_result->num_rows(): " . $query_result->num_rows() . " \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( $query_result->num_rows() < 1 );   $err_msg = "Zero or less file definition records have been found. \n\$box_folder_id $box_folder_id \n\$query_result->num_rows(): " . $query_result->num_rows() . " \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

			$file_definition = $query_result->row(); // set the file definition row object to be used when adding tags to the box file.
			$file_definition_id = $file_definition->File_Definition_Id; // set the file definition, later used as a box file [tag]
			$file_definition_name = $file_definition->File_Def_Name; // set the file definition name, later used if the file definition uses the file def name as the first file [tag]
			$criteria_separator = $file_definition->Criteria_Separator; // set the criteria separator character used to separate the different parts (file criteria) of the filename
		}


		$return = $this->Data_storage_model->BoxGetFilesFromFolder($account_id, $box_folder_id);
		$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->BoxGetFilesFromFolder() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !isset($return['Data']) );   $err_msg = "\$return[Data] is not set. \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$files_array = $return['Data']; // set the array of files located in the given box folder. this will be the main array of files we use to rename and add tags for.



		// ====================================================
		// Parse file parts and file definition file criteria.
		// Create file tags to be added to the file.
		// ====================================================

		// iterate through the array of files we want to add/update tags for and rename.
		foreach($files_array as $file_key => $file)
		{
			unset($file_tags);
			$file_tags = array(); // set the file tags array used to add file tags to the box file.

			unset($file_id);
			unset($filename);
			$file_id = $file['Id'];
			$filename = $file['Name'];

			$file_info = pathinfo($filename);
			$file_basename = ( isset($file_info['filename']) ) ? $file_info['filename'] : ''; // set the file basename without the extension.
			$file_extension = ( isset($file_info['extension']) ) ? $file_info['extension'] : ''; // set the file extension with the basename.
			$files_array[$file_key]['Pause'] = FALSE; // by default we set the value to pause after renaming to false unless determined that it should be true later.

			// File Definition To Use == Use_The_ID_Tag_As_File_Definition
			// if the file definition to use value equals Use_The_ID_Tag_As_File_Definition then we will need to get any existing tags for the file.
			if( strtoupper($file_definition_to_use) == "USE_THE_ID_TAG_AS_FILE_DEFINITION" )
			{
				// get the existing tags for the user to check if the file has an ID tag to get the file definition previously used to rename the file.
				$result = $this->Data_storage_model->BoxGetFileTags($account_id, $file_id);
				$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->BoxGetFileTags() \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( !isset($result['Tags']) );   $err_msg = "\$result[Tags] is not set. \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

				$existing_file_tags = $result['Tags']; // set the existing file tags.

				// now we have to find the existing ID tag if it exists; if it does not exist then we need to skip the record.
				unset($file_definition_id);
				foreach($existing_file_tags as $existing_tag)
				{
					// we check each tag if it matches our ID tag format, and any previous format used. if we find the ID tag then we need to set the file definition id we continue
					if( preg_match("/Def:/", $existing_tag) != FALSE || preg_match("/ID:/", $existing_tag) != FALSE || preg_match("/ID/", $existing_tag) != FALSE )
					{
						$fd_parts = explode(':', $existing_tag);
						$fd_parts = ( is_array($fd_parts) && (count($fd_parts) > 1) ) ? $fd_parts : explode('ID', $existing_tag);
						$file_definition_id = ( isset($fd_parts[1]) ) ? trim($fd_parts[1]) : '';
					}
				}
				// if the file definition id was found as a tag then proceed, otherwise we don't process the file.
				if( isset($file_definition_id) )
				{
					$this->db->where('Account_Id', $account_id);
					$this->db->where('File_Definition_Id', $file_definition_id);
					$query_result = $this->db->get('file_definitions');
					$sql_stmt = $this->db->last_query() ;
					$error = ( is_null($query_result) || $query_result == FALSE );   $err_msg = "The file definition failed to retrieve. \n\$query_result returned false. \n\$box_folder_id $box_folder_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
					if( $query_result->num_rows() != 1 )
					{
						unset($files_array[$file_key]);
						continue;
					}

					$file_definition = $query_result->row(); // set the file definition row object to be used when adding tags to the box file.
					$file_definition_id = $file_definition->File_Definition_Id; // set the file definition, later used as a box file [tag]
					$file_definition_name = $file_definition->File_Def_Name; // set the file definition name, later used if the file definition uses the file def name as the first file [tag]
					$criteria_separator = $file_definition->Criteria_Separator; // set the criteria separator character used to separate the different parts (file criteria) of the filename
				}
				else
				{
					unset($files_array[$file_key]);
					continue;
				}
			}


			// File Definition To Use == File_Definition_1st_Criteria_Of_Name
			// if the file definition to use value equals File_Definition_1st_Criteria_Of_Name then we will need to get any existing tags for the file.
			// if the file definition to use value equals File_Definition_1st_Criteria_Of_Name then we will attempt to use the first file part to get the file definition
			if( strtoupper($file_definition_to_use) == "FILE_DEFINITION_1ST_CRITERIA_OF_NAME" )
			{
				$filename_parts = explode($file_definition_to_use_criteria_separator, $file_basename);
				if( count($filename_parts) <= 1 )
				{
					continue;
				}

				$this->db->where('Account_Id', $account_id);
				$this->db->where('File_Def_Name', trim($filename_parts[0]));
				$query_result = $this->db->get('file_definitions');
				$sql_stmt = $this->db->last_query();
				$error = ( is_null($query_result) || $query_result == FALSE );   $err_msg = "The file definition query returned false. \n\$query_result returned false. \n\$filename_parts[0] File_Def_Name: " . $filename_parts[0] . " \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				if( $query_result->num_rows() != 1 )
				{
					unset($files_array[$file_key]);
					continue;
				}

				$file_definition = $query_result->row(); // set the file definition row object to be used when adding tags to the box file.
				$file_definition_id = $file_definition->File_Definition_Id; // set the file definition, later used as a box file [tag]
				$file_definition_name = $file_definition->File_Def_Name; // set the file definition name, later used if the file definition uses the file def name as the first file [tag]
				$criteria_separator = $file_definition->Criteria_Separator; // set the criteria separator character used to separate the different parts (file criteria) of the filename
			}

			// at this point we should have the file definition, and if we do not skip this file and continue to the next file in the array.
			if( empty($file_basename) || !isset($file_definition) || empty($file_definition) )
			{
				unset($files_array[$file_key]);
				continue;
			}

			$filename_parts = explode($criteria_separator, $file_basename);

			if (  ($file_definition->Definition_Starts_Filename == 1) && (strtoupper($file_definition_to_use) == "USE_THIS_FILE_DEFINITION") )
			{
				if ( strtoupper($filename_parts[0]) == strtoupper($file_definition_to_use) )
				{
					//  if the file definition to use is already the first file part, then go on without doing anything here
				}
				else
				{
					//  **** if the first file part is equal to a different file definition, then don't do anything with this file
					unset($files_array[$file_key]);
					continue;
					//  **** else, insert the specified file definition as the first file part, $filename_parts[0] = USE_THIS_FILE_DEFINITION
				}
			}

			$filename_parts_count = count($filename_parts); //( $file_definition->Definition_Starts_Filename == 1 ) ? (count($filename_parts)-1) : count($filename_parts);
			if( $filename_parts_count <= 1 ) // only add the tags to the file if the file parts count is greater than 1. chances, are if the file part count equals 1 the file was never named by filemation.
			{
				$error = ( 1===0 );   $err_msg = "The filename parts count is less than 1. \$filename_parts_count is less than 1. \n\$filename_parts_count: $filename_parts_count \n\$file_basename: $file_basename" ;   $notify = FALSE;   $severity = "NOTICE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				unset($files_array[$file_key]);
				continue;
			}

			// if the file definition name starts the filename then lets add the file definition as a file tag
			if( $file_definition->Definition_Starts_Filename == 1  )
			{
				$file_tags[] = $file_definition_name;
			}


			// rename the file then replace the file on the account's box data storage account.
			// next, since we have the file definition id we can get all of the file criteria associated with the file definition
			$return = $this->File_criteria_model->GetAllFileCriteriaForFileDefinition($file_definition_id);
			$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->File_criteria_model->GetAllFileCriteriaForFileDefinition() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( !isset($return['Data']) || empty($return['Data']) );   $err_msg = "\$return[Data] is not set or empty, and it is required. \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

			$file_criteria_array = $return['Data']; // set the file criteria data array

			$original_file_criteria_array = $file_criteria_array; // reset the file criteria array to a separate array because we will be manipulating the other file criteria array.
			$file_criteria_required_count = 0;
			foreach($file_criteria_array as $key => $fc)
			{
				unset($criteria_required);
				$criteria_required = (int)$fc['Criteria_Required'];
				if( $criteria_required != 1 )
				{
					unset($file_criteria_array[$key]);
				}
			}

			$file_criteria_count = ( $file_definition->Definition_Starts_Filename == 1 ) ? (count($original_file_criteria_array)+1) : count($original_file_criteria_array); // the total number of file criteria assocated with the file definition, plus 1 more file criteria if the file definition uses the definition name as the first filename part.
			$file_criteria_required_count = ( $file_definition->Definition_Starts_Filename == 1 ) ? ( count($file_criteria_array)+1 ) : count($file_criteria_array); // the total number of file criteria that is required by the user to be file or rename the file, plus 1 more if the file definition uses the definition name as the first filename part.
			if( DEBUG && $test ) {echo "Filename parts count: $filename_parts_count \n"; echo "File Criteria count: $file_criteria_count \n";	echo "File Criteria Required count: $file_criteria_required_count \n"; }

			// if the filename parts does not equal 0, equals the total required file criteria for the file definition, or equal the total file criteria rows for the file definition.
			if( ( ( $filename_parts_count == $file_criteria_count ) || (  $filename_parts_count == $file_criteria_required_count ) ) )
			{
				// we need to get the file criteria record so we can scrub the prefix and suffix, if it exists, from the file part string.
				$file_criteria_array_2 = $original_file_criteria_array;
				if( $filename_parts_count == $file_criteria_required_count )
				{
					$file_criteria_array_2 = $file_criteria_array;
				}
				reset($file_criteria_array_2); // reset the file criteria array so we can start with the first array member.


				unset($file_criteria);
				unset($file_criteria_dates);
				$file_criteria = array(); // the array we store our file criteria to rename the file with.
				$file_criteria_dates = array(); // the array we store our file parts that are dates which we will use below to re-order the way we process the files
				foreach($filename_parts as $key => $part)
				{

					if( $file_definition->Definition_Starts_Filename == 1 && $key == 0 ) { continue; } // if the file definition uses the definition name as the first filename part skip over it because it is not a file criteria value

					$fc_rec = current($file_criteria_array_2);
					$fc_prefix = $fc_rec['Criteria_Prefix'];
					$fc_suffix = $fc_rec['Criteria_Suffix'];

					// strip the prefix and suffix from the file part/file criteria
					$criteria = trim($part);
					$criteria = ( !empty($fc_prefix) ) ? str_replace($fc_prefix, '', $criteria) : $criteria;
					$criteria = ( !empty($fc_suffix) ) ? str_replace($fc_suffix, '', $criteria) : $criteria;


					// scrub any "Date" file criteria
					if( $fc_rec['Criteria_Type_Name'] == "Date" )
					{
//						echo "\n===== This is a Date file criteria =====\n : $criteria";
						// we have removed the prefix and suffix above.
						//$criteria = str_replace('/', '-', str_replace('.', '-', str_replace('\\', '-', str_replace(':', '-', str_replace('', '-', str_replace('_', '-', $criteria)))))); // replace "/", "\", ".", ":", ";", " ", "_" to "-"
						//$criteria = preg_replace('/[^-0-9]/', '', $criteria); // replace all characters except numeric and "-".
						$criteria = str_replace('-', '/', str_replace('.', '/', str_replace('\\', '/', str_replace(':', '/', str_replace(' ', '/', str_replace('_', '/', $criteria)))))); // replace "-", "\", ".", ":", ";", " ", "_" to "/"
						$criteria = preg_replace('/[^\/0-9]/', '', $criteria); // replace all characters except numeric and "-".
						$criteria = date($fc_rec['Criteria_Php_Date_Format_Str'], strtotime($criteria . " 00:00:00")); // reformat the date in the format saved with the file criteria.

						$file_criteria_dates[] = $criteria; // add the scrubbed date to the array of file criteria dates which we will use below to re-order the order we process our files.
					}

					// scrub any "Number" file criteria
					if( $fc_rec['Criteria_Type_Name'] == "Number" )
					{
//						echo "\n===== This is a Number file criteria =====\n";
						// we have removed the prefix and suffix above.
						$criteria = preg_replace('/[^0-9\-\.\,]/', '', $criteria); // removing all characters except numerals, dash, period, comma ("0-9", "-", ".", ",")
						$criteria = number_format($criteria, 2, $fc_rec['Criteria_Dec_Point'], $fc_rec['Criteria_Thousands_Sep']);
						// the prefix and suffix gets added below

					}

					// scrub any "Currency" file criteria
					if( $fc_rec['Criteria_Type_Name'] == "Currency" )
					{
//						echo "\n===== This is a Currency file criteria =====\n";
						// we have removed the prefix and suffix above.
						$criteria = preg_replace('/[^0-9\-\.\,]/', '', $criteria); // removing all characters except numerals, dash, period, comma ("0-9", "-", ".", ",")
						$criteria = number_format($criteria, 2, $fc_rec['Criteria_Dec_Point'], $fc_rec['Criteria_Thousands_Sep']);
						$criteria = ( substr(0, 1, $criteria) != $fc_rec['Criteria_Currency_Symbol'] ) ? $fc_rec['Criteria_Currency_Symbol'] . $criteria : $criteria;
						// the prefix and suffix gets added below
					}

					// add the prefix and suffix to the file part because it is possible it did not exist before.
					$criteria = $fc_prefix . $criteria; // add prefix
					$criteria = $criteria . $fc_suffix; // add suffix

					$file_criteria[] = $criteria; // add the file criteria to the array of file criteria.
					$file_tags[] = $criteria; // add the file criteria value after the prefix and suffix is stripped from the value as a file tag.

					// as we construct the file criteria to rename the file, we need to format the file tags to add the file tags.
					// Existing_Tags == Leave_Existing_Tags
					if( strtoupper($how_to_add_tags) == "LEAVE_EXISTING_TAGS" )
					{
						// if we haven't already retrieved the existing tags for the file, get them now. this check will save an extra call that is not needed.
						if( !isset($existing_tags) )
						{
							$result = $this->Data_storage_model->BoxGetFileTags($account_id, $file_id);
							$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->BoxGetFileTags() \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
							$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
							$error = ( !isset($result['Tags']) );   $err_msg = "\$result[Tags] is not set. \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

							$existing_tags = $result['Tags'];
						}

						// iterate through the existing tags and check if we need to add any new tags.
						unset($corresponding_existing_tags);
						$corresponding_existing_tags = array();
						foreach($existing_tags as $tag)
						{
							if( array_search($tag, $file_tags) == FALSE )
							{
								$file_tags[] = $tag;
							}
						}
						unset($existing_tags); // clean up
					}
					// Existing_Tags == Replace_All_Existing
					// nothing to do...


					// move the pointer to the next member in the file criteria corresponding
					next($file_criteria_array_2);
				}

				$files_array[$file_key]['File_Criteria_Date_Values'] = $file_criteria_dates; // set an array of dates that existed in the filename, so we can use them below to re order the filenames below.
			}
			else
			{
				unset($files_array[$file_key]);
				continue; // the total file criteria count, or the total required file criteria count do not equal the file parts count (minus the file definition name as a file part if it is a file part and the file definition is set to use the file def name as the first file part)
			}

			// lets add the file definition id tag to use to prepopulate the file criteria if the file is ever to be renamed by filemation
			$file_tags[] = "ID$file_definition_id";

			// Existing_Tags == Remove_All_Tags
			// if remove all tags was selected set the file tags array to an empty array.
			if( strtoupper($how_to_add_tags) == "REMOVE_ALL_TAGS" )
			{
				$file_tags = array(); // set the file tags array to an empty array.
			}

			// set the file tags to the file array to be used when we add tags to the uploaded file below.
			$files_array[$file_key]['File_Tags'] = $file_tags;


			// after we have reformated the fileparts we want to rename the file with the new file which will be uploaded next.
			// here we are just determining the new filename.
			$new_filename = $file_definition->File_Def_Name . $file_definition->Criteria_Separator;
			foreach($file_criteria as $key => $criteria)
			{
				$new_filename .= ( count($file_criteria) == ($key+1) ) ? $criteria : $criteria . $file_definition->Criteria_Separator;
			}
			$new_filename .= "." . $file_extension; // put the file extension on the end of the full path and filename. the file extension is set way up above.

			// set the new path filename to the file array to be used when we upload the new file and add tags to the file below.
			$files_array[$file_key]['New_Filename'] = $new_filename;


		}

		// ==================================
		// Process Order
		// ==================================

		// before we process the order of the files to be renamed and tagged we need to reset the keys in numerical order because some of the file entries
		// may have been removed above which would cause some key numbers to have been skipped in the current order. this would cause illegal offset errors
		// in the process orders below.
		$reset_counter = 0;
		$reset_tmp_files_array = $files_array;
		unset($files_array);
		$files_array = array();
		foreach($reset_tmp_files_array as $key => $file)
		{
			$files_array[$reset_counter] = $file;
			$reset_counter++;
		}
		unset($reset_tmp_files_array);

		// Process_Order == Process_In_Order_By_Filename
		// If the Process_Order value is Process_In_Order_By_Filename
		unset($tmp_files_array);
		unset($tmp_files_finished_array);
		$tmp_files_array = array();
		$tmp_files_sorted_array = array();
		if( strtoupper($process_order) == "PROCESS_IN_ORDER_BY_FILENAME" && strtoupper($process_in_order_by_filename_order) == "A_Z" )
		{
			foreach($files_array as $key => $file)
			{
				$tmp_files_array[$key] = $file['Name'];
			}
			sort($tmp_files_array);
			foreach($tmp_files_array as $key => $value)
			{
				$tmp_files_sorted_array[] = $files_array[$key];
			}
			$files_array = $tmp_files_sorted_array;
		}
		elseif( strtoupper($process_order) == "PROCESS_IN_ORDER_BY_FILENAME" && strtoupper($process_in_order_by_filename_order) == "Z_A" )
		{
			foreach($files_array as $key => $file)
			{
				$tmp_files_array[$key] = $file['Name'];
			}
			rsort($tmp_files_array);
			foreach($tmp_files_array as $key => $value)
			{
				$tmp_files_sorted_array[] = $files_array[$key];
			}
			$files_array = $tmp_files_sorted_array;
		}
		// clean up unused arrays
		unset($tmp_files_array);
		unset($tmp_files_sorted_array);

		// Process_order == Process_In_Order_Using_File_Criteria_As_A_Date
		// If the Process_Order value is Process_In_Order_Using_File_Criteria_As_A_Date
		//
		// first we need to iterate through all the files, and then get the last part of the file. if the last part of the file is a date, then add the date to a corresponding
		// array. after we get each file that has a date as the last filename file criteria part sort the array. after we sort the array reiterate through the array and change the value
		// to the filename.
		if( strtoupper($process_order) == "PROCESS_IN_ORDER_USING_FILE_CRITERIA_AS_A_DATE" )
		{
			unset($temp_files_array);
			unset($tmp_files_sorted_array);
			$tmp_files_array = array();
			$tmp_files_sorted_array = array();
			foreach($files_array as $key => $file)
			{
				unset($dates);
				$dates_array = $file['File_Criteria_Date_Values'];
				if( empty($dates_array) )
				{
					continue;
				}

				$tmp_files_array[$key] = strtotime(end($dates_array));

			}

			if( strtoupper($process_in_order_using_file_criteria_as_a_date_order) == "EARLIEST_LATEST" )
			{
				asort($tmp_files_array, SORT_NUMERIC | SORT_FLAG_CASE);
			}
			elseif( strtoupper($process_in_order_using_file_criteria_as_a_date_order) == "LATEST_EARLIEST" )
			{
				arsort($tmp_files_array, SORT_NUMERIC | SORT_FLAG_CASE);
			}

			foreach($tmp_files_array as $key => $date)
			{
				$files_array[$key]['Pause'] = TRUE;
				$tmp_files_sorted_array[] = $files_array[$key];

			}
			$files_array = $tmp_files_sorted_array;
		}
		// clean up unused arrays
		unset($tmp_files_array);
		unset($tmp_files_sorted_array);
		// if the Process_Order value is No_Sort no action needed.

		// =================================
		// Rename file and add tags
		// =================================

		// last rename the file and add tags if called for.
		foreach($files_array as $file)
		{
			unset($file_id);
			unset($new_path_filename);
			unset($file_tags);
			$file_id = $file['Id']; // set the file id we will use to delete the file.
			$new_filename = $file['New_Filename']; // set the new path filename to upload the file below.
			$file_tags = $file['File_Tags']; // set the file tags array to be used below when adding file tags below.

			// rename the file
			$file_data = array();
			$file_data['Name'] = $new_filename;
			$result = $this->Data_storage_model->BoxUpdateFileInformation($account_id, $file_id, $file_data);
			$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->BoxAddFilesTagsToFile() \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

			// after renaming the file, and uploading the file now add the file tags to the file on box.
			$result = $this->Data_storage_model->BoxAddFilesTagsToFile($account_id, $file_id, $file_tags);
			$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->BoxAddFilesTagsToFile() \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

			// if it has been deteremiend to pause after renaming then we need to pause for 1 second.
			if( isset($file['Pause']) && $file['Pause'] == TRUE )
			{
				sleep(1);
			}
		}


		// if we get here the method has completed successfully, wrap up and return results array
		$results_array['Result'] = TRUE;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}

	//  This method upload files from a folder on the local server to the user's box account and then adds and updates the tags.
	//  This Method is NOT being used and is NOT finished.
	public function BoxUploadFilesAndAddTags()
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 0 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$account_id = $this->auth_lib->GetAccountId(); // *** we could set this to the current user's account id, but instead we just hard code it, because this is an administrator method



		$return = $this->Data_storage_model->BoxGetAllFolders($account_id); // get 'all' folders in the root box account folder
		$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->BoxGetAllFolders() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !isset($return['Data']) );   $err_msg = "\$return[Data] is not set. \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$box_acc_folders_array = $return['Data']; // set array of all folders in the root box account folder


		$key = 0;
		$box_folders_tree_array = array(); // a method to get a tree or every folder in a box account does not exist in the box v2 api yet, so we have to do this manually. we will go 5 branches.
		foreach($box_acc_folders_array as $folder) // (1)
		{
			unset($box_folder_path);
			unset($box_folder_id);
			$box_folder_path = $folder['Full_Folder_Path'];
			$box_folder_id = $folder['Id'];

			$box_folders_tree_array[$key]['Box_Folder_Path'] = $box_folder_path;
			$box_folders_tree_array[$key]['Box_Folder_Id'] = $box_folder_id;
			$key++;

			// now we check if there are any folders in this folder (2)
			unset($return);
			$return = $this->Data_storage_model->BoxGetAllFoldersInFolder($account_id, $box_folder_id); // get 'all' folders in the root box account folder
			$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->BoxGetAllFolders() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( !isset($return['Data']) );   $err_msg = "\$return[Data] is not set. \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

			$box_acc_folders_array2 = $return['Data']; // set array of all folders in the root box account folder
			foreach($box_acc_folders_array2 as $folder2)
			{
				unset($box_folder_path);
				unset($box_folder_id);
				$box_folder_path = $folder2['Full_Folder_Path'];
				$box_folder_id = $folder2['Id'];

				$box_folders_tree_array[$key]['Box_Folder_Path'] = $box_folder_path;
				$box_folders_tree_array[$key]['Box_Folder_Id'] = $box_folder_id;
				$key++;

				// now we check if there are any folders in this folder (3)
				unset($return);
				$return = $this->Data_storage_model->BoxGetAllFoldersInFolder($account_id, $box_folder_id); // get 'all' folders in the root box account folder
				$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->BoxGetAllFolders() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( !isset($return['Data']) );   $err_msg = "\$return[Data] is not set. \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

				$box_acc_folders_array3 = $return['Data']; // set array of all folders in the root box account folder
				foreach($box_acc_folders_array3 as $folder3)
				{
					unset($box_folder_path);
					unset($box_folder_id);
					$box_folder_path = $folder3['Full_Folder_Path'];
					$box_folder_id = $folder3['Id'];

					$box_folders_tree_array[$key]['Box_Folder_Path'] = $box_folder_path;
					$box_folders_tree_array[$key]['Box_Folder_Id'] = $box_folder_id;
					$key++;

					// now we check if there are any folders in this folder (4)
					unset($return);
					$return = $this->Data_storage_model->BoxGetAllFoldersInFolder($account_id, $box_folder_id); // get 'all' folders in the root box account folder
					$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->BoxGetAllFolders() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
					$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
					$error = ( !isset($return['Data']) );   $err_msg = "\$return[Data] is not set. \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

					$box_acc_folders_array4 = $return['Data']; // set array of all folders in the root box account folder
					foreach($box_acc_folders_array4 as $folder4)
					{
						unset($box_folder_path);
						unset($box_folder_id);
						$box_folder_path = $folder4['Full_Folder_Path'];
						$box_folder_id = $folder4['Id'];

						$box_folders_tree_array[$key]['Box_Folder_Path'] = $box_folder_path;
						$box_folders_tree_array[$key]['Box_Folder_Id'] = $box_folder_id;
						$key++;

						// now we check if there are any folders in this folder (4)
						unset($return);
						$return = $this->Data_storage_model->BoxGetAllFoldersInFolder($account_id, $box_folder_id); // get 'all' folders in the root box account folder
						$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->BoxGetAllFolders() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
						$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
						$error = ( !isset($return['Data']) );   $err_msg = "\$return[Data] is not set. \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

						$box_acc_folders_array5 = $return['Data']; // set array of all folders in the root box account folder
						foreach($box_acc_folders_array5 as $folder5)
						{
							unset($box_folder_path);
							unset($box_folder_id);
							$box_folder_path = $folder5['Full_Folder_Path'];
							$box_folder_id = $folder5['Id'];

							$box_folders_tree_array[$key]['Box_Folder_Path'] = $box_folder_path;
							$box_folders_tree_array[$key]['Box_Folder_Id'] = $box_folder_id;
							$key++;

							// now we check if there are any folders in this folder (4)
							unset($return);
							$return = $this->Data_storage_model->BoxGetAllFoldersInFolder($account_id, $box_folder_id); // get 'all' folders in the root box account folder
							$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->BoxGetAllFolders() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
							$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
							$error = ( !isset($return['Data']) );   $err_msg = "\$return[Data] is not set. \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

							$box_acc_folders_array6 = $return['Data']; // set array of all folders in the root box account folder
							foreach($box_acc_folders_array6 as $folder6)
							{
								unset($box_folder_path);
							unset($box_folder_id);
							$box_folder_path = $folder5['Full_Folder_Path'];
							$box_folder_id = $folder5['Id'];

							$box_folders_tree_array[$key]['Box_Folder_Path'] = $box_folder_path;
							$box_folders_tree_array[$key]['Box_Folder_Id'] = $box_folder_id;
							$key++;

							}
						}

					}

				}

			}

		}


		echo "<pre>"; print_r($box_folders_tree_array);


		// if we get here the method has completed successfully, wrap up and return results array
		$results_array['Result'] = TRUE;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}
}