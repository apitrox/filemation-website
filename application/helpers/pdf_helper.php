<?php
/*
 * Lams Online
 * Version: 1.0, 1.5
 *
 * PDF Helper
 */

// This helper function will get the number of pages in a PDF document
// @Param 1:	required, path and file name to source file
// @Return:		number of pages
function GetPDFPages($filepath)
{ 
	//  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo
	$test = FALSE ;
	if(DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------"; }
	if(DEBUG && $test)  { echo "\nfunc_get_args(): ";  print_r(func_get_args(), FALSE);  echo "\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------\n"; }

	$num_args_expected = 1 ;
	$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

	$ci =& get_instance();
	
	$error = ( empty($filepath) );   $err_msg = "\$filepath is empty.";   $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	
	$fp = fopen(preg_replace("/\[(.*?)\]/i", "",$filepath),"r");
	$error = ( $fp === FALSE );   $err_msg = "The file could not be opened. \nFilename: $filepath.";   $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	
	$max = 0;
	while(@feof($fp) == FALSE)
	{ 
		$line = fgets($fp,255); 
		if (preg_match('/\/Count [0-9]+/', $line, $matches))
		{ 
			   preg_match('/[0-9]+/',$matches[0], $matches2); 
			   if ( $max < $matches2[0] ) 
			   {
				   $max = $matches2[0];
			   }
		} 
	} 
	fclose($fp); 
	if( $max == 0 )
	{ 
	    $im = new Imagick($filepath); 
	    $max = $im->getNumberImages(); 
	} 

	return $max;
} 

// This helper function will rotate a PDF file by running a unix command
// @Param 1:	required, path and file name to source file
// @Param 2:	optional, [default=180] how many degrees to rotate files
// @Return:		VOID, instead exec convert unix command
function PDFRotate($path_filename, $rotate_degrees = 180)
{
	$ci =& get_instance();
	$ci->load->model('Error_log_model');
    
	$error = ( empty($path_filename) );   $err_msg = "\$path_filename is empty. \nFilename: $path_filename";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
    
	$file_path = dirname($path_filename);
	$file_name = basename($path_filename);
	$file_base_name = basename($path_filename, '.pdf');
	$new_filename = $file_base_name . "_ROTATED.pdf";
	$new_path_filename = $file_path . DIRECTORY_SEPARATOR . $new_filename;	
	
	
	$command = "/usr/local/bin/pdftk $path_filename cat 1-endsouth output $new_path_filename";
	exec($command, $exec_result);

	
	$error = ( file_exists($new_path_filename) !== TRUE );   $err_msg = "The pdf document did not ROTATE correctly. \nFilename: $file_name";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	
	$delete_result = @unlink($path_filename);
	$error = ( $delete_result !== TRUE );   $err_msg = "The file did not delete/unlink correctly. \nFilename: $path_filename";   $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	
	$results_array = array();
	$results_array['Result'] = TRUE;
	$results_array['Filename'] = $new_filename;
	$results_array['Path_Filename'] = $new_path_filename;
	$results_array['Result_Message'] = "Executed Successfully!";
	
	return $results_array;
}

// This helper function will split a multi-page PDF document into multiple single pages
// @Param 1:	required, path and file name to source pdf file
// @Return:		ARRAY, Result => TRUE = Files split correctly, and source file deleted, Result => FALSE = Files did not split and source 
//				file not deleted
function PDFSplit($path_file_name)
{
	$ci =& get_instance();
	$ci->load->model('Error_log_model');
	
	$error = ( empty($path_file_name) );   $err_msg = "\$path_file_name is empty. \nFilename: $path_file_name";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	
	$pages = GetPDFPages($path_file_name);
	$file_path = dirname($path_file_name);
	$file_name = basename($path_file_name);
	$file_name_bomb = explode('.', $file_name);
	$file_base_name = isset($file_name_bomb[0]) ? $file_name_bomb[0] : '';
	
	// Check if we need to split the file. The file needs to be more than one page.
	$error = ( $pages <= 1 );   $err_msg = "\$pages returned is less than or equal to 1. The file needs to be more than one page. \nFilename: $path_file_name \nPages: $pages";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	// Check if $file_base_name is empty
	$error = ( empty($file_base_name) );   $err_msg = "\$file_base_name is empty. \nFilename: $path_file_name";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	
	// Split the file into separate pages
	exec("/usr/bin/pdftk $path_file_name burst output $file_path/" . $file_base_name . "_%03d.pdf", $result);
	
	// Check if the file split into separate pages
	for($i = 1; $i > $pages; $i++ )
	{
		unset($page_num);
		$page_num = ( strlen($i) == 1 ) ? "00$i" : $i;
		$page_num = ( strlen($i) == 2 ) ? "0$i" : $page_num;
		
		$check_file_path_name = $file_path . DIRECTORY_SEPARATOR . $file_base_name . '_' . $page_num . '.pdf';		
		$error = ( file_exists($check_file_path_name) !== TRUE );   $err_msg = "$check_file_path_name does not exist. The original pdf document did not split into separate files. \nFilename: $check_file_path_name \nOriginal File: $path_file_name";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	}
	
	$delete_result = @unlink($path_file_name);
	$error = ( $delete_result !== TRUE );   $err_msg = "\$delete_result returned false. The file did not delete. \nFilename: $path_file_name";   $notify = FALSE;   $severity = "ERROR";   $stop = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	
	
	$results_array = array();
	$results_array['Result'] = TRUE;
	$results_array['Result_Message'] = "Executed Successfully!";
	
	return $results_array;
}

// This helper function will merge multiple PDF documents into one PDF document.
// @Param 1:	required, ARRAY path file name's of documents to merge. 
//				IE: array('/home/imports/templates_converted/documentfile.pdf', '/home/imports/templates_converted/documentfile2.pdf')
// @Param 2:	required, Directory to output merged PDF document on disc
// @Return:		ARRAY, Result => True if files merged correctly, Result => False if failure
function PDFMerge($path_file_name_array, $output_directory)
{
	$test = FALSE ;
	if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date( "n-j-Y, g:i:s a" ) . "\n-----------------------------------------------------\n"; }
	if (DEBUG && $test)  { echo "func_get_args(): \n";  print_r(func_get_args());  echo "\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\n-----------------------------------------------------\n"; }

	$num_args_expected = 2 ;
	$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments. Expecting $num_args_expected, received " . func_num_args(); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

	
	$ci =& get_instance();
	$ci->load->helper('string');
	
	// check if $path_file_name_array is empty or null
	$error = ( empty($path_file_name_array) );   $err_msg = "\$path_file_name_array is empty or null. \nFilename: $path_file_name_array";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	// check if $path_file_name_array is empty or null
	$error = ( !is_array($path_file_name_array) );   $err_msg = "\$path_file_name_array is not an array. \nFilename: $path_file_name_array";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	// check if $output_directory is empty or null
	$error = ( empty($output_directory) );   $err_msg = "\$output_directory is empty or null. \nFilename: $output_directory";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	
	
	// construct files to be merged string
	$files_to_merge_str = '';
	$files_to_merge_count = count($path_file_name_array);
	foreach($path_file_name_array as $path_file_name)
	{
		// format for safe unix call
		$file_info = pathinfo($path_file_name);
		$format_filename = FormatUnixFilename($file_info['basename']);
		$path_file_name = $file_info['dirname'] . DIRECTORY_SEPARATOR . $format_filename;
		
		$files_to_merge_str .= $path_file_name . ' '; 
	}
	
	$error = ( empty($files_to_merge_str) );   $err_msg = "\n$files_to_merge_str is empty or null. \nFilename: $files_to_merge_str";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	
	// first merge pages
	$merged_pdf_name = random_string('unique') . '_MERGED.pdf';
	$output_dir_reverse = strrev($output_directory);
	$output_dir = ($output_dir_reverse[0] == '/') ? $output_directory : $output_directory . '/';
	$merged_pdf_path_name = $output_dir . $merged_pdf_name;
	if( isset($path_file_name_array['Test']) ) {	echo "/usr/bin/pdftk $files_to_merge_str cat output " . $merged_pdf_path_name; exit; }
	
	exec("/usr/bin/pdftk $files_to_merge_str cat output " . $merged_pdf_path_name, $result); // dev use (/usr/local/bin/pdftk) production use (/use/bin/pdftk)
	
	// check if new merged pdf document exists.
	$error = ( file_exists($merged_pdf_path_name) !== TRUE );   $err_msg = "Documents did not merge into one file. \nFilename: $files_to_merge_str";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	
	
	$results_array = array();
	$results_array['Result'] = TRUE;
	$results_array['File_Name'] = $merged_pdf_name;
	$results_array['Exp_Page_Count'] = $files_to_merge_count;
	
	if (DEBUG && $test)  { echo "\n------------------ \$results_array ------------------\n";   print_r($results_array);  echo "-----------------------------------------------------\nMethod:  " . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date( "n-j-Y, g:i:s a" ) . "\n-----------------------------------------------------\n"; }

	if (DEBUG && $test)  { echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date( "n-j-Y, g:i:s a" ) . "\n-----------------------------------------------------\n"; }

	
	return $results_array;
}

// This helper function will delete one or pages from a multi-page document
// @Param 1:	required, the path and file name of the document to delete pages from
// @Param 2:	the page number from which to delete from the multi-page document
// @Return:		ARRAY, Result => True is pages were deleted successfully, 
//				Result => False pages were not deleted successfully
function PDFDeletePage($path_file_name, $page_num)
{
	
	// check if $path_file_name is empty
	$error = ( empty($path_file_name) );   $err_msg = "\$page_file_name is empty.";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	
	// check if $path_file_name exists on the local drive
	$error = ( file_exists($path_file_name) !== TRUE );   $err_msg = "\$page_file_name does not exist on the local drive. \nFilename: $path_file_name";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	
	// check if $page_num is empty
	$error = ( empty($page_num) );   $err_msg = "\$page_num is empty.";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	
	
	$pages = GetPDFPages($path_file_name);
	$file_path = dirname($path_file_name);
	$file_name = basename($path_file_name);
	$file_name_bomb = explode('.', $file_name);
	$file_base_name = isset($file_name_bomb[0]) ? $file_name_bomb[0] : '';
	$new_file_name = $file_path . '/' . $file_base_name . '_DELETEPAGE.pdf';
	
	$num_range = ''; // ie: 1-12 14-end <-- deletes page 13
	if($pages > $page_num && $page_num != 1 && $pages != 1)
	{
		$first = $page_num - 1;
		$second = $page_num + 1;
		
		$num_range = '1-' . $first . ' ' . $second . '-end';	
	}
	 elseif($pages == $page_num && $page_num != 1 && $pages != 1)
	{
		$second = $page_num - 1;
		$num_range = '1-' . $second;
	}
	 elseif($page_num == 1)
	{
		$num_range = '2-end';
	}
	else
	{
		$error = ( TRUE );   $err_msg = "The page number can not be large than the total document page count. \nPage Num: $page_num \nPages: $pages";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	}
	
	$command = "/usr/bin/pdftk $path_file_name cat $num_range output $new_file_name";
	exec($command, $result);
	
	// check if the new file that we delete pages from exists on the local drive
	$error = ( file_exists($new_file_name) !== TRUE );   $err_msg = "\$new_file_name does not exist on the local drive. \nFilename: $new_file_name";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	
	$delete_result = @unlink($path_file_name);
	$error = ( $delete_result !== TRUE );   $err_msg = "\$delete_result equals false. The file did not delete successfully.";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	
	$results_array = array();
	$results_array['Result'] = TRUE;
	$results_array['File_Name'] = basename($new_file_name);
	$results_array['File_Path_Name'] = $new_file_name;
	$results_array['Result_Message'] = "Executed Successfully!";
	
	return $results_array;
}
?>