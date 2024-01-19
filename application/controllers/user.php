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
        $data['user_count'] = $this->m_model->get_user_count_by_role('user');
        $data['pesan'] = $this->m_model->get_data('pesan')->result();
        $data['current_user_id'] = $this->session->userdata('id');

        $data['user'] = $this->m_model->get_by_id('user', 'id', $this->session->userdata('id'))->result();
        $this->load->view('user/dashboard', $data);
    }

    public function retting()
    {
        $data['user'] = $this->m_model->get_by_id('user', 'id', $this->session->userdata('id'))->result();
        $user_id = $this->session->userdata('id');

        $ratingResults = $this->m_model->get_rating_results($user_id);

        $data['ratingResults'] = $ratingResults;

        $this->load->view('user/rating', $data);
    }

    public function aksi_ratting()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('rating', 'Rating', 'required|numeric|greater_than_equal_to[1]|less_than_equal_to[5]');
            $this->form_validation->set_rules('comment', 'Comment', 'required');

            if ($this->form_validation->run() == FALSE) {
                // Check if 'rating' is not provided, redirect back to the form view
                if (!$this->input->post('rating')) {
                    redirect(base_url('user/retting'));
                }

                $this->load->view('your_form_view');
            } else {
                $user_id = $this->session->userdata('id');

                if (!$user_id) {
                    redirect(base_url('user/retting'));
                }

                $rating = $this->input->post('rating');
                $comment = $this->input->post('comment');

                $data = array(
                    'id_user' => $user_id,
                    'rating' => $rating,
                    'comment' => $comment,
                );

                $this->m_model->tambah_data('ratting', $data);

                redirect(base_url('user/retting'));
            }
        } else {
            redirect(base_url('user/retting'));
        }
    }

    public function pesan()
    {
        $user_id = $this->session->userdata('id');
        $data['user_id'] = $user_id;

        $user_data = $this->session->userdata('id');
        $data['user_names'] = $this->m_model->get_data_except_current_users('user', $user_data)->result();

        $data['pesan'] = $this->m_model->get_messages_by_sender_all('pesan', $user_id)->result();

        $this->load->view('user/page_1', $data);
    }

    public function simpan_pesan()
    {
        $pesan = $this->input->post('pesan');
        $user_id = $this->session->userdata('id');
        $user_ids = $this->m_model->get_all_admin_ids_except_current($user_id);

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

    public function aksi_ubah_password()
    {
        $old_password = $this->input->post('password_lama');
        $password_baru = $this->input->post('password_baru');
        $konfirmasi_password = $this->input->post('konfirmasi_password');

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

            $this->updatePassword($password_baru);
        } else {
            // Handle the case where password_baru is empty (optional)
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Password baru tidak boleh kosong
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
            redirect(base_url('user/profile'));
        }
    }

    private function updatePassword($new_password)
    {
        $data['password'] = md5($new_password);

        $update_result = $this->m_model->ubah_data('user', $data, array('id' => $this->session->userdata('id')));

        if ($update_result) {
            $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Berhasil Merubah password
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
            redirect(base_url('user/profile'));
        } else {
            $this->session->set_flashdata('message', 'Gagal merubah password');
            redirect(base_url('user/profile'));
        }
    }

    public function aksi_ubah_profile()
    {
        $this->load->library('form_validation');

        // Validasi nomor
        $this->form_validation->set_rules('nomor', 'Nomor', 'required|numeric');

        $image = $_FILES['foto']['name'];
        $foto_temp = $_FILES['foto']['tmp_name'];
        $email = $this->input->post('email');
        $jenis_kelamin = $this->input->post('jenis_kelamin');
        $nama = $this->input->post('nama');
        $nomor = $this->input->post('nomor');

        // Validasi nomor
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Nomor tidak valid
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');
            redirect(base_url('user/profile'));
        }

        $current_user = $this->m_model->get_user_by_id($this->session->userdata('id'));

        $data['email'] = $email;
        $data['jenis_kelamin'] = $jenis_kelamin;
        $data['nama'] = $nama;
        $data['nomor'] = $nomor;

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
