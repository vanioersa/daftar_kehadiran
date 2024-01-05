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
        $this->load->view('auth/login');
    }

    public function register()
    {
        $this->load->view('auth/register');
    }

    public function submit()
    {
        // Validasi form
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('aktivitas', 'Aktivitas Lingkungan', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembali ke form dengan pesan error
            $this->load->view('auth/register');
        } else {
            // Jika validasi sukses, simpan data ke database (gunakan model)
            $data = array(
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'alamat' => $this->input->post('alamat'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'aktivitas' => $this->input->post('aktivitas'),
                'password' => md5($this->input->post('password')), // Use MD5 for password
                'role' => 'user'
            );

            // Panggil model untuk menyimpan data
            $this->m_model->insert_data($data);

            // Redirect ke halaman auth/login setelah berhasil menyimpan data
            redirect(base_url('auth'));
        }
    }

    public function submit_login()
    {
        $email = $this->input->post('email', true);
        $password = $this->input->post('password', true);
        $data = ['email' => $email];
        $query = $this->m_model->getwhere('user', $data);
        $result = $query->row_array();

        if (!empty($result) && md5($password) === $result['password']) {
            $data = [
                'loged_in' => TRUE,
                'email'    => $result['email'],
                'nama' => $result['nama'],
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
