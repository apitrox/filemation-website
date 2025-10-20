<?php if( !defined('BASEPATH') ) die('No direct script access');

class Docs_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}


	//  This method will copy/download a file from the remote file server to the local server.
	//  @Param 1:	required, the primary account key ID
	//  @Param 2:	required, the data storage file id we want to download from the remote file server
	//  @Param 3:	required, the name of the file we want to download
	//  @Return:	results array
	public function DownloadFileFromFileServer($account_id, $data_storage_file_id, $filename)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages0=TRUE for STARTING and ENDING messages only
		$messages1 = FALSE ;  //  set $messages1=TRUE for high level messages that are outside of any loop structure

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 3 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($account_id) );   $err_msg = "\$account_id is empty or invalid. \n\$account_id: $account_id \n\func_num_args: " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !is_numeric($account_id) );   $err_msg = "\$account_id is not numeric. \n\$account_id: $account_id \n\func_num_args: " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( (strlen($account_id) != 10) );   $err_msg = "\$account_id is not 10 digits. \n\$account_id: $account_id \n\func_num_args: " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($data_storage_file_id) );   $err_msg = "\$data_storage_file_id is empty or invalid. \n\$data_storage_file_id: $data_storage_file_id \n\func_num_args: " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( $filename == '' );   $err_msg = "The \$filename is empty. \nfunc_get_args: " . print_r(func_get_args(), TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$this->load->library('files_convert_lib'); // load the files conversion library
		
		// first we need to get the data provider from the account.
		$return = $this->Accounts_model->GetAccount($account_id);
		$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Accounts_model->GetAccount() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !isset($return['Row']) || empty($return['Row']) );   $err_msg = "\$return[Row] is not set or empty, and it is required. \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		$account = $return['Row']; // set the account record row.
		$error = ( !isset($account->Data_Storage) || empty($account->Data_Storage) );   $err_msg = "The data storage provider is invalid for the account. \$account->Data_Storage is not set or empty, and it is required. \n\$account: " . print_r($account, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$data_storage = $account->Data_Storage; // set the data storage provider from the account.
		
		// =============================================================================================
		// Download file, or get a preview of the file.
		// -----------------------------------------------------------------
		// - First depending on the data storage provider we take different actions on how we preview the file.
		// - Second depending on the type of device viewing the application we select a different solution to preview the file.
		// ==============================================================================================
		
		$this->load->library('mobile_detect_lib');
		
		$user_agent = $_SERVER['HTTP_USER_AGENT']; // set the user agent viewing this page.		
		// with this regular expression we match the user agent with *known* tablets and mobile devices/browers.
//		$is_not_pc = preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$user_agent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($user_agent,0,4) );
		$is_not_pc = ( $this->mobile_detect_lib->isMobile() || $this->mobile_detect_lib->isTablet() ) ? TRUE : FALSE;
		$is_html = false; // set the is html local variable to false, until other wise proven to be html content.
		$html_content = ""; // set the html content to empty, until $is_html is true and we have HTML content to display to the user.
		
		// Box
		// ==================================
		if( strtoupper($data_storage) == "BOX" )
		{
			
			$return = $this->Data_storage_model->BoxDownloadFile($account_id, $data_storage_file_id);
			$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->BoxDownloadFile() \n\$return: " . print_r($return, TRUE);   $err_type = ( isset($return['Error_Type']) ) ? $return['Error_Type'] : 'none';   $err_status = ( isset($return['Error_Status']) ) ? $return['Error_Status'] : 'none';   $err_code = ( isset($return['Error_Code']) ) ? $return['Error_Code'] : 'none';   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id,  'Error_Type' => $err_type, 'Error_Status' => $err_status, 'Error_Code' => $err_code,  'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			
			$error = ( !isset($return['Path_Filename']) || empty($return['Path_Filename']) );   $err_msg = "\$return[Path_Filename] is not set or empty, and it is required. \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( !file_exists($return['Path_Filename']) );   $err_msg = "The downloaded file does not exist on the local server. \$return[Path_Filename] does not exist on the local server. \n\$return[Path_Filename]: " . $return['Path_Filename'] . " \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			
			$local_path_filename = $return['Path_Filename']; // set the local path and filename. this will be reset after converting the file to pdf if it is not already a pdf.
			$new_filename = $return['Filename']; // set the new filename.
			
			$file_info = pathinfo($local_path_filename);
			$extension = ( isset($file_info['extension']) ) ? $file_info['extension'] : NULL;
			$error = ( empty($extension) );   $err_msg = "The downloaded file's file extension is empty, or invalid. \$extension is empty, or invalid \n\$file_info: " . print_r($file_info, TRUE) . " \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			
			if( strtoupper($extension) != "PDF" )
			{
				// since the box api does not allow us to export the file to a different file type then the original file type we have to convert the downloaded file type to PDF so we can view it.
				$return = $this->files_convert_lib->ConvertFileToPdf2($local_path_filename);
				$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->files_convert_lib->ConvertFileToPdf2() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( empty($return['Filename']));   $err_msg = "The converted file's filename is not set, is empty, or invalid. \n\$return[Filename] is not set, is empty, or invalid. \n\$return: " . print_r($return, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( empty($return['Path_Filename']));   $err_msg = "The converted file's full path and filename does not exist, is empty, or invalid. \n\$return[Path_Filename] is not set, is empty, or invalid. \n\$return: " . print_r($return, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				
				$local_path_filename = $return['Path_Filename']; // set the local path and filename. This is returned, and used to display the file to the user in the preview.
				$new_filename = $return['Filename']; // set the new filename. This is returned to the previewer.
				
			}
			
			// if the device viewing this page is NOT a personal computer then we need to convert the file to HTML so they are able to view it.
				
			if( $is_not_pc )
			{
				$return = $this->files_convert_lib->ConvertFileToHTML($local_path_filename);
				$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->files_convert_lib->ConvertFileToPdf2() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( empty($return['HTML_Content']));   $err_msg = "The converted file html content is not set, is empty, or invalid. \n\$return[File_Content] is not set, is empty, or invalid. \n\$return: " . print_r($return, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

				$is_html = TRUE; // set the content to be returned to HTML.
				$html_content = $return['HTML_Content']; // set the html content.
			}
						
			// get the pdf page count
			$local_filename_page_count = GetPDFPages($local_path_filename);
		}
		// Dropbox
		// ==================================
		elseif( strtoupper($data_storage) == "DROPBOX" )
		{
			$return = $this->Data_storage_model->DropboxDownloadFile($account_id, $data_storage_file_id);
			$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->DropboxDownloadFile() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( !isset($return['Path_Filename']) || empty($return['Path_Filename']) );   $err_msg = "\$return[Path_Filename] is not set or empty, and it is required. \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

			$local_path_filename = $return['Path_Filename']; // set the local path and filename
			$new_filename = $return['Filename']; // set the new filename
			
			// get the pdf page count
			$local_filename_page_count = GetPDFPages($local_path_filename);
			
			// if the device viewing this page is NOT a personal computer then we need to convert the file to HTML so they are able to view it.
				
			if( $is_not_pc )
			{
				$return = $this->files_convert_lib->ConvertFileToHTML($local_path_filename);
				$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->files_convert_lib->ConvertFileToPdf2() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( empty($return['File_Content']));   $err_msg = "The converted file content is not set, is empty, or invalid. \n\$return[File_Content] is not set, is empty, or invalid. \n\$return: " . print_r($return, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

				$is_html = TRUE; // set the content to be returned to HTML.
				$html_content = $return['File_Content']; // set the html content.
			}
		}
		
		
		// next lets determine if the file has been previously been renamed by filemation, and if so lets parse the file name parts (file criteria) into file criteria.
		// we can only order them by numbers as they are in order from the filename, because we do not know the name of the file criteria used.
		
		// ***** split file into parts here
		$pre_load_criteria = false;
		$file_definition_id = "";
		$file_criteria = array();
		if( (strpos($filename, ',') > 0) || (strpos($filename, ';') > 0) || (strpos($filename, '-') > 0) )
		{	
			// get the file detail information to retrieve the tags
			$return = $this->Data_storage_model->BoxGetFileTags($account_id, $data_storage_file_id);
			$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->GetFileTags() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( !isset($return['Filename']) || empty($return['Filename']) );   $err_msg = "\$return[Filename] is not set or empty, and it is required. \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( !isset($return['Tags']) );   $err_msg = "\$return[Tags] is not set or empty, and it is required. \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			
			$orig_filename = $return['Filename']; // set the original filename so we can parse the filename for file criteria
			$tags_array = $return['Tags']; // set the tags array
			
			if( count($tags_array) > 0 )
			{
				foreach($tags_array as $tag)
				{
					if( preg_match("/Def:/", $tag) != FALSE || preg_match("/ID:/", $tag) != FALSE || preg_match("/ID/", $tag) != FALSE )
					{
						$fd_parts = explode(':', $tag);
						$fd_parts = ( is_array($fd_parts) && (count($fd_parts) > 1) ) ? $fd_parts : explode('ID', $tag);
						$file_definition_id = ( isset($fd_parts[1]) ) ? trim($fd_parts[1]) : '';
					}
				}
			}
			
			if( !empty($file_definition_id) && is_numeric($file_definition_id) )
			{
				// lets get the file definitions record so we can determine the criteria separator to parse the filename and get the file criteria values.
				$return = $this->File_definitions_model->GetFileDefinition($account_id, $file_definition_id);
				$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->File_definitions_model->GetFileDefinition() \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "NOTICE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "NOTICE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( !isset($return['Row']) || empty($return['Row']) );   $err_msg = "\$return[Row] is not set or empty, and it is required. \n\$return: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "NOTICE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				
				if( isset($return['Result']) && $return['Result'] == TRUE )
				{
					$file_definition = $return['Row']; // set the file definition row object
					$criteria_separator = $file_definition->Criteria_Separator; // set the file definition criteria we use to parse the separate parts of the file name to load as file criteria

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

					$filename_info = pathinfo($orig_filename);
					$basename = ( isset($filename_info['filename']) ) ? $filename_info['filename'] : ''; // set the file basename without the extension

					if( !empty($basename) )
					{
						$filename_parts = explode($criteria_separator, $basename); // the filename separated into parts using the criteria separator character specified in the file definition.
						$filename_parts_count = count($filename_parts); // the total number of parts
						$file_criteria_count = ( $file_definition->Definition_Starts_Filename == 1 ) ? (count($original_file_criteria_array)+1) : count($original_file_criteria_array); // the total number of file criteria assocated with the file definition, plus 1 more file criteria if the file definition uses the definition name as the first filename part.
						$file_criteria_required_count = ( $file_definition->Definition_Starts_Filename == 1 ) ? (count($file_criteria_array)+1) : count($file_criteria_array); // the total number of file criteria that is required by the user to be file or rename the file, plus 1 more if the file definition uses the definition name as the first filename part.
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

							$pre_load_criteria = TRUE;
							foreach($filename_parts as $key => $part)
							{
								if( $file_definition->Definition_Starts_Filename == 1 && $key == 0 ) { continue; } // if the file definition uses the definition name as the first filename part skip over it because it is not a file criteria value

								$fc_rec = current($file_criteria_array_2);
								$fc_prefix = $fc_rec['Criteria_Prefix'];
								$fc_suffix = $fc_rec['Criteria_Suffix'];

								$criteria = trim($part);
								$criteria = ( !empty($fc_prefix) ) ? str_replace($fc_prefix, '', $criteria) : $criteria;
								$criteria = ( !empty($fc_suffix) ) ? str_replace($fc_suffix, '', $criteria) : $criteria;
								$file_criteria[] = $criteria;

								next($file_criteria_array_2);
							}

						}
					}
				}
			}
			
		}
		
		
		// if we get here the method has completed successfully, wrap up and return results array
		$results_array['Result'] = TRUE;
		$results_array['Path_Filename'] = $local_path_filename;
		$results_array['Filename'] = $new_filename;
		$results_array['Original_Filename'] = $filename;
		$results_array['Is_HTML'] = $is_html;
		$results_array['HTML_Content'] = $html_content;
		$results_array['Pre_Load_Criteria'] = $pre_load_criteria;
		$results_array['File_Definition_Id'] = $file_definition_id;
		$results_array['File_Criteria'] = $file_criteria;
		$results_array['Page_Count'] = $local_filename_page_count;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}


	//  This model method will get the list of 'to be filed' files on the remote file server for a given account.
	//  @Param 1:	required,  the account we are working with
	//  @Param 2:	required,  the path/folder for which to display a file listing
	//  @Return:	results array
	public function GetToBeFiledFilesForAccount($account_id, $source_location = NULL)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages0=TRUE for STARTING and ENDING messages only
		$messages1 = FALSE ;  //  set $messages1=TRUE for high level messages that are outside of any loop structure

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 2 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($account_id) );   $err_msg = "Account_id is missing,empty or invalid. \n\$account_id: $account_id \nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( strlen($account_id) != 10 );   $err_msg = "Account_id is an invalid length. \n\$account_id: $account_id \nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( $source_location == '' );   $err_msg = "Source_Location is missing,empty or invalid. \n\$source_location: $source_location \nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( strlen($source_location) < 1 );   $err_msg = "Source_Location is an invalid length. \n\$source_location: $source_location \nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}


		// get the account record
		$result = $this->Accounts_model->GetAccount($account_id);
		$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Accounts_model->GetAccount() \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$account = ( isset($result['Result']) && $result['Result'] == TRUE ) ? $result['Row'] : FALSE;
		$error = ( !is_object($account) );   $err_msg = "The account was not found in the database. \$account is not an object. \n\$account_id: $account_id \n" . $result['Result_Message'];   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$access_token = $account->Access_Token; // set the account access token used for all oauth 2.0 data storage providers
		$refresh_token = $account->Refresh_Token; // set the account refresh token used for box api
		$default_source_location = $account->Default_Source_Location; // set the default source location to get files to rename and file
		$data_storage = $account->Data_Storage; // set the data storage
		
		// check the source location. if it was not given in this method, then use the account default_source_location
		$source_location = ( !is_null($source_location) ) ? $source_location : $default_source_location;
		
		
		if( strtoupper($data_storage) == "BOX" )
		{
			$result = $this->Data_storage_model->BoxGetFilesFromFolder($account_id, $source_location);
			$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->BoxGetFilesFromFolder() \n\$return: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( !isset($result['Data']) );   $err_msg = "\$result[Data] is not set and is required. \n\$result: " . print_r($result, TRUE) ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		}
		else if( strtoupper($data_storage) == "DROPBOX" )
		{
			$result = $this->Data_storage_model->DropboxGetFilesFromFolder($account_id, $source_location);
			$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->DropboxGetFilesFromFolder() \n\$return: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( !isset($result['Data']) );   $err_msg = "\$result[Data] is not set and is required. \n\$result: " . print_r($result, TRUE) ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		}
		else if( strtoupper($data_storage) == "GOOGLE DRIVE" )
		{
			
		}
		else if( strtoupper($data_storage) == "MICORSOFT ONEDRIVE" )
		{
			
		}
		
		// set the files array returned from the data storage provider
		$files_array = $result['Data'];

		// format our to be filed readable array for the filer interface
		$to_be_filed_array = array();
		foreach( $files_array as $file )
		{
			unset($id);
			unset($filename);
			$id = ( isset($file['Id']) ) ? $file['Id'] : '';
			$name = ( isset($file['Name']) ) ? $file['Name'] : '';
			
			$temp_array = array();
			$temp_array['Id'] = $id;
			$temp_array['Filename'] = $name;

			$to_be_filed_array[] = $temp_array;
		}

		// if we get here the method has completed successfully, wrap up and return results array
		$results_array['Result'] = TRUE;
		$results_array['Account_Id'] = $account_id;
		$results_array['Source_Location'] = $source_location;
		$results_array['Data'] = $to_be_filed_array;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}
	
	//  This method will modify a given file depending on the action provided.
	//  @Param 1:	required, the account primary key ID
	//  @Param 2:	required, the data storage file id. This can be an integer or the filename depending on the data storage provider.
	//  @Param 3:	required, the filename of the file we are modifying.
	//  @Param 4:	required, the data storage folder id. This can be an integer or a string representation of the data storage path.
	//  @Param 4:	required, the modify *Action* we are taking with the file.
	public function ModifyFile($account_id, $data_storage_file_id, $filename, $data_storage_folder_id, $action)
	{
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages0=TRUE for STARTING and ENDING messages only
		$messages1 = FALSE ;  //  set $messages1=TRUE for high level messages that are outside of any loop structure

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 5 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($account_id) );   $err_msg = "\$account_id is not set, empty, null, or invalid. \n\$account_id: $account_id \nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( strlen($account_id) != 10 );   $err_msg = "Account_id is an invalid length. \$account_id character length does not equal 10. \n\$account_id: $account_id \nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($data_storage_file_id) );   $err_msg = "\$data_storage_file_id is not set, empty, null, or invalid. \n\$data_storage_file_id: $data_storage_file_id \nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($filename) );   $err_msg = "\$filename is not set, empty, null, or invalid. \n\$filename: $filename \nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($data_storage_folder_id) );   $err_msg = "\$data_storage_folder_id is not set, empty, null, or invalid. \n\$data_storage_folder_id: $data_storage_folder_id \nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( empty($action) );   $err_msg = "\$action is not set, empty, null, or invalid. \n\$action: $action \nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		// get the account record
		$result = $this->Accounts_model->GetAccount($account_id);
		$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Accounts_model->GetAccount() \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($result['Row']) );   $err_msg = "The account record is not set. \$result[Row] is not set, empty or invalid. \n\$account_id: $account_id \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$account = $result['Row']; // set the account record row.
		
		$data_storage = $account->Data_Storage; // set the account data storage provider.
		
		$file_info = pathinfo($filename);
		$file_extension = ( !empty($file_info['extension']) ) ? $file_info['extension'] : '';
		$error = ( empty($file_extension) );   $err_msg = "\$file_extension is not set, empty, null, or invalid. \n\$file_extension: $file_extension";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$this->load->helper('pdf_helper'); // load the pdf helper
		
		if( strtoupper($action) == "DELETE" ) // DELETE
		{
			if( strtoupper($data_storage) == "BOX" )
			{
				$result = $this->Data_storage_model->BoxDeleteFile($account_id, $data_storage_file_id);
				$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->BoxDeleteFile() \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				
				$local_path_filename = $this->config->item("FILES_CONVERTED_PATH") . DIRECTORY_SEPARATOR . $filename;
			}
		}
		else if( strtoupper($action) == "MERGE" ) // MERGE
		{
			
		}
		else if( strtoupper($action) == "OCR" ) // OCR
		{
			
		}
		else if( strtoupper($action) == "ROTATE" && strtoupper($file_extension) == "PDF" ) // ROTATE
		{
			// When rotating a pdf document we must first download the document from the data storage provider. 
			// Then we rotate the pdf document 180 degrees, delete the previous file from the data storage provider,
			// and then upload the document back to the data storage provider replacing the previous document.
			
			if( strtoupper($data_storage) == "BOX" )
			{
				$result = $this->Data_storage_model->BoxDownloadFile($account_id, $data_storage_file_id);
				$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->BoxDownloadFile() \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( empty($result['Path_Filename']) );   $err_msg = "The full path and filename is not set when downloading the box file. \$result[Path_Filename] is not set, empty or invalid. \n\$account_id: $account_id \n\$data_storage_file_id: $data_storage_file_id  \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				
				$local_path_filename = $result['Path_Filename']; // set the full path and filename to the file we want to rotate.
				
				$result = PDFRotate($local_path_filename);
				$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from PDFRotate() \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( empty($result['Filename']) );   $err_msg = "The filename is not set when rotating the pdf document. \$result[Path_Filename] is not set, empty or invalid. \n\$account_id: $account_id \n\$data_storage_file_id: $data_storage_file_id  \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( empty($result['Path_Filename']) );   $err_msg = "The full path and filename is not set when rotating the pdf document. \$result[Path_Filename] is not set, empty or invalid. \n\$account_id: $account_id \n\$data_storage_file_id: $data_storage_file_id  \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				
				$rotated_filename = $result['Filename']; // the new pdf filename returned from the rotate function.
				$rotated_path_filename = $result['Path_Filename']; // the new pdf full path and filename from the rotate function.
				
				
				// move the filename back to the original filename so it can be uploaded as that filename to the data storage provider. The original file has already been removed in the PDFRotate() function.
				$rename_path_filename = dirname($local_path_filename) . DIRECTORY_SEPARATOR . $filename;
				$result = rename($rotated_path_filename, $rename_path_filename);
				$error = ( $result == FALSE );   $err_msg = "Renaming the file failed. \$result returned false. \$rotated_path_filename: $rotated_path_filename \$local_path_filename: $local_path_filename";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				
				// upload the rotated file.
				$result = $this->Data_storage_model->BoxDeleteFile($account_id, $data_storage_file_id);
				$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from Data_storage_model->BoxDeleteFile() \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	
				
				// upload the rotated file.
				$result = $this->Data_storage_model->BoxUploadFile($account_id, $rename_path_filename, $data_storage_folder_id);
				$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from Data_storage_model->BoxUploadFile() \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				
				// we need to return the full path and filename to the UI, and we want to keep the local variable universal. Lets rename our renamed path and filename to our universal
				// local variables.
				$local_path_filename = $rename_path_filename;
					
			}
		}
		else if( strtoupper($action) == "SPLIT" ) // SPLIT
		{
			
		}
				
		// if we get here the method has completed successfully, wrap up and return results array
		$results_array['Result'] = TRUE;
		$results_array['Action'] = $action;
		$results_array['Filename'] = basename($local_path_filename);
		$results_array['Path_Filename'] = $local_path_filename;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}
	

	//  This method renames and files a document to a specific path on the remote file server.
	//  Criteria value formatting and validation is done interactively in the interface, and is done again here
	//  @Param 1:	required, the file criteria values array to rename the document
	//  @Return:	results array
	public function RenameAndFileDocument($filename_values_array)
	{
		//  $filename_values_array  ELEMENTS:
		// Account_Id			-> This is the ID number of the account.
		// User_Id			-> This is the ID of the current user.
		// File_Definition_Id	-> This is the file definition ID. We rename and file per this file definition record.
		// Filename			-> This is the name of the source file that needs to be renamed
		// Data_Storage_File_Id	-> The data storage file primary key id
		// Source_Path			-> This is the path/folder to the source file that needs to be renamed
		// Destination_Path		-> This is the destination path/folder where the renamed file needs to be saved
		// File_Criteria		-> This is an associative array with the file criteria values to use to rename the original file. The array keys are the File_Criteria_Ids to each file criteria.   Ex:  File_Criteria[1000000091] => '06-18-2014'
		// File_Action			-> Rename_And_File_Document = if this action value is provided then rename the file with the file criteria, and move the file to a destination.   Rename_Document = if this action value is provided the file will only be reanamed and will not be moved
		// Filename_Exists_Solution	-> If the filename already exists in the destination to copy or move the file this will have values. Save_And_Replace = replace the existing file with this file, Save_As_New_Version = keep the existing file, and save this file with a different filename by adding a suffix to the end of this filename.
		// Conflicting_File_Id	-> The file id of the existing file with the same name as this filename. This will be used to delete the existing file when saving the file and replacing the existing file.
		
		$test = FALSE ;  //  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo, not available on production
		$messages0 = FALSE ;  //  set $messages0=TRUE for STARTING and ENDING messages only
		$messages1 = FALSE ;  //  set $messages1=TRUE for high level messages that are outside of any loop structure
		$messages2 = FALSE ;  //  set $messages2=TRUE for each criteria loop
		$messages3 = TRUE ;  //  set $messages3=TRUE for recall names messages

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\nfunc_get_args(): ";  print_r(func_get_args(),FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  STARTING  >>>\nfunc_get_args(): " . print_r(func_get_args(),TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$num_args_expected = 1 ;
		$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($filename_values_array) );   $err_msg = "\$filename_values_arrayis empty or invalid. \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !is_array($filename_values_array) );   $err_msg = "\$filename_values_array is not an array. \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($filename_values_array['Filename']) );   $err_msg = "Filename is missing, empty or invalid. \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($filename_values_array['Data_Storage_File_Id']) );   $err_msg = "Data_Storage_File_Id is missing, empty or invalid. \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( !isset($filename_values_array['Source_Path']) || $filename_values_array['Source_Path'] == '' );   $err_msg = "Source_Path is missing, empty or invalid. \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( !isset($filename_values_array['Destination_Path']) || $filename_values_array['Destination_Path'] == '' );   $err_msg = "Destination_Path is missing, empty or invalid. \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($filename_values_array['User_Id']) );   $err_msg = "User_Id is missing,empty or invalid. \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( strlen($filename_values_array['User_Id']) != 10 );   $err_msg = "User_Id is an invalid length. \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($filename_values_array['Account_Id']) );   $err_msg = "Account_id is missing,empty or invalid. \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( strlen($filename_values_array['Account_Id']) != 10 );   $err_msg = "Account_id is an invalid length. \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($filename_values_array['File_Definition_Id']) );   $err_msg = "File_Definition_Id is missing,empty or invalid. \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( strlen($filename_values_array['File_Definition_Id']) != 10 );   $err_msg = "File_Definition_Id is an invalid length. \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$error = ( empty($filename_values_array['File_Criteria']) );   $err_msg = "File_Criteria is missing,empty or invalid. \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !is_array($filename_values_array['File_Criteria']) );   $err_msg = "File_Criteria is not an array. \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$error = ( !isset($filename_values_array['File_Action']) );   $err_msg = "File_Action is not set. \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($filename_values_array['File_Action']) );   $err_msg = "File_Action is empty. \n\$filename_values_array[File_Action]: " . $filename_values_array['File_Action'] . " \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		
		$error = ( $messages1 );   $err_msg = "\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		$filename = $filename_values_array['Filename'];
		$data_storage_file_id = $filename_values_array['Data_Storage_File_Id'];
		$source_path = $filename_values_array['Source_Path'];
		$destination_path = $filename_values_array['Destination_Path'];

		$user_id = $filename_values_array['User_Id'];
		$account_id = $filename_values_array['Account_Id'];
		$file_definition_id = $filename_values_array['File_Definition_Id'];

		$file_criteria_values_array = $filename_values_array['File_Criteria'];
		$file_action = $filename_values_array['File_Action'];
		$filename_exists_solution = ( isset($filename_values_array['Filename_Exists_Solution']) ) ? $filename_values_array['Filename_Exists_Solution'] : '';
		$conflicting_file_id = ( isset($filename_values_array['Conflicting_File_Id']) ) ? $filename_values_array['Conflicting_File_Id'] : '';
		
		$this->load->helper('string');

		// get information on our filename, particularly extension
		$file_info = pathinfo($filename);
		$error = ( !is_array($file_info) );   $err_msg = "The pathinfo() value returned is not an array. \$file_info is not an array. \n\$file_info: " . print_r($file_info,TRUE) . " \n\$filename: $filename";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( !isset($file_info) || empty($file_info['extension']) );   $err_msg = "The \$file_info[extension] is not set or empty. \n\$file_info: " . print_r($file_info,TRUE) . " \n\$filename: $filename";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$extension = '.' . $file_info['extension'];

		// get the account record
		$result = $this->Accounts_model->GetAccount($account_id);
		$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Accounts_model->GetAccount() \n\$result: " . print_r($result, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$account = ( isset($result['Result']) && $result['Result'] == TRUE ) ? $result['Row'] : FALSE;
		$error = ( !is_object($account) );   $err_msg = "The account was not found in the database. \$account is not an object. \n\$account_id: $account_id \n" . $result['Result_Message'];   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		$data_storage = $account->Data_Storage; // set the data storage provider value
		$error = ( empty($data_storage) );   $err_msg = "The account data storage provider is empty, or invalid. \n\$account: " . print_r($account, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		
		
		// get the file definition record so we can use information in the record to rename the file
		$this->db->where('Account_Id', $account_id);
		$this->db->where('File_Definition_Id', $file_definition_id);
		$result = $this->db->get('file_definitions');
		$sql_stmt = $this->db->last_query() ;
		$error = ( is_null($result) || ($result == FALSE) );   $err_msg = "Retrieving the file definition record failed. \$result returned false. \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $result->num_rows() != 1 );   $err_msg = "The query failed to return a single record. \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \nSQL Statement: \n$sql_stmt \n\$result->num_rows(): " . $result->num_rows();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$file_definition = $result->row();  // set the file definition record object
		unset($result) ;  // clean up
		unset($sql_stmt) ;  // clean up


		// get the file criteria records so we can use them to build the new filename
		$this->db->where('Account_Id', $account_id);
		$this->db->where('File_Definition_Id', $file_definition_id);
		$this->db->order_by('Criteria_Order', 'ASC');
		$result = $this->db->get('file_criteria');
		$sql_stmt = $this->db->last_query() ;
		$error = ( is_null($result) || ($result == FALSE) );   $err_msg = "Retrieving the file criteria records failed. \$result returned false. \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( $result->num_rows() < 1 );   $err_msg = "The query returned 0 records. \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$file_criteria_query = $result;  // use an appropriate name
		unset($result) ;  // clean up
		unset($sql_stmt) ;  // clean up


		// first we do validation on the criteria values, confirm something didn't get by the interface validation
		// before we can rename the file we need to format the new filename.
		// the filename is formatted by a series of criteria values, each separated by a criteria separator; and each called a segment
		$add_file_definition_name_as_tag = FALSE; // if this is set to true then the file definition name will be added as a box tag
		$new_filename = "" ;
		if ( $file_definition->Definition_Starts_Filename == 1 )
		{
			//  the criteria separator cannot exist anywhere in the file definition if the file definition is going to be used in the name
			$error = ( substr_count($file_definition->File_Def_Name, $file_definition->Criteria_Separator) > 0 );   $err_msg = "The file definition contains the criteria separator string.  This is not allowed. \nFile_Definition: " . $file_definition->File_Def_Name . " \nCriteria_Separator: $file_definition->Criteria_Separator";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			//  start the filename with the file definition
			$new_filename = ( $file_definition->Definition_Starts_Filename == 1 ) ? $file_definition->File_Def_Name : "" ;
			$add_file_definition_name_as_tag = TRUE;
			
		}

		foreach($file_criteria_query->result() as $file_criteria)
		{
			$file_criteria_id = $file_criteria->File_Criteria_Id ;
			$criteria_type_id = $file_criteria->Criteria_Type_Id;
			
			//  clean up the value, if not set or null then set to empty string
			$file_criteria_values_array[$file_criteria_id] = ( !isset($file_criteria_values_array[$file_criteria_id]) ) ? "" : $file_criteria_values_array[$file_criteria_id] ;
			$file_criteria_values_array[$file_criteria_id] = ( is_null($file_criteria_values_array[$file_criteria_id]) ) ? "" : $file_criteria_values_array[$file_criteria_id] ;
			$file_criteria_values_array[$file_criteria_id] = trim($file_criteria_values_array[$file_criteria_id]) ;

			//  if doesn't exist and required, that is an error (a zero [0] can be a valid value so cannot use empty for validation here)
			$error = ( ($file_criteria_values_array[$file_criteria_id] == "") && ($file_criteria->Criteria_Required == 1) );   $err_msg = "A required criteria value is missing. \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \n\$file_criteria_id: $file_criteria_id  \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

			//  if min len specified and value is too short and is required, that is an error  (should have been resolved by the interface)
			$error = ( !is_null($file_criteria->Criteria_Min_Len) && (strlen($file_criteria_values_array[$file_criteria_id]) < $file_criteria->Criteria_Min_Len) && ($file_criteria->Criteria_Required == 1) );   $err_msg = "A required criteria value is too short. \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \n\$file_criteria_id: $file_criteria_id  \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

			//  if min len specified and value is too short and is optional, remove whatever is there
			$file_criteria_values_array[$file_criteria_id] = ( !is_null($file_criteria->Criteria_Min_Len) && (strlen($file_criteria_values_array[$file_criteria_id]) < $file_criteria->Criteria_Min_Len) && ($file_criteria->Criteria_Required != 1) ) ? "" : $file_criteria_values_array[$file_criteria_id] ;

			//  if max len specified and value is too long, that is an error  (should have been resolved by the interface)
			$error = ( !is_null($file_criteria->Criteria_Max_Len) && (strlen($file_criteria_values_array[$file_criteria_id]) > $file_criteria->Criteria_Max_Len) );   $err_msg = "A required criteria value is too long. \n\$file_criteria_values[$file_criteria_id]: " . $file_criteria_values_array[$file_criteria_id] . " \n\$file_criteria->Criteria_Max_Len: " . $file_criteria->Criteria_Max_Len . " \n\string length \$file_criteria_values[$file_criteria_id]: " . strlen($file_criteria_values_array[$file_criteria_id]) . "  \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

			$currency_type = 50102 ;
			$number_type = 50105 ;
			if ( ($criteria_type_id == $currency_type) || ($criteria_type_id == $number_type) )
			{
				//  if optional and does not exist, don't do any numeric validation or formatting on this criteria value
				if ( ($file_criteria->Criteria_Required != 1) && ($file_criteria_values_array[$file_criteria_id] == "") )
				{
					//  set array element value to working variable, so we don't edit what was passed to the method, until we are done with it
					$this_val = $file_criteria_values_array[$file_criteria_id] ;

					//  remove the currency symbol, if the value has it
					$this_val = str_replace($file_criteria->File_Currency_Symbol,"",$this_val) ;

					// verify that we have a valid numeric value
					$error = ( !is_numeric($this_val) );   $err_msg = "A value is not a valid numeric value. \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \n\$file_criteria_id: $file_criteria_id  \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

					//  round to specified decimal precision
					$this_val = round(doubleval($this_val),$file_criteria->Criteria_Decimals) ;

					//  format as specified
					$this_val = number_format($this_val, $file_criteria->Criteria_Decimals, $file_criteria->Dec_Point, $file_criteria->Thousands_Sep) ;

					//  add currency symbol if this ia a currency value an a currency symbol was specified
					$this_val = ( ($file_criteria_id == $currency_type) && !is_null($file_criteria->Criteria_Currency_Symbol) ) ? $file_criteria->Criteria_Currency_Symbol . $this_val : $this_val ;

					//  finished, reset working variable value back to array element
					$file_criteria_values_array[$file_criteria_id] = $this_val ;
					unset($this_val) ;   // clean up
				}
			}

			$date_type = 50104 ;
			if ( $criteria_type_id == $date_type )
			{
				//  if optional and does not exist, don't do any date validation or formatting on this criteria value
				if ( ($file_criteria->Criteria_Required != 1) && ($file_criteria_values_array[$file_criteria_id] == "") )
				{
					//  set array element value to working variable, so we don't edit what was passed to the method, until we are done with it
					$this_val = $file_criteria_values_array[$file_criteria_id] ;

					// validate date, assuming no date used in a filename can be prior to January 2, 1970
					$error = ( strlen($this_val < 6) );   $err_msg = "An invalid date has been used in a filename. \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \n\$file_criteria_id: $file_criteria_id  \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

					//  replace periods with hyphens, now it will have only hyphens as date separators
					$this_val = str_replace(".","-",$this_val) ;

					//  convert to a php time value (number of seconds)
					//  if the date does NOT start with a year, we need to replace the "-" with a "/" for the strtotime function to work properly
					$this_val = ( (substr_count(substr($this_val,0,4),'-')>0) ) ? strtotime(str_replace('-','/',$this_val . '00:00:00')) : strtotime($this_val . '00:00:00') ;

					// validate date, assuming no date used in a filename can be prior to January 2, 1970
					$error = ( is_null($this_val) || ($this_val < 100) );   $err_msg = "An invalid date has been used in a filename.  The earliest date to use in a filename is January 2, 1970. \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \n\$file_criteria_id: $file_criteria_id  \n\$filename_values_array: " . print_r($filename_values_array,TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

					// validate that the user has not selected a date earlier than the earliest valid date
					if ( !is_null($file_criteria->Days_Back) )
					{
						$secs_in_a_day = (60 * 60 * 24) ;
						$secs_back = (intval($file_criteria->Days_Back) * $secs_in_a_day) ;
						$earliest_valid_date_val = (strtotime(date("Y-m-d 00:00:00", time())) - $secs_back) ;
						$error = ( $this_val < $earliest_valid_date_val );   $err_msg = "The selected date is before the earliest valid date. \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \n\$file_criteria_id: $file_criteria_id  \n\Selected date: " . date("Y-m-d",$this_val) . "\n\Earliest valid date: " . date("Y-m-d",$earliest_valid_date_val);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
					}
					elseif ( !is_null($file_criteria->Date_Back) )
					{
						$earliest_valid_date_val = strtotime($file_criteria->Date_Back . ' 00:00:00') ;
						$error = ( $this_val < $earliest_valid_date_val );   $err_msg = "The selected date is before the earliest valid date. \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \n\$file_criteria_id: $file_criteria_id  \n\Selected date: " . date("Y-m-d",$this_val) . "\n\Earliest valid date: " . date("Y-m-d",$earliest_valid_date_val);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
					}
					else
					{
						$error = ( TRUE );   $err_msg = "This criteria fails to specify an earliest valid date. \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \n\$file_criteria_id: $file_criteria_id";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
					}

					// validate that the user has not selected a date later than the latest valid date
					if ( !is_null($file_criteria->Days_Forward) )
					{
						$secs_in_a_day = (60 * 60 * 24) ;
						$secs_forward = (intval($file_criteria->Days_Forward) * $secs_in_a_day) ;
						$latest_valid_date_val = (strtotime(date("Y-m-d 00:00:00", time())) + $secs_forward) ;
						$error = ( $this_val > $latest_valid_date_val );   $err_msg = "The selected date is after the latest valid date. \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \n\$file_criteria_id: $file_criteria_id  \n\Selected date: " . date("Y-m-d",$this_val) . "\n\Latest valid date: " . date("Y-m-d",$latest_valid_date_val);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
					}
					elseif ( !is_null($file_criteria->Date_Forward) )
					{
						$latest_valid_date_val = strtotime($file_criteria->Date_Forward . ' 00:00:00') ;
						$error = ( $this_val > $latest_valid_date_val );   $err_msg = "The selected date is after the latest valid date. \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \n\$file_criteria_id: $file_criteria_id  \n\Selected date: " . date("Y-m-d",$this_val) . "\n\Latest valid date: " . date("Y-m-d",$latest_valid_date_val);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
					}
					else
					{
						$error = ( TRUE );   $err_msg = "This criteria fails to specify a latest valid date. \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \n\$file_criteria_id: $file_criteria_id";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
					}

					//  the date value is valid, format the date as specified
					$this_val = date($file_criteria->Criteria_Php_Date_Format, $this_val) ;

					//  finished, reset working variable value back to array element
					$file_criteria_values_array[$file_criteria_id] = $this_val ;
					unset($this_val) ;   // clean up
				}
			}

			//  the file criteria separator cannot exist anywhere in the critieria value
			$error = ( substr_count($file_criteria_values_array[$file_criteria_id], $file_definition->Criteria_Separator) > 0 );   $err_msg = "The file criteria value contains the criteria separator string.  This is not allowed. \nFile_Criteria_Value: " . $file_criteria_values_array[$file_criteria_id] . " \nCriteria_Separator: $file_definition->Criteria_Separator";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

			//  the criteria separator cannot exist anywhere in the critieria prefix value
			$error = ( substr_count($file_criteria->Criteria_Prefix, $file_definition->Criteria_Separator) > 0 );   $err_msg = "The criteria prefix value contains the criteria separator string.  This is not allowed. \nFile_Prefix_Value: " . $file_criteria->Criteria_Prefix . " \nCriteria_Separator: $file_definition->Criteria_Separator";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

			//  the criteria separator cannot exist anywhere in the critieria suffix value
			$error = ( substr_count($file_criteria->Criteria_Suffix, $file_definition->Criteria_Separator) > 0 );   $err_msg = "The criteria suffix value contains the criteria separator string.  This is not allowed. \nFile_Suffix_Value: " . $file_criteria->Criteria_Suffix . " \nCriteria_Separator: $file_definition->Criteria_Separator";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

			//  done formatting and passed all validation checks of criteria values, now we cancatenate the criteria value onto the new filename
			if ( $file_criteria_values_array[$file_criteria_id] != "" )
			{
				$new_filename .= ( $new_filename == "" ) ? "" : $file_definition->Criteria_Separator ;  //  append a criteria separator if the filename has already been started
				$prefix = ( (strlen($file_criteria->Criteria_Prefix) == 0) || is_null($file_criteria->Criteria_Prefix) ) ? "" : $file_criteria->Criteria_Prefix ;   // cannot use empty because zero is a value, do not trim because space may be used
				$suffix = ( (strlen($file_criteria->Criteria_Suffix) == 0) || is_null($file_criteria->Criteria_Suffix) ) ? "" : $file_criteria->Criteria_Suffix ;   // cannot use empty because zero is a value, do not trim because space may be used
				$new_filename .= $prefix . $file_criteria_values_array[$file_criteria_id] . $suffix ;   //  append the criteria value with any prefix and suffix
			}
			$error = ( $messages2 );   $err_msg = "\$new_filename: $new_filename \n\$file_criteria_id: $file_criteria_id";   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

			//  if this is a name criteria type, and it is recallable, save the value to the recall table if it is not already there
			$name_type = 50103 ;
			$new_recall_name_id = NULL ;  // default to NULL
			if ( $criteria_type_id == $name_type )
			{
				$error = ( $messages3 );   $err_msg = "\$file_criteria->Criteria_Recall_Name: $file_criteria->Criteria_Recall_Name \n\$file_criteria_id: $file_criteria_id";   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				//  if optional and does not exist, don't do any date validation or formatting on this criteria value
				if ( $file_criteria->Criteria_Recall_Name == 1 )
				{
					unset( $names_cnt ) ;

					// determine if the name is already in the recall_names table for this account
					$this->db->where('Account_Id', $account_id);
					if ( $account->Recall_Names_By_File_Definition == 1 )
					{
						// if this account recalls names by file definition, then each file definition can have it's own set of unique names
						$this->db->where('File_Definition_Id', $file_definition_id);
						$this->db->where('File_Criteria_Id', $file_criteria_id);
					}
					if ( $account->Recall_Names_By_User == 1 )
					{
						// if this account recalls names by user_id, then each user can have it's own set of unique names
						$this->db->where('User_Id', $user_id);
					}
					$this->db->where('Recall_Name', $file_criteria_values_array[$file_criteria_id]);
					$names_cnt = $this->db->count_all_results('recall_names');
					$sql_stmt = $this->db->last_query() ;
					$error = ( (is_null($names_cnt) || ($names_cnt === FALSE)) && ($names_cnt != 0) );   $err_msg = "Error occurred while checking database for existing recall name. \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
					$error = ( $messages3 );   $err_msg = "\$names_cnt: $names_cnt \n\$file_criteria_id: $file_criteria_id";   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
					$error = ( $messages3 );   $err_msg = "Query for existing name. \n\$sql_stmt: \n$sql_stmt \n\$file_criteria_id: $file_criteria_id";   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
					unset($sql_stmt) ;  // clean up

					if ( $names_cnt == 0 )
					{
						//  if there is no such name, then insert it into the table so it can later be recalled
						unset($new_recall_name_array) ;
						$new_recall_name_array = array() ;
						$new_recall_name_array['Account_Id'] = $account_id ;
						$new_recall_name_array['User_Id'] = $user_id ;
						$new_recall_name_array['File_Definition_Id'] = $file_definition_id ;
						$new_recall_name_array['File_Criteria_Id'] = $file_criteria_id ;
						$new_recall_name_array['Recall_Name'] = $file_criteria_values_array[$file_criteria_id] ;
						$new_recall_name_array['Created_DateTime'] = date("Y-m-d H:i:s", time()) ;
						$result = $this->db->insert('recall_names', $new_recall_name_array);
						$sql_stmt = $this->db->last_query() ;
						$error = ( is_null($result) || ($result == FALSE) );   $err_msg = "The insert of the new recall name failed. \$result is false. \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \nSQL Statement: \n$sql_stmt";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
						$error = ( $messages3 );   $err_msg = "Insert of new name. \n\$sql_stmt: \n$sql_stmt \n\$file_criteria_id: $file_criteria_id";   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

						//  Get the unique key, Recall_Name_Id, of the recall_name record we just inserted
						$new_recall_name_id = $this->db->insert_id() ;
						$error = ( empty($new_recall_name_id) );   $err_msg = "The new Recall_Name_Id is invalid. \n\$new_recall_name_id: $new_recall_name_id \n\$account_id: $account_id \n\$file_definition_id: $file_definition_id \nSQL Statement: \n$sql_stmt"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
						$error = ( $messages3 );   $err_msg = "Record ID of new name. \n\$new_recall_name_id: $new_recall_name_id \n\$file_criteria_id: $file_criteria_id";   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
						unset($new_recall_name_array) ;  // clean up
						unset($result) ;  // clean up
						unset($sql_stmt) ;  // clean up
					}
				}
			}

		}

		//  if the new filename is too short, error
		$error = ( strlen($new_filename) < 5 );   $err_msg = "The new filename is an invalid length.  It must not be shorter than 5 characters. \n\$new_filename: $new_filename";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		//  if the new filename is too long, error
		$error = ( strlen($new_filename) > 250 );   $err_msg = "The new filename is an invalid length.  It must be not be longer than 250 characters. \n\$new_filename: $new_filename";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

			
		
		//  The filename already exists, and the end user has been prompted to take action. This is only happens if filename already exists and the user has been prompted to take action.
		//  The filename has already been constructed. 
		//
		//  The actions are:
		//  Save_And_Replace ->	Save and replace existing file.
		//  Save_As_New_Version ->	Save as a new version by concatenating a copied file suffix to the end of the file. (IE: Filename(2).pdf)
		
		$do_not_delete_file = false; // we set a value to not delete the file which will be passed back to the delete method.
		
		if( !empty($filename_exists_solution) )
		{
			if( strtoupper($filename_exists_solution) == "SAVE_AND_REPLACE" )
			{
				// delete the file with the filename that already exists from the remote data storage provider account.
				if( strtoupper($data_storage) == "BOX" )
				{
					$result = $this->Data_storage_model->BoxDeleteFile($account_id, $conflicting_file_id);
					$error = ( empty($result) || !isset($result['Result']) || !isset($result['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->BoxDeleteFile() \n\$result: " . print_r($result, TRUE);   $err_type = ( isset($result['Error_Type']) ) ? $result['Error_Type'] : 'none';   $err_status = ( isset($result['Error_Status']) ) ? $result['Error_Status'] : 'none';   $err_code = ( isset($result['Error_Code']) ) ? $result['Error_Code'] : 'none';  $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Error_Type' => $err_type, 'Error_Status' => $err_status, 'Error_Code' => $err_code,  'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
					$error = ( empty($result['Result']) || ($result['Result'] !== TRUE) );   $err_msg = $result['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $err_status = ( isset($result['Error_Status']) ) ? $result['Error_Status'] : 'none';   $err_code = ( isset($result['Error_Code']) ) ? $result['Error_Code'] : 'none';  $conflicting_file_id = ( isset($result['Conflicting_File_Id']) ) ? $result['Conflicting_File_Id'] : '';  $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Error_Type' => $err_type, 'Error_Status' => $err_status, 'Error_Code' => $err_code,  'Conflicting_File_Id' => $conflicting_file_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
				}
				elseif( strtoupper($data_storage) == "DROPBOX" )
				{
					
				}
				elseif( strtoupper($data_storage) == "GOOGLE DRIVE" )
				{
					
				}
				elseif( strotupper($data_storage) == "MICROSOFT ONEDRIVE" )
				{
					
				}
			}
			elseif( strtoupper($filename_exists_solution) == "SAVE_AS_NEW_VERSION" )
			{
				// to save as a new version we need to construct a new filename. we do this by adding some type of suffix towards the end. we will follow conventional version suffix formats.
				// for example, the second copy of the file will end in (2).ext, and the third (3).ext.
				
				$do_not_delete_file = true; // if we are saving as a new version we are keeping the original version. Set the original file to not delete.
				
				// we can use this filename to check for any previous version suffix characters since it is the same as the original file.
				$filename_original_suffix = substr($new_filename, -3, strlen($new_filename));
				$suffix_1 = substr($suffix, 0, 1);
				$suffix_2 = substr($suffix, 1, 1);
				$suffix_3 = substr($suffix, 2, 3);
				
				if( $suffix_1 == "(" && is_numeric($suffix_2) && $suffix_3 == ")" )
				{
					$suffix_num = ((int)$suffix_2+2);
					$new_filename .= "($suffix_num)";
				}
				else
				{
					$new_filename .= "(2)";
				}
				
			}
		}
		
		// after all file renaming is complete concatenate the file extension on to the file
		$new_filename .= $extension; // concatenate the original filename extension on to the new file name
		
		$error = ( $messages1 );   $err_msg = "Before renaming and moving. \n\$new_filename: $new_filename \n\$destination_path: $destination_path \n\$filename: $filename \n\$source_path: $source_path";   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	
		
		
		// rename and file the file on the data storage provider
		if( strtoupper($data_storage) == "BOX" )
		{
			$source_folder_id = ( !empty($source_path) || $source_path == 0 ) ? $source_path : '';
			$destination_folder_id = ( $destination_path == "" ) ? $file_definition->Default_Destination_Path : $destination_path;
			$return = $this->Data_storage_model->BoxCopyFileAndDelete($account_id, $data_storage_file_id, $source_folder_id, $destination_folder_id, $new_filename, $file_action, $do_not_delete_file);
			$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->BoxCopyFileAndDelete() \n\$result: " . print_r($return, TRUE);   $err_type = ( isset($return['Error_Type']) ) ? $return['Error_Type'] : 'none';   $err_status = ( isset($return['Error_Status']) ) ? $return['Error_Status'] : 'none';   $err_code = ( isset($return['Error_Code']) ) ? $return['Error_Code'] : 'none';   $conflicting_file_id = ( isset($return['Conflicting_File_Id']) ) ? $return['Conflicting_File_Id'] : '';  $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Error_Type' => $err_type, 'Error_Status' => $err_status, 'Error_Code' => $err_code,  'Conflicting_File_Id' => $conflicting_file_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $err_status = ( isset($return['Error_Status']) ) ? $return['Error_Status'] : 'none';   $err_code = ( isset($return['Error_Code']) ) ? $return['Error_Code'] : 'none';  $conflicting_file_id = ( isset($return['Conflicting_File_Id']) ) ? $return['Conflicting_File_Id'] : '';  $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Error_Type' => $err_type, 'Error_Status' => $err_status, 'Error_Code' => $err_code,  'Conflicting_File_Id' => $conflicting_file_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
			$error = ( isset($return['New_Data_Storage_File_Id']) && empty($return['New_Data_Storage_File_Id']) );   $err_msg = "The new data storage file id did not return, or is invalid. \n\$return: " . print_r($return, TRUE) ; $err_status = ( isset($return['Error_Status']) ) ? $return['Error_Status'] : 'none';   $err_code = ( isset($return['Error_Code']) ) ? $return['Error_Code'] : 'none';  $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Error_Type' => $err_type, 'Error_Status' => $err_status, 'Error_Code' => $err_code,  'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

			$new_data_storage_file_id = $return['New_Data_Storage_File_Id'];
			
		}
		elseif( strtoupper($data_storage) == "DROPBOX")
		{
			
		}
		elseif( strtoupper($data_storage) == "GOOGLE DRIVE" )
		{
			
		}
		elseif( strtoupper($data_stroage) == "MICROSOFT ONEDRIVE" )
		{
			
		}
		
		
		// add file criteria as file tags
		
		$file_tags_array = array();
		// first if the file definition name is being used at the beginning of the filename then we add it as a tag as well.
		if( $add_file_definition_name_as_tag )
		{
			$file_tags_array[] = $file_definition->File_Def_Name;
		}		
		// next add all the file criteria values as tags
		$file_criteria_array = $file_criteria_values_array;
		foreach($file_criteria_array as $criteria)
		{
			// cleanse the tag value by removing any invalid characters and skipping empty criteria values
			unset($tag);
			$tag = trim($criteria);
			if( $tag != '' )
			{
				// remove all separator types
				$tag = str_replace(',', '', $tag);
				$tag = str_replace(';', '', $tag);
				
				
				$file_tags_array[] = $tag;
			}
		}
		// last we want to add the file definition primary key id as a tag so we can later use it to parse the filename. If the file has already been renamed by filemation, and is opened we automatically select the file definition
		// from the tag and parse the filename to populate the file criteria listed under the file definition.
		$fd_tag = "ID:" . $file_definition->File_Definition_Id;
		$file_tags_array[] = $fd_tag;
		
		$return = $this->Data_storage_model->BoxAddFilesTagsToFile($account_id, $new_data_storage_file_id, $file_tags_array);
		$error = ( empty($return) || !isset($return['Result']) || !isset($return['Result_Message']) );   $err_msg = "Missing or invalid results array returned from \$this->Data_storage_model->BoxAddFilesTagsToFile() \n\$result: " . print_r($return, TRUE);   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		$error = ( empty($return['Result']) || ($return['Result'] !== TRUE) );   $err_msg = $return['Result_Message'] . "\n------------------------------------\nA called method returned ['Result'] !== 'TRUE' and the above message." ; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		

		//  final step is to log the activity in the activity log table
		unset($new_file_activity_log_array) ;
		$new_file_activity_log_array = array() ;
		$new_file_activity_log_array['Account_Id'] = $account_id ;
		$new_file_activity_log_array['User_Id'] = $user_id ;
		$new_file_activity_log_array['File_Definition_Id'] = $file_definition_id ;
		$new_file_activity_log_array['File_Activity_DateTime'] = date("Y-m-d H:i:s", time()) ;
		$new_file_activity_log_array['File_Activity_Date'] = date("Y-m-d", time()) ;
		$new_file_activity_log_array['Source_Filename'] = $filename ;
		$new_file_activity_log_array['Source_Path'] = $source_path ;
		$new_file_activity_log_array['Criteria_Separator'] = $file_definition->Criteria_Separator ;  // saved so we may later be able to parse the name apart
		$new_file_activity_log_array['Destination_Filename'] = $new_filename ;
		$new_file_activity_log_array['Destination_Path'] = $destination_path ;
		$new_file_activity_log_array['New_Recall_Name_Id'] = $new_recall_name_id ;
		$new_file_activity_log_array['File_KB_Size'] = NULL ;  //  THIS STILL NEEDS TO BE DONE
		$new_file_activity_log_array['File_Pages'] = NULL ;  //  THIS STILL NEEDS TO BE DONE
		$new_file_activity_log_array['Pre_Modified_DateTime'] = NULL ;  //  THIS STILL NEEDS TO BE DONE
		$new_file_activity_log_array['Post_Modified_DateTime'] = NULL ;  //  THIS STILL NEEDS TO BE DONE
		$new_file_activity_log_array['Pre_Created_DateTime'] = NULL ;  //  THIS STILL NEEDS TO BE DONE
		$new_file_activity_log_array['Post_Created_DateTime'] = NULL ;  //  THIS STILL NEEDS TO BE DONE
		$result = $this->db->insert( 'file_activity_log', $new_file_activity_log_array );
		$sql_stmt = $this->db->last_query() ;
		$error = ( !isset($result) || ($result === FALSE) );   $err_msg = "An error occured when saving/inserting a new file activity log entry into the db. \n\$result: $result \nSQL Statement: \n$sql_stmt \n\$new_file_activity_log_array: " . print_r($new_file_activity_log_array, TRUE); $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		//  Get the unique key, $file_activity_log_id, of the record we just inserted
		$file_activity_log_id = $this->db->insert_id() ;
		$error = ( empty($file_activity_log_id) || (strlen(intval($file_activity_log_id)) !== 10) );   $err_msg = "The new File_Activity_Log_Id is invalid. \n\$file_activity_log_id: $file_activity_log_id \nSQL Statement: \n$sql_stmt"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
		unset($new_file_activity_log_array) ;  // clean up
		unset($result) ;  // clean up
		unset($sql_stmt) ;  // clean up


		// if we get here the method has completed successfully, wrap up and return results array
		$results_array['Result'] = TRUE;
		$results_array['Account_Id'] = $account_id ;
		$results_array['User_Id'] = $user_id ;
		$results_array['File_Definition_Id'] = $file_definition_id ;
		$results_array['Source_Filename'] = $filename;
		$results_array['Source_Path'] = $source_path;
		$results_array['Destination_Filename'] = $new_filename;
		$results_array['Destination_Path'] = $destination_path;
		$results_array['New_Recall_Name_Id'] = ( is_null($new_recall_name_id) ) ? "" : $new_recall_name_id ;   // can't pass a null value in an array element
		$results_array['File_Activity_Log_Id'] = $file_activity_log_id;
		$results_array['Result_Message'] = "Executed Successfully. \nMethod: " . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y h:i:s A");

		if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n\$results_array: ";  print_r($results_array,FALSE);  echo "\n-----------------------------------------------------"; }
		$error = ( $messages0 );   $err_msg = "<<<  ENDING  >>>\n\$results_array: " . print_r($results_array,TRUE);   $notify = FALSE;   $severity = "MESSAGE";   $stop = FALSE;   $display = FALSE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $this->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, $display, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

		return $results_array;
	}

}
/* End of file docs_model.php */
/* Location: ./application/models/docs_model.php */
