<?php defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('m_model');
        $this->load->helper('my_helper');
    }

	public function index()
	{
		$this->load->view('home');
	}
}
