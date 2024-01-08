<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('m_model');
        if ($this->session->userdata('loged_in') != true || $this->session->userdata('role') != 'admin') {
            redirect(base_url() . 'auth');
        }
    }

    public function index()
    {
        $this->load->view('admin/dashboard');
    }

    public function page_1()
    {
        $data['public'] = $this->m_model->get_data('deskripsi_public')->result();
        $this->load->view('admin/page_1', $data);
    }    

    public function tambah_card()
    {
        $this->load->view('admin/tambah_card');
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
                        'redirect' => base_url('admin/page_1'),
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

        // Menggunakan echo json_encode untuk response AJAX
        echo json_encode($response);
    }
}