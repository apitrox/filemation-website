<?php

class Login extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function Index()
	{
		$this->load->view('head_login');
		$this->load->view('login/login');
		$this->load->view('footer');
	}
	
}