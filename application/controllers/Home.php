<?php defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('m_model');
    }

	public function index()
	{
		$data['public'] = $this->m_model->get_data('deskripsi_public')->result();
		$this->load->view('home', $data);
	}
}
