<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_model');
        if ($this->session->userdata('loged_in') != true || $this->session->userdata('role') != 'user') {
            redirect(base_url() . 'auth');
        }
    }

    public function index()
    {
        $this->load->view('user/dashboard');
    }
}