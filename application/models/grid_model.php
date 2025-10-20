<?php if( !defined('BASEPATH') ) die('No direct script access');

/*
 * Filemation
 */

class Grid_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	
	//  This method queries to get all file definition records for a given account, and it constructs it to be read in the config file definitions grid
	//  @Param 1:	required, the primary account key ID
	//  @Param 2:	optional, the data to filter the grid results
	//  @Record:	result array
	public function GetConfigFileDefinitionsData($account_id, $data)
	{
		// The second parameter $data is used to filter the data results.
		// The second parameter can be empty, but the following data sets are set in the data value given.
		// bRegex
		// bRegex_0
		// bSearchable_0
		// bSortable_0
		// iColumns
		// iDisplayLength
		// iDisplayStart
		// iSortCol_0
		// iSortingCols
		// mDataPromp_0
		// sColumns
		// sEcho
		// sSearch
		// sSearch_0
		// sSortDir_0
		
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 2 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty or invalid. \n\$account_id: $account_id \n\func_get_args(): " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		// build dataTables ajax server json response.
		$results_array['sEcho'] = ( isset($data['sEcho']) && $data['sEcho'] != FALSE ) ? intval($data['sEcho']) : 1;
		$results_array['iTotalRecords'] = 0;
		$results_array['iTotalDisplayRecords'] = 0;
		$results_array['aaData'] = array();
		
		// get total record count for the given account ID
		$this->db->where('Account_Id', $account_id);
		$total_records = $this->db->count_all_results('file_definitions');
		$results_array['iTotalRecords'] = $total_records;
		
		// build columns to filter result
		$list_columns = array('file_definitions.File_Def_Name');
		
		// build query sql
		$sql_assembly = '';
		
		// sql select
		// ----------------------------------------------
		$sql_select = '';
		$sql_select .= "SELECT ";
		$sql_select .= "File_Definition_Id AS 'File_Definition_Id' , ";
		$sql_select .= "Account_Id AS 'Account_Id' , ";
		$sql_select .= "File_Def_Name AS 'File_Def_Name' , ";
		$sql_select .= "Default_Destination_Path AS 'Default_Destination_Path' , ";
		$sql_select .= "Is_Destination_Path_Selectable AS 'Is_Destination_Path_Selectable' , ";
		$sql_select .= "Min_Pages AS 'Min_Pages' , ";
		$sql_select .= "Max_Pages AS 'Max_Pages' , ";
		$sql_select .= "Definition_Starts_Filename AS 'Definition_Starts_Filename' , ";
		$sql_select .= "Criteria_Separator AS 'Criteria_Separator' , ";
		$sql_select .= "Update_Modified_Date AS 'Update_Modified_Date' , ";
		$sql_select .= "Update_Created_Date AS 'Update_Created_Date' ";
			
		// sql from
		// ----------------------------------------------
		$sql_from = "";
		$sql_from .= "FROM ";
		$sql_from .= "file_definitions ";
		
		
		// sql where (filter search results by column)
		// ----------------------------------------------
		$sql_where = "";
		$sql_where .= "WHERE ";
		$sql_where .= "file_definitions.Account_Id = $account_id";
		if ( isset($data['sSearch']) && $data['sSearch'] != "" )
		{
			$sql_where .= " AND (";
			for ( $i=0 ; $i<count($list_columns) ; $i++ )
			{
				$sql_where .= $list_columns[$i]." LIKE '%".mysql_real_escape_string( $data['sSearch'] )."%' OR ";
			}
			$sql_where = substr_replace( $sql_where, "", -3 );
			$sql_where .= ')';
		}
		
		// sql order
		// ----------------------------------
		$sql_order = "";
		if ( isset( $data['iSortCol_0'] ) )
		{
			$sql_order .= " ORDER BY  ";
			for ( $i=0 ; $i<intval( $data['iSortingCols'] ) ; $i++ )
			{
				if ( $data[ 'bSortable_' . intval($data['iSortCol_'.$i]) ] == "true" )
				{
					$sql_order .= $list_columns[ intval( $data['iSortCol_'.$i] ) ] .
						' ' . mysql_real_escape_string( $data['sSortDir_'.$i] ) .", ";
				}
			}
			
			$sql_order = substr_replace( $sql_order, "", -2 );
			if ( trim(strtoupper($sql_order)) == "ORDER BY" )
			{
				$sql_order = "";
			}
		}
		
		// sql limit (paging)
		// ---------------------------------
		$sql_limit = "";
		if ( isset( $data['iDisplayStart'] ) && $data['iDisplayLength'] != '-1' )
		{
			$sql_limit = " LIMIT ". $data['iDisplayStart'] . " , " . $data['iDisplayLength'];
		}
		
		
		// query and get result
		$sql_assembly = $sql_select . $sql_from . $sql_where . $sql_order . $sql_limit; 
		$result = $this->db->query($sql_assembly);
		$sql_stmt = $this->db->last_query() ;
		$error = ( is_null($result) || ($result == FALSE) );   $err_msg = "Selecting the file definition records failed. \$result returned false. \n\$account_id: $account_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		
		// format list array
		if($result->num_rows() > 0)
		{
			foreach($result->result() as $row)
			{
				
				$file_definition_id = $row->File_Definition_Id;
				$account_id = $row->Account_Id;
				$file_def_name = $row->File_Def_Name;
				$default_destination_path = $row->Default_Destination_Path;
				$is_destination_path_selectable = $row->Is_Destination_Path_Selectable;
				$min_pages = $row->Min_Pages;
				$max_pages = $row->Max_Pages;
				$definition_starts_filename = $row->Definition_Starts_Filename;
				$criteria_separator = $row->Criteria_Separator;
				$update_modified_date = $row->Update_Modified_Date;
				$update_created_date = $row->Update_Created_Date;
				
				$is_selectable_str = ( (int)$is_destination_path_selectable == 1 ) ? "is selectable": "is <i>not</i> selectable";// the is destination path selectable string for the data cell
				$min_pages_str = ( $min_pages > 0 ) ? $min_pages : "none";
				$max_pages_str = ( $max_pages > 0 ) ? $max_pages : "none";
				$criteria_separator_str = $criteria_separator;
				$update_modified_date_str = ( $update_modified_date == 1 ) ? "Yes" : "No";
				$update_created_date_str = ( $update_created_date == 1 ) ? "Yes" : "No";
				$sort_buttons = "<div class='btn-group btn-group-xs pull-right'>";
				$sort_buttons .= "<button class='btn btn-default btn-xs tt' data-placement='top' data-toggle='tooltip' title='Edit file definition' onclick='LoadConfigFileDefinition($file_definition_id);'><i class='fa fa-pencil'></i></button>";
				$sort_buttons .= "<button class='btn btn-default btn-xs tt' data-placement='top' data-toggle='tooltip' title='Delete file definition' onclick='DeleteFileDefinition($file_definition_id, this);'><i class='fa fa-times'></i></button>";
				$sort_buttons .= "</div>";
				
				// format cell data
				$row = "";
				$row .= "<div class='pull-left'><a href='#' onclick='LoadConfigFileDefinition($file_definition_id);'><strong>$file_def_name</strong></a><br/>";
				$row .= "Default Destination Folder: <span class='config_file_definitions_grid_source_folder_name' rel='$default_destination_path'><i class='fa fa-circle-o-notch fa-spin'></i></span>, $is_selectable_str<br/>";
				$row .= "<div style='float: left; width: 200px;' class='grid_row_small_print'>Min/Max Pages: <i>$min_pages_str/$max_pages_str</i></div> <div style='float: left; width: auto;' class='grid_row_small_print'>Update Modified/Created Date: <i>$update_modified_date_str/$update_created_date_str</i></div></div>";
				$row .= $sort_buttons;
				
				unset($record_row);
				$record_row = array();
				$record_row[] = $row;
				
				array_push($results_array['aaData'], $record_row);
			}
		}
		
		// set total display records
		$results_array['iTotalDisplayRecords'] = $total_records; //$result->num_rows();
		$results_array['iTotalRecords'] = $result->num_rows();
		
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		return $results_array;
	}
	
	
	//  This method queries to get all file criteria records for a given account, and it constructs it to be read in the config file criteria grid
	//  @Param 1:	required, the primary account key ID
	//  @Param 2:	optional, the data to filter the grid results
	//  @Record:	result array
	public function GetConfigFileCriteriaData($account_id, $data)
	{
		// The second parameter $data is used to filter the data results.
		// The second parameter can be empty, but the following data sets are set in the data value given.
		// file_definition_id   <-- this is the file definition primary key
		// bRegex
		// bRegex_0
		// bSearchable_0
		// bSortable_0
		// iColumns
		// iDisplayLength
		// iDisplayStart
		// iSortCol_0
		// iSortingCols
		// mDataPromp_0
		// sColumns
		// sEcho
		// sSearch
		// sSearch_0
		// sSortDir_0
		
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 2 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty or invalid. \n\$account_id: $account_id \n\func_get_args(): " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		$file_definition_id = ( isset($data['file_definition_id']) && !empty($data['file_definition_id']) ) ? $data['file_definition_id'] : '';
		
		// build dataTables ajax server json response.
		$results_array['sEcho'] = ( isset($data['sEcho']) && $data['sEcho'] != FALSE ) ? intval($data['sEcho']) : 1;
		$results_array['iTotalRecords'] = 0;
		$results_array['iTotalDisplayRecords'] = 0;
		$results_array['aaData'] = array();
		
		// build columns to filter result
		$list_columns = array('file_criteria.Criteria_Name');
		
		// build query sql
		$sql_assembly = '';
		
		// sql select
		// ----------------------------------------------
		$sql_select = '';
		$sql_select .= "SELECT ";
		$sql_select .= "file_criteria.File_Criteria_Id AS 'File_Criteria_Id' , ";
		$sql_select .= "file_criteria.Account_Id AS 'Account_Id' , ";
		$sql_select .= "file_criteria.File_Definition_Id AS 'File_Definition_Id' , ";
		$sql_select .= "file_criteria.Criteria_Order AS 'Criteria_Order' , ";
		$sql_select .= "file_criteria.Criteria_Name AS 'Criteria_Name' , ";
		$sql_select .= "file_criteria.Criteria_Type_Id AS 'Criteria_Type_Id' , ";
		$sql_select .= "file_criteria.Criteria_Required AS 'Criteria_Required' , ";
		$sql_select .= "file_criteria.Criteria_Min_Len AS 'Criteria_Min_Len' , ";
		$sql_select .= "file_criteria.Criteria_Max_Len AS 'Criteria_Max_Len' , ";
		$sql_select .= "file_criteria.Criteria_Default_Value AS 'Criteria_Default_Value' , ";
		$sql_select .= "file_criteria.Criteria_Tooltip AS 'Criteria_Tooltip' , ";
		$sql_select .= "file_criteria.Criteria_Recall_Name AS 'Criteria_Recall_Name' , ";
		$sql_select .= "file_criteria.Criteria_Prefix AS 'Criteria_Prefix' , ";
		$sql_select .= "file_criteria.Criteria_Suffix AS 'Criteria_Suffix' , ";
		$sql_select .= "file_criteria.Criteria_Decimals AS 'Criteria_Decimals' , ";
		$sql_select .= "file_criteria.Criteria_Dec_Point AS 'Criteria_Dec_Point' , ";
		$sql_select .= "file_criteria.Criteria_Thousands_Sep AS 'Criteria_Thousands_Sep' , ";
		$sql_select .= "file_criteria.Criteria_Currency_Symbol AS 'Criteria_Currency_Symbol' , ";
		$sql_select .= "file_criteria.Days_Back AS 'Days_Back' , ";
		$sql_select .= "file_criteria.Date_Back AS 'Date_Back' , ";
		$sql_select .= "file_criteria.Days_Forward AS 'Days_Forward' , ";
		$sql_select .= "file_criteria.Date_Forward AS 'Date_Forward' , ";
		$sql_select .= "file_criteria.Criteria_Php_Date_Format_Str AS 'Criteria_Php_Date_Format_Str' , ";
		$sql_select .= "file_criteria.Criteria_JavaScript_Date_Format_Str AS 'Criteria_JavaScript_Date_Format_Str' , ";
		$sql_select .= "file_definitions.File_Def_Name AS 'File_Def_Name' , ";
		$sql_select .= "criteria_types_ref.Criteria_Type_Name AS 'Criteria_Type_Name' ";
		
			
		// sql from
		// ----------------------------------------------
		$sql_from = "";
		$sql_from .= "FROM ";
		$sql_from .= "file_criteria ";
		$sql_from .= "JOIN file_definitions ON(file_criteria.File_Definition_Id = file_definitions.File_Definition_Id)";
		$sql_from .= "JOIN criteria_types_ref ON(file_criteria.Criteria_Type_Id = criteria_types_ref.Criteria_Type_Id)";
		
		
		// sql where (filter search results by column)
		// ----------------------------------------------
		$sql_where = "";
		$sql_where .= " WHERE ";
		$sql_where .= "file_criteria.Account_Id = $account_id ";
		if( !empty($file_definition_id) )
		{
			$sql_where .= "AND file_criteria.File_Definition_Id = $file_definition_id ";
		}
//		if ( isset($data['sSearch']) && $data['sSearch'] != "" )
//		{
//			$sql_where .= " AND (";
//			for ( $i=0 ; $i<count($list_columns) ; $i++ )
//			{
//				$sql_where .= $list_columns[$i]." LIKE '%".mysql_real_escape_string( $data['sSearch'] )."%' OR ";
//			}
//			$sql_where = substr_replace( $sql_where, "", -3 );
//			$sql_where .= ')';
//		}
		
		// sql order
		// ----------------------------------
		$sql_order = "";
		if ( isset( $data['iSortCol_0'] ) )
		{
			$sql_order .= " ORDER BY  ";
			for ( $i=0 ; $i<intval( $data['iSortingCols'] ) ; $i++ )
			{
				if ( $data[ 'bSortable_' . intval($data['iSortCol_'.$i]) ] == "true" )
				{
					$sql_order .= $list_columns[ intval( $data['iSortCol_'.$i] ) ] .
						' ' . mysql_real_escape_string( $data['sSortDir_'.$i] ) .", ";
				}
			}
			
			$sql_order = substr_replace( $sql_order, "", -2 );
			if ( trim(strtoupper($sql_order)) == "ORDER BY" )
			{
				$sql_order = "";
			}
		}
		else
		{
			$sql_order .= "ORDER BY file_criteria.Criteria_Order";
			
		}
		
		// sql limit (paging)
		// ---------------------------------
		$sql_limit = "";
		if ( isset( $data['iDisplayStart'] ) && $data['iDisplayLength'] != '-1' )
		{
			$sql_limit .= " LIMIT ". $data['iDisplayStart'] . " , " . $data['iDisplayLength'];
		}
		
		
		// only if the file definition id exists and it is not empty, else display no records in the grid
		if( !empty($file_definition_id) )
		{
			// query and get result
			$sql_assembly = $sql_select . $sql_from . $sql_where . $sql_order . $sql_limit;
			
			//echo $sql_assembly; exit;
			
			$result = $this->db->query($sql_assembly);
			$sql_stmt = $this->db->last_query() ;
			$error = ( is_null($result) || ($result == FALSE) );   $err_msg = "Selecting the file criteria records failed. \$result returned false. \n\$account_id: $account_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
			// format list array
			if($result->num_rows() > 0)
			{
				foreach($result->result() as $row)
				{

					$file_criteria_id = $row->File_Criteria_Id;
					$account_id = $row->Account_Id;
					$file_definition_id = $row->File_Definition_Id;
					$file_def_name = $row->File_Def_Name;
					$criteria_order = $row->Criteria_Order;
					$criteria_name = $row->Criteria_Name;
					$criteria_type_id = $row->Criteria_Type_Id;
					$criteria_type_name = $row->Criteria_Type_Name;
					$criteria_required = $row->Criteria_Required;
					$criteria_min_len = $row->Criteria_Min_Len;
					$criteria_max_len = $row->Criteria_Max_Len;
					$criteria_default_value = $row->Criteria_Default_Value;
					$criteria_tooltip = $row->Criteria_Tooltip;
					$criteria_recall_name = $row->Criteria_Recall_Name;
					$criteria_prefix = $row->Criteria_Prefix;
					$criteria_suffix = $row->Criteria_Suffix;
					$criteria_decimals = $row->Criteria_Decimals;
					$criteria_dec_point = $row->Criteria_Dec_Point;
					$criteria_thousands_sep = $row->Criteria_Thousands_Sep;
					$criteria_currency_symbol = $row->Criteria_Currency_Symbol;
					$days_back = $row->Days_Back;
					$date_back = $row->Date_Back;
					$days_forward = $row->Days_Forward;
					$date_forward = $row->Date_Forward;
					$criteria_php_date_format_str = $row->Criteria_Php_Date_Format_Str;
					$criteria_javascript_date_format_str = $row->Criteria_JavaScript_Date_Format_Str;

					$criteria_min_len_str = ( !empty($criteria_min_len) ) ? $criteria_min_len : 'none';
					$criteria_max_len_str = ( !empty($criteria_max_len) ) ? $criteria_max_len : 'none';

					$criteria_name_str = "<div class='pull-left'><a href='#' onclick='LoadConfigFileCriteria($file_criteria_id, $file_definition_id);'><strong>$criteria_name</strong></a><br/>";
					$file_definition_str = "File Definition: <i>$file_def_name</i>, field type is <i>$criteria_type_name</i><br/>";
					$min_max_len_str = "<div class='grid_row_small_print'>Min/Max Length: <i>$criteria_min_len_str/$criteria_max_len_str</i></div></div>";
					$sort_buttons = "<div class='btn-group btn-group-xs pull-right'>";
					$sort_buttons .= "<button class='btn btn-default btn-xs tt' data-placement='top' data-toggle='tooltip' title='Edit file criteria' onclick='LoadConfigFileCriteria($file_criteria_id, $file_definition_id);'><i class='fa fa-pencil'></i></button>";
					$sort_buttons .= "<button class='btn btn-default btn-xs tt' data-placement='top' data-toggle='tooltip' title='Delete file criteria'  onclick='DeleteFileCriteria($file_criteria_id, $file_definition_id, this);'><i class='fa fa-times'></i></button>";
					$sort_buttons .= "<button class='btn btn-default btn-xs tt' data-placement='top' data-toggle='tooltip' title='Move order up'  onclick='UpdateFileCriteriaSort($file_criteria_id, $file_definition_id, \"UP\");'><i class='fa fa-sort-asc' style='position: relative; top: 2px;'></i></button>";
					$sort_buttons .= "<button class='btn btn-default btn-xs tt' data-placement='top' data-toggle='tooltip' title='Move order down' onclick='UpdateFileCriteriaSort($file_criteria_id, $file_definition_id, \"DOWN\");'><i class='fa fa-sort-desc' style='position: relative; bottom: 2px;'></i></button>";
					$sort_buttons .= "</div>";
					

					// format cell data
					$row = "";
					$row .= $criteria_name_str;
					$row .= $file_definition_str;
					$row .= $min_max_len_str;
					$row .= $sort_buttons;
					
					unset($record_row);
					$record_row = array();
					$record_row[] = $row;

					array_push($results_array['aaData'], $record_row);
				}
			}
		}
		
		
		// set total display records
		$results_array['iTotalRecords'] = count($results_array['aaData']);
		$results_array['iTotalDisplayRecords'] = count($results_array['aaData']);
		$results_array['iTotalRecords'] = count($results_array['aaData']);
		
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		return $results_array;
	}
	
	
	//  This method queries to get all user records for a given account, and it constructs it to be read in the config file users grid
	//  @Param 1:	required, the primary account key ID
	//  @Param 2:	optional, the data to filter the grid results
	//  @Record:	result array
	public function GetConfigUsersData($account_id, $data)
	{
		// The second parameter $data is used to filter the data results.
		// The second parameter can be empty, but the following data sets are set in the data value given.
		// bRegex
		// bRegex_0
		// bSearchable_0
		// bSortable_0
		// iColumns
		// iDisplayLength
		// iDisplayStart
		// iSortCol_0
		// iSortingCols
		// mDataPromp_0
		// sColumns
		// sEcho
		// sSearch
		// sSearch_0
		// sSortDir_0
		
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 2 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty or invalid. \n\$account_id: $account_id \n\func_get_args(): " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$this_user_email = $this->auth_lib->GetEmail();
		
		// build dataTables ajax server json response.
		$results_array['sEcho'] = ( isset($data['sEcho']) && $data['sEcho'] != FALSE ) ? intval($data['sEcho']) : 1;
		$results_array['iTotalRecords'] = 0;
		$results_array['iTotalDisplayRecords'] = 0;
		$results_array['aaData'] = array();
		
		// get total record count for the given account ID
		$this->db->where('Account_Id', $account_id);
		$total_records = $this->db->count_all_results('users');
		$results_array['iTotalRecords'] = $total_records;
		
		// build columns to filter result
		$list_columns = array('users.User_First_Name', 'users.User_Last_Name');
		
		// build query sql
		$sql_assembly = '';
		
		// sql select
		// ----------------------------------------------
		$sql_select = '';
		$sql_select .= "SELECT ";
		$sql_select .= "users.User_Id AS 'User_Id', ";
		$sql_select .= "users.Account_Id AS 'Account_Id' , ";
		$sql_select .= "users.User_First_Name AS 'User_First_Name' , ";
		$sql_select .= "users.User_Last_Name AS 'User_Last_Name' , ";
		$sql_select .= "users.User_Email AS 'User_Email' , ";
		$sql_select .= "users.Email_Confirmed_DateTime AS 'Email_Confirmed_DateTime'";
		
		
		// sql from
		// ----------------------------------------------
		$sql_from = "";
		$sql_from .= "FROM ";
		$sql_from .= "users ";
		
		
		// sql where (filter search results by column)
		// ----------------------------------------------
		$sql_where = "";
		$sql_where .= "WHERE ";
		$sql_where .= "users.Account_Id = $account_id";
		if ( isset($data['sSearch']) && $data['sSearch'] != "" )
		{
			$sql_where .= " AND (";
			for ( $i=0 ; $i<count($list_columns) ; $i++ )
			{
				$sql_where .= $list_columns[$i]." LIKE '%".mysql_real_escape_string( $data['sSearch'] )."%' OR ";
			}
			$sql_where = substr_replace( $sql_where, "", -3 );
			$sql_where .= ')';
		}
		
		// sql order
		// ----------------------------------
		$sql_order = "";
		if ( isset( $data['iSortCol_0'] ) )
		{
			$sql_order .= " ORDER BY  ";
			for ( $i=0 ; $i<intval( $data['iSortingCols'] ) ; $i++ )
			{
				if ( $data[ 'bSortable_' . intval($data['iSortCol_'.$i]) ] == "true" )
				{
					$sql_order .= $list_columns[ intval( $data['iSortCol_'.$i] ) ] .
						' ' . mysql_real_escape_string( $data['sSortDir_'.$i] ) .", ";
				}
			}
			
			$sql_order = substr_replace( $sql_order, "", -2 );
			if ( trim(strtoupper($sql_order)) == "ORDER BY" )
			{
				$sql_order = "";
			}
		}
		
		// sql limit (paging)
		// ---------------------------------
		$sql_limit = "";
		if ( isset( $data['iDisplayStart'] ) && $data['iDisplayLength'] != '-1' )
		{
			$sql_limit = " LIMIT ". $data['iDisplayStart'] . " , " . $data['iDisplayLength'];
		}
		
		
		// query and get result
		$sql_assembly = $sql_select . $sql_from . $sql_where . $sql_order . $sql_limit; 
		$result = $this->db->query($sql_assembly);
		$sql_stmt = $this->db->last_query() ;
		$error = ( is_null($result) || ($result == FALSE) );   $err_msg = "Selecting the user records failed. \$result returned false. \n\$account_id: $account_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		// format list array
		if($result->num_rows() > 0)
		{
			foreach($result->result() as $row)
			{
				
				$user_id = $row->User_Id;
				$account_id = $row->Account_Id;
				$user_first_name = $row->User_First_Name;
				$user_last_name = $row->User_Last_Name;
				$user_email = $row->User_Email;
				$email_confirmed = ( !empty($row->Email_Confirmed_DateTime) && !is_null($row->Email_Confirmed_DateTime) ) ? "<span class='text-success'>Confirmed</span>" : "<span class='text-danger'>Not Confirmed</span>";
				$is_current_user = ( $row->User_Email == $this_user_email ) ? TRUE : FALSE; // if true the user accessing this method is the user in the $row record.
				
				$user_str = "<div class='pull-left'><a href='#' onclick='LoadConfigUser($user_id);'><strong>$user_first_name $user_last_name</strong></a><br/>";
				$email_str = "<div class='grid_row_small_print'><i>$user_email</i> - $email_confirmed</div></div>";
				$sort_buttons = "<div class='btn-group btn-group-xs pull-right'>";
				$sort_buttons .= "<button class='btn btn-default btn-xs tt' data-placement='top' data-toggle='tooltip' title='Edit user' onclick='LoadConfigUser($user_id);'><i class='fa fa-pencil'></i></button>";
				if( !$is_current_user)
				{
					$sort_buttons .= "<button class='btn btn-default btn-xs tt' data-placement='top' data-toggle='tooltip' title='Delete user' onclick='DeleteUser($user_id, this);'><i class='fa fa-times'></i></button>";
				}
				$sort_buttons .= "</div>";
				
				// format cell data
				$row = "";
				$row .= $user_str;
				$row .= $email_str;
				$row .= $sort_buttons;
				
				unset($record_row);
				$record_row = array();
				$record_row[] = $row;
				
				array_push($results_array['aaData'], $record_row);
			}
		}
		
		// set total display records
		$results_array['iTotalDisplayRecords'] = $total_records; //$result->num_rows();
		$results_array['iTotalRecords'] = $result->num_rows();
		
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		return $results_array;
	}
	
	//  This method queries to get all error log records, and it constructs it to be read in the admin error logre port.
	//  @Param 1:	required, the primary account key ID
	//  @Param 2:	optional, the data to filter the grid results
	//  @Record:	result array
	public function GetAdminErrorLogReportData($data)
	{
		// The second parameter $data is used to filter the data results.
		// The second parameter can be empty, but the following data sets are set in the data value given.
		// file_definition_id   <-- this is the file definition primary key
		// bRegex
		// bRegex_0
		// bSearchable_0
		// bSortable_0
		// iColumns
		// iDisplayLength
		// iDisplayStart
		// iSortCol_0
		// iSortingCols
		// mDataPromp_0
		// sColumns
		// sEcho
		// sSearch
		// sSearch_0
		// sSortDir_0
		
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages = FALSE ;  //  set $messages=TRUE to log messages to the error_log table, logging available on production
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 1 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
//		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty or invalid. \n\$account_id: $account_id \n\func_get_args(): " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		$file_definition_id = ( isset($data['file_definition_id']) && !empty($data['file_definition_id']) ) ? $data['file_definition_id'] : '';
		
		// build dataTables ajax server json response.
		$results_array['sEcho'] = ( isset($data['sEcho']) && $data['sEcho'] != FALSE ) ? intval($data['sEcho']) : 1;
		$results_array['iTotalRecords'] = 0;
		$results_array['iTotalDisplayRecords'] = 0;
		$results_array['aaData'] = array();
		
		// build columns to filter result
		$list_columns = array('file_criteria.Criteria_Name');
		
		// build query sql
		$sql_assembly = '';
		
		// sql select
		// ----------------------------------------------
		$sql_select = '';
		$sql_select .= "SELECT ";
		$sql_select .= "error_log.Error_Log_Id AS 'Error_Log_Id' , ";
		$sql_select .= "error_log.Error_Date AS 'Error_Date' , ";
		$sql_select .= "error_log.Error_DateTime AS 'Error_DateTime' , ";
		$sql_select .= "error_log.User_Code AS 'User_Code' , ";
		$sql_select .= "error_log.Severity AS 'Severity' , ";
		$sql_select .= "error_log.Error_Message AS 'Error_Message', ";
		$sql_select .= "error_log.Method AS 'Method' , ";
		$sql_select .= "error_log.Line_Num ";
		
		// sql from
		// ----------------------------------------------
		$sql_from = "";
		$sql_from .= "FROM ";
		$sql_from .= "error_log ";
		
		// sql where (filter search results by column)
		// ----------------------------------------------
		$sql_where = "";
//		$sql_where .= " WHERE ";
		

		
		// sql order
		// ----------------------------------
		$sql_order = "";
		if ( isset( $data['iSortCol_0'] ) )
		{
			$sql_order .= " ORDER BY  ";
			for ( $i=0 ; $i<intval( $data['iSortingCols'] ) ; $i++ )
			{
				if ( $data[ 'bSortable_' . intval($data['iSortCol_'.$i]) ] == "true" )
				{
					$sql_order .= $list_columns[ intval( $data['iSortCol_'.$i] ) ] .
						' ' . mysql_real_escape_string( $data['sSortDir_'.$i] ) .", ";
				}
			}
			
			$sql_order = substr_replace( $sql_order, "", -2 );
			if ( trim(strtoupper($sql_order)) == "ORDER BY" )
			{
				$sql_order = "";
			}
		}
		else
		{
			$sql_order .= "ORDER BY error_log.Error_Log_Id ASC";
			
		}
		
		// sql limit (paging)
		// ---------------------------------
		$sql_limit = "";
		if ( isset( $data['iDisplayStart'] ) && $data['iDisplayLength'] != '-1' )
		{
			$sql_limit .= " LIMIT ". $data['iDisplayStart'] . " , " . $data['iDisplayLength'];
		}
		
		
		// query and get result
		$sql_assembly = $sql_select . $sql_from . $sql_where . $sql_order . $sql_limit;

		//echo $sql_assembly; exit;

		$result = $this->db->query($sql_assembly);
		$sql_stmt = $this->db->last_query() ;
		$error = ( is_null($result) || ($result == FALSE) );   $err_msg = "Selecting the error log records failed. \$result returned false. \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		// format list array
		if($result->num_rows() > 0)
		{
			foreach($result->result() as $key => $row)
			{
				$number = $key+1;
				$error_log_id = $row->Error_Log_Id;
				$error_date = $row->Error_Date;
				$error_datetime = $row->Error_DateTime;
				$user_code = $row->User_Code;
				$severity = $row->Severity;
				$error_message = $row->Error_Message;
				$method = $row->Method;
				$line_num = $row->Line_Num;

				// format cell data
				$col1 = "$number.";
				$col2 = $error_log_id;
				$col3 = $error_datetime;
				$col4 = $severity;
				$col5 = $error_message;
				$col6 = $method . '<br/>' . $line_num;
				$col7 = "";

				unset($record_row);
				$record_row = array();
				$record_row[] = $col1;
				$record_row[] = $col2;
				$record_row[] = $col3;
				$record_row[] = $col4;
				$record_row[] = $col5;
				$record_row[] = $col6;
				$record_row[] = $col7;

				array_push($results_array['aaData'], $record_row);
			}
		}
		
		
		// set total display records
		$results_array['iTotalRecords'] = count($results_array['aaData']);
		$results_array['iTotalDisplayRecords'] = count($results_array['aaData']);
		$results_array['iTotalRecords'] = count($results_array['aaData']);
		
		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		return $results_array;
	}
	
}