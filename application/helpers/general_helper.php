<?php
/*
** Lams Online
** Version 1.0
**
** This helper is for general function to help keep the integrity of our Lams Online data
*/



//  this function adds a blank item, as the first item in any array
// Param 1:  an array
// return:   array with blank item added as first element
function AddBlankItemToArray( $this_array )
{
	if( !is_array($this_array) ) return NULL ;

	$temp_array = array() ;
	$temp_array[0] = '' ;

	$counter = 1 ;

	foreach ( $this_array as $this_element )
	{
		$temp_array[$counter] = $this_element ;
		$counter ++ ;
	}

	return $temp_array ;
}


//  This function converts an array into an sql list
//  items, inclosed in single quotes and separated by commas
//  if the array is empty, the returned list is an empty string
// Param 1:  the array to work on
// return:   string, the sql formatted list
function ArrayToSqlList( $array_to_convert )
{
		$sql_list = '' ;
		$counter = 0 ;
		foreach ( $array_to_convert as $array_item )
		{
			$sql_list = ( $counter > 0 ) ? $sql_list . "," : $sql_list ;
			$sql_list .= "'" . $array_item . "'" ;
			$counter ++ ;
		}
		return $sql_list ;
}

//	This helper function compresses an array of files into ZIP format
//	@Param 1:	required, files array
//	@Param 2:	required, destination to save zip file
//	@Param 3:	optional, overwrite file if it already exists.
//	@Return:	result array
function CreateZipFile($files = array(), $destination = '', $overwrite = false)
{
	$test = FALSE ;
	$ci =& get_instance();
	$ci->load->model('Error_log_model');

	$error = ( file_exists($destination) && !$overwrite );   $err_msg = "file already exists, and overwrite is set as false.\nFilename $destination"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg);}

	$valid_files = array();

	if(is_array($files))
	{
		foreach($files as $file)
		{
			if(file_exists($file))
			{
				$valid_files[] = $file;
			}
		}
	}

	$error = ( count($valid_files) == 0 );   $err_msg = "\$valid_files count is 0. No files to compress into ZIP."; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg);}

	$zip = new ZipArchive();
	$zip_create = $zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE);
	$error = ( $zip_create !== TRUE );   $err_msg = "Could not open zip archive to create the zip file.\nFilename $destination"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg);}

	foreach($valid_files as $file)
	{
		$result = $zip->addFile($file, basename($file) );
		$error = ( $result == FALSE );   $err_msg = "The file did not add to the zip archive successfully. \n\$zip->addFile(\$file, basename(\$file)) \n\$file: $file"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg);}
	}

	if( DEBUG && $test ) { echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status; }

	$result = $zip->close();
	$error = ( $result == FALSE );   $err_msg = "The zip archive did not close successfully. \n\$zip->close \n\$zip"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg);}

	// delete all the files contained in the compressed file
	foreach($valid_files as $file)
	{
		$delete_result = @unlink($file);
		$error = ( $delete_result !== TRUE );   $err_msg = "\$delete_result returned false. The file did not delete successfully. \nFilename: $file"; $notify = FALSE;   $severity = "WARNING";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg);}
	}

	$results_array = array();
	$results_array['Result'] = TRUE;
	$results_array['File_Exists'] = file_exists($destination);
	$results_array['File_Name'] = $destination;
	$results_array['Result_Message'] = "Executed Successfully!";

	return $results_array;
}

/*function GetDatesInRange($start_date, $end_date)
{
	$start_date_utime = strtotime($start_date . ' 00:00:00') ;
	$end_date_utime = strtotime($end_date . ' 00:00:00') ;

	if( $start_date_utime == $end_date_utime) return array( date('Y-m-d', $start_date_utime) ) ;

	$dates = array();
	$dates[] = date( 'Y-m-d', strtotime('+1 day', $start_date . ' 00:00:00') ) ;
	while( $start_date_utime <= $end_date_utime )
	{
		$dates[] = date( 'Y-m-d', strtotime('+1 day', $start_date . ' 00:00:00') ) ;
	}
	$dates[] = date( 'Y-m-d', strtotime('+1 day', $end_date . ' 00:00:00') ) ;

	return $dates;
}*/


//  This helper function will delete all files and directories in a given directory then delete the directory its self
//  @Param 1:	requird, directory path name of directory to delete/remove
//  @Return:   result array
function DeleteDir( $dir_path_name )
{
	//  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo
	$test = FALSE ;
	if(DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------\n"; }
	if(DEBUG && $test)  { echo "func_get_args(): \n";  print_r(func_get_args(), FALSE);  echo "\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------\n\n"; }

	$ci =& get_instance();

	$num_args_expected = 1 ;
	$error = ( func_num_args() != $num_args_expected );   $err_msg = "Invalid number of arguments passed to method.  Expected: " . $num_args_expected . "   Received: " . func_num_args();   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

	$error = ( empty($dir_path_name) );   $err_msg = "\$dir_path_name is empty.";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	$error = ( is_dir($dir_path_name) == FALSE );   $err_msg = "\$dir_path_name is not a directory.";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

	$files = @glob($dir_path_name . DIRECTORY_SEPARATOR . '*', GLOB_MARK);
	foreach ($files as $file)
	{
		if (is_dir($file))
		{
		    self::DeleteDir($file);
		}
		else
		{
		    @unlink($file);
		}
	}

	$result = @rmdir($dir_path_name);
	$error = ( $result == FALSE );   $err_msg = "The directory was not removed. \$result is false. \nDirectory: $dir_path_name";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}
	$error = ( file_exists($dir_path_name) );   $err_msg = "\$dir_path_name still exists after removal.";   $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg . "\nError_Log_Id:  $err_log_id");}

	$results_array = array();
	$results_array['Result'] = TRUE;
	$results_array['Result_Message'] = "Executed Successfully!";

	if  (DEBUG && $test)  { echo "\n------------------------ RETURN/RESULTS ARRAY -----------------------------\n";   print_r($results_array, FALSE);  echo "\n-----------------------------------------------------\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") . "\n-----------------------------------------------------\n"; }

	if (DEBUG && $test)  { echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date( "n-j-Y, g:i:s a" ) . "\n-----------------------------------------------------\n"; }

	return $results_array;
}


//  computes the time difference between 2 times and returns a string in format: "x hrs, x mins, x secs"
//  It doesn't matter which parameter is the start/small time and which is the end/large time
//  @Param 1:	requird, a time in the format time()
//  @Param 2:	optional, a time in the format time(), if not provided uses the current time
//  @Return:   result array
function ElapsedTimeReadable( $time1, $time2 )
{
	$time2 = ( !isset($time2) || empty($time2) ) ? time() : $time2 ;

	$time_diff = abs($time2 - $time1) ;   //  calculate elapsed time
	$hrs = ( $time_diff >= (60 * 60) ) ? floor($time_diff/(60 * 60)) : 0 ;  // calculate hours
	$time_diff = $time_diff - ($hrs * (60 * 60)) ;   // subtract hours time from time_diff
	$mins = ( $time_diff >= 60 ) ? floor($time_diff/60) : 0 ;  // calculate minutes
	$secs = $time_diff - ($mins * 60) ;  // calculate seconds (remaining)

	return "$hrs hrs, $mins mins, $secs secs" ;
}


// This helper function forces httpd connection to the {HTTPS} protocal.
// @Return:	VOID, redirect user browser connection
function ForceSSL()
{
    if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != "on")
	{
        $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        redirect($url);
        exit;
    }
}


//  Formats data strings from yyyy-mm-dd to mm-dd-yyyy, mm-dd-yyyy to yyyy-mm-dd
//  @param1:	string date
//  @param2:	format, TRUE = return mm-dd-yyyy, FALSE = return yyyy-mm-dd
//  @Return:	formatted date
function FormatDateString($date_string, $format = TRUE)
{
	if( empty($date_string) ) return NULL;

	$date_bomb = explode('-', $date_string);
	$new_date = $date_string;

	if( isset($date_bomb[2]) && strlen($date_bomb[2]) == 4)
	{
		if($format)
		{
			$new_date = $date_bomb[0] . '-' . $date_bomb[1] . '-' . $date_bomb[2];
		}
		 else
		{
			$new_date = $date_bomb[2] . '-' . $date_bomb[0] . '-' . $date_bomb[1];
		}
	}
	 elseif(isset($date_bomb[0]) &&  strlen($date_bomb[0]) == 4)
	{
		if($format)
		{
			$new_date = $date_bomb[1] . '-' . $date_bomb[2] . '-' . $date_bomb[0];
		}
		 else
		{
			$new_date = $date_bomb[0] . '-' . $date_bomb[1] . '-' . $date_bomb[2];
		}
	}

	return $new_date;

}


//  formats first 10-digits of a string as a phone number (xxx) xxx-xxxx
//  @param1:  string to work on
//  @return: resulting formatted string, NULL if nothing passed to in
function FormatPhoneNum( $string )
{
	$string = RemoveNonNumericChars( $string ) ;

	if ( is_null($string) || empty($string) || strlen($string) < 3 )
	{
		return NULL ;
	}
	else
	{
		return $string =  '(' . substr($string,0,3) . ') ' . substr($string,3,3) . '-' . substr($string,6,4) ;
	}
}


//  formats first 10-digits of a string as a phone number xxx-xxx-xxxx
//  @param1:  string to work on
//  @return: resulting formatted string, NULL if nothing passed to in
function FormatPhoneNumShort( $string )
{
	$string = RemoveNonNumericChars( $string ) ;

	if ( is_null($string) || empty($string) || strlen($string) < 3 )
	{
		return NULL ;
	}
	else
	{
		return $string =  substr($string,0,3) . '-' . substr($string,3,3) . '-' . substr($string,6,4) ;
	}
}


//  formats a referral number from a contact_id
//  @param1:  contact_id string to work on
//  @return: resulting formatted string, NULL if nothing passed to in
function FormatReferralNum( $contact_id )
{
	$string = RemoveNonNumericChars( $contact_id ) ;

	if ( is_null($string) || empty($string) || (strlen($string) < 9) || (strlen($string) > 11) )
	{
		return NULL ;
	}
	else
	{
		return $string =  substr($string,0,3) . '-' . substr($string,3,3) . '-' . substr($string,6) ;
	}
}


//	This helper function formats a filename to be recognize in a linux call.
//	- all spaces, commas, }, {, [, ]  are to have a backward slash (\) in front of them
function FormatUnixFilename( $file_name )
{
	$return_file = str_replace(' ', '\ ', $file_name);
	$return_file = str_replace(',', '\,', $return_file);
	$return_file = str_replace('}', '\}', $return_file);
	$return_file = str_replace('{', '\{', $return_file);
	$return_file = str_replace('[', '\[', $return_file);
	$return_file = str_replace(']', '\]', $return_file);

	return $return_file;
}


//  This function returns the age in years given a DOB
// Param 1:  date of birth
// Param 2:  date of death, if not provided then calculates age as of today
// return:   number of years old, NULL if error
function GetAge( $dob, $dod = NULL )
{
	if ( !isset($dob) )  return NULL ;
	if ( is_null($dob) )  return NULL ;
	if ( empty($dob) )  return NULL ;
	if ( ($dob == "") )  return NULL ;

	$dob_date = date('Y-m-d', strtotime(str_replace('-', '/', $dob))) ;

	$dob_year = intval(date('Y',  strtotime($dob_date))) ;
	$dob_month = intval(date('m',  strtotime($dob_date))) ;
	$dob_day = intval(date('d',  strtotime($dob_date))) ;

	//  if no date of death has been provided, calculate age as of today, else use the date of death
	if ( !isset($dod) || is_null($dod) || empty($dod) || ($dod == "") )
	{
		$as_of_date = date('Y-m-d', time()) ;
	}
	else
	{
		$as_of_date = date('Y-m-d', strtotime(str_replace('-', '/', $dod))) ;
	}

	$as_of_year = intval(date('Y',  strtotime($as_of_date))) ;
	$as_of_month = intval(date('m',  strtotime($as_of_date))) ;
	$as_of_day = intval(date('d',  strtotime($as_of_date))) ;

	$diff_year  = intval($as_of_year - $dob_year) ;
	$diff_month = intval($as_of_month - $dob_month) ;
	$diff_day   = intval($as_of_day - $dob_day) ;

	// If birthday has not happen yet this year, subtract 1.
	if ( ($diff_month < 0) || ( ($diff_month == 0) && ($diff_day < 0) ) )
	{
		$age = $diff_year - 1 ;
	}
	else
	{
		$age = $diff_year ;
	}

	//  as a safety check, if age is less than 1, then return a zero
	if ( $age < 1 )
	{
		$age = 0 ;
	}

	return $age;
}


//  This function computes and returns day values for a given date
// Param 1:  date
// return:   NULL if error, else an array with element values representing, YYYYDDD, YYYYWW, YYYYMM, YYYYQ, YYYY
function GetDayValues( $the_date )
{
	//  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo
	$test = FALSE ;
	if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date( "n-j-Y h:i:s A" ) . "\n-----------------------------------------------------\n"; }
	if (DEBUG && $test)  { echo "func_get_args(): \n";  print_r(func_get_args());  echo "\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\n-----------------------------------------------------\n\n"; }

	$num_args_expected = 1 ;
	if ( func_num_args() != $num_args_expected )  return array('Result' => FALSE, 'Result_Message' => 'ERROR: Invalid number of arguments.' . "  Expecting $num_args_expected, received " . func_num_args() . ".<br />" . "Method: " . __METHOD__ . "<br />Line Number: " . __LINE__ . "<br />") ;

	if ( !isset($the_date) )  return NULL ;
	if ( is_null($the_date) )  return NULL ;
	if ( empty($the_date) )  return NULL ;
	if ( ($the_date == "") )  return NULL ;

	if ( strpos(substr($the_date,0,4),'-') > 0 )
	{
		//  if there is a - in the first four digits, then assume it is in the format mm-dd-yyyy, so convert dash to slash so we can get proper date/time
		$the_date = date('Y-m-d', strtotime(str_replace('-', '/', $the_date))) ;
	}
	else
	{
		$the_date = date('Y-m-d', strtotime($the_date)) ;
	}

	//if ( intval(strtotime($the_date)) < 100 )  return NULL ;   // UNIX result if invalid date
	if ( intval(date("Ymd", strtotime($the_date))) == 19691213 )  return NULL ;   // UNIX result if invalid date

	//  calculate date related fields

	// note, in PHP z starts at 0, so we always increment by 1
	$the_day_of_year = ( intval(date("z", strtotime($the_date))) + 1 ) ;

	$the_day_of_week = intval(date("w", strtotime($the_date))) ;

	$the_month_of_year = intval(date("m", strtotime($the_date))) ;

	$the_year = intval(date("Y", strtotime($the_date))) ;

	$the_quarter = 1 ;
	$the_quarter = ( $the_month_of_year >= 4 ) ? 2 : $the_quarter ;
	$the_quarter = ( $the_month_of_year >= 7 ) ? 3 : $the_quarter ;
	$the_quarter = ( $the_month_of_year >= 10 ) ? 4 : $the_quarter ;


	//  if Sunday (0), increment date by 1 to put into next week, so weeks will be Sun - Sat, not Mon - Sun
	$the_date2 = ( $the_day_of_week == 0 )  ?  date('Y-m-d', strtotime($the_date . ' +1 day'))  :  $the_date  ;
	$the_week_of_year2 = intval(date("W", strtotime($the_date2))) ;   // the week of the year, using modified date
	$the_year2 = intval(date("Y", strtotime($the_date2))) ;   //  the year of the modified date
	//  if the date is in the 52nd week of the year, but the date falls in the next year (month = 1),
	//  subtract 1 from the year to make it the 52nd week of the year in which the week started (the previous year)
	$the_year2 = ( ($the_week_of_year2 == 52) && ($the_month_of_year == 1) ) ? ( $the_year2 - 1 ) : $the_year2 ;



	//  ***  generate year-day  YYYYDDD, so that every date in history will have a unique and numerically sequential day value,
	//  where DDD is the number of days since the first day of the current year, with Jan 01 being day one
	$year_day = intval( $the_year . str_pad($the_day_of_year, 3, '0', STR_PAD_LEFT) ) ;



	//  ***  generate year-week  YYYYWW, so that every date in history will have a unique and numerically sequential week value,
	//  where WW is the week of the year since the first week of the current year
	$year_week = intval( $the_year2 . str_pad($the_week_of_year2, 2, '0', STR_PAD_LEFT) ) ;



	//  ***  generate year-month  YYYYMM, so that every date in history will have a unique and numerically sequential month value,
	//  where MM is the month of the year
	$year_month = intval( $the_year . str_pad($the_month_of_year, 2, '0', STR_PAD_LEFT) ) ;



	//  ***  generate year-month  YYYYQ, so that every date in history will have a unique and numerically sequential quarter value,
	//  where Q is the quarter of the year
	$year_quarter = intval( $the_year . $the_quarter ) ;


	$day_values = array() ;
	$day_values['Year_Day'] = $year_day ;
	$day_values['Year_Week'] = $year_week ;
	$day_values['Year_Month'] = $year_month ;
	$day_values['Year_Quarter'] = $year_quarter ;
	$day_values['Year'] = $the_year ;

	if (DEBUG && $test)  { echo "<pre>" ; echo "\n------------------------ DAY VALUES ARAY-----------------------------\n";   print_r($day_values);  echo "\n-----------------------------------------------------\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date( "n-j-Y h:i:s A" ) . "\n-----------------------------------------------------\n"; }

	if (DEBUG && $test)  { echo "<pre>" ;   echo "\n-----------------------------------------------------\n   <<<  ENDING  >>>\n" . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date( "n-j-Y h:i:s A" ) . "\n-----------------------------------------------------\n"; }

	return $day_values;
}


// This helper function calculates the difference between two dates and returns in it hh:mm format
// @Param 1:	required, maximum date
// @Param 2:	required, minimum date
// @Return:		hh:mm  (difference in hours and minutes) format
function GetElapsedTimeHrsMins($date_time_max, $date_time_min)
{
	$date_max_utime = @strtotime($date_time_max);
	$date_min_utime = @strtotime($date_time_min);

	$diff_hours = ( ($date_max_utime - $date_min_utime) / 3600 );
	$diff_minutes = ceil( round( abs( $date_max_utime - $date_min_utime) / 60, 2) );

	$hours_mins = sprintf("%01d:%02d", floor($diff_minutes / 60), $diff_minutes % 60);
	// %02dh %02dm

	$assembly = "$hours_mins";
	return $assembly;

}


// This helper function calculates the difference between two dates and returns difference in minutes
// @Param 1:	required, maximum date
// @Param 2:	required, minimum date
// @Return:		difference in minutes
function GetElapsedTimeMins($date_max, $date_min)
{
	$date_max_utime = @strtotime($date_time_max);
	$date_min_utime = @strtotime($date_time_min);

	$diff_minutes = ceil( round( abs( $date_max_utime - $date_min_utime ) / 60, 2) );

	return $diff_minutes;
}

//  This helper function retrieves all system languages and returns them in an dropdown array
//  @Return:	result array
function GetLanguageForDropdown()
{
	$ci =& get_instance();
	$ci->load->config('lams');

	$languages_array = $ci->config->item('LANGUAGES');
	if( empty($languages_array ) ) return array('Result' => FALSE, 'Result_Message' => 'ERROR: $languages_array is empty, containing no languages. \n Method: ' . __METHOD__ . ' Line Number: ' . __LINE__);
	if( !is_array($languages_array) ) return array('Result' => FALSE, 'Result_Message' => 'ERROR: $languages_array is not an array. \n Method: ' . __METHOD__ . ' Line Number: ' . __LINE__);

	$dropdown = array();
	$key = 0;
	foreach($languages_array as $language)
	{
		$dropdown[$key]['Default'] = 0;
		$dropdown[$key]['Operator'] = $language['Lang_Name'];
		$dropdown[$key]['Value'] = $language['Lang_Code'];
		$key++;
	}

	return array('Result' => TRUE, 'Dropdown_List' => $dropdown, 'Result_Message' => 'Executed Successfully');
}

//	This helper function determines if a given array is an associative array or not
//	@Param 1:	required, array to determine type of array
//	@Return:    BOOLEAN, TRUE if array is associative, FALSE if array is an indexed array
function IsAssocArray($array)
{
    return array_keys($array) !== range(0, count($array) - 1);
}


//	This helper function determines if the SERVER HOST is a dev*.* server and not production.
//	@Return:	return true if dev, return false otherwise
function IsDev()
{

	//echo strpos($_SERVER['HTTP_HOST'], 'ev'); exit;

	if( strpos($_SERVER['HTTP_HOST'], 'ev') != FALSE )
	{
		return TRUE;
	}
	 else
	{
		return FALSE;
	}
}


//	This helper function determines if the SERVER HOST is a production server and not dev.
//	@Return:	return true if dev server.
function IsProduction()
{
	if( strpos($_SERVER['HTTP_HOST'], 'dev') == FALSE && strpos($_SERVER['HTTP_HOST'], 'stage') == FALSE )
	{
		return TRUE;
	}
	 else
	{
		return FALSE;
	}
}


// This helper function determines the ordinal of a number
// @Param 1:	 required, the number to be ordinalized
// @Return:	the number with ordinal appended, in string format and in lowercase
function OrdinalizeNumber($num)
{
	if (empty($num) || !is_numeric($num) || ($num == 0) )  return $num ;

	$last_digit = substr($num, -1) ;


	if ( ($last_digit == 1) && ($num != 11) )
	{
		$ordinal = 'st' ;
	}
	elseif ( ($last_digit == 2) && ($num != 12) )
	{
		$ordinal = 'nd' ;
	}
	elseif ( ($last_digit == 3) && ($num != 13) )
	{
		$ordinal = 'rd' ;
	}
	else
	{
		$ordinal = 'th' ;
	}

	return $num.$ordinal ;
}


//  This function propercases a name (first, middle, or last) according to this application's rules
//  @param 1:  the name to propercase as a string
//  @return:  the name as a string in its propercase form
function PropercaseName( $name )
{
	  //  This method is supposed to uppercase each word and each character after: mc    -    '  (string "mc", dash, single-quote)
	  $str1 = array( "mc", "-", "'" );
	  $str2 = array( "mc~ ", "-~ ", "'~ " ) ;  // this is the same as $str1, except with a newline after each character, newline will force following char to be uppercase
	  $name = str_replace( '~', '', $name ) ;  // remove any tildes, used as a marker character
	  $name = strtolower( $name ) ;
	  $name = str_replace( $str1, $str2, $name ) ;  // do the switch, to instert a newline after each desired substring
	  $name = ucwords( $name ) ;  //  uppercase each word, will think character after newline is a new word
	  $name = str_replace( "~ ", "", $name ) ;   // now remove the newlines
	  return $name ;
}


//  This function propercases and validates the suffix portion of a name according to this application's rules
//  @param 1:  the suffix to propercase as a string
//  @return:  the resulting suffix as a string in its propercase form, otherwise NULL
function PropercaseNameSuffix( $suffix )
{
	  $lsuffix = strtolower( trim( $suffix ) ) ;

	  if (strlen( $lsuffix ) == 0 )
	  {
			  return NULL ;
	  }
	  elseif (substr_count( $lsuffix , 'jr' ) > 0 )
	  {
			  return 'Jr' ;
	  }
	  elseif (substr_count( $lsuffix , 'sr' ) > 0 )
	  {
			  return 'Sr' ;
	  }
	  elseif (substr_count( $lsuffix , 'viii' ) > 0 )
	  {
			  return 'VIII' ;
	  }
	  elseif (substr_count( $lsuffix , 'vii' ) > 0 )
	  {
			  return 'VII' ;
	  }
	  elseif (substr_count( $lsuffix , 'vi' ) > 0 )
	  {
			  return 'VI' ;
	  }
	  elseif (substr_count( $lsuffix , 'iv' ) > 0 )
	  {
			  return 'IV' ;
	  }
	  elseif (substr_count( $lsuffix , 'v' ) > 0 )
	  {
			  return 'V' ;
	  }
	  elseif (substr_count( $lsuffix , 'iii' ) > 0 )
	  {
			  return 'III' ;
	  }
	  elseif (substr_count( $lsuffix , 'ii' ) > 0 )
	  {
			  return 'II' ;
	  }
	  else
	  {
			  return NULL ;
	  }

}


//  This function propercases a street portion of an address according to this application's rules
//  @param 1:  street portion of the address as a string
//  @return:  street portion of the address in its propercase form
function PropercaseStreetAddr( $name )
{
	  //  This method is supposed to uppercase each word and each character after: mc    -    '  (string "mc", dash, single-quote)
	  $str1 = array( "mc", "-", "'" );
	  $str2 = array( "mc~ ", "-~ ", "'~ " ) ;  // this is the same as $str1, except with a newline after each character, newline will force following char to be uppercase
	  $name = str_replace( '~', '', $name ) ;  // remove any tildes, used as a marker character
	  $name = strtolower( $name ) ;
	  $name = str_replace( $str1, $str2, $name ) ;  // do the switch, to instert a newline after each desired substring
	  $name = ucwords( $name ) ;  //  uppercase each word, will think character after newline is a new word
	  $name = str_replace( "~ ", "", $name ) ;   // now remove the newlines
	  $name = str_replace( "Po ", "PO ", $name ) ;   // now uppercase PO
	  return $name ;
}


//  Removes duplicate spaces, and leading and trailing spaces, from a string
//  @param1:  string to work on
//  @return: resulting string with no extra spaces
function RemoveExtraSpaces( $string )
{
	  $string = trim( $string );

	  while ( substr_count( $string , '  ' ) > 0)
	  {
			  $string = str_replace ( '  ', ' ', str_replace ( '   ', ' ', $string ) );
	  }

	  return trim( $string ) ;
}


//  Removes all invalid characters from the field cases.Case_Styled
//  @param1:  string to work on
//  @return: resulting string of valid case_styled characters
function RemoveInvalidCaseStyledChars( $string )
{
	$string = str_replace( "`", "'", trim($string) ) ;
	$string = preg_replace('/[^a-zA-Z0-9\ \'\-\.\,]/', '', $string )  ;
	$string = str_replace( "VS.", " VS. ", $string);
	$string = trim( RemoveExtraSpaces( $string ) ) ;
	return $string ;
}


//  Removes all invalid document title characters from a string (as defined by ffer)
//  @param1:  string to work on
//  @return: resulting string of valid document title charactes
function RemoveInvalidDocTitleChars( $string )
{
	$string = preg_replace('/[^a-zA-Z\ \-]/', '', $string )  ;
	$string = trim( RemoveExtraSpaces( $string ) ) ;
	return trim($string) ;
}


//  Removes all invalid email characters from a string (scrubs an email)
//  @param1:  string to work on
//  @return: resulting string with invalid email chars removed
function RemoveInvalidEmailChars( $string )
{
	return trim($string);
	return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", trim($string));
}


//  Removes all invalid name characters from a string (as defined by ffer)
//  @param1:  string to work on
//  @return: resulting string of valid name charactes
function RemoveInvalidNameChars( $string )
{
	$string = str_replace( "`", "'", trim($string) ) ;
	$string = preg_replace('/[^a-zA-Z0-9\ \'\-]/', '', $string )  ;
	$string = trim( RemoveExtraSpaces( $string ) ) ;
	return $string ;
}


//  Removes all non-gender characters from a string
//  @param1:  string to work on
//  @return: resulting string of only one valid gender character (M or F)
function RemoveNonGenderChars( $string )
{
	  return strtoupper(substr(preg_replace('/[^MF]/s', '', $string),0,1)) ;
}


//  Removes all non-numeric and non-alphabetic characters from a string
//  @param1:  string to work on
//  @return: resulting string of only numeric and alphabetic characters
function RemoveNonNumericAndAlphaChars( $string )
{
	return preg_replace('/[^a-zA-Z0-9]/s', '', $string) ;
}


//  Removes all non-numeric and non-alphabetic characters from a string
//  @param1:  string to work on
//  @return: resulting string of only numeric and alphabetic characters
function RemoveNonNumericAndNonAlphaChars( $string )
{
	return preg_replace('/[^a-zA-Z0-9]/s', '', $string) ;
}


//  Removes all non-numeric characters from a string
//  @param1:  string to work on
//  @return: resulting string of only numeric characters
function RemoveNonNumericChars( $string )
{
	  return preg_replace('/[^0-9]/', '', $string) ;
}


//  This helper function will format a phone number (xxx) xxx-xxxx to xxxxxxxxxx
//  @Param1:  string to work on
//  @Return: resulting formatted string, NULL if nothing passed to in
function StripPhoneNum( $phone_string )
{
	$phone = str_replace('(', '', $phone_string);
	$phone = str_replace(')', '', $phone);
	$phone = str_replace('-', '', $phone);
	$phone = str_replace(' ', '', $phone);

	return trim($phone);
}

//  This helper function will check if the given string is in the array stack.
//  @Param 1:   the string we we are matching to the array stack
//  @Param 2:   the array stack to search
//  @Return:    true if in array, false otherwise.
function InArrayNormal($needle, $haystack)
{
    $needle = str_replace('^', '', $needle);
    $needle = trim( strtolower( str_replace('.', '', $needle) ) );

    return in_array( $needle, $haystack);
}

//  This helper function will find parts of the full name string given and return it in 5 parts, title, first, middle, last, suffix.
//  @Param 1:   string persons full name to be parsed
//  @Return:    assoc array of name results.
function ParsePersonName($fullname)
{

    // Return result:
    // Result   -->
    // Title    -->
    // First    -->
    // Middle   -->
    // Last     -->
    // Suffix   -->

    if( empty($fullname) || is_null($fullname) ) return array('Result' => FALSE, 'Result_Message' => 'ERROR: $full_name empty or null (METHOD: ' . __METHOD__ . ' LINE: ' . __LINE__ . ' )');


    //  configure titles, prefices, and suffices
	$titles	= array('dr','miss','mr','mrs','ms','judge');
	$prefices =	array('ben','bin','da','dal','de','del','der','de','e', 'la','le','san','st','ste','van','vel','von');
	$suffices =	array('esq','esquire','jr','sr','2','ii','iii','iv');
    //$prefices = array("&", "AB", "AIRMAN", "AN", "AND", "BG", "BR", "BRIG", "BRIGADIER", "CADET", "CAPT", "CAPTAIN", "CMDR", "COL", "COLONEL", "COMMANDER", "CORPORAL", "CPL", "CPT", "DEP", "DEPUTY", "DOCTOR", "DR", "FATHER", "FR", "GEN", "GENERAL", "HON", "HONORABLE", "JDGE", "JUDGE", "LIEUTENANT", "LT", "LTCOL", "LTGEN", "LTCOL", "LTGEN", "MAJ", "MAJGEN", "MAJOR", "MASTER", "MISS", "MISTER", "MR", "MRMRS", "MRS", "MS", "PASTOR", "PFC", "PRES", "PRIVATE", "PROF", "PROFESSOR", "PVT", "RABBI", "REP", "REV", "REVEREND", "SEN", "SENATOR", "SGT", "SSGT", "SHERIFF", "SIR", "SISTER", "SM", "SN", "SRA", "SSGT");
    //$suffices = array("CCSP", "CPA", "DC", "DDS", "DMD", "DO", "DPM", "DVM", "ESQ", "ESTATE", "FAM", "FAMILY", "II", "III", "IV", "Jr", "LUTCF", "MD", "OC", "OD", "PA", "PE", "PhD", "SJ", "Sr", "V", "VI", "VP");
	$pieces = explode(',', preg_replace('/\s+/', ' ', trim($fullname)) );
	$n_pieces =	count($pieces);
    #echo "<pre>"; print_r($pieces); exit;
    #echo $n_pieces; exit;

    //  prep return result
    $return_result = array();
    $return_result['Result'] = TRUE;
    $return_result['Title'] = '';
    $return_result['First'] = '';
    $return_result['Middle'] = '';
    $return_result['Last'] = '';
    $return_result['Suffix'] = '';

	switch($n_pieces)
    {
		case 1:	// array(title first middles last suffix)
			$subp =	explode(' ',trim($pieces[0]));
			$n_subp	= count($subp);

			for($i = 0; $i < $n_subp; $i++)
            {
				$curr =	trim($subp[$i]);
				$next =	( isset($subp[$i + 1]) ) ? trim($subp[$i+1]) : $subp[$i];

				if( $i == 0 && InArrayNormal($curr, $titles) )
                {
					$return_result['Title'] = $curr;
					continue;
				}

				if(!$return_result['First'])
                {
					$return_result['First'] = $curr;
					continue;
				}

				if( ($i == ($n_subp - 2) ) && $next && InArrayNormal($next, $suffices) )
                {
					if($return_result['Last'])
                    {
						$return_result['Last'] .= " $curr";
                    }
					 else
                    {
						$return_result['Last'] = $curr;
					}

                    $return_result['Suffix'] = $next;
					break;
				}

				if($i == $n_subp - 1)
                {
					if($return_result['Last'])
                    {
						$return_result['Last'] .= " $curr";
					}
					 else
                    {
						$return_result['Last'] = $curr;
					}
					continue;
				}

				if( InArrayNormal($curr, $prefices) )
                {
					if($return_result['Last'])
                    {
						$return_result['Last'] .= " $curr";
                    }
					 else
                    {
						$return_result['Last'] = $curr;
					}
					continue;
				}



				if( strtoupper($next) == 'Y' )
                {
					if($return_result['Last'])
                    {
						$return_result['Last'] .= " $curr";
					}
					 else
                    {
						$return_result['Last'] = $curr;
					}
					continue;
				}

				if($return_result['Last'])
                {
					$return_result['Last'] .=	" $curr";
					continue;
				}

				if($return_result['Middle'])
                {
					$return_result['Middle'] .= " $curr";
				}
				 else
                {
					$return_result['Middle'] = $curr;
				}
			}
			break;

		case 2:
            switch( InArrayNormal($pieces[1], $suffices) ) {
                case TRUE: // array(title first middles last,suffix)
                    $subp =	explode(' ',trim($pieces[0]));
                    $n_subp	= count($subp);

                    for($i = 0; $i < $n_subp; $i++)
                    {
                        $curr =	trim($subp[$i]);
                        $next =	( isset($subp[$i + 1]) ) ? trim($subp[$i + 1]) : $curr;

                        if($i == 0 && InArrayNormal($curr,$titles))
                        {
                            $return_result['Title'] =	$curr;
                            continue;
                        }

                        if(!$return_result['First'])
                        {
                            $return_result['First'] =	$curr;
                            continue;
                        }

                        if($i == $n_subp-1)
                        {
                            if($return_result['Last'])
                            {
                                $return_result['Last'] .=	" $curr";
                            }
                             else
                            {
                                $return_result['Last'] = $curr;
                            }
                            continue;
                        }

                        if(InArrayNormal($curr,$prefices))
                        {
                            if($return_result['Last'])
                            {
                                $return_result['Last'] .=	" $curr";
                            }
                             else
                            {
                                $return_result['Last'] = $curr;
                            }
                            continue;
                        }

                        if( strtoupper($next) == 'Y' )
                        {
                            if($return_result['Last'])
                            {
                                $return_result['Last'] .=	" $curr";
                            }
                             else
                            {
                                $return_result['Last'] = $curr;
                            }
                            continue;
                        }

                        if($return_result['Last'])
                        {
                            $return_result['Last'] .=	" $curr";
                            continue;
                        }

                        if($return_result['Middle'])
                        {
                            $return_result['Middle'] .= " $curr";
                        }
                         else
                        {
                            $return_result['Middle'] = $curr;
                        }
                    }

                    $return_result['Suffix'] = trim($pieces[1]);

                    break;
                case FALSE: // array(last, title first middles suffix)
                    $subp =	explode( ' ', trim($pieces[1]) );
                    $n_subp = count($subp);

                    for($i = 0; $i < $n_subp; $i++)
                    {
                        $curr =	trim($subp[$i]);
                        $next =	( isset($subp[$i + 1]) ) ?  trim($subp[$i + 1]) : $subp[$i];

                        if( ($i == 0) && InArrayNormal($curr, $titles) )
                        {
                            $return_result['Title'] = $curr;
                            continue;
                        }

                        if(!$return_result['First'])
                        {
                            $return_result['First'] = $curr;
                            continue;
                        }


                        if( ($i == ($n_subp - 2)) && $next && InArrayNormal($next, $suffices) )
                        {

                            if($return_result['Middle'])
                            {
                                $return_result['Middle'] .= " $curr";
                            }
                             else
                            {
                                $return_result['Middle'] = $curr;
                            }

                            $return_result['Suffix'] = $next;
                            break;
                        }

                        if( ( $i == ($n_subp - 1) ) && InArrayNormal($curr, $suffices) )
                        {
                            $return_result['Suffix'] = $curr;
                            continue;
                        }

                        if($return_result['Middle'])
                        {
                            $return_result['Middle'] .=	" $curr";
                        }
                         else
                        {
                            $return_result['Middle'] = $curr;
                        }
                    }

                    $return_result['Last'] = $pieces[0];
                    break;
                }

			unset($pieces);
			break;

		case	3:	// array(last,title first middles,suffix)
			$subp =	explode(' ',trim($pieces[1]));
			$n_subp	= count($subp);

            for($i = 0; $i < $n_subp; $i++)
            {
				$curr = isset($subp[$i]) ? trim($subp[$i]) : $subp[1];
				$next = isset($sub[$i+1]) ? trim($subp[$i+1]) : $subp[$i];

                if($i == 0 && InArrayNormal($curr,$titles))
                {
					$return_result['Title'] =	$curr;
					continue;
				}

				if(!$return_result['First'])
                {
					$return_result['First'] =	$curr;
					continue;
                }

				if($return_result['Middle'])
                {
					$return_result['Middle'] .= " $curr";
				}
				 else
                {
					$return_result['Middle'] = $curr;
				}
			}

			$return_result['Last'] =	trim($pieces[0]);
			$return_result['Suffix'] = trim($pieces[2]);
			break;

		default:	// unparseable
			unset($pieces);
			break;
	}

    $return_result['Result_Message'] = 'Executed successfully.';

	return $return_result;
}

//	This helper function remoe all "Microsoft Word" ASCII and formatting codes in a given string
//	@Param 1:	required, string to remove ascii codes from
//	@Return:	clean string
function RemoveWordTagsInString( $string )
{
	if( empty($string) ) return $string;
	if( is_null($string) ) return $string;

	$reg_exp_1 = "@<w[^>]*>[\s\S]*</w[^>]*>@smU";
	$reg_exp_2 = "@<style[^>]*>[\s\S]*</style[^>]*>@smU";
	$reg_exp_3 = "@<p[^>]*>@smU";
	$string = preg_replace($reg_exp_1, '', $string);
	$string = preg_replace($reg_exp_2, '', $string);
	$string = str_replace('<![endif]-->', '', $string);
	$string = str_replace('<xml>', '', $string);
	$string = str_replace('</xml>', '', $string);
	$string = str_replace('<!--[if gte mso 10]>', '', $string);
	$string = str_replace('<!--[if gte mso 9]>', '', $string);
	$string = str_replace('<font>', '', $string);
	$string = str_replace('</font>', '', $string);
	$string = str_replace('</p>', '', $string);
	$string = preg_replace($reg_exp_3, '', $string);

	return $string;
}

//	This helper function un compresses a zip file and creates the directory in the same directory while substaining correct unix permissions
//	@Param 1:	required, file path name of zip file
//	@Param 2:	required, path directory name to unzip file contents
//	@Return:	result array
function UnzipFile( $file, $unzip_path_dir )
{
	$zip = new ZipArchive;

	$zip_open = @$zip->open($file);
	$error = ( empty($zip_open) );   $err_msg = "The file could not open to unzip. \nFilename $file"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg);}

	$finfo = pathinfo($file);
	$new_folder = $finfo['filename'];

	// Extract the files from the zip file to the path provided.
	// The files are extracted to the given directory plus a new folder with the same basename as the file name.
	// Ex: /home/ourfiles/templates_converted/filename/     and the zip file is named filename.zip
	$extract_result = @$zip->extractTo($unzip_path_dir . DIRECTORY_SEPARATOR . $new_folder);
	$error = ( empty($extract_result) );   $err_msg = "the zip file can not be uncompressed. \nFilename $file"; $notify = FALSE;   $severity = "ERROR";   $stop = TRUE;    /* -- Do Not Edit beyond this point on this line -- */   if($error){$err_log_id = $ci->Error_log_model->NewErrorLogEntry3(TRUE, $notify, $severity, $err_msg, __METHOD__, __LINE__);}  if($stop && $error){return array('Result' => FALSE, 'Error_Log_Id' => $err_log_id, 'Result_Message' => $err_msg);}

	$zip->close();

	@chmod($unzip_path_dir . DIRECTORY_SEPARATOR . $new_folder, 0770);

	$dir_contents_array = glob($unzip_path_dir . DIRECTORY_SEPARATOR . $new_folder . DIRECTORY_SEPARATOR . '*', GLOB_MARK);

	$results_array = array();
	$results_array['Result'] = TRUE;
	$results_array['Dir'] = $unzip_path_dir . DIRECTORY_SEPARATOR . $new_folder . DIRECTORY_SEPARATOR;
	$results_array['Dir_Contents_Array'] = $dir_contents_array;
	$results_array['Result_Message'] = "Executed Successfully!";

	return $results_array;
}

//  This helper function compares two date unix times and returns the difference.
//  @Param 1:	required, the first date
//  @Param 2:	required, the second date
//  @Param 3:	optional, how to return the order
//  @Return:	0 if the two dates are equal, -1 if a is less than b, 1 if be is less than a
function DateCompare($date_a, $date_b, $order = 'DESC')
{
	if ($date_a == $date_b)
	{
		return 0;
	}

	if( strtoupper($order) == 'ASC' )
	{
		return ($date_a < $date_b) ? -1 : 1;
	}
	else
	{
		return ($date_a < $date_b) ? 1 : -1;
	}
}

//  This function returns the default array item for a filter dropdown array
//  @Param 1:	required, array of filter dropdown values
//  @Return:	default value
function GetFilterDropdownDefaultValue( $filter_dropdown_list )
{
	if( !is_array($filter_dropdown_list) ) return '';

	$default_value = '';
	foreach($filter_dropdown_list['Dropdown_List'] as $row)
	{
		if( isset($row['Default']) && $row['Default'] == TRUE )
		{
			$default_value = ( isset($row['Value']) ) ? $row['Value'] : $default_value;
		}
	}

	return $default_value;
}


//  This function calculates the starting and ending date of a week by the given date.
//  @Param 1:	required, the date to calculate the week start and end date
//  @Return:		return array
function GetDateWeekRange($the_date)
{
	//  return elements of results array are:
	//  $return_array['Result']   -->   TRUE if executes successfully, FALSE if error occurs
	//  $return_array['Start']   -->   unix time (utime) for the for the first/start day of the week
	//  $return_array['First_Day']   -->   same as Start
	//  $return_array['First_Date']   -->   the date in "YYYY-mm-dd" format of the first date of the week, a Sunday
	//  $return_array['End']   -->   unix time (utime) for the for the last/end day of the week
	//  $return_array['Last_Day']   -->   same as End
	//  $return_array['Last_Date']   -->   the date in "YYYY-mm-dd" format of the last date of the week, a Saturday
	//  $return_array['Result_Message']   //  message text

	//  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo
	$test = FALSE ;
	if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date( "n-j-Y h:i:s A" ) . "\n-----------------------------------------------------\n"; }
	if (DEBUG && $test)  { echo "func_get_args(): \n";  print_r(func_get_args());  echo "\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\n-----------------------------------------------------\n\n"; }

	$num_args_expected = 1 ;
	if ( func_num_args() != $num_args_expected )  return array('Result' => FALSE, 'Result_Message' => 'ERROR: Invalid number of arguments.' . "  Expecting $num_args_expected, received " . func_num_args() . ".\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\n") ;

	if ( !isset($the_date) )  return array('Result' => FALSE, 'Result_Message' => "ERROR: \$the_date is not set." . "\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") ) ;
	if ( is_null($the_date) )  return array('Result' => FALSE, 'Result_Message' => "ERROR: \$the_date is null." . "\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") ) ;
	if ( empty($the_date) )  return array('Result' => FALSE, 'Result_Message' => "ERROR: \$the_date is empty." . "\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") ) ;

	//  if there is a - in the first four digits, then assume it is in the format mm-dd-yyyy, so convert dash to slash so we can get proper date/time
	//  mm-dd-yyyy and m-d-yyyy are not valid date formats to be used with strtotime, mm/dd/yyyy and m/d/yyyy  are valid formats, yyyy-mm-dd is also valid format
	if ( strpos(substr($the_date,0,4),'-') > 0 )
	{
		$the_date = date('Y-m-d', strtotime(str_replace('-', '/', $the_date))) ;
	}
	else
	{
		$the_date = date('Y-m-d', strtotime($the_date)) ;
	}

	//  check for valid date
	if ( intval(strtotime($the_date)) < 100 )  return array('Result' => FALSE, 'Result_Message' => "ERROR: \$the_date is not a valid date (first validation)." . "\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") ) ;
	if ( intval(date("Ymd", strtotime($the_date))) == 19691213 )  return array('Result' => FALSE, 'Result_Message' => "ERROR: \$the_date is not a valid date (second validation)." . "\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") ) ;


	$the_day_of_week = intval(date("w", strtotime($the_date))) ;     //  Numeric representation of the day of the week;  0 (for Sunday) through 6 (for Saturday)

	$start_date = date('Y-m-d', strtotime($the_date . " -$the_day_of_week day")) ;    // subtract the correct number of days from the_date, to get the prior Sunday

	$end_date = date('Y-m-d', strtotime($start_date . " +6 day")) ;   // from Sunday, add 6 days to get to the following Saturday

	$start = strtotime($start_date . ' 00:00:00') ;   //  get utime (Unix time) value

	$end = strtotime($end_date . ' 00:00:00') ;   //  get utime (Unix time) value

//	$start = strtotime($date) - strftime('%w', strtotime($date)) * 24 * 60 * 60;
//	$end = $start + 6 * 24 * 60 * 60;

//	$return = array();
//	$return['Start'] = $start;
//	$return['First_Day'] = $start;
//	$return['End'] = $end;
//	$return['Last_Day'] = $end;

	$return_array = array();
	$return_array['Result'] = TRUE ;
	$return_array['Start'] = $start;
	$return_array['First_Day'] = $start;
	$return_array['First_Date'] = $start_date;
	$return_array['End'] = $end;
	$return_array['Last_Day'] = $end;
	$return_array['Last_Date'] = $end_date;
	$return_array['Result_Message'] =  "Executed successfully.\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") ;

	return $return_array;
}


//  This function calculates the first and last day of the given valid dates month
//  @Param 1:	required, valid date with time
//  @Return:		return array
function GetDateMonthRange( $the_date )
{
	//  return elements of results array are:
	//  $return_array['Result']   -->   TRUE if executes successfully, FALSE if error occurs
	//  $return_array['Start']   -->   unix time (utime) for the for the first/start day of the month
	//  $return_array['First_Day']   -->   same as Start
	//  $return_array['First_Date']   -->   the date in "YYYY-mm-dd" format of the first date of the month
	//  $return_array['End']   -->   unix time (utime) for the for the last/end day of the month
	//  $return_array['Last_Day']   -->   same as End
	//  $return_array['Last_Date']   -->   the date in "YYYY-mm-dd" format of the last date of the month
	//  $return_array['Result_Message']   //  message text

 	//  Set $test=TRUE to turn on echo for testing, else FALSE to turn off echo
	$test = FALSE ;
	if (DEBUG && $test)  { echo "<pre>";  echo "\n-----------------------------------------------------\n   <<<  STARTING  >>>\n" . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date( "n-j-Y h:i:s A" ) . "\n-----------------------------------------------------\n"; }
	if (DEBUG && $test)  { echo "func_get_args(): \n";  print_r(func_get_args());  echo "\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\n-----------------------------------------------------\n\n"; }

	$num_args_expected = 1 ;
	if ( func_num_args() != $num_args_expected )  return array('Result' => FALSE, 'Result_Message' => 'ERROR: Invalid number of arguments.' . "  Expecting $num_args_expected, received " . func_num_args() . ".\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\n") ;

	if ( !isset($the_date) )  return array('Result' => FALSE, 'Result_Message' => "ERROR: \$the_date is not set." . "\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") ) ;
	if ( is_null($the_date) )  return array('Result' => FALSE, 'Result_Message' => "ERROR: \$the_date is null." . "\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") ) ;
	if ( empty($the_date) )  return array('Result' => FALSE, 'Result_Message' => "ERROR: \$the_date is empty." . "\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") ) ;

	//  if there is a - in the first four digits, then assume it is in the format mm-dd-yyyy, so convert dash to slash so we can get proper date/time
	//  mm-dd-yyyy and m-d-yyyy are not valid date formats to be used with strtotime, mm/dd/yyyy and m/d/yyyy  are valid formats, yyyy-mm-dd is also valid format
	if ( strpos(substr($the_date,0,4),'-') > 0 )
	{
		$the_date = date('Y-m-d', strtotime(str_replace('-', '/', $the_date))) ;
	}
	else
	{
		$the_date = date('Y-m-d', strtotime($the_date)) ;
	}

	//  check for valid date
	if ( intval(strtotime($the_date)) < 100 )  return array('Result' => FALSE, 'Result_Message' => "ERROR: \$the_date is not a valid date (first validation)." . "\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") ) ;
	if ( intval(date("Ymd", strtotime($the_date))) == 19691213 )  return array('Result' => FALSE, 'Result_Message' => "ERROR: \$the_date is not a valid date (second validation)." . "\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") ) ;

	$the_year = date( 'Y', strtotime($the_date)) ;
	$the_month = date( 'm', strtotime($the_date)) ;
	$the_last_day = date( 't', strtotime($the_date)) ;   //  number of days in the month, which will be used as the last day of the month

	$start_date = date( 'Y-m-d', mktime(0, 0, 0, $the_month, 1, $the_year) ) ;   //  first day of the month is always day 1

	$end_date = date( 'Y-m-d', mktime(0, 0, 0, $the_month, $the_last_day, $the_year) ) ;  // last day of the month is always equal to the number of days in the month

	$start = strtotime($start_date . ' 00:00:00') ;   //  get utime (Unix time) value

	$end = strtotime($end_date . ' 00:00:00') ;   //  get utime (Unix time) value

	$return_array = array();
	$return_array['Result'] = TRUE ;
	$return_array['Start'] = $start;
	$return_array['First_Day'] = $start;
	$return_array['First_Date'] = $start_date;
	$return_array['End'] = $end;
	$return_array['Last_Day'] = $end;
	$return_array['Last_Date'] = $end_date;
	$return_array['Result_Message'] =  "Executed successfully.\nMethod: " . __METHOD__ . "\nLine Number: " . __LINE__ . "\nTime: " . date("n-j-Y, g:i:s a") ;

	return $return_array;

//	if( strtotime($the_date) == 0 ) return array('Start' => 0, 'First_Day' => 0, 'End' => 0, 'Last_Day' => 0);
//
//	$total_days = date('t', strtotime($date) );
//	$year = date('Y', strtotime($date) );
//	$month = date('n', strtotime($date) );
//	$day = date('j', strtotime($date) );
//
//	$first_factor = $day - 1;
//	$last_factor = $total_days - $day;
//	$first_day = strtotime($date . " -$first_factor days");
//	$last_day = strtotime($date . " +$last_factor days");
//
//	$return = array();
//	$return['Start'] = $first_day;
//	$return['First_Day'] = $first_day;
//	$return['End'] = $last_day;
//	$return['Last_Day'] = $last_day;
//
//	return $return;
}

//  This helper function helps determine the <head/><title/> text value from the given url segment(2)
//  @Return: <head/><title/> text value
function GetPortalHeadTitle()
{
	$ci =& get_instance();

	$title = "";
	if( strtoupper($ci->uri->segment(2)) == 'MEMBER' || strtoupper($ci->uri->segment(2)) == 'GUEST' || strtoupper($ci->uri->segment(2)) == 'MEMBERLOGIN' )
	{
		$title = "Member";
	}
	else
	{
		$title = "Attorney";
	}

	return $title;

}



function GetDaysDiffDates()
{
			$date1 = strtotime(date("Y-m-d") . " 00:00:00") ;
//			$date2 = strtotime("2009-01-01" . " 00:00:00") ;
//			$days_diff = round((abs($date1-$date2)/60/60/24),0) ;
//			$days_back = $days_diff * -1 ;
}

function CreateGridColumnHeaderWithTooltip( $name, $tooltip )
{
	return "<span class='tooltip_grid' bt-xtitle='$tooltip'>$name</span>";
}

/* End of file general_helper.php */
/* Location: ./helpers/general_helper.php */

?>