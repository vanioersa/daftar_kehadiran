<?php defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('m_model');
        $this->load->helper('my_helper');
        if ($this->session->userdata('loged_in') != true || $this->session->userdata('role') != 'user') {
            redirect(base_url() . 'auth');
        }
    }

    public function index()
    {
        $this->load->view('user/dashboard');
    }

    public function retting()
    {
        $this->load->view('user/rating');
    }

    public function pesan($page = 1)
    {
        $data['per_page'] = 10;
        $offset = ($page - 1) * $data['per_page'];
        $user_id = $this->session->userdata('id');
        $data['pesan'] = $this->m_model->get_dataa_by_user_id('pesan', $data['per_page'], $offset, $user_id);

        $user_id = $this->session->userdata('id');
        $data['user_id'] = $user_id;
        $data['current_user_id'] = $user_id;
        $user_data = $this->session->userdata('id');
        $data['user_names'] = $this->m_model->get_data_except_current_user('user', $user_data)->result();

        $total_rows = $this->m_model->count_rows('pesan');

        $data['total_pages'] = ceil($total_rows / $data['per_page']);
        $data['current_page'] = $page;

        $this->load->view('user/page_1', $data);
    }

    public function simpan_pesan()
    {
        $pesan = $this->input->post('pesan');
        $user_id = $this->session->userdata('id');

        // Get all user IDs (excluding the current user)
        $user_ids = $this->m_model->get_all_user_ids_except_current($user_id);

        if (!empty($pesan)) {
            $this->m_model->simpan_pesan($pesan, $user_id, $user_ids);
        }

        redirect(base_url('user/pesan'));
    }

    public function profile()
    {
        $data['user'] = $this->m_model->get_by_id('user', 'id', $this->session->userdata('id'))->result();
        $this->load->view('user/profile', $data);
    }

    public function aksi_ubah_profile()
    {
        $old_password = $this->input->post('password_lama');
        $image = $_FILES['foto']['name'];
        $foto_temp = $_FILES['foto']['tmp_name'];
        $password_baru = $this->input->post('password_baru');
        $konfirmasi_password = $this->input->post('konfirmasi_password');
        $email = $this->input->post('email');
        $jenis_kelamin = $this->input->post('jenis_kelamin');
        $nama = $this->input->post('nama');

        $current_user = $this->m_model->get_user_by_id($this->session->userdata('id'));

        if (!empty($password_baru)) {
            if (!$current_user || md5($old_password) !== $current_user->password) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Password lama tidak sesuai
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>Password lama tidak sesuai');
                redirect(base_url('user/profile'));
            }

            if ($password_baru !== $konfirmasi_password) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Password baru dan konfirmasi password harus sama
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');
                redirect(base_url('user/profile'));
            }

            $data['password'] = md5($password_baru);
        }

        $data['email'] = $email;
        $data['jenis_kelamin'] = $jenis_kelamin;
        $data['nama'] = $nama;

        if ($image) {
            $kode = round(microtime(true) * 100);
            $file_name = $kode . '_' . $image;
            $upload_path = './image/' . $file_name;

            if (move_uploaded_file($foto_temp, $upload_path)) {
                $old_file = $this->m_model->get_foto_by_id($this->session->userdata('id'));
                if ($old_file && file_exists('./image/' . $old_file)) {
                    unlink('./image/' . $old_file);
                }
                $data['image'] = $file_name;
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Gagal mengunggah foto
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');
                redirect(base_url('user/profile'));
            }
        }

        $update_result = $this->m_model->ubah_data('user', $data, array('id' => $this->session->userdata('id')));

        if ($update_result) {
            $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Berhasil Merubah data
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
            redirect(base_url('user/profile'));
        } else {
            $this->session->set_flashdata('message', 'Gagal merubah data');
            redirect(base_url('user/profile'));
        }
    }

    public function hapus_imagee()
    {
        $user_id = $this->session->userdata('id');

        $current_user = $this->m_model->get_user_by_id($this->session->userdata('id'));
        $current_image = $current_user->image;

        if (!empty($current_image) && file_exists('./image/' . $current_image)) {
            unlink('./image/' . $current_image);
        }

        $data = array('image' => NULL);
        $eksekusi = $this->m_model->ubah_data('user', $data, array('id' => $user_id));

        if ($eksekusi) {
            $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil Menghapus Profile
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect(base_url('user/profile'));
        } else {
            $this->session->set_flashdata('error', 'Gagal...');
            redirect(base_url('user/profile'));
        }
    }
}
