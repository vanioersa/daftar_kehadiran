<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('m_model');
    }

    public function index()
    {
        $data['user'] = $this->m_model->get_data('user')->result();
        $this->load->view('auth/login', $data);
    }    

    public function register()
    {
        $this->load->view('auth/register');
    }

    public function registerrr()
    {
        $this->load->view('auth/registerrr');
    }

    public function submit()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('nomor', 'nomor', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/register');
        } else {
            $data = array(
                'nama' => $this->input->post('nama'),
                'nomor' => $this->input->post('nomor'),
                'email' => $this->input->post('email'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'password' => md5($this->input->post('password')),
                'role' => 'user'
            );
            $this->m_model->insert_data($data);
            redirect(base_url('auth'));
        }
    }

    public function submittt()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('nomor', 'nomor', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/register');
        } else {
            $data = array(
                'nama' => $this->input->post('nama'),
                'nomor' => $this->input->post('nomor'),
                'email' => $this->input->post('email'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'password' => md5($this->input->post('password')),
                'role' => 'admin'
            );
            $this->m_model->insert_data($data);
            redirect(base_url('auth'));
        }
    }

    public function submit_login()
    {
        $email = $this->input->post('email', true);
        $nomor = $this->input->post('nomor', true);
        $password = $this->input->post('password', true);
        
        $data = ['email' => $email];
        $data = ['nomor' => $nomor];
        $query = $this->m_model->getwhere('user', $data);
        $result = $query->row_array();

        if (!empty($result) && md5($password) === $result['password']) {
            $data = [
                'loged_in' => TRUE,
                'email'    => $result['email'],
                'nomor' => $result['nomor'],
                'role'     => $result['role'],
                'id'       => $result['id'],
            ];
            $this->session->set_userdata($data);
            if ($this->session->userdata('role') == 'admin') {
                redirect(base_url() . "admin");
            } elseif ($this->session->userdata('role') == 'user') {
                redirect(base_url() . "user");
            } else {
                redirect(base_url() . "auth");
            }
        } else {
            $this->session->set_flashdata('error', 'Login gagal. Email atau password salah.');
            redirect(base_url() . "auth");
        }
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('auth'));
    }
}
