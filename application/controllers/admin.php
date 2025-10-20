<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Filemation
 */


class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
	}
	
	public function ErrorLogReport()
	{
		$this->auth_lib->Secure();
		
		$view_data = array();
		
		$this->load->view('head');
		$this->load->view('header_admin');
		$this->load->view('admin/reports/error_log_report');
		$this->load->view('footer');
	}
	
	//  This method will get file definitions data for the filemation configuration grid
	//  Request Data: GET[]
	public function GetErrorLogReportGrid()
	{
		$get_data = $this->input->get();
		
		$result = $this->Grid_model->GetAdminErrorLogReportData($get_data);
		
		$json_response = $result;
		
		if( $this->input->get('callback') != FALSE )
		{
			echo $this->input->get('callback') . '(' . json_encode($json_response) . ')';
		}
		else
		{
			echo json_encode($json_response);
		}
		
	}

}

/* End of file account.php */
/* Location: ./application/controllers/account.php */