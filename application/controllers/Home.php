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
        $data['reting'] = $this->m_model->get_data('ratting')->result();
		$data['public'] = $this->m_model->get_data('deskripsi_public')->result();
		$this->load->view('home', $data);
	}
    
	public function ratting()
	{
        $data['reting'] = $this->m_model->get_data('ratting')->result();
		$this->load->view('rating', $data);
	}

    
}
