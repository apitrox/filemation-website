<?php if( !defined('BASEPATH') ) die('No direct script access');

/*
 * Filemation
 */

class Modal extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function Index()
	{
		
	}
	
	//  This method controls the 'select data storage path' modal dialog.
	//  Request Data: GET[data_storage_folder_id]
	public function SelectDataStorageFolder()
	{
		//  Request GET Data
		//  data_storage_folder_id = the current data storage folder id. if this is not empty then the folder hiarchy will expand to its previously saved folder.
		
		$input = $this->input->get('input');
		
		$view_data = array();
		$view_data['input'] = $input;
		
		$this->load->view('modal/select_data_storage_folder', $view_data);
	}
	
	//  This method controls the 'filename already exists select solution' modal dialog.
	//  Request Data: GET[]
	public function FilenameExistsSelectSolution()
	{
		//  Request GET Data
		//  rename_and_file_action = the action took with the data storage file. either Rename_And_File_Document or Rename_Document
		
		$rename_and_file_action = $this->input->get('rename_and_file_action');
		$conflicting_file_id = $this->input->get('conflicting_file_id');
		
		$view_data = array();
		$view_data['rename_and_file_action'] = $rename_and_file_action;
		$view_data['conflicting_file_id'] = $conflicting_file_id;
		
		$this->load->view('modal/filename_exists_select_solution', $view_data);
	}
}