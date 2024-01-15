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
        $this->form_validation->set_rules('nomor', 'Nomor', 'required|callback_check_nomor_exists');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|callback_check_password_not_same_as_email');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/register');
        } else {
            $config['upload_path']   = './image/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size']      = 2048;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('image')) {
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('auth/register', $error);
            } else {
                $upload_data = $this->upload->data();
                $nomor_exists = $this->m_model->check_nomor_exists($this->input->post('nomor'));
                $email_exists = $this->m_model->check_email_exists($this->input->post('email'));

                if ($nomor_exists || $email_exists) {
                    $response = [
                        'status'   => 'error',
                        'message'  => $nomor_exists ? 'Nomor sudah digunakan.' : 'Email sudah digunakan.',
                        'redirect' => base_url('auth'),
                    ];
                    $this->load->view('auth/register', $response);
                } else {
                    $data = array(
                        'nama'          => $this->input->post('nama'),
                        'nomor'         => $this->input->post('nomor'),
                        'email'         => $this->input->post('email'),
                        'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                        'password'      => md5($this->input->post('password')),
                        'role'          => 'user',
                        'image'         => $upload_data['file_name']
                    );

                    $this->load->model('m_model');
                    $inserted_id = $this->m_model->insert_user($data);

                    if ($inserted_id) {
                        redirect(base_url('auth'));
                    } else {
                        $response = [
                            'status'   => 'error',
                            'message'  => 'Gagal menyimpan data.',
                            'redirect' => base_url('auth'),
                        ];
                        $this->load->view('auth/register', $response);
                    }
                }
            }
        }
    }

    public function check_password_not_same_as_email($password)
    {
        $email = $this->input->post('email');

        if ($password == $email) {
            $this->form_validation->set_message('check_password_not_same_as_email', 'Password tidak boleh sama dengan Email.');
            return FALSE;
        } else {
            return TRUE;
        }
    }


    public function submittt()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('nomor', 'Nomor', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/registerrr');
        } else {
            $config['upload_path']   = './image/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size']      = 2048;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('image')) {
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('auth/registerrr', $error);
            } else {
                $upload_data = $this->upload->data();
                $nomor_exists = $this->m_model->check_nomor_exists($this->input->post('nomor'));
                $email_exists = $this->m_model->check_email_exists($this->input->post('email'));
                if ($nomor_exists || $email_exists) {
                    $response = [
                        'status'   => 'error',
                        'message'  => $nomor_exists ? 'Nomor sudah digunakan.' : 'Email sudah digunakan.',
                        'redirect' => base_url('auth'),
                    ];
                    $this->load->view('auth/registerrr', $response);
                } else {
                    $data = array(
                        'nama'          => $this->input->post('nama'),
                        'nomor'         => $this->input->post('nomor'),
                        'email'         => $this->input->post('email'),
                        'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                        'password'      => md5($this->input->post('password')),
                        'role'          => 'admin',
                        'image'         => $upload_data['file_name']
                    );

                    $this->load->model('m_model');
                    $inserted_id = $this->m_model->insert_user($data);

                    if ($inserted_id) {
                        redirect(base_url('auth'));
                    } else {
                        // Handle insertion failure
                        $response = [
                            'status'   => 'error',
                            'message'  => 'Gagal menyimpan data.',
                            'redirect' => base_url('auth'),
                        ];
                        $this->load->view('auth/registerrr', $response);
                    }
                }
            }
        }
    }

    public function check_email_exists($email)
    {
        $this->load->model('m_model');
        $exists = $this->m_model->check_email_exists($email);

        if ($exists) {
            $this->form_validation->set_message('check_email_exists', 'Email sudah digunakan.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_nomor_exists($nomor)
    {
        $this->load->model('m_model');
        $exists = $this->m_model->check_nomor_exists($nomor);

        if ($exists) {
            $this->form_validation->set_message('check_nomor_exists', 'Nomor sudah digunakan.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function submit_login()
    {
        $nomor = $this->input->post('nomor', true);
        $password = $this->input->post('password', true);

        $data = ['nomor' => $nomor];
        $query = $this->m_model->getwhere('user', $data);
        $result = $query->row_array();

        if (!empty($result) && md5($password) === $result['password']) {
            $data = [
                'loged_in' => TRUE,
                'nomor'    => $result['nomor'],
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
            $this->session->set_flashdata('error', 'Login gagal. Nomor atau password salah.');
            redirect(base_url() . "auth");
        }
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('auth'));
    }
}
