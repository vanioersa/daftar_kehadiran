<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('m_model');
        $this->load->helper('my_helper');
        if ($this->session->userdata('loged_in') != true || $this->session->userdata('role') != 'admin') {
            redirect(base_url() . 'auth');
        }
    }

    public function index()
    {
        $data['user'] = $this->m_model->get_by_id('user', 'id', $this->session->userdata('id'))->result();
        $this->load->view('admin/dashboard', $data);
    }

    public function public()
    {
        $data['public'] = $this->m_model->get_data('deskripsi_public')->result();
        $this->load->view('admin/page_1', $data);
    }

    public function tambah_card_public()
    {
        $this->load->view('admin/tambah_card');
    }

    public function hapus_image($id)
    {
        $deskripsi = $this->m_model->get_deskripsi_by_id($id);

        if ($deskripsi) {
            $image_file = $deskripsi->image;

            if ($image_file) {
                $image_path = './image/' . $image_file;

                if (file_exists($image_path) && unlink($image_path)) {
                    $data = ['image' => ''];
                    $this->m_model->edit_deskripsi($id, $data);
                    $response = [
                        'status' => 'success',
                        'message' => 'Foto telah dihapus.',
                        'redirect' => base_url('admin/public')
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'Foto tidak dapat dihapus. Silakan coba lagi.'
                    ];
                }
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Foto sudah dihapus.'
                ];
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data ruangan tidak ditemukan.'
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function aksi_tambah_card()
    {
        $tempat = $this->input->post('tempat');
        $deskripsi = $this->input->post('deskripsi');
        $image = $_FILES['foto']['name'];

        $errors = [];

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_info = pathinfo($image);
        $extension = isset($file_info['extension']) ? strtolower($file_info['extension']) : null;

        if (empty($image) || !in_array($extension, $allowed_extensions)) {
            $errors[] = 'Foto harus diunggah dengan format JPG, JPEG, PNG, atau GIF.';
        }

        if (count($errors) > 0) {
            $response = [
                'status' => 'error',
                'message' => implode(' ', $errors),
            ];
        } else {
            $image_temp = $_FILES['foto']['tmp_name'];
            $kode = round(microtime(true) * 100);
            $file_name = $kode . '_' . $image;
            $upload_path = './image/' . $file_name;

            if (move_uploaded_file($image_temp, $upload_path)) {
                $data = [
                    'image' => $file_name,
                    'deskripsi' => $deskripsi,
                    'tempat' => $tempat,
                ];

                $inserted = $this->m_model->tambah_data('deskripsi_public', $data);

                if ($inserted) {
                    $response = [
                        'status' => 'success',
                        'message' => 'Data berhasil ditambahkan.',
                        'redirect' => base_url('admin/public'),
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'Gagal menambahkan data. Silakan coba lagi.',
                    ];
                    unlink($upload_path);
                }
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Gagal mengunggah foto. Silakan coba lagi.',
                ];
            }
        }
        echo json_encode($response);
    }

    public function edit_card_public($id)
    {
        $data['public'] = $this->m_model->get_deskripsi_by_id($id);
        $this->load->view('admin/edit_card', $data);
    }

    public function aksi_edit_card($id)
    {
        $id = $id;
        $tempat = $this->input->post('tempat');
        $deskripsi = $this->input->post('deskripsi');
        $image = $_FILES['foto']['name'];
        $foto_temp = $_FILES['foto']['tmp_name'];
        $response = [
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat mengubah deskripsi public.',
            'redirect' => ''
        ];
        if ($id) {
            $current_data = $this->m_model->get_deskripsi_by_id($id);
            if ($current_data) {
                $data = [];
                $data['tempat'] = $tempat;
                $data['deskripsi'] = $deskripsi;
                if ($tempat !== $current_data->tempat || $deskripsi !== $current_data->deskripsi || !empty($image)) {
                    if (!empty($image)) {
                        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                        $file_extension = pathinfo($image, PATHINFO_EXTENSION);

                        if (!in_array(strtolower($file_extension), $allowed_extensions)) {
                            $response = [
                                'status' => 'error',
                                'message' => 'Ekstensi file tidak diizinkan. Pilih file foto dengan ekstensi: ' . implode(', ', $allowed_extensions),
                                'redirect' => base_url('admin/edit_card_public/' . $id),
                            ];
                            header('Content-Type: application/json');
                            echo json_encode($response);
                            return;
                        }
                        $kode = round(microtime(true) * 100);
                        $file_name = $kode . '_' . $image;
                        $upload_path = './image/' . $file_name;

                        if (move_uploaded_file($foto_temp, $upload_path)) {
                            $old_file = $this->m_model->get_image_by_id('deskripsi_public', $id);
                            if ($old_file && file_exists('./image/' . $old_file)) {
                                unlink('./image/' . $old_file);
                            }

                            $data['image'] = $file_name;
                        } else {
                            $response = [
                                'status' => 'error',
                                'message' => 'Gagal mengunggah foto. Silakan coba lagi.',
                                'redirect' => base_url('admin/edit_card_public/' . $id),
                            ];
                        }
                    }
                    $update_result = $this->m_model->edit_deskripsi($id, $data);
                    if ($update_result) {
                        $response = [
                            'status' => 'success',
                            'message' => 'Berhasil Mengubah Deskripsi Public',
                            'redirect' => base_url('admin/public'),
                        ];
                    }
                } else {
                    // Tidak ada perubahan data
                    $response = [
                        'status' => 'error',
                        'message' => 'Anda harus mengubah setidaknya satu data pada deskripsi Public.',
                        'redirect' => base_url('admin/edit_card_public/' . $id),
                    ];
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function profile()
    {
        $data['user'] = $this->m_model->get_by_id('user', 'id', $this->session->userdata('id'))->result();
        $this->load->view('admin/profile', $data);
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

        // Check if updating the password
        if (!empty($password_baru)) {
            // Verify old password
            if (!$current_user || md5($old_password) !== $current_user->password) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Password lama tidak sesuai
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>Password lama tidak sesuai');
                redirect(base_url('admin/profile'));
            }

            // Check if the new password matches the confirmation
            if ($password_baru !== $konfirmasi_password) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Password baru dan konfirmasi password harus sama
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');
                redirect(base_url('admin/profile'));
            }

            $data['password'] = md5($password_baru);
        }

        // Update other profile information
        $data['email'] = $email;
        $data['jenis_kelamin'] = $jenis_kelamin;
        $data['nama'] = $nama;

        // Update profile image if provided
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
                redirect(base_url('admin/profile'));
            }
        }

        // Update user data
        $update_result = $this->m_model->ubah_data('user', $data, array('id' => $this->session->userdata('id')));

        if ($update_result) {
            $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Berhasil Merubah data
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
            redirect(base_url('admin/profile'));
        } else {
            $this->session->set_flashdata('message', 'Gagal merubah data');
            redirect(base_url('admin/profile'));
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
            redirect(base_url('admin/profile'));
        } else {
            $this->session->set_flashdata('error', 'Gagal...');
            redirect(base_url('admin/profile'));
        }
    }

    public function pesan($page = 1)
    {
        $data['per_page'] = 10; // Number of records per page
        $offset = ($page - 1) * $data['per_page'];

        $data['pesan'] = $this->m_model->get_dataa('pesan', $data['per_page'], $offset)->result();
        $user_id = $this->session->userdata('id');
        $data['user_id'] = $user_id;
        $user_data = $this->session->userdata('id');
        $data['user_names'] = $this->m_model->get_data_except_current_user('user', $user_data)->result();

        // Get total rows for pagination
        $total_rows = $this->m_model->count_rows('pesan');

        // Calculate total pages
        $data['total_pages'] = ceil($total_rows / $data['per_page']);
        $data['current_page'] = $page;

        // Load the view with data
        $this->load->view('admin/pesan', $data);
    }

    public function simpan_pesan()
    {
        $pesan = $this->input->post('pesan');
        $penerima = $this->input->post('penerima');
        $user_data = $this->m_model->get_by_id('user', 'id', $this->session->userdata('id'))->row();
        $pengirim = $user_data->id;

        if (!empty($pesan)) {
            $this->m_model->simpan_pesan($pesan, $pengirim, $penerima);
        }

        redirect(base_url('admin/pesan'));
    }
}
