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
        $data['reting'] = $this->m_model->get_data('ratting')->result();
        $data['pesan'] = $this->m_model->get_data('pesan')->result();
        $data['current_user_id'] = $this->session->userdata('id');
        $data['user_names'] = $this->m_model->get_data_except_current_users('user', $data['current_user_id'])->result();
        $role = 'user';
        $data['pengguna'] = $this->m_model->get_user_data_by_rolle($role);
        $data['user'] = $this->m_model->get_by_id('user', 'id', $data['current_user_id'])->result();

        $this->load->view('admin/dashboard', $data);
    }

    public function ratting()
    {
        $data['reting'] = $this->m_model->get_data('ratting')->result();
        $this->load->view('admin/rating', $data);
    }

    public function public()
    {
        $data['public'] = $this->m_model->get_data('deskripsi_public')->result();
        usort($data['public'], function ($a, $b) {
            $dateA = isset($a->tanggal) && $a->tanggal ? strtotime($a->tanggal) : 0;
            $dateB = isset($b->tanggal) && $b->tanggal ? strtotime($b->tanggal) : 0;

            return $dateB - $dateA;
        });

        $this->load->view('admin/page_1', $data);
    }

    public function detail_pengguna($id)
    {
        $data['user'] = $this->m_model->get_data_by_id('user', $id)->result();
        $this->load->view('admin/detail', $data);
    }

    public function tambah_card_public()
    {
        $this->load->view('admin/tambah_card');
    }

    public function aksi_tambah_card()
    {
        date_default_timezone_set('Asia/Jakarta');

        $tempat = $this->input->post('tempat');
        $deskripsi = $this->input->post('deskripsi');
        $image = $_FILES['foto']['name'];
        $waktu_kejadian = $this->input->post('waktu_kejadian');

        $errors = [];

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_info = pathinfo($image);
        $extension = isset($file_info['extension']) ? strtolower($file_info['extension']) : null;

        if (empty($image) || !in_array($extension, $allowed_extensions)) {
            $errors[] = 'Foto harus diunggah dengan format JPG, JPEG, PNG, atau GIF.';
        }

        if (empty($waktu_kejadian)) {
            $errors[] = 'Waktu kejadian harus diisi.';
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
                $current_date = date('Y-m-d');
                $current_time = date('H:i:s');

                $data = [
                    'image' => $file_name,
                    'deskripsi' => $deskripsi,
                    'tempat' => $tempat,
                    'tanggal' => $current_date,
                    'jam' => $current_time,
                    'waktu_kejadian' => $waktu_kejadian, // Use the user-input waktu_kejadian
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

    public function hapus_data_deskripsi($id)
    {
        $deskripsi_public = $this->m_model->get_deskripsi_by_id($id);

        if (!$deskripsi_public) {
            $this->session->set_flashdata('error', 'Data deskripsi public tidak ditemukan.');
            redirect('admiin/public');
        }

        $image_file = $deskripsi_public->image;
        if ($image_file) {
            $image_path = 'image/' . $image_file;
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        $this->m_model->delete('deskripsi_public', 'id', $id);

        $this->session->set_flashdata('success', 'Data deskripsi public berhasil dihapus.');
        redirect('admin/public');
    }

    public function profile()
    {
        $data['user'] = $this->m_model->get_by_id('user', 'id', $this->session->userdata('id'))->result();
        $this->load->view('admin/profile', $data);
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
                redirect(base_url('admin/profile'));
            }

            if ($password_baru !== $konfirmasi_password) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Password baru dan konfirmasi password harus sama
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
                redirect(base_url('admin/profile'));
            }

            $this->updatePassword($password_baru);
        } else {
            // Handle the case where password_baru is empty (optional)
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Password baru tidak boleh kosong
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
            redirect(base_url('admin/profile'));
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
            redirect(base_url('admin/profile'));
        } else {
            $this->session->set_flashdata('message', 'Gagal merubah password');
            redirect(base_url('admin/profile'));
        }
    }

    public function aksi_ubah_profile()
    {
        $this->load->library('form_validation');

        // Validasi nomor
        $this->form_validation->set_rules('nomor', 'Nomor', 'required|numeric');

        $image = $_FILES['foto']['name'];
        $foto_temp = $_FILES['foto']['tmp_name'];
        $jenis_kelamin = $this->input->post('jenis_kelamin');
        $nama = $this->input->post('nama');
        $nomor = $this->input->post('nomor');

        // Validasi nomor
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Nomor tidak valid
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');
            redirect(base_url('admin/profile'));
        }

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

    public function pesan()
    {
        $data['pesan'] = $this->m_model->get_all_messages('pesan')->result();

        $user_id = $this->session->userdata('id');
        $data['user_id'] = $user_id;

        $user_data = $this->session->userdata('id');
        $data['user_names'] = $this->m_model->get_data_except_current_users('user', $user_data)->result();

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

    public function table_pengguna()
    {
        $this->load->library('pagination');

        $config['base_url'] = base_url('admin/table_pengguna');
        $config['total_rows'] = $this->m_model->count_user_data_by_role('user');
        $config['per_page'] = 20;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['public'] = $this->m_model->get_user_data_by_role('user', $config['per_page'], $page);

        $this->load->view('admin/table_pengguna', $data);
    }
}
