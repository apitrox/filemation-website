<?php
/*
 * Filemation
 * 
 * Data storage configuration file that sets the production and development data storage provider api credentials.
 */


// require the filemation configuration file to set different config data for production vs development applications.
require_once(FCPATH . '/fm_config/fm_config.php');

//  ===================================
//  Clould Elements
//  ===================================
$config['Data_Storage_Cloud_Elements_User_Secret'] = "liL5CiTYuJJz7d2L4J5hAuoBcWKCbuYWpiPi+8TAbmo=";
$config['Data_Storage_Cloud_Elements_Organization_Secret'] = "88d5235a13bf4717f8b3c7bbc1ec63ca";


//  ===================================
//  Box API
//  ===================================

if( DEBUG != TRUE )
{
	// Production Box Credentials
	$config['Data_Storage_Box_Client_Id'] = "4fbszm4bfyxgficxrmbsznm0szq0x541"; // filemation box api v2 client ID
	$config['Data_Storage_Box_Client_Secret'] = "gMwkJp5MiZw96vExKhqlmOgVkoRF3rVh"; // filemation box api v2 client secret
	$config['Data_Storage_Box_Api_Key'] = "4fbszm4bfyxgficxrmbsznm0szq0x541"; // filemation box api key
	$config['Data_Storage_Box_View_API_Key'] = "er3czovednqygojjii0mbdq7mwqvgqla"; // filemation view box api key
	$config['Data_Storage_Box_Redirect_Uri'] = "https://app.filemation.com/ds/GetDataStorageAuthTokens/"; // the redirect url to authorize user's file storage accounts with filemation accounts
	$config['Date_Storage_Box_Security_Token'] = "security_token DKnhMJatFipTAnM0nHlZA";
}
else
{
	// Development Box Credentials
	$config['Data_Storage_Box_Client_Id'] = "6lmr5ujufqzpc65e72iye5dkzan6s9am"; // filemation box api v2 client ID
	$config['Data_Storage_Box_Client_Secret'] = "ECGMW2NEXZQ4Gys2OjwBkEjhgXIZdWcz"; // filemation box api v2 client secret
	$config['Data_Storage_Box_Api_Key'] = "6lmr5ujufqzpc65e72iye5dkzan6s9am"; // filemation box api key
	$config['Data_Storage_Box_View_API_Key'] = ""; // filemation box view api key
	$config['Data_Storage_Box_Redirect_Uri'] = "https://dev.filemation.com/ds/GetDataStorageAuthTokens/"; // the redirect url to authorize user's file storage accounts with filemation accounts
	$config['Date_Storage_Box_Security_Token'] = "";
}

//  ===================================
//  Dropbox API
//  ===================================

$config['Data_Storage_Dropbox_Client_Id'] = "l2k8s5sx5kl5yam"; // filemation dropbox api v1 client ID
$config['Data_Storage_Dropbox_Client_Secret'] = "hkd0tadtzdjw46m"; // filemation dropbox api v1 client secret
$config['Data_Storage_Dropbox_Redirect_Uri'] = "https://dev.filemation.com/ds/GetDataStorageAuthTokens"; // the redirect url to authorize user's file storage accounts with filemation accounts

//  ===================================
//  Google Drive API
//  ===================================

$config['Data_Storage_Google_Drive_Client_Id'] = "754728185708-1d2elli067ba1p55vbb0n1dmv2730i6v.apps.googleusercontent.com";
$config['Data_Storage_Google_Drive_Client_Secret'] = "aTaAgGTJL3I1lVR51Gx6ANTU";
$config['Data_Storage_Google_Drive_Email_Address'] = "754728185708-1d2elli067ba1p55vbb0n1dmv2730i6v@developer.gserviceaccount.com";
$config['Data_Storage_Redirect_Uri'] = "https://dev.filemation.com/ds/GetDataStorageAuthTokens";
$config['Data_Storage_Javascript_Origins'] = "https://dev.filemation.com";


//  ===================================
//  Microsoft OneDrive
//  ===================================

$config['Data_Storage_Microsoft_One_Drive_Client_Id'] = "000000004C12334C";
$config['Data_Storage_Microsoft_One_Drive_Client_Service'] = "aIHDWtJgqsJw2hUPETlvqH36sYPuIljx";